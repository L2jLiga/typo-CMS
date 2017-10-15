<?PHP
require_once 'inc/config.php';
require_once 'inc/generate.php';

if(isset($_GET['module']) and !empty($_GET['module'])) {
	$module=$_GET['module'];
} else {
	$module = $def_module;
}
require_once 'inc/modules_loader.php';

// Завершаем генерацию страницы
require_once 'inc/generate_end.php';
?>