<?
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

include "../include/address.mem.php";
echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");

$uid=$_REQUEST['uid'];
$langx=$_SESSION['langx'];
$rtype=ltrim(strtolower($_REQUEST['rtype']));
$league_id=$_REQUEST['league_id'];
require ("../include/traditional.$langx.inc.php");
if ($rtype==""){
	$rtype="r";
}
$sql = "select Status from web_member_data where Oid='$uid' and Status=0";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('".BROWSER_IP."/tpl/logout_warn.html','_top')</script>";
	exit;
}
mysql_close();
?>
<!--<script>if (top.game_alert.indexOf('BK')==-1){alert("<?=$mem_msg?>"); top.game_alert+='BK,'}</script>-->
<script> 
var show_ior = '100';
</script>
<html>
<head>
<title>下注分割畫面</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script> 
var keepGameData=new Array();
var gidData=new Array();
parent.gamecount=0;
//判斷賠率是否變動
//包td
 
function checkRatio(rec,index){
 //alert(flash_ior_set);
	//return true;
	if (flash_ior_set =='Y'){
 
		if (""+keepGameData[rec]=="undefined"||keepGameData[rec]==""){
			keepGameData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
		}
		//判斷gid是否相同
		if (gidData[rec]!=GameFT[rec][0]||""+GameFT[rec][0]=="undefined"){
			keepGameData[rec]=new Array();
			gidData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
			gidData[rec][0]=GameFT[rec][0];
		}
 
		if (""+keepGameData[rec][index]=="undefined" ||keepGameData[rec][index]==""){
			keepGameData[rec][index]=GameFT[rec][index];
		}
		//alert("aaa==>"+keepGameData[rec][index]+"bbb==>"+GameFT[rec][index]);
		if (keepGameData[rec][index]!=GameFT[rec][index]&& keepGameData[rec][index] !=""&&GameFT[rec][index]!=""){
	    	//keepGameData[rec][index]=GameFT[rec][index];
	    	keepGameData[rec][index] = "";
	    	//keepGameData[rec]="";
			return " bgcolor=yellow ";
		}
		return true;
	}
}
//包font
function checkRatio_font(rec,index){
//alert(flash_ior_set);
	//return true;
	//alert(GameFT.length+"----"+keepGameData.length)
 
	if (flash_ior_set =='Y'){
		if (""+keepGameData[rec]=="undefined"||keepGameData[rec]==""){
			keepGameData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
		}
		//判斷gid是否相同
		if (gidData[rec]!=GameFT[rec][0]||""+GameFT[rec][0]=="undefined"){
			keepGameData[rec]=new Array();
			gidData[rec]=new Array();
			keepGameData[rec][index]=GameFT[rec][index];
			gidData[rec][0]=GameFT[rec][0];
		}
		if (""+keepGameData[rec][index]=="undefined"||keepGameData[rec][index] ==""){
			keepGameData[rec][index]=GameFT[rec][index];
		}
 
		//alert("ccc==>"+keepGameData[rec][index]+"ddd==>"+GameFT[rec][index]);
		if (keepGameData[rec][index]!=GameFT[rec][index] && keepGameData[rec][index] !=""&&GameFT[rec][index]!="") {
	    	//keepGameData[rec][index]=GameFT[rec][index];
	    	keepGameData[rec][index] = "";
	    	//keepGameData[rec]="";
			return '  style=\"background-color : yellow\" ';
		}
		return true;
	}
}
function gethighlight(){
	return " style=\"color:red\" style=\"font-weight:bolder\" ";
}
//滑鼠移動帶出索引
//function showMsg(msg, type) {
//	var showHelpMsg = body_browse.document.getElementById("showHelpMsg");
////	var showHelpMsg = parent.body_browse.document.getElementById('showHelpMsg');
//	var helpMsg = body_browse.document.getElementById('helpMsg').innerHTML;
//	var tmpHTML = "";
//	if(type == 1) {
//		tmpHTML = helpMsg;
//		tmpHTML = tmpHTML.replace("*SHOWMSG*", msg);
//		showHelpMsg.innerHTML = tmpHTML;
//		showHelpMsg.style.display = "block";
//		showHelpMsg.style.top = body_browse.document.body.scrollTop+body_browse.event.clientY-10;
//		showHelpMsg.style.left = body_browse.document.body.scrollLeft+body_browse.event.clientX+10;
//	} else showHelpMsg.style.display = "none";
//}
 
//====== 加入現場轉播功能 2009-04-09
// 開啟轉播
function OpenLive(eventid, gtype){
	if (top.liveid == undefined) {
		parent.self.location = "";
		return;
	}
	window.open("../live/live.php?langx="+top.langx+"&uid="+top.uid+"&liveid="+top.liveid+"&eventid="+eventid+"&gtype="+gtype,"Live","width=780,height=585,top=0,left=0,status=no,toolbar=no,scrollbars=no,resizable=no,personalbar=no");
}
 
function VideoFun(eventid, hot, play, gtype) {
	var tmpStr = "";
	if (play == "Y") {
		tmpStr+= "<img lowsrc=\"/images/member/video_1.gif\" onClick=\"parent.OpenLive('"+eventid+"','"+gtype+"')\" style=\"cursor:hand\">";
	} else {
		tmpStr+= "<img lowsrc=\"/images/member/video_2.gif\">";
	}
	return tmpStr;
}
 
function MM_ShowLoveI(gid,getDateTime,getLid,team_h,team_c){
	var txtout="";
	if(!top.swShowLoveI){
		if(!chkRepeat(gid)){	
			txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img id='"+MM_imgId(getDateTime,gid)+"' lowsrc=\"/images/member/icon_X2.gif\" vspace=\"0\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></span>";
		}else{
			txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></span>";
		}
	}else{
		txtout = "<img lowsrc=\"/images/member/love_small.gif\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \">";
	}
	return txtout;
}
 
function chkRepeat(gid){
	var getGtype =getGtypeShowLoveI();
	var sw =false;
	for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
		if(top.ShowLoveIarray[getGtype][i][0]==gid)
			sw =true;
	}
	return sw;
}
 
function MM_IdentificationDisplay(time,gid){
	var getGtype = getGtypeShowLoveI();
	var txt_array = top.ShowLoveIOKarray[getGtype];
	if(top.swShowLoveI){
		var tmp = time.split("<br>")[0];
		if(txt_array.length==0)return true;
		if(txt_array.indexOf(tmp+gid +",",0)== -1)
			return true;
	}
}
function getGtypeShowLoveI(){
	var Gtype;
	var getGtype =sel_gtype;
	
	if(getGtype =="FU"||getGtype=="FT"){
		Gtype ="FT";
	}else if(getGtype =="OM"||getGtype=="OP"){
		Gtype ="OP";
	}else if(getGtype =="BU"||getGtype=="BK"){
		Gtype ="BK";
	}else if(getGtype =="BSFU"||getGtype=="BS"){
		Gtype ="BS";
	}else if(getGtype =="VU"||getGtype=="VB"){
		Gtype ="VB";
	}else if(getGtype =="TU"||getGtype=="TN"){
		Gtype ="TN";
	}else {
		Gtype ="FT";
	}
	//alert("in==>"+parent.sel_gtype+",out==>"+Gtype);
	return Gtype;
}
function MM_imgId(time,gid){	
	var tmp = time.split("<br>")[0];
	//alert(tmp+gid);
	return tmp+gid;
}
 
</script>
<script>
 
/**
 * 選擇多盤口時 轉換成該選擇賠率
 * @param odd_type 	選擇盤口
 * @param iorH		主賠率
 * @param iorC		客賠率
 * @param show		顯示位數
 * @return		回傳陣列 0-->H  ,1-->C
 */
function  get_other_ioratio(odd_type, iorH, iorC , showior){
	var out=new Array();
	if(iorH!="" ||iorC!=""){
		out =chg_ior(odd_type,iorH,iorC,showior);
	}else{
		out[0]=iorH;
		out[1]=iorC;
	}
	return out;
}
/**
 * 轉換賠率
 * @param odd_f
 * @param H_ratio
 * @param C_ratio
 * @param showior
 * @return
 */
function chg_ior(odd_f,iorH,iorC,showior){
	var ior=new Array();
	if(iorH < 3) iorH *=1000;
	if(iorC < 3) iorC *=1000;
	iorH=parseFloat(iorH);
	iorC=parseFloat(iorC);
	switch(odd_f){
	case "H":	//香港變盤(輸水盤)
		ior = get_HK_ior(iorH,iorC);
		break;
	case "M":	//馬來盤
		ior = get_MA_ior(iorH,iorC);
		break;
	case "I" :	//印尼盤
		ior = get_IND_ior(iorH,iorC);
		break;
	case "E":	//歐洲盤
		ior = get_EU_ior(iorH,iorC);
		break;
	default:	//香港盤
		ior[0]=iorH ;
		ior[1]=iorC ;
	}
	ior[0]/=1000;
	ior[1]/=1000;
	
	ior[0]=printf(Decimal_point(ior[0],showior),iorpoints);
	ior[1]=printf(Decimal_point(ior[1],showior),iorpoints);
	//alert("odd_f="+odd_f+",iorH="+iorH+",iorC="+iorC+",ouH="+ior[0]+",ouC="+ior[1]);
	return ior;
}
 
/**
 * 換算成輸水盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_HK_ior( H_ratio, C_ratio){
	var out_ior=new Array();
	var line,lowRatio,nowRatio,highRatio;
	var nowType="";
	if (H_ratio <= 1000 && C_ratio <= 1000){
		out_ior[0]=H_ratio;
		out_ior[1]=C_ratio;
		return out_ior;
	}
	line=2000 - ( H_ratio + C_ratio );
	if (H_ratio > C_ratio){ 
		lowRatio=C_ratio;
		nowType = "C";
	}else{
		lowRatio = H_ratio;
		nowType = "H";
	}
	if (((2000 - line) - lowRatio) > 1000){
		//對盤馬來盤
		nowRatio = (lowRatio + line) * (-1);
	}else{
		//對盤香港盤
		nowRatio=(2000 - line) - lowRatio;	
	}
	if (nowRatio < 0){
		highRatio = Math.floor(Math.abs(1000 / nowRatio) * 1000) ;
	}else{
		highRatio = (2000 - line - nowRatio) ;
	}
	if (nowType == "H"){
		out_ior[0]=lowRatio;
		out_ior[1]=highRatio;
	}else{
		out_ior[0]=highRatio;
		out_ior[1]=lowRatio;
	}
	return out_ior;
}
/**
 * 換算成馬來盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_MA_ior( H_ratio, C_ratio){
	var out_ior=new Array();
	var line,lowRatio,highRatio;
	var nowType="";
	if ((H_ratio <= 1000 && C_ratio <= 1000)){
		out_ior[0]=H_ratio;
		out_ior[1]=C_ratio;
		return out_ior;
	}
	line=2000 - ( H_ratio + C_ratio );
	if (H_ratio > C_ratio){ 
		lowRatio = C_ratio;
		nowType = "C";
	}else{
		lowRatio = H_ratio;
		nowType = "H";
	}
	highRatio = (lowRatio + line) * (-1);
	if (nowType == "H"){
		out_ior[0]=lowRatio;
		out_ior[1]=highRatio;
	}else{
		out_ior[0]=highRatio;
		out_ior[1]=lowRatio;
	}
	return out_ior;
}
/**
 * 換算成印尼盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_IND_ior( H_ratio, C_ratio){
	var out_ior=new Array();
	out_ior = get_HK_ior(H_ratio,C_ratio);
	H_ratio=out_ior[0];
	C_ratio=out_ior[1];
	H_ratio /= 1000;
	C_ratio /= 1000;
	if(H_ratio < 1){
		H_ratio=(-1) / H_ratio;
	}
	if(C_ratio < 1){
		C_ratio=(-1) / C_ratio;
	}
	out_ior[0]=H_ratio*1000;
	out_ior[1]=C_ratio*1000;
	return out_ior;
}
/**
 * 換算成歐洲盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_EU_ior(H_ratio, C_ratio){
	var out_ior=new Array();
	out_ior = get_HK_ior(H_ratio,C_ratio);
	H_ratio=out_ior[0];
	C_ratio=out_ior[1];       
	out_ior[0]=H_ratio+1000;
	out_ior[1]=C_ratio+1000;
	return out_ior;
}
/*
去正負號做小數第幾位捨去
進來的值是小數值
*/
function Decimal_point(tmpior,show){
	var sign="";
	sign =((tmpior < 0)?"Y":"N");
	tmpior = (Math.floor(Math.abs(tmpior) * show + 1 / show )) / show;
	return (tmpior * ((sign =="Y")? -1:1)) ;
}
 
 
/*
 公用 FUNC
*/
function printf(vals,points){ //小數點位數
	vals=""+vals;
	var cmd=new Array();
	cmd=vals.split(".");
	if (cmd.length>1){
		for (ii=0;ii<(points-cmd[1].length);ii++)vals=vals+"0";
	}else{
		vals=vals+".";
		for (ii=0;ii<points;ii++)vals=vals+"0";
	}
	return vals;
}</script>
<script> 
function ShowGameList(){
	if(loading == 'Y') return;
	obj_msg = body_browse.document.getElementById('real_msg');
	obj_msg.innerHTML = '<marquee scrolldelay=\"120\">'+msg+'</marquee>';
	//只有 讓分/走地 才有更新時間
	if(ShowType=='OU' || ShowType=='RE'){
		hr_info = body_browse.document.getElementById('hr_info');
		if(retime){
			hr_info.innerHTML = retime+str_renew;
		}else{
			hr_info.innerHTML = str_renew;
		}
//		if(body_browse.ReloadTimeID)	clearInterval(body_browse.ReloadTimeID);
//		if (retime_flag == 'Y')	body_browse.ReloadTimeID = setInterval("body_browse.reload_var()",retime*1000);
	}
	game_table = body_browse.document.getElementById('game_table');
	//alert(keepGameData.length+"---"+gamount)
	if (parent.gamecount!=gamount){
		keepGameData=new Array();
	}
	if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";
	switch(ShowType){
		case 'OU':	//單式
			ShowData_OU(game_table,GameFT,gamount,top.odd_f_type);
			show_page();
			break;
		case 'RE':	//單式
			ShowData_RE(game_table,GameFT,gamount,top.odd_f_type);
			break;
		case 'PR':	//讓球過關
			ShowData_PR(game_table,GameFT,gamount);
			break;
	}
	parent.gamecount=gamount;
}
function show_page(){
	pg_str='';
	obj_pg = body_browse.document.getElementById('pg_txt');
	//alert(eval("top."+top.sel_gtype+"_lid_ary"))
	if(eval("parent."+sel_gtype+"_lid_ary")=='ALL'&&!top.swShowLoveI){
		for(var i=0;i<t_page;i++){
		  	if (pg!=i)
		  		pg_str=pg_str+"<a href=# onclick='chg_pg("+i+");'>"+(i+1)+"</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		  	else
		  		pg_str=pg_str+(i+1)+"&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	//alert(pg_str)
	obj_pg.innerHTML = pg_str;
}
//------單式顯示------
function ShowData_OU(obj_table,GameData,data_amount,odd_f_type){
	var R_ior =Array();
	var OU_ior =Array();
	
	var nowLeague = '';
	var nowDate = '';
 
	with(obj_table){
		//清除table資料
		while(rows.length > 1) deleteRow(rows.length-1);
 
		//開始顯示開放中賽程資料
		for(i=0; i<data_amount; i++){
			if(MM_IdentificationDisplay(GameData[i][1],GameData[i][3]))continue;
			R_ior  = get_other_ioratio(odd_f_type, GameData[i] [9], GameData[i][10] , show_ior);
			OU_ior = get_other_ioratio(odd_f_type, GameData[i][13], GameData[i][14] , show_ior);
 
			if(("-"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2]+"-"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') continue;
 
			gdate = GameData[i][1].substr(0,5);
			//====== 判斷是否為早, 並秀出所選擇的賽程日期
			//if (g_date != "" && gdate != g_date.substr(5,5)) continue;
 
			//判斷聯盟是否相同不同加一列顯示聯盟
			if(nowLeague != GameData[i][2] || nowDate != gdate){
				nowLeague = GameData[i][2];
				nowDate = gdate;
				nowTR = insertRow();
				with(nowTR){
					nowTD = insertCell();
					nowTD.colSpan = 5;
					nowTD.className = 'b_hline';
					nowTD.innerHTML = GameData[i][2];
					//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"</td>"+
					//	"<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
				}
			}
			nowTR = insertRow();
			nowTR.id ="TR_"+MM_imgId(GameData[i][1],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = 'b_cen';
			with(nowTR){
			    //滾球字眼
			    GameData[i][1]=GameData[i][1].replace("Running Ball",top.str_RB);
				//日期時間
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				nowTD.innerHTML = GameData[i][1]+'<BR>';
				//隊伍
				nowTD = nowTR.insertCell();
				nowTD.rowSpan = 2;
				nowTD.align = 'left';
				nowTD.innerHTML = GameData[i][5]+'&nbsp;&nbsp;<BR>'+GameData[i][6];
				//tmp_data=GameData[i][5].split("<");
				tmp_data=((GameData[i][5].replace("<font style=background-color:#FFFF99>","")).replace("</font>","")).split("<");
				//單雙
				nowTD = insertCell();
				if(langx=="zh-tw"){
						title_str="單";
					}
					if(langx=="zh-cn"){
						title_str="单";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Odd";
					}
				nowTD.innerHTML = GameData[i][15]+'<A href=\"../BK_order/BK_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=ODD\" target=\"mem_order\" title=\"'+title_str+'\"><font '+checkRatio_font(i,17)+'>'+GameData[i][17]+'</A></font>';
				//讓球主隊
				nowTD = insertCell();
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == 'H') //強隊是客隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				else  //強隊是主隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
				tmpStr += '<td '+checkRatio(i,9)+'><a href=\"../BK_order/BK_order_r.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=H&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'\" target=\"mem_order\" title=\"'+tmp_data[0]+'\">'+R_ior[0]+'</a></td>'+
					'</tr></table>';
				nowTD.innerHTML = tmpStr;
				//大小盤主隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(langx=="zh-tw"){
						title_str="大";
					}
					if(langx=="zh-cn"){
						title_str="大";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Over";
					}
				nowTD.innerHTML = '<font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</font>&nbsp;&nbsp;'+
					'<A href=\"../BK_order/BK_order_ou.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=C&gnum='+GameData[i][4]+'\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,14)+'>'+OU_ior[1]+'</A></font>&nbsp;';
			}//主隊TR結束
 
			nowTR = insertRow();
			nowTR.id ="TR1_"+MM_imgId(GameData[i][1],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = 'b_cen';
			with(nowTR){
				//單雙
				tmp_data=((GameData[i][6].replace("<font style=background-color:#FFFF99>","")).replace("</font>","")).split("<");
				nowTD = insertCell();
				if(langx=="zh-tw"){
						title_str="雙";
					}
					if(langx=="zh-cn"){
						title_str="双";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Even";
					}
				nowTD.innerHTML = GameData[i][16]+'<A href=\"../BK_order/BK_order_t.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&rtype=EVEN\" target=\"mem_order\" title=\"'+title_str+'\"><font '+checkRatio_font(i,18)+'>'+GameData[i][18]+'</A></font>';
				//讓球客隊
				nowTD = insertCell();
 
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == 'C') //強隊是主隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				else  //強隊是客隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
				tmpStr += '<td '+checkRatio(i,10)+'><a href=\"../BK_order/BK_order_r.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=C&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'\" target=\"mem_order\" title=\"'+tmp_data[0]+'\">'+R_ior[1]+'</a></td>'+
					'</tr></table>';
				nowTD.innerHTML = tmpStr;
				//大小盤客隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(langx=="zh-tw"){
						title_str="小";
					}
					if(langx=="zh-cn"){
						title_str="小";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Under";
					}
				nowTD.innerHTML = '<font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</font>&nbsp;&nbsp;'+
					'<A href=\"../BK_order/BK_order_ou.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=H&gnum='+GameData[i][3]+'\" target=\"mem_order\" title=\"'+title_str+'\">&nbsp;&nbsp;<font '+checkRatio_font(i,13)+'>'+OU_ior[0]+'</A></font>&nbsp;';
			}//客隊TR結束
 
			nowTR = insertRow();
			nowTR.id ="TR2_"+MM_imgId(GameData[i][1],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			nowTR.className = 'b_cen';
			with(nowTR){
				nowTD = insertCell();
				nowTD.align = 'left';
				//nowTD.innerHTML = str_even;
				//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
				tmpStr = "<table width='100%'><tr><td align='left'>&nbsp;</td>";
				tmpStr+= "<td class='hot_td'>";
				tmpStr+= "<table><tr align='right' height='17'><td>";
				tmpStr+=MM_ShowLoveI(GameData[i][3],GameData[i][1],GameData[i][2],GameData[i][5],GameData[i][6]);
				tmpStr+= "</td><td>";
				if (top.casino == "SI2") {
					if (GameData[i][20] != "" && GameData[i][20] != "null" && GameData[i][20] != undefined) {	//判斷是否有轉播
						tmpStr+= VideoFun(GameData[i][21], GameData[i][22], GameData[i][23], "BK");
					}
				}
				tmpStr+= "</td></tr></table>";
				tmpStr+= "</td>";
				tmpStr+= "</tr></table>";
				nowTD.innerHTML = tmpStr;
 
				nowTD = insertCell();
				nowTD.colSpan = 5;
				nowTD.height = 1;
			}//分隔線TR
		}
	}//with(obj_table);
}//顯示單式結束
 
function ShowData_RE(obj_table,GameData,data_amount,odd_f_type){
	var R_ior =Array();
	var OU_ior =Array();
	
	var nowLeague = '';
	//var nowDate = '';
	var half='';
	with(obj_table){
		//清除table資料
		while(rows.length > 1)
			deleteRow(rows.length-1);
		//開始顯示走地賽程資料
		for(i=0; i<data_amount; i++){
			if(MM_IdentificationDisplay(GameData[i][32],GameData[i][3]))continue;
			R_ior  = get_other_ioratio(odd_f_type, GameData[i] [9], GameData[i][10] , show_ior);
			OU_ior = get_other_ioratio(odd_f_type, GameData[i][13], GameData[i][14] , show_ior);
 
			if(("-"+parent.BK_lname_ary_RE).indexOf(("-"+GameData[i][2].replace(/&#/g,"+-")+"-"),0)==-1&&parent.BK_lname_ary_RE!='ALL') continue;
//			if ((GameData[i][9] == "" || GameData[i][10] == "") && (GameData[i][13] == "" || GameData[i][14] == "")){
//				continue;
//			}
			//判斷聯盟是否相同不同加一列顯示聯盟
			//gdate = GameData[i][1].substr(0,5);
 
			if(nowLeague != GameData[i][2]){
				nowLeague = GameData[i][2];
				//nowDate = gdate;
				nowTR = insertRow();
				with(nowTR){
					nowTD = insertCell();
					nowTD.className = 'b_hline';
					nowTD.colSpan = 6;
					nowTD.innerHTML = GameData[i][2];
					//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"</td>"+
					//	"<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
				}
			}
 
//			if(chk_half(GameData[i][5])){
//				half ='h'
//			}else{
//				half = '';
//			}
			nowTR = insertRow();
			nowTR.id ="TR_"+MM_imgId(GameData[i][32],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			if(chk_half(GameData[i][5])){
				nowTR.className = 'b_1st';
			}else{
				nowTR.className = 'b_cen';
			}
			with(nowTR){
//				//目前結果
//				nowTD = insertCell();
//				nowTD.rowSpan = 2;
//				nowTD.innerHTML = GameData[i][18]+':'+GameData[i][19];
				//日期時間
				nowTD = insertCell();
				nowTD.rowSpan = 3;
				nowTD.innerHTML = GameData[i][1];
				//隊伍主隊
				nowTD = nowTR.insertCell();
				nowTD.align = 'left';
				nowTD.innerHTML = GameData[i][5];
				tmp_data=GameData[i][5].split("<");
				//讓球主隊
				nowTD = insertCell();
 
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == 'H') //強隊是主隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				else  //強隊是客隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp;</td>';
				tmpStr += '<td '+checkRatio(i,9)+'><a href=\"../BK_order/BK_order_'+half+'re.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=H&gnum='+GameData[i][3]+'&strong='+GameData[i][7]+'\" target=\"mem_order\" title=\"'+tmp_data[0]+'\">'+R_ior[0]+'</a></td>'+
					  '</tr></table>';
				nowTD.innerHTML = tmpStr;
				//大小盤主隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(langx=="zh-tw"){
						title_str="大";
					}
					if(langx=="zh-cn"){
						title_str="大";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Over";
					}
				nowTD.innerHTML = '<font '+checkRatio_font(i,11)+'>'+GameData[i][11]+'</font>&nbsp;&nbsp;'+
						'&nbsp;&nbsp;<a href=\"../BK_order/BK_order_'+half+'rou.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=C&gnum='+GameData[i][4]+'\" target=\"mem_order\" title=\"'+title_str+'\"><font '+checkRatio_font(i,14)+'>'+OU_ior[1]+'</a></font>&nbsp;';
			}//主隊TR結束
 
			nowTR = insertRow();
			nowTR.id ="TR1_"+MM_imgId(GameData[i][32],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			if(chk_half(GameData[i][5])){
				nowTR.className = 'b_1st';
			}else{
				nowTR.className = 'b_cen';
			}
			with(nowTR){
				//隊伍客隊
				nowTD = nowTR.insertCell();
				nowTD.align = 'left';
				nowTD.innerHTML = GameData[i][6];
				tmp_data=GameData[i][6].split("<");
				//讓球客隊
				nowTD = insertCell();
				tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">';
				if(GameData[i][7] == 'C') //強隊是客隊
					tmpStr += '<tr><td '+checkRatio(i,8)+' align=\"center\" width=\"68%\">'+GameData[i][8]+'</td>';
				else  //強隊是主隊
					tmpStr += '<tr><td align=\"center\" width=\"68%\">&nbsp</td>';
				tmpStr += '<td '+checkRatio(i,10)+'><a href=\"../BK_order/BK_order_'+half+'re.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=C&gnum='+GameData[i][4]+'&strong='+GameData[i][7]+'\" target=\"mem_order\"  title=\"'+tmp_data[0]+'\">'+R_ior[1]+'</a></td>'+
					  '</tr></table>';
				nowTD.innerHTML = tmpStr;
				//大小盤主隊
				nowTD = insertCell();
				nowTD.align = 'right';
				if(langx=="zh-tw"){
						title_str="小";
					}

					if(langx=="zh-cn"){
						title_str="小";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Under";
					}
				nowTD.innerHTML = '<font '+checkRatio_font(i,12)+'>'+GameData[i][12]+'</font>&nbsp;&nbsp;'+
						'&nbsp;&nbsp;<a href=\"../BK_order/BK_order_'+half+'rou.php?gid='+GameData[i][0]+'&uid='+uid+'&odd_f_type='+odd_f_type+'&type=H&gnum='+GameData[i][3]+'\" target=\"mem_order\" title=\"'+title_str+'\"><font '+checkRatio_font(i,13)+'>'+OU_ior[0]+'</a></font>&nbsp;';
			}//客隊TR結束
 
			nowTR = insertRow();
			nowTR.id ="TR2_"+MM_imgId(GameData[i][32],GameData[i][3]);
			nowTR.onmouseover =function(){body_browse.mouseEnter_pointer(this.id);}
			nowTR.onmouseout =function(){body_browse.mouseOut_pointer(this.id);}
			if(chk_half(GameData[i][5])){
				nowTR.className = 'b_1st';
			}else{
				nowTR.className = 'b_cen';
			}
			with(nowTR){
				nowTD = insertCell();
				nowTD.align = 'left';
				//nowTD.innerHTML = str_even;
				//====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
				tmpStr = "<table width='100%'><tr><td align='left'>&nbsp;</td>";
				tmpStr+= "<td class='hot_td'>";
				tmpStr+= "<table><tr align='right' height='17'><td>";
				tmpStr+=MM_ShowLoveI(GameData[i][3],GameData[i][32],GameData[i][2],GameData[i][5],GameData[i][6]);
				tmpStr+= "</td><td>";
				if (top.casino == "SI2") {
					if (GameData[i][29] != "" && GameData[i][29] != "null" && GameData[i][29] != undefined) {	//判斷是否有轉播
						tmpStr+= VideoFun(GameData[i][29], GameData[i][30], GameData[i][31], "BK");	
					}
				}
				tmpStr+= "</td></tr></table>";
				tmpStr+= "</td>";
				tmpStr+= "</tr></table>";
				nowTD.innerHTML = tmpStr;
 
				nowTD = insertCell();
				nowTD.colSpan = 5;
				nowTD.height = 1;
			}//分隔線TR
		}
	}//with(obj_table);
}//顯示走地結束
 
//------讓球過關顯示------
function ShowData_PR(obj_div,GameData,data_amount){
 
/* GameFT Array		gid, gdate, league, gnum_h, gnum_c, team_h, team_c, strong, 讓球球頭, PRH賠率, PRC賠率, 大小球頭, POUH賠率, POUC賠率
					 0	   1	  2		  3		  4		  5		  6		  7			8		9		 10		  11,12		13			14
*/
	var nowLeague = '';
	var nowDate = '';
	var firstFlag = 1;
 
	gcount = 0;
	gc = 0;
	//清除div資料
	obj_div.innerHTML = "";
 
	//開始顯示讓球過關賽程資料
	for(i=0; i<data_amount; i++){
		if(MM_IdentificationDisplay(GameData[i][1],GameData[i][3]))continue;
//		alert(eval('top.'+top.sel_gtype+'_lname_ary').indexOf(GameData[i][2].replace(/&#/g,"+-")+"-",0)+"\n"+top.BK_lname_ary);
//		if(eval('top.'+top.sel_gtype+'_lname_ary').indexOf(GameData[i][2].replace(/&#/g,"+-")+"-",0)==-1&&eval('top.'+top.sel_gtype+'_lname_ary')!='ALL') {gc++;continue;}
		if(("-"+eval('parent.'+sel_gtype+'_lname_ary')).indexOf(("-"+GameData[i][2]+"-"),0)==-1&&eval('parent.'+sel_gtype+'_lname_ary')!='ALL') continue;
 
		//判斷是否讓球兩個賠率都有值,否則不顯示
		if((GameData[i][9]=='' || GameData[i][10]=='') && (GameData[i][12]=="" || GameData[i][13]== "")){
			gc++;
			continue;
		}
		//判斷聯盟是否相同不同加一列顯示聯盟
		//滾球字眼過關只秀時間
		GameData[i][1]=GameData[i][1].replace("<br><font color=red>Running Ball</font>","");		
		gdate = GameData[i][1].substr(0,5);
		if(nowLeague != GameData[i][2] || nowDate != gdate){
		    if(nowDate != gdate){
 			    if(!firstFlag){
					nowTR = obj_table.insertRow();
					nowTR.bgColor = '#FFFFFF';
					nowTR.align = 'center';
					nowTR.height = 30;
					nowTD = nowTR.insertCell();
					nowTD.colSpan = 5;
 
					if(gcount > 1){
						nowTD.innerHTML = '<INPUT TYPE=\"HIDDEN\" NAME=\"teamcount\" VALUE=\"'+gcount+'\">'+
//										  '<INPUT TYPE=\"HIDDEN\" NAME=\"active\" VALUE=\"1\">'+
										  '<INPUT TYPE=\"HIDDEN\" NAME=\"uid\" VALUE=\"'+uid+'\">'+
										  '<input type=SUBMIT id=\"TEAM'+showDate+'\" value=\"'+str_submit+'\" class=\"yes\">&nbsp;&nbsp;&nbsp;';
					}
 
					nowTD.innerHTML += '<input type=BUTTON name=\"cancel2\" value=\"'+str_reset+'\" class=\"no\" onClick=\"parent.ShowGameList();\">';
				}//if(!firstFlag)
				firstFlag = 0;
				nowDate = gdate;
				showDate = gdate.substr(0,2)+''+gdate.substr(3,2);
				gcount = 0;
				obj_div.innerHTML += '<TABLE ID=\"gtable'+showDate+'\" width=\"526\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"game\">'+
									 '<TR><TD><FORM ID=\"form'+showDate+'\" NAME=\"form'+showDate+'\" ACTION=\"/app/member/BK_order/BK_order_pr.php\" METHOD=POST onSubmit=\"return ChkSelect(\''+showDate+'\'); reload_var();\" target=\"mem_order\"></TD></TR>'+
									 '</TABLE></FORM>';
				obj_table = body_browse.document.getElementById('gtable'+showDate);
			}//if(nowDate != gdate)
 
			nowLeague = GameData[i][2];
			nowTR = obj_table.insertRow();
			nowTD = nowTR.insertCell();
			nowTD.className = 'b_hline';
			nowTD.colSpan = 5;
			nowTD.innerHTML = GameData[i][2]+'&nbsp;&nbsp;'+nowDate;
						//nowTD.innerHTML = "<table border=\"0\"  width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"b_h_txt\">"+GameData[i][2]+"&nbsp;&nbsp;"+nowDate+"</td>"+
						//	  "<td class=\"b_h_but\"><input type=\"button\" name=\"ReloadLeague"+i+"\" value=\""+top.str_renew+"\" title=\""+top.str_renew+"\" onClick=\"javascript:reload_var();\" ></td></tr></table>";
		}//if(nowLeague != GameData[i][2] || nowDate != gdate)
 
		gcount++;
		nowTR = obj_table.insertRow();
		nowTR.className = 'b_cen';
		nowTR.id="pr";
		with(nowTR){
			var tmp_team = "";
			//日期時間(過關只秀時間)
			nowTD = insertCell();
			nowTD.className = 'time';
			nowTD.innerHTML = '<INPUT type=\"HIDDEN\" NAME=\"game_id'+gcount+'\" VALUE=\"'+GameData[i][0]+'\">'+GameData[i][1].slice(-6,15);
 
			//場次
			nowTD = insertCell();
			nowTD.className = 'num';
			nowTD.innerHTML = GameData[i][3]+"<br>"+GameData[i][4];
 
			// 主客隊名
			nowTD = insertCell();
			nowTD.className = 'team';
			nowTD.align = "left";
			nowTD.innerHTML = GameData[i][5]+"<BR>"+GameData[i][6];
 
			//==== 讓球
			nowTD = insertCell();
			nowTD.className = 'pr';
			nowTD.align = "right";
			if (GameData[i][9] != "" && GameData[i][10] != ""){
				//強隊讓球賠率
				if(GameData[i][7] == 'H') {tmp_team = "<font "+checkRatio_font(i,8)+" color='#000000'>"+GameData[i][8]+"</font>&nbsp;&nbsp;";}
				tmp_team += "<font "+checkRatio_font(i,9)+" color='#CC0000'><B>"+GameData[i][9]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='PRH' class='za_dot' title=\""+GameData[i][5]+"\">&nbsp;<BR>";
 
				//強隊是客隊
				if(GameData[i][7] == 'C') {tmp_team += "<font "+checkRatio_font(i,8)+" color='#000000'>"+GameData[i][8]+"</font>&nbsp;&nbsp;";}
				tmp_team += "<font "+checkRatio_font(i,10)+" color='#CC0000'><B>"+GameData[i][10]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='PRC' class='za_dot' title=\""+GameData[i][6]+"\">&nbsp;";
				nowTD.innerHTML = tmp_team;
			}
 
			//==== 大小球
			nowTD = insertCell();
			nowTD.className = 'ou';
			nowTD.align = "right";
			if (GameData[i][13] != "" && GameData[i][14] != ""){
				if(langx=="zh-tw"){
						title_str="大";
					}
					if(langx=="zh-cn"){
						title_str="大";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Over";
					}
				tmp_team  = "<font "+checkRatio_font(i,11)+" color='#000000'>"+GameData[i][11]+"</font>&nbsp;&nbsp;";	//大
				tmp_team += "<font "+checkRatio_font(i,13)+" color='#CC0000'><B>"+GameData[i][13]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='POUC' class='za_dot' title=\""+title_str+"\">&nbsp;";
				tmp_team += "<BR>";
				if(langx=="zh-tw"){
						title_str="小";
					}
					if(langx=="zh-cn"){
						title_str="小";
					}
					if(langx=="en-us"||langx=="th-tis"){
						title_str="Under";
					}
				tmp_team += "<font "+checkRatio_font(i,12)+" color='#000000'>"+GameData[i][12]+"</font>&nbsp;&nbsp;";	//小
				tmp_team += "<font "+checkRatio_font(i,14)+" color='#CC0000'><B>"+GameData[i][14]+"</B></font>&nbsp;<input type='radio' name='game"+gcount+"' value='POUH' class='za_dot' title=\""+title_str+"\">&nbsp;";
				nowTD.innerHTML = tmp_team;
			}
		}//with(nowTR)
	}
 
	//判斷賽事數量兩場以上就顯示確認按鈕
	if((data_amount-gc)!=0){
		nowTR = obj_table.insertRow();
		nowTR .bgColor = '#FFFFFF';
		nowTR.align = 'center';
		nowTR.height = 30;
		nowTD = nowTR.insertCell();
		nowTD.colSpan = 6;
		if(gcount > 1){
			nowTD.innerHTML = '<INPUT TYPE=\"HIDDEN\" NAME=\"teamcount\" VALUE=\"'+gcount+'\">'+
//			                  '<INPUT TYPE=\"HIDDEN\" NAME=\"active\" VALUE=\"1\">'+
			                  '<INPUT TYPE=\"HIDDEN\" NAME=\"uid\" VALUE=\"'+uid+'\">'+
			                  '<input type=SUBMIT id=\"TEAM'+showDate+'\" value=\"'+str_submit+'\" class=\"yes\">&nbsp;&nbsp;&nbsp;';
		}
		nowTD.innerHTML += '<input type=BUTTON name=\"cancel2\" value=\"'+str_reset+'\" class=\"no\" onClick=\"parent.ShowGameList();\">';
	}
}//讓球過關結束
 
function chk_half(str){
 
	if(str.indexOf("<font color=gray>") > -1) return true;
	return false;
}
</script>
<!--SCRIPT language=javaScript src="/js/BK_mem_showgame.js" type=text/javascript></SCRIPT-->
<SCRIPT LANGUAGE="JAVASCRIPT"> 
<!-- 
var username='';
var maxcredit='';
var code='';
var pg=0;
var uid=''; //user's session ID
var loading = 'Y'; //是否正在讀取瀏覽頁面
var loading_var = 'Y'; //是否正在讀取變數值頁面
var ShowType = ''; //目前顯示頁面
var ltype = 1; //目前顯示line
var retime_flag = 'N'; //自動更新旗標
var retime = 0; //自動更新時間
 
var str_even = '和局';
var str_renew = '秒自動更新';
var str_submit = '確認';
var str_reset = '重設';
 
var num_page = 20; //設定20筆賽程一頁
var now_page = 1; //目前顯示頁面
var pages = 1; //總頁數
var msg = ''; //即時資訊
var gamount = 0; //目前顯示一般賽程數
var GameFT = new Array(512); //最多設定顯示512筆開放賽程
for(var i=0; i<512; i++){
	GameFT[i] = new Array(34); //為各賽程宣告 34 個欄位
}
var sel_gtype='BK';
var iorpoints=3;
// -->
</SCRIPT>
</head>
<frameset rows="0,*" frameborder="NO" border="0" framespacing="0"  style="height:510px;">
  <frame name="body_var" scrolling="NO" noresize src="body_var.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>&league_id=<?=$league_id?>">
  <frame name="body_browse" src="body_browse.php?uid=<?=$uid?>&rtype=<?=$rtype?>&langx=<?=$langx?>">
</frameset>
<noframes><body bgcolor="#000000">
 
</body></noframes>
</html>

