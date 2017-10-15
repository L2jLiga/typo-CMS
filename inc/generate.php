<?PHP
// Кодировка сайта
header("charset=$charset");

// Соединение с БД
require_once $root_dir.'/inc/mydb.class.php';
$db = new L2jDB_API($db_host, $db_user, $db_password, $db_name, $db_con_charset, $db_con_type);

// Шаблонизатор
require_once $root_dir.'/inc/templates.class.php';
$tpl = new Templ('');
$footer = $tpl->GetFooter($title);

// Функциональная переменная, хранит номер страницы
if(!isset($_GET['page']) or empty($_GET['page'])) $page=1; else $page=$_GET['page'];

?>