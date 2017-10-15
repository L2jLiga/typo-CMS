<?PHP
require_once 'inc/config.php';

// Загружаем базовый стиль сайта
$buffer = file_get_contents($root_dir.'/res/style.css');


// Если у нас модуль подгружаем таблицу стилей модуля
if(isset($_GET['module']) and !empty($_GET['module'])) {
	$style=$modules_path.$_GET['module'].'/res/style.css';
	if(file_exists($style)) $buffer .= file_get_contents($style);
}

// выводим итоговый CSS
header("Content-type: text/css;");
echo $buffer;

?>