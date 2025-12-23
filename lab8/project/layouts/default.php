<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/lab8/project/webroot/styles.css">
        <title><?= $title ?></title>
    </head>
    <body>
        <header>
            <img src="/lab8/project/webroot/logo.png" alt="Логотип">
            хедер сайта
        </header>
        <div class="container">
            <aside class="sidebar left">
                левый сайдбар
            </aside>
            <main>
                <?= $content ?>
            </main>
            <aside class="sidebar right">
                правый сайдбар
            </aside>
        </div>
        <footer>
            футер сайта
        </footer>
    </body>
</html>