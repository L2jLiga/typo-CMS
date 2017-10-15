<?PHP
	 if(!isset($_GET['page']) or empty($_GET['page'])) $page=1; else $page=$_GET['page'];

	 $views = 15*($page-1);
	 $query = "SELECT * FROM `news` ORDER BY `date` DESC LIMIT $views,15";
	 
	 $res = $db->Executive($query);
	 if($res) {
		$replacement = array();
		foreach ($res AS $sth) {
			$sth['mvdimgdir'] = $url_path.'/modules/'.$module.'/res/img';
			$replacement[]=$sth;
		}
		$tpl_name = "view_news.tpl";
		echo $tpl->GetGoods($replacement,$tpl_name);
	 } else {
		 echo '<div>Нет новостей</div>';
	 }

	 if ($page > 1):?>
	 <a href="?page=<?PHP echo $page-1;?>">Новее</a>
	 <?PHP endif;?>
	 <div><?PHP echo $page;?></div>
	 <?PHP 
		$query = "SELECT COUNT(*) FROM `messages`";
		$res = $db->Executive($query);
		$count = sizeof($res);
		if($res) if ($count[0] >= $page*15):
	?><a href="?page=<?PHP echo $page+1;?>">Старее</a><?PHP endif;
?>