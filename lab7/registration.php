<?php
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['answer'])) {
        if (isset($_SESSION['captcha'])) {
            $userAnswer = trim($_POST['answer']);
            $captcha = $_SESSION['captcha'];
            
            if ($userAnswer === $captcha) {
                $message = 'Правильно!';
            } else {
                $message = 'Неправильно! Правильный ответ: ' . htmlspecialchars($captcha);
            }
            
            // Очищаем капчу после проверки
            unset($_SESSION['captcha']);
        } else {
            $message = 'Ошибка: картинка не загружена. Включите показ картинок в браузере.';
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <title>Регистрация</title>
</head>
<body>
  <h1>Регистрация</h1>
  <form action="" method="post">
    <div>
      <img src="noise-picture.php">
    </div>
    <div>
      <label>Введите строку</label>
      <input type="text" name="answer" size="6">
    </div>
    <input type="submit" value="Подтвердить">
  </form>
  <?php 
  if ($message !== '') {
      echo '<p>' . htmlspecialchars($message) . '</p>';
  }
  ?>
</body>
</html>