package com.mh.web.controller;

import java.util.HashMap;
import java.util.Map;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import com.mh.commons.orm.Page;
import com.mh.commons.utils.HttpClientUtil;
import com.mh.commons.utils.ServletUtils;
import com.mh.entity.WebBankHuikuan;
import com.mh.service.WebBankHuikuanService;
import com.mh.web.login.UserContext;
/**
 * 我的账户--投注管理---充值记录（汇款）
 * @author Administrator
 *
 */
@Controller
@RequestMapping("/webBankHuiKuan")
public class WebBankHuikuanController extends BaseController{
	@Autowired
	private WebBankHuikuanService webBankHuikuanService;
	
	
	/**
	 * 充值记录列表
	 * 方法描述: TODO</br> 
	 * @param request
	 * @param response
	 * @param cpParameter  
	 * void
	 */
	@RequestMapping("/getWebBankHuiKuanList")
	public void getWebBankHuiKuanList(HttpServletRequest request,HttpServletResponse response){
		try {
			UserContext uc = this.getUserContext(request);
 
			String beginTimeStr = request.getParameter("beginTimeStr");
			String endTimeStr = request.getParameter("endTimeStr");
			
			String orderNo = request.getParameter("orderNo");
			String status = request.getParameter("status");
			WebBankHuikuan huikuan = new WebBankHuikuan();
			
 
			huikuan.setUserName(uc.getUserName());
			if(StringUtils.isNotBlank(status)){
				huikuan.setStatus(status);
			}
			if(StringUtils.isNotBlank(orderNo)){
				huikuan.setHkOrder(orderNo);
			}
	 
			if(StringUtils.isNotBlank(beginTimeStr)){
				huikuan.setBeginTimeStr(beginTimeStr);
			}
			if(StringUtils.isNotBlank(endTimeStr)){
				huikuan.setEndTimeStr(endTimeStr);
			}
			
			
			Page page = this.newPage(request);
			webBankHuikuanService.getWebBankHuikuanList(page,huikuan); 
			
			
			ServletUtils.outPrintSuccess(request, response, page);
		} catch (Exception e) {
			e.printStackTrace();
			ServletUtils.outPrintFail(request, response, "查询汇款失败！" );
		}
	
	}
	public static void main(String[] args) {
		String url="http://127.0.0.1:8080/yabo/webBankHuiKuan/getWebBankHuiKuan";
		Map<String,String> params=new HashMap<String,String>();
		params.put("beginTime", "2015-09-22 05:22:00");
		params.put("endTime", "2015-10-10 01:12:01");
		params.put("userName", "love2015");
		params.put("currentPage", "1");
		params.put("pageLimit", "20");
		String str = HttpClientUtil.post(url, params);
		System.out.println(str);
	}
}
