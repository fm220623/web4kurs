<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/factory/router.php';
require_once __DIR__ . '/factory/models/collection.php';
require_once __DIR__ . '/factory/models/user.php';
require_once __DIR__ . '/factory/models/users.php';

require_once __DIR__ . '/mvc/views/markdownview.php';

use Factory\Models\Users;

$usersObj = new Users();
$users = $usersObj->users;

$view = new \MVC\Views\MarkdownView($users);
echo nl2br($view->render());