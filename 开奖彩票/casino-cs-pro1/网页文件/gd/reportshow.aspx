<%@ Page language="c#" Codebehind="reportshow.aspx.cs" AutoEventWireup="false" Inherits="newball.gd.reportshow" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<title>reportshow</title>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<link rel="stylesheet" href="css/css.css" type="text/css">
	</HEAD>
	<body topmargin="1" leftmargin="2">
		<form id="Form1" method="post" runat="server">
			<table id="tableBarMenu" width="950" runat="server" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td>
						&nbsp;&nbsp;股东：
					</td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" width="950" id="tableHeader" runat="server">
				<tr class="dlsreport">
					<td>信用</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
			<br>
			<table border="0" cellpadding="0" cellspacing="0" width="950" id="tableMiddle" runat="server">
				<tr class="dlsreport">
					<td>过单</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" width="950" id="tableBottom" runat="server">
				<tr class="pinkheader">
					<td>总数</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
