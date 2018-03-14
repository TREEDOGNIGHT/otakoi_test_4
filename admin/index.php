<? session_start(); ?>
<html>
<head>
<title>CommentSystem - Admin</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script Language="JavaScript">
function toggle(id)
{
	var e = document.getElementById(id);
	var dh = gh(id);
	var elems = e.getElementsByTagName('*');
	var flag;
	
	if (e.style.display == "none")
	{
		if (flag != 0)
		{
			flag = 0;
			for(var i=0; i<elems.length; i++){vhe(elems[i], "hidden");}
		
			e.style.height="1px";
			e.style.display = "block";
			for(var i=0;i<=100;i+=5)
			{
				(function()
					{
						var pos=i;
						setTimeout(function(){e.style.height = (pos/100)*dh+1+"px";},pos*5);
					}
				)();
			}
			setTimeout(function(){for(var i=0; i<elems.length; i++){elems[i].style.visibility="visible";}},500);
			return true;
			flag = 1;
		}
	}
	else
	{
		if (flag != 0)
		{
			flag = 0;
			var lh=dh-1+"px";
			
			for(var i=0; i<elems.length; i++){vhe(elems[i], "hidden");}
			
			for (var i=100;i>=0;i-=5)
			{
				(function()
					{
						var pos=i;
						setTimeout(function()
						{
							e.style.height = (pos/100)*dh+"px";
							if (pos<=0)
							{
								e.style.display = "none";
								e.style.height=lh;
							}
						},1000-(pos*5));
					}
				)();
			}
			return true;
			flag = 1;
		}
	}
	return false;
}
function vhe(obj, vh){obj.style.visibility=vh;}
function gh(id)
{
	var e = document.getElementById(id);
	if(e.style.display == "none")
	{
		e.style.visibility = "hidden";
		e.style.display = "block";
		dh = e.clientHeight||e.offsetHeight+5; // Высота
		e.style.display = "none";
		e.style.visibility = "visible";
	}
	else
	{
		dh = e.clientHeight||e.offsetHeight+5; // Высота
	}
	return dh;
}
</script>
</head>
<body>
<center>
<div id="content">
<?
include('../config.php');
//проверяем пароль
if(isset($_POST['admin_pass']))
{
	if($admin_pass == $_POST['admin_pass'])
	{
		$_SESSION['admin_pass'] = true;
	}
}

if($_SESSION['admin_pass'])
{
	if(isset($_GET['good'])){$public=1;}
	elseif(isset($_GET['moderate'])){$public=0;}
	else{$public=0;}
	//одобряем
	if(isset($_GET['good_comment']))
	{
	$id = $_GET['good_comment'];
	mysql_query("update ".$c_tab." set public = '1' where id = '{$id}'") or die ("Error! query - set");	
	}
	//удаляем
	if(isset($_GET['delete']))
	{
	$id = $_GET['delete'];
	mysql_query("delete from ".$c_tab." where id = '{$id}'") or die ("Error! query - delete");
	}
	//Завершаем работу
	if(isset($_GET['end']))
	{
	session_destroy();
	echo "Сессия завершена! Если вы желаете продолжить работу, обновите страницу и войдите заново.";
	return;
	}

	function countcomments($pub)
	{
		include('../config.php');
		$res = mysql_query("select count(id) from ".$c_tab." where public='".$pub."'", $con);
		$arr = mysql_fetch_array($res, MYSQL_NUM); return $arr[0];
	}

	$res = mysql_query("select * from ".$c_tab." where public='".$public."'", $con) or die ("Error!");
	while($arr = mysql_fetch_array($res, MYSQL_NUM))
	{
		$comments[$arr[0]]['id'] = $arr[0];
		$comments[$arr[0]]['parent_id'] = $arr[1];
		$comments[$arr[0]]['url_id'] = $arr[2];
		$comments[$arr[0]]['id_material'] = $arr[3];
		$comments[$arr[0]]['name'] = $arr[4];
		$comments[$arr[0]]['url'] = $arr[5];
		$comments[$arr[0]]['mail'] = $arr[6];
		$comments[$arr[0]]['text'] = $arr[7];
		$comments[$arr[0]]['date_add'] = $arr[8];
		$comments[$arr[0]]['public'] = $arr[9];
	}
	?>
	<div id="head">
		<? if(countcomments(0)>0): ?><a href="?moderate">На проверке</a> <font color="red">[<?=countcomments(0)?>]</font><? endif; ?>
		<? if(countcomments(1)>0): ?><a href="?good">Одобренные</a> <font color="green">[<?=countcomments(1)?>]</font><? endif; ?>
		<!--<a onclick="toggle('setings')">Настройки</a>-->
		[<a href="?end">выход</a>]
	</div>
	<div id="setings" style="display:none;">
	<? //include('settings.php'); ?>
	</div>
		<table class="list" cellspacing="0" cellpadding="0">
		<? if(count($comments)>0): ?>
			<? foreach($comments as $item): ?>
			<tr>
				<td class="left"  valign='top'>
					<ul>
						<? if($item['public'] == 0): ?>
						
						<li><img src="good.gif"/><a href="?good_comment=<?=$item['id']?>">Одобрить</a></li>
						
						<? else: ?>
							Одобрено
						<? endif; ?>
						
						<li><img src="material.gif"/><a href="http://<?=$item['url_id']?>" target="_blank">Посмотреть материал</a></li>
						<li><img src="comment.gif"/><a href="http://<?=$item['url_id']?>#<?=$id_pref?><?=$item['id']?>" target="_blank">Перейти к комментарию</a></li>
						<li><img src="delete.gif"/><a href="?delete=<?=$item['id']?>" onclick="return confirm('Удалить комментарий?');">Удалить</a></li>
					</ul>
				</td>
				
				<td class="right" valign='top'>
					<div class="title"><b> <?=$item['name']?> </b>
						<span>
							<? if($item['url'] != ''): ?>
							<a href="<?=$item['url']?>" target="_blank"><?=$item['url']?></a> |
							<? endif; ?>
							<?=$item['mail']?> |
							<?=$item['date_add']?>
						</span>
					</div>
					<div class="text">
						<?=$item['text']?>
					</div>
				</td>
			</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td>
					<br>Немає нових повідомлень!<br><br>
				</td>
			</tr>
		<? endif; ?>
		</table>
<?
}
else
{
?>
<br>
<form action="index.php" method="POST">
Введіть пароль:<br>
<input type="password" name="admin_pass"/>
<input type="submit" value="Войти"/>
</form>
<br>
<?
}
?>
</div>
</center>
</body>
</html>