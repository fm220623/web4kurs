<?php
require_once 'INewsDB.class.php';

class NewsDB implements INewsDB {

    const DB_NAME = 'news.db';
    const RSS_NAME = 'rss.xml';
    const RSS_TITLE = 'Последние новости';
    const RSS_LINK = 'http://f1203326.xsph.ru/lab5/news/news.php';

    private $_db;

    public function __construct() {
        $this->_db = null;
        
        try {
            if (file_exists(self::DB_NAME) && filesize(self::DB_NAME) == 0) {
                unlink(self::DB_NAME);
            }
            
            $this->_db = new PDO('sqlite:' . self::DB_NAME);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_db->setAttribute(PDO::ATTR_TIMEOUT, 5);
            
            $this->initDatabase();
            
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }

    public function __destruct() {
        $this->_db = null;
    }

    private function initDatabase() {
        try {
            $this->_db->beginTransaction();
            
            $tableExists = $this->_db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='msgs'");
            
            if (!$tableExists->fetch()) {
                $this->_db->exec("
                    CREATE TABLE msgs(
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        title TEXT,
                        category INTEGER,
                        description TEXT,
                        source TEXT,
                        datetime INTEGER
                    )
                ");

                // Создаем таблицу category
                $this->_db->exec("
                    CREATE TABLE category(
                        id INTEGER PRIMARY KEY,
                        name TEXT
                    )
                ");

                $this->_db->exec("INSERT INTO category(id, name) VALUES (1, 'Политика')");
                $this->_db->exec("INSERT INTO category(id, name) VALUES (2, 'Культура')");
                $this->_db->exec("INSERT INTO category(id, name) VALUES (3, 'Спорт')");
            }
            
            // Коммитим транзакцию
            $this->_db->commit();
            
        } catch (PDOException $e) {
            if ($this->_db->inTransaction()) {
                $this->_db->rollBack();
            }
            
            if (file_exists(self::DB_NAME) && filesize(self::DB_NAME) == 0) {
                unlink(self::DB_NAME);
            }
            
            throw new Exception("Ошибка инициализации базы данных: " . $e->getMessage());
        }
    }

    public function saveNews($title, $category, $description, $source) {
        try {
            $stmt = $this->_db->prepare("
                INSERT INTO msgs (title, category, description, source, datetime) 
                VALUES (:title, :category, :description, :source, :datetime)
            ");

            $stmt->bindValue(':title', $title, PDO::PARAM_STR);
            $stmt->bindValue(':category', (int)$category, PDO::PARAM_INT);
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);
            $stmt->bindValue(':source', $source, PDO::PARAM_STR);
            $stmt->bindValue(':datetime', time(), PDO::PARAM_INT);

            $result = $stmt->execute();
            
            if ($result) {
                $this->createRss(); 
                return true;
            }
            
            return false;

        } catch (PDOException $e) {
            error_log("Ошибка сохранения новости: " . $e->getMessage());
            return false;
        }
    }

    public function getNews() {
        try {
            $stmt = $this->_db->query("
                SELECT msgs.id as id, title, category.name as category, description, source, datetime
                FROM msgs 
                LEFT JOIN category ON category.id = msgs.category
                ORDER BY msgs.id DESC
            ");

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Ошибка получения новостей: " . $e->getMessage());
            return false;
        }
    }

    public function deleteNews($id) {
        try {
            // Проверяем существование записи
            $checkStmt = $this->_db->prepare("SELECT COUNT(*) as count FROM msgs WHERE id = :id");
            $checkStmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $checkStmt->execute();
            $row = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row['count'] == 0) {
                return false;
            }
            
            $stmt = $this->_db->prepare("DELETE FROM msgs WHERE id = :id");
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $result = $stmt->execute();
            
            return $result && $stmt->rowCount() === 1;

        } catch (PDOException $e) {
            error_log("Ошибка удаления новости: " . $e->getMessage());
            return false;
        }
    }

    public function createRss() {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;

        $rss = $dom->createElement('rss');
        $dom->appendChild($rss);

        $version = $dom->createAttribute('version');
        $version->value = '2.0';
        $rss->appendChild($version);

        $channel = $dom->createElement('channel');
        $rss->appendChild($channel);

        $title = $dom->createElement('title', self::RSS_TITLE);
        $channel->appendChild($title);

        $link = $dom->createElement('link', self::RSS_LINK);
        $channel->appendChild($link);

        $newsItems = $this->getNews();
        if ($newsItems === false) {
            return false;
        }

        foreach ($newsItems as $item) {
            $rssItem = $dom->createElement('item');

            $itemTitle = $dom->createElement('title', htmlspecialchars($item['title']));
            $rssItem->appendChild($itemTitle);

            $itemLink = $dom->createElement('link', self::RSS_LINK . '?view=' . $item['id']);
            $rssItem->appendChild($itemLink);

            $description = $dom->createElement('description');
            $cdataDesc = $dom->createCDATASection($item['description']);
            $description->appendChild($cdataDesc);
            $rssItem->appendChild($description);

            $pubDate = $dom->createElement('pubDate', date(DATE_RSS, $item['datetime']));
            $rssItem->appendChild($pubDate);

            $category = $dom->createElement('category', htmlspecialchars($item['category']));
            $rssItem->appendChild($category);

            $channel->appendChild($rssItem);
        }

        $dom->save(self::RSS_NAME);
        return true;
    }
}
?>