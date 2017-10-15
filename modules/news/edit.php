<?PHP
if(!isset($_GET['id']) or empty($_GET['id'])) header("location: /?module=news");
$cond = array(
	'id' => $_GET['id']
);
	if(isset($_POST['submit'])):
		$data = array(
			'title' => $_POST['title'],
			'short_news' => nl2br($_POST['short_news']),
			'full_news' => nl2br($_POST['full_news'])
		);
		if(isset($_POST['removed']) and $_POST['removed'] == "remove_foto") {
			$imgname = '0';
			unlink($modules_path.$module.'/res/img/mini_'.$_POST['exist_photo'].'.png');
			unlink($modules_path.$module.'/res/img/'.$_POST['exist_photo'].'.png');
		}
		elseif (isset($_FILES['photo']['tmp_name']) & !empty($_FILES['photo']['tmp_name'])) {
			require_once 'resizeIMG.php';
		}
		if (isset($imgname)) {
			$data['photo'] = $imgname;
		}
		$db->Update("news", $data, $cond);
?>
	<div><strong>Новость изменена!</strong></div>
<?PHP 
	endif;
	$res = $db->select('news',$cond);
	$res = $res[0];
?>	<form action="" method="POST" enctype="multipart/form-data">
		<div><input name="title" type="text" value="<?PHP echo $res['title']?>"/></div>
		<div>
			<img src="<?PHP echo $url_path.'/modules/'.$module.'/res/img/mini_'.$res['photo'].'.png'; ?>" alt=""/><input name="photo" type="file" accept="image/jpg,image/jpeg,image/png,image/bmp" value=""/>
			<?PHP if($res['photo']!=0):?><input type="checkbox" value="remove_foto" name="removed"/>Удалить?<input type="hidden" name="exist_photo" value="<?PHP echo $res['photo']?>"/><?PHP endif;?>
		</div>
		<div><textarea name="short_news"><?PHP echo str_replace("<br />","",$res['short_news'])?></textarea></div>
		<div><textarea name="full_news"><?PHP echo str_replace("<br />","",$res['full_news'])?></textarea></div>
		<div><a href="../../">Отменить</a>&nbsp;||&nbsp;<input name="submit" type="submit" value="Изменить"/></div>
	</form>