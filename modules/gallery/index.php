<?PHP
/*
 * Модуль галерея
 * Загружаемые картинки находятся в подпапке
 * Дальше есть определеная иерархия, через readdir получаем список файлов
 */

// TO DO: Реализовать механизм открытия папок
// Сохранения пути
if (isset($_GET['act']) and !empty($_GET['act'])) {
	$act_to_vw = str_replace('_','/',$_GET['act']);
	// Обрезка символа
	$Multilevel = explode('_', $_GET['act']);
	$level='';
	for($i=1; $i<sizeof($Multilevel)-1;$i++) {
		$level .= '_'.$Multilevel[$i];
	}
	$act = '/'.$act_to_vw.'/';
} else {
	$act_to_vw = '';
	$act = '/';
}
$gal = opendir($module_dir."/uploads".$act);
$dirs = array();
$files = array();
 
while($cats = readdir($gal)) {
	if ( $cats != "." && $cats != ".." && $cats != "0.txt" && $cats != "0.png") {
		if (strpos($cats, '.png') !== false) {
			$files[] = $cats;
		} else {
			$dirs[] = $cats;
		}
	}
}

closedir($gal);
$act_to_vw = str_replace('/','_',$act_to_vw);

// Ассоциативный массив для вывода списка папок
if(!empty($dirs)) {
	$dirs_list = array();
	foreach ($dirs AS $directory) {
		$img = $module."/uploads".$act.$directory;
		$name = file_get_contents($modules_path.$img."/0.txt");
		$tmp = array (
			'url' => $url_path,
			'act' => $act_to_vw,
			'dir_path' => $directory,
			'dir_name' => $name,
			'dir_img' =>  '/modules/'.$img
		);
		$dirs_list[] = $tmp;
	}
	echo $tpl->GetGoods($dirs_list, "gallery_dir_list.tpl");	 
}
 
 
// Ассоциативный массив для вывода списка фотографий
if(!empty($files)) {
	$img_list = array();
	foreach ($files AS $file) {
		$img = $url_path.'/modules/'.$module."/uploads".$act.$file;
		$tmp = array (
			'img' => $img
		);
		$img_list[] = $tmp;
	}
	echo $tpl->GetGoods($img_list, "gallery.tpl");
}
?>