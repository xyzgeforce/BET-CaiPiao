﻿<?
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");    
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");    
header("Cache-Control: no-store, no-cache, must-revalidate");    
header("Cache-Control: post-check=0, pre-check=0", false);    
header("Pragma: no-cache"); 
header("Content-type: text/html; charset=utf-8");

include ("../../agents/include/address.mem.php");
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../../agents/include/config.inc.php");

$uid=$_REQUEST["uid"];
$langx=$_SESSION["langx"];
$loginname=$_SESSION["loginname"];
$lv=$_REQUEST["lv"];
require ("../../agents/include/traditional.$langx.inc.php");

$sql = "select website,Admin_Url from web_system_data where ID=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$admin_url=explode(";",$row['Admin_Url']);
if (in_array($_SERVER['SERVER_NAME'],array($admin_url[0],$admin_url[1],$admin_url[2],$admin_url[3]))){
   $web='web_system_data';
}else{
   $web='web_agents_data';
}
switch ($lv){
case 'M':
	$user='Admin';
	break;	
case 'A':
	$user='Super';
	break;
case 'B':
	$user='Corprator';
	break;
case 'C':
	$user='World';
	break;
case 'D':
    $user='Agents';
	break;
}
$sql = "select ID,UserName,Language,SubUser,SubName from $web where Oid='$uid' and LoginName='$loginname'";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."','_top')</script>";
}
$row = mysql_fetch_array($result);
$subUser=$row['SubUser'];
if ($subUser==0){
	$name=$row['UserName'];
}else{
	$name=$row['SubName'];
}
if (isset($_POST['edit']))
{
	$title = $_POST['title'];
	$content = str_replace("\r\n","<br />",$_POST['content']);
	$creatdate = date("Y-m-d H:i:s",time());
	$sql = "update `web_member_msg` set ";
	$sql .= "`title`='$title',";
	$sql .= "`content`='$content',";
	$sql .= "`creatdate`='$creatdate',";
	$sql .= "`state`='0' where `id`='".$_POST['d_msgid']."'";	
	//$sql;die();
	mysql_db_query($dbname, $sql) or die($sql);
	echo "<script>alert('更新成功！');window.location.replace('msg_list.php?uid=".$uid."');</script>";
}
if (isset($_POST['del']))
{
	$arr = $_POST['msgid'];
	foreach ($arr as $v)
	{
		$b .= $v.",";
	}
	$b = substr($b, 0, strlen($b)-1);
	$del .= "delete from `web_member_msg` where id in (".$b.");";
	//echo $del;die();
	mysql_query($del) or die(mysql_error());
	echo "<script>alert('删除成功!');hisotry.back();</script>";
}
$id=$_REQUEST['id'];
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
$sql="select * from `web_member_msg` order by id desc";
$result = mysql_db_query($dbname,$sql);
$cou=mysql_num_rows($result);
if ($_REQUEST['everypage']=='')
{
	$page_size=30;
}
else
{
	$page_size=$_REQUEST['everypage'];
}
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
//echo $mysql;
$result = mysql_db_query($dbname,$mysql);
if ($cou==0){
	$page_count=1;
}
?>
<html>
<head>
<title>MSG系統</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<? if($noread>0){ ?>
<? } ?>
<script language="JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
// -->

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}
//-->
</script>
<script language="JavaScript" src="/js/agents/simplecalendar.js"></script>
<script>
function clickMsg()
{
	var chk=document.getElementsByTagName("input");
	for(var ii=0;ii<chk.length;ii++){
		if(chk[ii].type.toLowerCase()=="checkbox")
			chk[ii].checked=!chk[ii].checked;
	}
}
function setPage()
{
	var Page = document.getElementById("everypage").value;
	window.location.replace('msg_list.php?uid=<?=($uid)?>&everypage='+Page);
}
</script>
<link rel="stylesheet" href="/style/agents/control_800main.css" type="text/css">
<link rel="stylesheet" href="/style/agents/control_calendar.css">
<style type="text/css">
<!--
.m_rig2 { background-color: #CCCCCC; text-align: right}
-->
</style>
</head>
<!--<base target="net_ctl_main">
<base target="_top">-->
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C" 

oncontextmenu="self.event.returnValue=false;window.event.returnValue=false;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;
    <font color="#000099"><a href=../admin/system.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> style="color:#00F;" target="main" title="系统参数" onMouseOver="window.status='系统参数'; return true;" onMouseOut="window.status='';return true;">系统参数</a></font>&nbsp;&nbsp;
    <font color="#000099"><a href=../admin/add_notice.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> style="color:#00F;" target="main" title="系统公告" onMouseOver="window.status='系统公告'; return true;" onMouseOut="window.status='';return true;">系统公告</a></font>&nbsp;&nbsp;
    <font color="#000099"><a href=../admin/news.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&action=opennews style="color:#00F;" target="main" title="系统短信" onMouseOver="window.status='系统短信'; return true;" onMouseOut="window.status='';return true;">系统短信</a></font>&nbsp;&nbsp;
    <font color="#000099"><a href=../admin/news.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?>&action=sitenews style="color:#00F;" target="main" title="系统消息" onMouseOver="window.status='系统消息'; return true;" onMouseOut="window.status='';return true;">系统消息</a></font>&nbsp;&nbsp;
	<font color="#000099"><a href=../adminmsg/index.php?uid=<?=$uid?>&lv=<?=$lv?>&langx=<?=$langx?> style="color:#00F;" target="main" title="会员消息" onMouseOver="window.status='系统公告'; return true;" onMouseOut="window.status='';return true;">会员消息</a></font>&nbsp;&nbsp;
    <font color="#000099"><a href="../admin/access.php?uid=<?=$uid?>&langx=<?=$langx?>&action=S" style="color:#00F;">会员存款</a></font>&nbsp;&nbsp;
    <font color="#000099"><a href="../admin/access.php?uid=<?=$uid?>&langx=<?=$langx?>&action=T" style="color:#00F;">会员提款</a></font>
	</td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <FORM id="myFORM" ACTION="" METHOD=POST  name="FrmData">
  <tr> 
    <td class="m_tline">
        <table width="549" border="0" cellpadding="0" cellspacing="0" >
          <tr> 
		    
            <td width="274">设置每页显示
            <label>
              <input name="everypage" value="<?=($page_size)?>" type="text" id="everypage" size="3" >
              <input type="submit" name="button" id="button" value="确定" onClick="setPage();">
            </label>
            ---&nbsp;總頁數:</td>
            <td width="57"> 
              <select id="page" name="page"  class="za_select" onChange="self.myFORM.submit()">
              <?
		      if ($page_count==0){
			      $page_count=1;
			  }
		      for($i=0;$i<$page_count;$i++){
				  if ($i == $page)
				  {
					  $s = 'selected="selected"';
				  }
				  else
				  {
					  $s = '';
				  }
			      echo "<option  ".$s."  value='$i'>".($i+1)."</option>";
		       }
		      ?>
              </select>
            </td>
            <td width="218"> / <?=$page_count?> 頁</td>
          </tr>
        </table>
      </td>
    <td width="30"><img src="/images/agents/top/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</FORM>
</table>
<table width="975" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_top">
      <table border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          <td >&nbsp;<img src="/images/agents/top/main_dot.gif" width="13" height="15">&nbsp; 
          </td>
          <td ><font color="#000099"><a href="take_msg.php?uid=<?=($uid)?>" style="color:#00F;">发送一条新的短消息</a></font></td>
        </tr>
      </table>
    </td>
    <td width="221"><img src="/images/agents/800/800_title_p1.gif" width="221" height="31"></td>
  </tr>
</table>
<table width="975" border="0" cellspacing="0" cellpadding="0" class="m_tab">
  <tr>
    <td>
      <table width="100%" border="1" cellspacing="2" cellpadding="0" class="m_tab_main" bordercolor="#CCCCCC">
      <form  method=post target='_self' action="<?=($_SERVER['PHP_SELF']."?uid=".$uid."&langx=".$langx)?>">
        <tr class="m_title"> 
          <td width="103" align="center">全选
<label>
              <input onClick="clickMsg();" type="checkbox" name="checkbox" id="checkbox">
          </label></td>
          <td width="191" align="center">标题</td>
          <td width="305" align="center">内容</td>
          <td width="67" align="center">状态</td>
          <td width="80" align="center">接收人</td>
          <td width="201" align="center">操作</td>
        </tr>
        <!-- BEGIN DYNAMIC BLOCK: row -->
<?
if ($cou==0){
?>
<tr class="m_cen"> 
          <td>目前沒有記錄</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
<?
}else{
while ($row = mysql_fetch_array($result)){
?>
<tr class="m_cen"> 
          <td><?=($row['id'])?><input value="<?=($row['id'])?>" type="hidden" name="d_msgid">
            <input value="<?=($row['id'])?>" type="checkbox" name="msgid[]" id="msgid[]"></td>
          <td><textarea name="title" cols="25" rows="5"><?=($row['title'])?>
          </textarea></td>
          <td><textarea name="content" cols="40" rows="5"><?=(str_replace("<br />","\r\n",$row['content']))?>
          </textarea></td>
          <td align="center"><? if ($row['state']==0) { echo "<font color=red>未读</font>";} else {echo "<font color=green>已读</font>";} ?>&nbsp;</td>
          <td align="center"><?=($row['receive'])?></td>
          <td align="center">日期： 
            <label>
            <?=($row['creatdate'])?>
            <br>
            <input type="submit" name="edit" id="edit" value="更新标题及内容">
            <br>
            * 更新后，短信变为<strong>未读</strong></label></td>
        </tr>
<?
} 
}      
?>
<tr class="m_cen"> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="center"><label>
            <input type="submit" name="del" id="del" value="删除所有选中ID">
          </label></td>
        </tr>
        </form>
        <!-- END DYNAMIC BLOCK: row -->
      </table>
    </td>
  </tr>
</table>
<table width="975" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td background="/images/agents/800/800_title_p21b.gif">&nbsp;</td>
    <td width="18"><img src="/images/agents/800/800_title_p22.gif" width="18" height="15"></td>
    <td width="200" class="m_foot">Copyrignt by SYTNET Online Corporation</td>
  </tr>
</table>
</body>
</html>