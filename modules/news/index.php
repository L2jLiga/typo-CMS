<?PHP
$moved_img_dir = $module_dir.'/res/img/';
if (!isset($_GET['act'])) $act=''; else $act = $_GET['act'];
switch ($act) {
	case 'edit':
		require_once 'edit.php';
		break;
	case 'view':
		if(!isset($_GET['id']) | empty($_GET['id'])) header('location: ../../');
		$id = $_GET['id'];
		
		
	default: 
		require_once 'page.php';
}
?>