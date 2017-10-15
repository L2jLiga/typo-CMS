<?PHP

// Загрузка списка модулей
$mods_dir = opendir($modules_path);
$modules = array();
while($module_dir = readdir($mods_dir)) {
	if($module_dir != "." && $module_dir != "..") {

		// Проверка не выключен ли модуль
		$disable = 0;
		$read_module_dir = opendir($modules_path.$module_dir.'/');
		while ($is_disabled = readdir($read_module_dir)) {
			if($is_disabled == "disabled") $disable = 1;
		}
		closedir($read_module_dir);

		// Если модуль не выключен, то добавляем его в список модулей
		if(!$disable)
		{
			$this_path = $modules_path.$module_dir.'/';
			$modules[] = array(
				'dir' => $module_dir,
				'name' => file_get_contents($this_path.'name.txt'),
				'ver' => file_get_contents($this_path.'ver.txt')
			);
		}
	}
}
closedir($mods_dir);

// Загрузчик модуля
	$module_dir = $modules_path.$module;

	// Если нет модуля
	if(!file_exists($module_dir)) {
		echo $tpl->GetHeader("Страница не найдена", null);
		echo $tpl->GetGoods($modules, 'menu.tpl');
		echo '</nav>';
		require_once '404.html';
		return;
	}

	// Получаем основную информацию о модуле
	$this_path = $module_dir.'/';
	$name = file_get_contents($this_path."name.txt");

	// Вывод шапки страницы
	echo $tpl->GetHeader($name.' '.$title, $module);
	echo $tpl->GetGoods($modules, 'menu.tpl');
	echo '</header><main>';

	// Загурзка модуля
	$tpl = new Templ('modules/'.$module.'/');
	require_once $this_path.'index.php';

?>