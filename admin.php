<?PHP
require_once 'inc/config.php';
require_once 'inc/generate.php';

// Подгружаем переменные FROM URI
if(isset($_GET['module'])) {$module = $_GET['module'];} else {$module='';}
if(isset($_GET['act'])) {$act = $_GET['act'];} else {$act='';}
if(isset($_GET['id'])) {$id = $_GET['id'];} else {$id='';}


?>