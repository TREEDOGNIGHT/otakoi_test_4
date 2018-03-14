<?php ob_start('comments_compress');
//$idm="345";
$dom = $_SERVER['SERVER_NAME'];
$page = $_SERVER['REQUEST_URI'];
$uid=$dom.$page;
function url(){
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    $_SERVER['REQUEST_URI']
  );
}
$site_url = url();
include('config.php');
include('lib/includes.php');
include('lang.php');
//$lb=get_label();

?>
<script Language="JavaScript">
function obj(){var rt;var b = navigator.appName;if(b == "Microsoft Internet Explorer"){var rt = new ActiveXObject("Microsoft.XMLHTTP");
}else{var rt = new XMLHttpRequest();}return rt;}
function ajax(p)
{
	var r = obj();
	m=(!p.method ? "POST" : p.method.toUpperCase());
	
	if(m=="GET")
	{
		send=null;
		p.url=p.url+"&ajax=true";
	}
	else
	{
		send="";
		for (var i in p.data) send+= i+"="+p.data[i]+"&";
		send=send+"ajax=true";
	}
	
	r.open(m, p.url, true);
	if(p.statbox)document.getElementById(p.statbox).innerHTML = '<? echo templater($theme_path."wait.php", array('[#theme_path]','[#wait]'), array($theme_path,$wait_text)); ?>';
	r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	r.send(send);
	r.onreadystatechange = function()
	{
		if (r.readyState == 4 && r.status == 200)
		{
			if(p.success)p.success(r.responseText);
		}
	}
}
function ct(f){if (f.defaultValue == f.value) f.value = '';else if (f.value == '') f.value = f.defaultValue;}
function gbi(id){var e = document.getElementById(id); return e;}
function rp(pid)
{
	var e = gbi("status");
	var a = gbi("pid");
	var b = gbi("buf");
	b.value=e.innerHTML;
	e.innerHTML=gbi(pid).innerHTML+'<? echo templater($theme_path."reply.php", '[#unreply]', $unreply); ?>';
	a.value=pid;
}
function unrp()
{
	var e = gbi("status");
	var a = gbi("pid");
	var b = gbi("buf");
	e.innerHTML=b.value;
	a.value='0';
}
</script>
<style>
#cs {width:870px; color:#333; padding:10px; font:normal 14px Verdana; text-align:left; background:#FFF;}
#cs a{text-decoration:none; cursor:pointer;}
#cs div.f{width:99%; float:right;}
#cs div.s{width:90%; float:right; margin-top:5px;}
#cs div.c{background: url(<?=$theme_path?>top.png) left top no-repeat;}
#cs div.c div{clear:both; padding:10px; background: url(<?=$theme_path?>fon.png);}
#cs div.c span.l{height:40px; float:left;}
#cs div.c span.rd{height:40px; font-size:10px; position:relative; top:15px; left:-10px; float:right;}
span.r{float:right; margin:2px 0px 2px; padding:5px 15px 5px; border:1px #CCC solid; cursor:pointer; background: url(<?=$theme_path?>addtitle.png) bottom left repeat-x; color:#FFF;}
span.r:hover{color:#FF5;}
#cf {background: #b6b5b5 url(<?=$theme_path?>addtitle.png) top left repeat-x; border:1px solid #CCC; margin-top:25px; padding:10px;}
#scf {background:#FFF;}
#cf #status span.t{font: bold 18px Verdana; color:#FFF;}
#cf #status font.ok{font: bold 18px Verdana; color:#9F9;}
#cf #status font.err{font: bold 18px Verdana; color:#F99;}
#cf #rules{font:normal 12px Verdana; background: url(<?=$theme_path?>bottom.png) right bottom no-repeat; padding:5px 0px 20px;}
#cf #rules div{padding:5px 15px 5px; color:#FFF;}
#cf textarea{border:10px solid #FFF; padding:5px; font:normal 15px Verdana; overflow:hidden; background: url(<?=$theme_path?>areafon.png) top left no-repeat;}
#cf #name{width:30%; height:50px; float:left;}
#cf #site{width:60%; height:50px;}
#cf #mail{width:90%; height:50px;}
#cf #text {width:90%; margin:5px 10px 15px; border:1px solid #DDD; height:200px; background:#EEE;}
.clear {clear:both;}
.add {cursor:pointer; margin:10px 0px 0px;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div class="clear"></div>
<div id="cs">

	<? parentcomments(); ?>
	
	<div id="cf">
		<div id="status"><span class="t"><?=$addc_text?></span></div>
				<div id="rules">
					<div><?=$rules?></div>
				</div>

		<div id="scf">
			<textarea id="name" onfocus="ct(this)" onblur="ct(this)"><?=$name_area?></textarea>
			<textarea id="site" onfocus="ct(this)" onblur="ct(this)"><?=$site_area?></textarea>
			<textarea id="mail" onfocus="ct(this)" onblur="ct(this)"><?=$mail_area?></textarea>
			<textarea id="text" onfocus="ct(this)" onblur="ct(this)"><?=$text_area?></textarea>
			<input type="hidden" id="uid" value="<?=$uid?>">
			<input type="hidden" id="pid" value="0">
			<input type="hidden" id="buf" value="">
			<? if(isset($idm)): ?>
			<input type="hidden" id="idm" value="<?=$idm?>">
			<? endif; ?>
		</div>
		
		<img src="<?=$theme_path?>comment.png" class="add" onclick='
			ajax({
					url:"<?=$site_url?>get_ajax.php",
					statbox:"status",
					method:"POST",
					data:
					{
						name:gbi("name").value,
						mail:gbi("mail").value,
						site:gbi("site").value,
						text:gbi("text").value,
						pid:gbi("pid").value,
						uid:gbi("uid").value
						<? if(isset($idm)): ?>
						,idm:gbi("idm").value
						<? endif; ?>
					},
					success:function(data){gbi("status").innerHTML=data;}
				})'
		>
	</div>
</div>
<?

function comments_compress($buffer)
{
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	return $buffer; 
}

ob_end_flush(); ?>