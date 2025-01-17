namespace newball.dls
{
    using MyTeam.DbClass;
    using MyTeam.Functions;
    using MyTeam.OnlineList;
    using System;
    using System.Data.SqlClient;
    using System.Web.UI;

    public class football_rqgg : Page
    {
        protected double abcadd = 0;

        private void InitializeComponent()
        {
            base.Load += new EventHandler(this.Page_Load);
        }

        protected override void OnInit(EventArgs e)
        {
            this.InitializeComponent();
            base.OnInit(e);
        }

        private void Page_Load(object sender, EventArgs e)
        {
            if (!MyFunc.CheckUserLogin(1) || !MyTeam.OnlineList.OnlineList.isUserLogin(1))
            {
                MyFunc.goToLoginPage();
                base.Response.End();
            }
            else if (!this.Page.IsPostBack)
            {
                this.TopMenuProcess();
                this.ProcessContent();
            }
        }

        private void ProcessContent()
        {
            string s = "<font style='FONT-SIZE:9pt'>&nbsp;&nbsp;三全中</font>\n<table id='m_tab' border='0' cellspacing='1' cellpadding='0' width='510' class='tableNoBorder1'>\n<tr align='center' class='dlsheader' height=25 >\n";
            s = s + "<td width='60'nowrap>时间</td><td width='130'nowrap>联塞</td><td width='170'>主队/客队</td><td width='150'>三全中</td></tr>" + this.SumAllMember();
            base.Response.Write(s);
        }

        private string SumAllMember()
        {
            string sql = "";
            string text2 = "";
            int num = 0;
            string connStr = "";
            connStr = MyFunc.GetConnStr(2);
            connStr = connStr.Substring(connStr.IndexOf("catalog=", 0) + 8, (connStr.IndexOf(";user", 0) - connStr.IndexOf("catalog=", 0)) - 8);
            if ((this.Session.Contents["football_rqgg.aspx"] != null) && (this.Session.Contents["football_rqgg.aspx"].ToString().Trim() != ""))
            {
                sql = "select * from ball_pl7view where matchname in (" + MyFunc.FormatMyStr(this.Session.Contents["football_rqgg.aspx"].ToString().Trim()) + ")";
            }
            else
            {
                sql = "select * from ball_pl7view where 1 = 1 ";
            }
            if ((this.Session.Contents["sessionSelectZD"] != null) && (this.Session.Contents["sessionSelectZD"].ToString().Trim() == "有单"))
            {
                string text5 = sql;
                sql = text5 + " and (select count(*) from " + connStr + "..ball_order where datediff(day,updatetime,getdate()) = 0 and charindex(ball_pl7view.team1,content)>0 and charindex(ball_pl7view.team2,content)>0 and charindex(ball_pl7view.matchname,content)>0 and tztype = 8 and dlsid='" + this.Session["adminuserid"].ToString() + "') > 0";
            }
            DataBase base2 = new DataBase(MyFunc.GetConnStr(2));
            SqlDataReader reader = base2.ExecuteReader(sql);
            while (reader.Read())
            {
                num++;
                string text6 = ((text2 + "<tr class='TableBody1'>") + "<td nowrap align=center>" + reader["balltime"].ToString() + "</td>") + "<td align=center>" + reader["matchname"].ToString() + "</td>\n<td><table cellSpacing='0' cellPadding=\"0\" width=\"100%\" border=\"0\"><tr><td>";
                string text7 = text6 + reader["team1"].ToString() + "</td></tr><tr><td>" + reader["team2"].ToString() + "</td></tr></table></td>\n";
                text2 = text7 + "<td align=center><a href='tzinfo.aspx?gameid=" + reader["ballid"].ToString().Trim() + "&tztype=8&marker=none'>" + MyFunc.SumStatic(reader["ballid"].ToString().Trim(), "8", "none") + "</a></td></tr>";
            }
            if (num == 0)
            {
                text2 = text2 + "<tr class='TableBody1'><td colspan=4 align=center height=30><marquee align=middle behavior=alternate width=200><font color=red size=2><b>没有相关注单</b></font></marquee></td></tr>";
            }
            reader.Close();
            base2.CloseConnect();
            base2.Dispose();
            return (text2 + "\n</table></form></body></html>");
        }

        private void TopMenuProcess()
        {
            string ltype = "C";
            string retime = "-1";
            string strMethod = "rqgg";
            if (base.Request.Form["selectZD"] != null)
            {
                this.Session["sessionSelectZD"] = base.Request.Form["selectZD"].ToString();
            }
            else if (this.Session["sessionSelectZD"] == null)
            {
                this.Session["sessionSelectZD"] = "无有单";
            }
            if (base.Request.Form["staticCS"] != null)
            {
                this.Session["sessionSelectStaticCS"] = base.Request.Form["staticCS"].ToString();
            }
            else if (this.Session["sessionSelectStaticCS"] == null)
            {
                this.Session["sessionSelectStaticCS"] = "全部";
            }
            if (base.Request.Form["ltype"] != null)
            {
                ltype = base.Request.Form["ltype"].ToString().Trim();
                this.Session["football_b_ltype"] = ltype;
            }
            else if (this.Session["football_b_ltype"] != null)
            {
                ltype = this.Session["football_b_ltype"].ToString().Trim();
            }
            if (base.Request.Form["retime"] != null)
            {
                retime = base.Request.Form["retime"].ToString().Trim();
                this.Session["football_b_retime"] = retime;
            }
            else if (this.Session["football_b_retime"] != null)
            {
                retime = this.Session["football_b_retime"].ToString().Trim();
            }
            if (ltype.ToUpper() == "A")
            {
                this.abcadd = 0.01;
            }
            if (ltype.ToUpper() == "B")
            {
                this.abcadd = 0.03;
            }
            if (ltype.ToUpper() == "D")
            {
                this.abcadd = -0.015;
            }
            string s = MyFunc.pintingAgenceMenu(ltype, retime, strMethod);
            base.Response.Write(s);
        }
    }
}

