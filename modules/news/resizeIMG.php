<?PHP
$image = $_FILES['photo'];
global $min_width,$max_width,$min_height,$max_height;
/*
 * Проверка изображения
 * $file - непосредственно файл
 * WxH - массив: [0] - ширина, [1] - высота изображения
 */
function img_cond($file, $WxH) {
	$errs = array();
	$types = array(
		'image/png' => true,
		'image/jpeg' => true,
		'image/jpg' => true,
		'image/bmp' => true
	);
	if(!$types($file['type'])) {
		$errs[]='Неправильный формат фотографии';
	}
	if($WxH[0] != $WxH[1]) {
		$errs[]='Соотношение сторон изображения должно быть 1:1';
	}
	return $errs;
}

$Sizes = @getimagesize($image['tmp_name']);
// if(!empty(img_cond($image, $Sizes))) {return false;}

/*
 * Загружаем изображение в память и удаляем с сервера
 */
if ($image['type'] == 'image/bmp'){
		$src_img = imagecreatefromwbmp($image['tmp_name']);
	} elseif (($image['type'] == 'image/jpeg') || ($image['type'] == 'image/jpg')) {
		$src_img = imagecreatefromjpeg($image['tmp_name']);
	} else {
		$src_img = imagecreatefrompng($image['tmp_name']);
	}
unlink($image['tmp_name']);

/*
 * Создаем миниатюру и полную фотографии из исходной
 */
$miniature = imagecreatetruecolor($min_width,$min_height);
$fullyimage = imagecreatetruecolor($max_width,$max_height);
imagecopyresized($miniature,$src_img,0,0,0,0,$min_width,$min_height,$Sizes[0],$Sizes[1]);
imagecopyresized($fullyimage,$src_img,0,0,0,0,$max_width,$max_height,$Sizes[0],$Sizes[1]);

/*
 * Название картинки - случайное число
 * Для миниатюры используется префикс mini_
 * Изображения сохраняются в формате PNG
 * В папку, указанную в конфигурации
 */
$imgname = rand(100000,413718311);
imagepng($fullyimage,$moved_img_dir.$imgname.".png");
imagepng($miniature,$moved_img_dir."mini_".$imgname.".png");
?>