<?PHP
if(!isset($_GET['page']) or empty($_GET['page'])) $page=1; else $page=$_GET['page'];

session_start();
if(!isset($_POST['submit'])):
?><form action="" method="POST">
	<div>Имя:&nbsp;<input name="author" type="text" value=""/></div>
	<div>почта:&nbsp;<input name="mail" type="email" value="" /></div>
	<div>сообщение:<br><textarea name="msg" rows="3" cols="20"></textarea></div>
	<div><img src="res/secpic.php" alt="CAPTCHA" /><input type="text" value="" name="captcha" /></div>
	<div><input type="submit" name="submit" value="отправить" /></div>
	</form>
<?PHP
 else:
	function ClearVars ($var) {
		$var = htmlspecialchars($var);
		$var = mysql_escape_string($var);
		return trim($var);
	}
	$author=ClearVars($_POST['author']);
	$mail=ClearVars($_POST['mail']);
	$msg=nl2br($_POST['msg']);
	$captcha=strtolower(ClearVars($_POST['captcha']));
	if ($captcha != $_SESSION['secpic']) {header("location: ?");die();}
	mysql_query("INSERT INTO `messages` (`author`,`mail`,`msg`) VALUES ('$author', '$mail', '$msg')");
 ?>Спасибо за отзыв!<?PHP
 endif;
 session_destroy();

 $views = 15*($page-1);
 $query = "SELECT * FROM `messages` ORDER BY `date` DESC LIMIT $views,15";
 $res = $db->Executive($query);

 foreach($res AS $msg):?>
	<div style="border: 1px dotted green;display:block;margin:10px"><?PHP echo $msg['msg']; ?></div>
<?PHP endforeach;
  
 if ($page > 1):
 ?><a href="?page=<?PHP echo $page-1;?>">Новее</a><?PHP
 endif;?>
 <div><?PHP echo $page;?></div>
 <?PHP 
	$count = $db->CountOF("messages");
	if($res) if ($count[0] >= $page*15):
?>
 <a href="?page=<?PHP echo $page+1;?>">Старее</a><?PHP endif;
?>