<?php

App::uses('AppController', 'Controller');

/**
 * Vendorplants Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PayatomController extends AppController {

    public $components = array('Paginator', 'Session', 'Image','Mpdf');
    public $uses = array('CustomerBGP', 'PaymentMaster', 'Adminuser');
    public $layout = 'frontend';
	/*Atom */
    public function pay() {
		if(isset($_GET['text']))
		{
			$varr=base64_decode(strtr($_GET['text'], '-_', '+/'));		
			parse_str($varr,$url_prams);			
						
			// ===== For Test Use =============
				
			//	$url = "http://203.114.240.183/paynetz/epi/fts";// test bed URL
			//	$port = 80;
			//	$atom_prod_id = "NSE";
			//	
			//	$userid = "160";
			//	$password = "Test@123";
			//	$amount = "100";
			//	$clientcode = base64_encode("007");
			//	$invoiceid = $this->appid;
			//	$today = date("d/m/Y H:i:s");
			//	$returnurl = SITE_ROOT."/pay/responce";
			//	
			//	$param = "&login=".$userid."&pass=".$password."&ttype=NBFundTransfer&prodid=".$atom_prod_id."&amt=".$amount."&txncurr=INR&txnscamt=0&clientcode=".$clientcode."&txnid=".$invoiceid."&date=".$today."&custacc=12345&ru=".$returnurl;
				
			// ==== End ========

			$url = "https://payment.atomtech.in/paynetz/epi/fts";//live URL
			$port = 443;
			$atom_prod_id = "BIRLAGOLD";
			$login = "13716";
			$password = "Birla@123";
			$clientcode = base64_encode("007");
			$amount = $url_prams['amount'];
			
			if(count($url_prams) == 3)
				$txnid = $url_prams['id']."-".$url_prams['action'];
			else
				$txnid = $url_prams['id'];
			$today = date("d/m/Y H:i:s");
			$returnurl = BASE_URL."pay/response";
			$param = "&login=".$login."&pass=".$password."&ttype=NBFundTransfer&prodid=".$atom_prod_id."&amt=".$amount."&txncurr=INR&txnscamt=0&clientcode=".$clientcode."&txnid=".$txnid."&date=".$today."&custacc=12345&ru=".$returnurl;


			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_PORT , $port);
			//curl_setopt($ch, CURLOPT_SSLVERSION,3);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
			$returnData = curl_exec($ch);
			
			// Check if any error occured
			if(curl_errno($ch))
			{
				echo "Curl error: " . curl_error($ch);
			}
			curl_close($ch);

			$xmlObj = new SimpleXMLElement($returnData);

			$final_url = $xmlObj->MERCHANT->RESPONSE->url;
			// eof code to generate token
			// code to generate form action
			$param = "";
			$param .= "&ttype=NBFundTransfer";
			$param .= "&tempTxnId=".$xmlObj->MERCHANT->RESPONSE->param[1];
			$param .= "&token=".$xmlObj->MERCHANT->RESPONSE->param[2];
			$param .= "&txnStage=1";
			$url = $url."?".$param;
			header("Location: ".$url);
			exit;			
		}	
		else {
			return $this->redirect(array('controller' => 'customermaster', 'action' => 'registration'));
		}		
    }
	

	public function response()
	{
		$search = array();
		/* $search["mer_txn"] = $_POST['mer_txn'];
		$check_name = $this->PaymentMaster->find('all', array('conditions' => $search));
		if(count($check_name) == 0)
		{ */
			//$result = $db->Insert($table, $_POST,1);
			$data = explode("-",$_POST["mer_txn"]);
			$_POST["mer_txn"]  = $data[0];
			$data['PaymentMaster']["mmp_txn"] = $_POST["mmp_txn"];
			$data['PaymentMaster']["mer_txn"] = $_POST["mer_txn"];
			$data['PaymentMaster']["amt"] = $_POST["amt"];
			$data['PaymentMaster']["prod"] = $_POST["prod"];
			$data['PaymentMaster']["date"] = $_POST["date"];
			$data['PaymentMaster']["bank_txn"] = $_POST["bank_txn"];
			$data['PaymentMaster']["f_code"] = $_POST["f_code"];
			$data['PaymentMaster']["clientcode"] = $_POST["clientcode"];
			$data['PaymentMaster']["bank_name"] = $_POST["bank_name"];
			$data['PaymentMaster']["udf9"] = $data[1];
			
			$result = $this->PaymentMaster->save($data);
	//	}
  		if($_POST['f_code']=="Ok") // atom status
		{
	  		if($result)
	  		{
	  			$data = array();
	  			$data['send_form'] = 1;
				
	  				$this->CustomerBGP->updateAll(
					array('send_form' => "1"),
					array('application_no' => $_POST['mer_txn'])
				);
				$search = array();
				$search["application_no"] = $_POST['mer_txn'];
				$result_data = $this->CustomerBGP->find("all",array('conditions' => $search,
								'joins' => array(
									array(
										'alias' => 'payment',
										'table' => 'payment_master',
										'type' => 'left',
										'conditions' => array('payment.mer_txn = CustomerBGP.application_no','payment.udf9' => $data['PaymentMaster']["udf9"],'payment.f_code' => "'".$_POST['f_code']."'" )
									)
								), 'order' => 'CustomerBGP.customer_id DESC'));
				
				
				$bank_name = '';
				$branch_name = '';
				$tenture = '';
				$monthly_sub_amt = '';
				
				
	  			$app_no = $result_data[0]['CustomerBGP']['application_no'];
				$dist_data = 'RDIRECT';
				if(isset($result_data[0]['CustomerBGP']['partner_code']) && $result_data[0]['CustomerBGP']['partner_code'] != ''){
					$dist_data = $result_data[0]['CustomerBGP']['partner_code'];
				}
				
				$toname ="";
				$toname = $result_data[0]['CustomerBGP']['applicant_name'];
				
				if( $result_data[0]['CustomerBGP']['monthly_sip_pdc']== 'SIP'){
					$bank_name = $result_data[0]['CustomerBGP']['bank_name'];
					$tenture = $result_data[0]['CustomerBGP']['tenure'];
					$monthly_sub_amt = $result_data[0]['CustomerBGP']['ecs_amount_of_subscription'];
					$branch_name = $result_data[0]['CustomerBGP']['ecs_branch_address'];
				}else{
					$bank_name = '';
					$tenture = $result_data[0]['CustomerBGP']['tenure'];
					$monthly_sub_amt = $result_data[0]['CustomerBGP']['amount'];
					$branch_name = '';
				}
				
				$branch_name = str_replace('\r\n',' ',$branch_name);
				
	  			$html_ac = '<html>
					<head>
					
					<style>
					/**** Common Style *****/
					div, dl, dt, dd, ul, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
						margin:0;
						padding:0;
					}
					html, body {
						font-size:15px;
						text-align:left;
						color:#373435;
						font-family: Arial, Helvetica, sans-serif;
						direction: ltr;
						font-weight:normal;
						margin:0;
						padding:0px 0 0 0;
						background: #fff;
					}
					
					.paddingT2		{padding-top:2px;}
					.paddingB2		{padding-bottom:2px;}
					
					.paddingT5		{padding-top:5px;}
					.paddingB5		{padding-bottom:5px;}
					.paddingT		{padding-top:10px;}
					.paddingL		{padding-left:10px;}
					.paddingR		{padding-right:10px;}
					.paddingB		{padding-bottom:10px;}
					.marginr15		{margin-right:15px;}
					.paddingL5		{padding-left:5px;}
					.paddingR5		{padding-right:5px;}
					
					.head2{ font-size:18px; color:#373435;}
					.rightTxt{ color:#373435;}
					.rightTxt a {color:#373435; text-decoration:none;}
					.codeBox{border:1px solid #333; width:25px; height:28px;}
					.codeBoxR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center;}
					.heading{ background:#D2D3D5; border:1px solid #333; font-weight:bold; padding:3px 0 3px 5px; width:995px;}
					.boxContent{ border:1px solid #333; border-top:0; padding:5px 0 5px 10px; width:990px; }
					
					.inputBox{ width:60%; padding:2%; border:1px solid #333; margin:0; }
					.taxStatusBorder{width:190px; }
					.inputBoxDtl{ width:180px; padding:22px; border:1px solid #333; margin:0; }
					.inputBoxDtl-2{width:265px; height:22px; border:1px solid #333; margin:0; }
					
					.inputBox_sign{width:210px; height:30px; padding:3px; border:1px solid #333; margin:0; }
					.inputBox-email{width:480px; padding:3px; border:1px solid #333; margin:0; }
					.photoBox{ border:1px solid #333;display:inline-block; padding:5px;} 
					
					/**** Application Form 12-05-2014 ****/
					.paddingT2		{padding-top:2px;}
					.paddingB2		{padding-bottom:2px;}
					
					.inputBoxDtl-2{width:210px; padding:3px; border:1px solid #333; margin:0; }
					.app_inputBox{width:90px; padding:3px; border:1px solid #333; margin:0; }
					.underLine{width:90px;}
					.fontsize11{ font-size:11px;}
					.fontsize12{ font-size:12px;}
					.fontsize14{ font-size:14px;}
					.fontsize15{ font-size:15px;}
					.lF{ float:left;}
					.rF{ float:right;}
					.passPhoto{ border:1px solid #333; display:inline-block; padding:5px; background:#999; vertical-align:middle;}
					.head2{ font-size:18px; color:#373435;}
					.checkBox{ width:12px; width:12px; border:1px solid #666; margin:0; padding:0;}/**/
					.bold{ font-weight:bold;}
					.Boxborder{border:1px solid #333;}
					.borderTR{ border-top:1px solid #333;  border-right:1px solid #333;}
					.borderBL{ border-bottom:1px solid #333;  border-left:1px solid #333;}
					.DetailBox{border:1px solid #333; width:25px; height:28px; background:#d1d2d4; text-align:center; line-height:28px; text-transform:uppercase;}
					.DetailBoxR{border:1px solid #333; border-left:0; width:25px; height:28px; text-align:center; background:#d1d2d4; line-height:28px; text-transform:uppercase;}
					.DateBox{border:1px solid #333; width:25px; height:22px; text-align:center; text-transform:uppercase;}
					.DateBoxR{border:1px solid #333; border-left:0; width:25px; height:22px; text-align:center; text-transform:uppercase;}
					.BoxborderBotm{border-bottom:1px solid #333;}
					.BoxborderRight{border-right:1px solid #333;}
					.BoxborderTop{border-top:1px solid #333;}
					.StatusBox{ width:120px;}
					.codeBoxBg{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
					.GardianDtl{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
					.GardianDtlR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center; background:#d1d2d4;}
					.paddingTRBL5{ padding:5px;}
					.paddingTRBL{ padding:10px;}
					
					.signBox{ border:2px dotted #333; text-align:center; width:420px; height:45px;}
					lable{ margin:0; padding:0;}
					
					/**** New class ****/ 
					.add_input{border:1px solid #333; width:976px; height:20px; background:#888888;}
					.residence_input{border:1px solid #333; width:846px; height:20px; background:#888888;}
					.inputBoxDtl-3{width:388px; height:22px; border:1px solid #333; margin:0; padding:3px 0;}
					.inputBoxDtl-4{width:427px; height:22px; border:1px solid #333; margin:0; padding:3px 0; }
					table { margin:0; padding:0;}
					</style>
					
					</head>
					<body>
					
					
					<div style="width:1000px; padding:10px 10px 10px 40px; margin:0 auto;"><table width="1000" border="0" cellspacing="0" cellpadding="0">';
			  			$html_ac .= '<tr>
								  <td colspan="2" align="left" class="paddingT2"><table border="0" cellspacing="0" cellpadding="0">
								  	<tr>
								  		<td style="padding-bottom:10px">
								  			<b>Acknowledgment Slip</b>
								  		</td>
								  		<td>
								  			Application No: '.$app_no.'
								  		</td>
								  	</tr>
								    <tr>
								      <td width="850" valign="top" style="font-size:14px;line-height:30px;">	
									  	<p>Received with thanks from Mr./Ms./Mrs  '.(($result_data[0]['CustomerBGP']['applicant_name'] != "") ? '<span style="text-decoration: underline;">'.$result_data[0]['CustomerBGP']['applicant_name'].'&nbsp;&nbsp;&nbsp;</span>' : "____________________________________________________").' an application for allotment</p><br/>
										<p>of gold gram under BGSP as per the advance payment details below:-<br/></p>
										<p>
										Amount '.(($result_data[0]['CustomerBGP']['amt'] != "") ? '<span style="text-decoration: underline;">'.$result_data[0]['CustomerBGP']['amt'].'</span>' : "___________________").' Payment Mode: Cheque/DD/Payorder Instrument No. '.(($result_data[0]['CustomerBGP']['bank_txn'] != "") ? '<span style="text-decoration: underline;">'.$result_data[0]['CustomerBGP']['bank_txn'].'</span>' : "___________________").' Date <span style="text-decoration: underline;">'.date('d-m-Y').'</span></p><br/>
										
										<p>Bank Name '.(($bank_name != "") ? '<span style="text-decoration: underline;">'.$bank_name.'</span>' : "______________________________").' Branch '.(($branch_name != "") ? '<span style="text-decoration: underline;">'.$branch_name.'</span>' : "_________________________").' Tenure '.(($tenture != "") ? '<span style="text-decoration: underline;">'.$tenture.' Years</span>' : "_________").'</p><br/>
										
										<p>Monthly Subscription Option: '.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? 'ECS / Direct Debit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : "PDC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;").' Monthly Subscription Amount '.(($monthly_sub_amt != 0) ? '<span style="text-decoration: underline;">'.$monthly_sub_amt.'</span>' : "______________").'</p>
									  </td>
								      <td align="center" class="paddingL">
								        <table width="180" border="0" cellspacing="0" cellpadding="0" class="">
								          <tr>
								            <td align="center" width="180" style="height:80px; text-align:center;">
								            <img src="img/logo.jpg" />
								            </td>
								          </tr>
								        </table>
								      </td>
								    </tr>
								  </table>
								 </td>
							   </tr>
							   <tr>
				              	<td height="28" valign="bottom" align="left" style="font-size:12px;">
				                	Birla Gold and Precious Metals Ltd
				                </td>
				              	<td height="28" valign="bottom" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
				              </tr>
							   </table></div>';
			  			
		  		$date = date_create();
				$pdf_time = date_timestamp_get($date);
				
				$this->Mpdf->init();
				$this->Mpdf->WriteHTML($html_ac);
				$this->Mpdf->Output(WWW_ROOT."/documents/tempPDF/AC_".$pdf_time.".pdf","F");

				
//============================================================= Cust Data Mail ===========================================================
				
				$html = '
			<html>
			<head>
			
			<style>
			/**** Common Style *****/
			div, dl, dt, dd, ul, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
				margin:0;
				padding:0;
			}
			html, body {
				font-size:13px;
				text-align:left;
				color:#373435;
				font-family: Arial, Helvetica, sans-serif;
				direction: ltr;
				font-weight:normal;
				margin:0;
				padding:0px 0 0 0;
				background: #fff;
			}
			
			.paddingT2		{padding-top:2px;}
			.paddingB2		{padding-bottom:2px;}
			
			.paddingT5		{padding-top:5px;}
			.paddingB5		{padding-bottom:5px;}
			.paddingT		{padding-top:10px;}
			.paddingL		{padding-left:10px;}
			.paddingR		{padding-right:10px;}
			.paddingB		{padding-bottom:10px;}
			.marginr15		{margin-right:15px;}
			.paddingL5		{padding-left:5px;}
			.paddingR5		{padding-right:5px;}
			
			.head2{ font-size:18px; color:#373435;}
			.rightTxt{ color:#373435;}
			.rightTxt a {color:#373435; text-decoration:none;}
			.codeBox{border:1px solid #333; width:25px; height:28px;}
			.codeBoxR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center;}
			.heading{ background:#D2D3D5; border:1px solid #333; font-weight:bold; padding:3px 0 3px 5px; width:995px;}
			.boxContent{ border:1px solid #333; border-top:0; padding:5px 0 5px 10px; width:990px; }
			
			.inputBox{ width:60%; padding:2%; border:1px solid #333; margin:0; }
			.taxStatusBorder{width:190px; }
			.inputBoxDtl{ width:180px; padding:22px; border:1px solid #333; margin:0; }
			.inputBoxDtl-2{width:265px; height:22px; border:1px solid #333; margin:0; }
			
			.inputBox_sign{width:210px; height:30px; padding:3px; border:1px solid #333; margin:0; }
			.inputBox-email{width:480px; padding:3px; border:1px solid #333; margin:0; }
			.photoBox{ border:1px solid #333;display:inline-block; padding:5px;} 
			
			/**** Application Form 12-05-2014 ****/
			.paddingT2		{padding-top:2px;}
			.paddingB2		{padding-bottom:2px;}
			
			.inputBoxDtl-2{width:210px; padding:3px; border:1px solid #333; margin:0; }
			.app_inputBox{width:90px; padding:3px; border:1px solid #333; margin:0; }
			.underLine{width:90px;}
			.fontsize11{ font-size:11px;}
			.fontsize12{ font-size:12px;}
			.fontsize14{ font-size:14px;}
			.fontsize15{ font-size:15px;}
			.lF{ float:left;}
			.rF{ float:right;}
			.passPhoto{ border:1px solid #333; display:inline-block; padding:5px; background:#999; vertical-align:middle;}
			.head2{ font-size:18px; color:#373435;}
			.checkBox{ width:12px; width:12px; border:1px solid #666; margin:0; padding:0;}/**/
			.bold{ font-weight:bold;}
			.Boxborder{border:1px solid #333;}
			.borderTR{ border-top:1px solid #333;  border-right:1px solid #333;}
			.borderBL{ border-bottom:1px solid #333;  border-left:1px solid #333;}
			.DetailBox{border:1px solid #333; width:25px; height:28px; background:#d1d2d4; text-align:center; line-height:28px; text-transform:uppercase;}
			.DetailBoxR{border:1px solid #333; border-left:0; width:25px; height:28px; text-align:center; background:#d1d2d4; line-height:28px; text-transform:uppercase;}
			.DateBox{border:1px solid #333; width:25px; height:22px; text-align:center; text-transform:uppercase;}
			.DateBoxR{border:1px solid #333; border-left:0; width:25px; height:22px; text-align:center; text-transform:uppercase;}
			.BoxborderBotm{border-bottom:1px solid #333;}
			.BoxborderRight{border-right:1px solid #333;}
			.BoxborderTop{border-top:1px solid #333;}
			.StatusBox{ width:120px;}
			.codeBoxBg{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
			.GardianDtl{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
			.GardianDtlR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center; background:#d1d2d4;}
			.paddingTRBL5{ padding:5px;}
			.paddingTRBL{ padding:10px;}
			
			.signBox{ border:2px dotted #333; text-align:center; width:420px; height:45px;}
			lable{ margin:0; padding:0;}
			
			/**** New class ****/ 
			.add_input{border:1px solid #333; width:976px; height:20px; background:#888888;}
			.residence_input{border:1px solid #333; width:846px; height:20px; background:#888888;}
			.inputBoxDtl-3{width:388px; height:22px; border:1px solid #333; margin:0; padding:3px 0;}
			.inputBoxDtl-4{width:427px; height:22px; border:1px solid #333; margin:0; padding:3px 0; }
			table { margin:0; padding:0;}
			</style>
			
			</head>
			<body>
			
			
			<div style="width:1000px; padding:10px 10px 10px 40px; margin:0 auto;">
			
			<table width="1000" border="0" cellspacing="0" cellpadding="0">
			<tr>
			    <td colspan="2" align="left" valign="top">
			    	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			        <td width="840" align="left" valign="top" style="padding-right:10px;">
			            	<table width="820" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="410"><img src="img/logo.jpg" /></td>
			                    <td>
			                        <table width="250" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td colspan="2" class="head2">APPLICATION FORM &nbsp;</td>
			                          </tr>
			                          <tr>
			                            <td colspan="2" width="120" class="fontsize12">
			                            Application No. - '.$app_no.'
			                            </td>
			                          </tr>
			                        </table>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td colspan="2" class="paddingT2">
			                    	<span class="fontsize14">Please select the fulfillment preference</span>
			                    	
			                    	
			                    	<label><input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['fulfilment'] == "Coin") ? "checked=checked" : "").' value="" class="checkBox" /> Coin </label>
									<label><input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['fulfilment'] == "Jewellery") ? "checked=checked" : "").' value="" class="checkBox" /> Jewellery </label>
									<label><input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['fulfilment'] == "Pendant") ? "checked=checked" : "").' value="" class="checkBox" /> Pendant </label>';
				

			                    	
			                        
		$html.=	                        '<span class="fontsize11">(If not selected, default preference is Coin)</span>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td colspan="2" class="paddingT2">
			                       <table width="820" border="0" cellspacing="0" cellpadding="0" class="borderTR">
			                          <tr>
			                            <td class="borderBL fontsize15" align="center">Distributor Code</td>
			                            <td class="borderBL fontsize15" align="center">Sub-Partner Code</td>
			                            <td class="borderBL fontsize15" align="center">For Office Use Only</td>
			                          </tr>
			                          <tr>
			                            <td class="borderBL" style="text-align:center">'.$dist_data.'</td>
			                            <td class="borderBL">'.$result_data[0]['CustomerBGP']['sub_partner_code'].'</td>
			                            <td class="borderBL">&nbsp;</td>
			                          </tr>
			                         
			                      </table>
			                    </td>
			                  </tr>
			                </table>
			
			            </td>
						<td width="40"></td>
			          <td class="passPhoto bold" width="160" height="85" valign="middle" align="center">
			          		<br />Paste1 <br />
			                Passport size <br />
			                photograph
			            </td>
			          </tr>
			        </table>
			
			    </td>
			</tr>
			
			<tr>
			    <td height="15" colspan="2" align="left"><table width="1000%" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td>
			        <table width="1000" border="0" cellspacing="0" cellpadding="0">
			          <tr></tr>
			          <tr>
			            <td width="695" class="bold fontsize14"><strong>1.APPLICANT DETAILS</strong></td>
			            <td width="305" align="left" class="paddingT5">*are Mandatory Fields</td>
			          </tr>
			          <tr>
			            <td colspan="2" class="Boxborder paddingB2 paddingT2" width="1000"><table width="1000" border="0" cellpadding="0" cellspacing="0">
			              <tr>
			                <td valign="top"><table width="1000" border="0" cellspacing="0" cellpadding="0">
			                  
			                  
			                  <tr>
			                    <td class="paddingL" width="850"> *Name of Applicant (as mentioned on ID Proof)
			                      <label>
			                        Title </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_title'] == "Mr") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Mr. </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_title'] == "Ms") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Ms. </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_title'] == "Mrs") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Mrs. </label></td>
			                    <td width="190" align="right" class="paddingR"> Gender*:
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_gender'] == "Male") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Male</label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_gender'] == "Female") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Female</label></td>
			                  </tr>
			                  
			                </table></td>
			              </tr>
			              <tr>
			                <td class="paddingL">
			                	<input name="" type="text" class="add_input" style=" width:1001px;" value="'. $result_data[0]['CustomerBGP']['applicant_name'].'" />
			                </td>
			              </tr>
			              <tr>
			                <td valign="top" class="paddingL paddingT2 paddingB2">
			                <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			                  <tr>
			                    <td headers="8"></td>
			                    <td class="paddingR"></td>
			                  </tr>
			                  <tr>
			                  
			                   <td width="670" style="padding:0;"><span style="width:80px;" class="lF">Status </span>
			                   
			                  	<label style="width:140px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "Resident Individual") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Resident Individual </label>
			                      <label style="width:90px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "NRI") ? "checked=checked" : "").' value="" class="checkBox" />
			                        NRI </label>
			                      <label style="width:80px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "HUF") ? "checked=checked" : "").' value="" class="checkBox" />
			                        HUF </label>
			                      <label style="width:140px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "On behalf of Minor") ? "checked=checked" : "").' value="" class="checkBox" />
			                        On behalf of Minor </label>
			                      
			                     <div style="clear:both;"></div>
			                        <span style="width:93x;" class="lF">Proof of DOB* </span>
			                      <label style="width:129px;" class="lF paddingL">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Birth Certificate") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Birth Certificate</label>
			                      <label style="width:176px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Passport") ? "checked=checked" : "").' value="" class="checkBox" />
			                        School Leaving Certificate</label>
			                      <label style="width:90px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "School Leaving Certificate") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Passport</label>
			                      <label style="width:131px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />Others - '.$result_data[0]['CustomerBGP']['applicant_dob_proof_other'].'</label>
			                  
			                  	</td>
			                  	
			                    <td width="349" align="right" class="paddingR" style="padding-bottom:3px;"> 
			                      <table width="150" border="0" align="left" cellpadding="0" cellspacing="0">
			                        <tr>
			                          <td width="60">Date of Birth</td>
			                          
			                          <td class="DateBox" colspan="2">'.(($result_data[0]['CustomerBGP']['applicant_dob'] != "0000-00-00") ? date('d',strtotime($result_data[0]['CustomerBGP']['applicant_dob'])) : "").'</td>
			                          <td class="DateBoxR" colspan="2">'.(($result_data[0]['CustomerBGP']['applicant_dob'] != "0000-00-00") ? date('m',strtotime($result_data[0]['CustomerBGP']['applicant_dob'])) : "").'</td>
			                          <td class="DateBoxR" colspan="4">'.(($result_data[0]['CustomerBGP']['applicant_dob'] != "0000-00-00") ? date('Y	',strtotime($result_data[0]['CustomerBGP']['applicant_dob'])) : "").'</td>
			                          
			                        </tr>
			                      </table></td>
			                  </tr>
			                  
			                </table></td>
			              </tr>
			              <tr>
			              
			              <td class="paddingL BoxborderTop paddingT2" width="790"> Guardian Details (in case applicant is minor)
			                  <label> Title </label>
			                  <label>
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_title'] == "Mr") ? "checked=checked" : "").' value="" class="checkBox"/>
			                    Mr. </label>
			                  <label>
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_title'] == "Ms") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Ms. </label>
		                  </td>
			              
			              </tr>
			              <tr>
			                <td height="" >
			                	&nbsp;<input name="" type="text" class="add_input" style="width:1006px;" value="'.$result_data[0]['CustomerBGP']['applicant_guardian_name'].'"/>
			                </td>
			              </tr>
			              <tr>
			                <td class=" paddingL paddingT2">
			                <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="130">Country of Residence</td>
			                    <td align="left">
			                    	<input name="" type="text" class="residence_input" style="width:870px;" value="'.$result_data[0]['CustomerBGP']['applicant_guardian_country_resident'].'"/>
			                        </td>
			                  </tr>
			                </table>
			                </td>
			              </tr>
			              
			              
			              <tr>
			                <td class="paddingL paddingT2"><label class="lF" style="width:222px;">
			                  Relationship with minor</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship'] == "Father") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Father </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship'] == "Mother") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Mother</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Other - '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship_other'] != "") ? $result_data[0]['CustomerBGP']['applicant_guardian_relationship_other'] : "______________").'</label>
			                  </td>
			              </tr>
			            
			              <tr>
			                    <td align="center" class="paddingB2 paddingT2 fontsize14"><strong>
			                    	-----------------------------------------
			                    	Proof of Address Submitted by Applicant (any one of the below)
			                        ---------------------------------------</strong></td>
			                  </tr>
			              <tr>
			                <td class="paddingL"><label class="lF" style="width:182px;">
			                  <input name="input" type="checkbox" value="" class="checkBox " />
			                  UID(Aadhar)</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Driving License </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Passport</label>
			                  <label class="lF" style="width:142px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Voter ID </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Pan Card</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Other ___________</label></td>
			              </tr>
			            </table></td>
			          </tr>
			          
			        </table></td>
			      </tr>
			    </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left">
			  		<table width="980" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			            <td class="bold fontsize14 paddingT2"><strong>2.MAILING ADDRESS(*Fields are mandatory)</strong></td>
			          </tr>
			          <tr>
			            <td width="980" class=" Boxborder paddingB5 paddingL paddingT5">
			            	<table width="980" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="979">
			                    <textarea cols="" rows="2" style="width:983px;" class="add_txtarea">'.$result_data[0]['CustomerBGP']['mailing_address'].'</textarea>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2">
			                    <table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="70">Landmark</td>
			                        <td ><input name="" type="text" class="add_input" style="width:906px;" value="'.$result_data[0]['CustomerBGP']['mailing_landmark'].'" /></td>
			                      </tr>
			                    </table>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2"><table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="680">
			                        <table width="680" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70">City*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:607px;" value="'.$result_data[0]['CustomerBGP']['mailing_city'].'" /></td>
			                          </tr>
			                        </table></td>
			                        <td width="300">
			                        	<table width="300" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70" align="center">Pin Code*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:220px;" value="'.$result_data[0]['CustomerBGP']['mailing_pincode'].'" /></td>
			                          </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table></td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2"><table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="680">
			                        <table width="670" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70">State*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:607px;" value="'.$result_data[0]['CustomerBGP']['mailing_state'].'" /></td>
			                          </tr>
			                        </table></td>
			                        <td width="300">
			                        	<table width="300" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70" align="center">Country</td>
			                            <td width="30" >&nbsp;</td>
			                            <td width="" ><input name="" type="text" class="add_input" style="width:190px;" value="INDIA" /></td>
			                          </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table></td>
			                  </tr>
			                  <tr>
			                    <td>Overseas Address (Mandatory for NRI)</td>
			                  </tr>
			                  <tr>
			                    <td><input name="" type="text" class="add_input" value="'.$result_data[0]['CustomerBGP']['mailing_overseas_address'].'" /></td>
			                  </tr>
			                  <tr>
			                    <td align="center" class="paddingB5 paddingT5 fontsize15"><strong>
			                    	-----------------------------------------
			                    	Proof of Address Submitted by Applicant (any one of the below)
			                        -----------------------------------------
			                    	</strong></td>
			                  </tr>
			                  <tr width="970">
			                    <td class="paddingB5 paddingT5">
			                   <label class="lF" style="width:120px;">
			                  <input name="input" type="checkbox" value="" class="checkBox" />
			                  UID(Aadhar)</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Driving License </label>
			                  <label class="lF" style="width:110px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Passport</label>
			                  <label class="lF" style="width:111px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Voter ID </label>
			                  
			                    <label class="lF" style="width:112px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Ration Card</label>
			                    <label class="lF" style="width:172px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Lease or Sale Agreement</label>
			                    <label class="lF" style="width:222px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Latest Bank Statement/Passbook</label>
								
			                    
			                        
			                    </td>
			                  </tr>
							  <tr>
							  	<td>
									 <label class="lF" style="width:180px;">
										<input name="input" type="checkbox" value="" class="checkBox lF" />Latest Utility Bill</label>
								<label class="lF" style="width:190px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Latest Gas Bill</label>
			                  	<label class="lF">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Other____________</label>
								</td>
							  </tr>
			                  <tr>
			                    <td class="paddingT5 fontsize11" width="950">
			                    **Not more than 3 months old proof of address issued by any of the following: Bank Managers of Schedule Commercial Bank/Schedule Co-operative Bank/Multinational Foreign Bank
			Gazetted oficer/Notary Public/ElectedRepresentatives to the Representative to the Legislative Assembly/Parliament/Document issued by Govt. or Statutory Authority.
			                    </td>
			                  </tr>
			                  
			                </table>
			
			            </td>
			          </tr>
			        </table>
			
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="left" valign="top" class="paddingB5 paddingT5">
			  <table width="1000" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td class="bold fontsize14 paddingB paddingT">
			      	3. CONTACT DETAILS and PAN DETAIL (*Fields are mandatory)
			      </td>
			    </tr>
			    <tr>
			      <td class="paddingTRBL5" style="padding-left:0;">
			      <table width="1000" border="0" cellspacing="0" cellpadding="0" class="borderBL">
			        <tr>
			          <td width="80" class="paddingT2 paddingB2 borderTR">&nbsp; Phone</td>
			          <td width="120" class="paddingT2 paddingB2 borderTR">&nbsp; Residence</td>
			          <td width="230" class="paddingT2 paddingB2 borderTR">'.$result_data[0]['CustomerBGP']['contact_phone_residence'].'</td>
			          <td width="90" class="paddingT2 paddingB2 borderTR">&nbsp; Office</td>
			          <td width="200" class="paddingT2 paddingB2 borderTR">'.$result_data[0]['CustomerBGP']['contact_phone_office'].'</td>
			          <td width="300" class="paddingT2 paddingB2 borderTR">&nbsp; PAN No.- '.$result_data[0]['CustomerBGP']['contact_pan_no'].'</td>
			        </tr>
			      </table></td>
			    </tr>
			    <tr>
			      <td height="20" >
					  <table width="1010" border="0" cellspacing="0" cellpadding="0">
			        <tr>
			          <td width="480" align="left" >
			          <table width="480" border="0" cellspacing="0" cellpadding="0" class="Boxborder">
			            <tr>
			              <td width="180" class="BoxborderRight">&nbsp; E-mail</td>
			              <td width="300">'.$result_data[0]['CustomerBGP']['contact_email'].'</td>
			            </tr>
			          </table>
			          </td>
			          <td width="30"></td>
			          <td width="488">
			          <table width="490" border="0" align="right" cellpadding="0" cellspacing="0" class="Boxborder">
			            <tr>
			              <td width="170" class="BoxborderRight">&nbsp; Mobile</td>
			              <td width="338">'.$result_data[0]['CustomerBGP']['contact_mobile'].'</td>
			            </tr>
			          </table>
			          </td>
			        </tr>
			      </table>
				  
				  </td>
			    </tr>
			    <tr>
			      <td class="fontsize11 paddingL5">I agree to receive updates via SMS on my registered mobile and to receive Account Statements / other statutory as well as other information documents on my registered email in lieu of physical documents</td>
			    </tr>
			    <tr>
			    
			    <td class="paddingB5 paddingT5 BoxborderBotm BoxborderTop fontsize11">
			       <span class="lF bold" style="width:90px;">Occupation</span>
			                   <label class="lF" style="width:101px;">
			                  <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Private Sector") ? "checked=checked" : "").' value="" class="checkBox" />
			                   Private Sector</label>
			                  <label class="lF" style="width:129px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Government Service") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Government Service </label>
			                  <label class="lF" style="width:82px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Business") ? "checked=checked" : "").' value="" class="checkBox" />
			                   Business</label>
			                  <label class="lF" style="width:96px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Professional") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Professional </label>
			                  <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Agriculturist") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Agriculturist </label>
			                    <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Retired") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Retired </label>
			                    <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Housewife") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Housewife</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Other _______</label>
			                        
            	  </td>
			    </tr>
			  </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left"><table width="1000" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td class="bold fontsize14">3.PAYMENT DETAILS</td>
			    </tr>
			    <tr>
			      <td width="1000" class=" Boxborder  ">
			      		<table width="995" border="0" cellspacing="0" cellpadding="0">
			              <tr>
			                <td width="490" valign="top" class="paddingB2 BoxborderRight paddingL5">
			                	<table width="500" border="0" align="right" cellpadding="0" cellspacing="0">
			                      <tr>
			                        <td class="bold fontsize14  paddingT2 paddingB2">
			                        	<span style="text-decoration:underline;">Initial Subscription Details</span></td>
			                      </tr>
			                      <tr>
			                        <td class="">
			                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                              <tr>
			                                <td width="150">Amount(Rs.)</td>
			                                <td><p>
			                                  <input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value="'.$result_data[0]['CustomerBGP']['initial_amount'].'" />
			                                </p></td>
			                              </tr>
			                              <tr>
			                                <td>Mode of Payment</td>
			                                <td class="paddingT2">
			                                	<label class="lF" style="width:90px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['initial_pay_by'] == "Cheque") ? "checked=checked" : "").' value="" class="checkBox" /> Cheque </label>
			                                    <label class="lF" style="width:60px;"><input name="" type="checkbox"  value="" class="checkBox" /> DD </label>
			                                    <label class="lF"><input name="" type="checkbox" value="" class="checkBox" /> Payorder </label>
			                                </td>
			                              </tr>
			                              <tr>
			                                <td>Cheque/DD/Payorder No.</td>
			                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
			                              </tr>
			                              <tr>
			                                <td>Cheque/DD/Payorder Date</td>
			                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
			                              </tr>
			                              <tr>
			                                <td>Bank Name<br />
			                                Bank Branch</td>
			                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
			                              </tr>
			                              <tr>
			                                <td>Account Number</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
			                              </tr>
			                              <tr>
			                                <td>Account Type</td>
			                                <td class="paddingT5">
				                                <label class="lF" style="width:64px;"><input name="" type="checkbox" value="" class="checkBox" /> Saving </label>
			                                    <label class="lF" style="width:64px;"><input name="" type="checkbox"  value="" class="checkBox" /> Current </label>
			                                    <label class="lF" style="width:50px;"><input name="" type="checkbox" value="" class="checkBox" /> NRE </label>
			                                    <label class="lF"><input name="" type="checkbox" value="" class="checkBox" /> NRO </label>
			                                </td>
			                              </tr>
			                            </table>
			                        </td>
			                      </tr>
			                    </table>
			
			                </td>
			                <td width="549" valign="top" class="paddingL5">
			                	 <table width="545" border="0" align="right" cellpadding="0" cellspacing="0">
			                  <tr>
			                     <td>
			                     	<table width="545" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="360" class="paddingT2 paddingB5"><span class="bold fontsize14" style="text-decoration:underline;">Monthly Subscription Details</span>
			                            	<div><label class="paddingT2 lF"><input name="" type="checkbox" value="" class="checkBox" /> SIP through Auto-Debit(ECS/Direct Debit)</label></div>
			                            </td>
			                            <td width="20"><input name="" type="checkbox" value="" class="checkBox" '.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' /> </td>
										<td width="30"> SIP</td>
			                            <td width="20"><input name="" type="checkbox"  value="" class="checkBox" '.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? "checked=checked" : "").' /> </td>
										<td width="30"> PDC</td>
										<td width="10">&nbsp;</td>
			                          </tr>
			                        </table>
			                     </td>
			                   </tr>
			                  
			                  <tr>
			                    <td>
			                    	
			                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                              <tr>
			                                <td width="150" valign="top">Bank Name<br />
			                                Bank Branch</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-3" style="width:365px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['bank_name'] : "").'" /></td>
			                              </tr>
			                              <tr>
			                                <td>Account Number</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-3" style="width:365px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['account_number'] : "").'"/></td>
			                              </tr>
			                              <tr>
			                                <td>Account Type</td>
			                                <td class="paddingT2">
				                                <label class="lF" style="width:64px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "Saving" && $result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP" ) ? "checked=checked" : "").' value="" class="checkBox"  /> Saving </label>
			                                    <label class="lF" style="width:64px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "Current" && $result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").'  value="" class="checkBox"  /> Current </label>
			                                    <label class="lF" style="width:50px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "NRE" && $result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' value="" class="checkBox"  /> NRE </label>
			                                    <label class="lF"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "NRO" && $result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' value="" class="checkBox" /> NRO </label>
			                                </td>
			                              </tr>
			                          </table> 
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2 BoxborderBotm paddingB2">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Amount (Rs.)</td>
			                            <td> <input name="" type="text" class="app_inputBox" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['amount'] : "").'" /></td>
			                            <td>Tenure</td>
			                            <td width="80"> <input name="" type="text" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['tenure'] : "").'" class="app_inputBox" style="width:25px;"/> years</td>
			                            <td>
			                            	<table width="186" border="0" cellspacing="0" cellpadding="0">
			                                  <tr>
			                                    <td width="90">
			                                    	Period From  
			                                    </td>
			                                    <td align="center"><input name="" type="text" class="app_inputBox" style="width:45px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['period_from'] : "").'" /> to</td>
			                                    <td><input name="" type="text" class="app_inputBox" style="width:55px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? $result_data[0]['CustomerBGP']['period_to'] : "").'"/></td>
			                                  </tr>
			                                </table>
			
			                            </td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                  <tr>
			                  	<td class="paddingT2"><label><input name="" type="checkbox" value="" class="checkBox" /> </label>SIP through Post Dated Cheque</td>
			                  </tr>
			                  <tr>
			                    <td class="">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Amount (Rs.)</td>
			                            <td> <input name="" type="text" class="app_inputBox" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? $result_data[0]['CustomerBGP']['amount'] : "").'"/></td>
			                            <td>Tenure</td>
			                            <td width="80"> <input name="" type="text" class="app_inputBox" style="width:25px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? $result_data[0]['CustomerBGP']['tenure'] : "").'"/> years</td>
			                            <td>
			                            	<table width="186" border="0" cellspacing="0" cellpadding="0">
			                                  <tr>
			                                    <td width="90">
			                                    	Period From  
			                                    </td>
			                                    <td align="center"><input name="" type="text" class="app_inputBox" style="width:45px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? $result_data[0]['CustomerBGP']['period_from'] : "").'"/> to</td>
			                                    <td><input name="" type="text" class="app_inputBox" style="width:55px;" value="'.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? $result_data[0]['CustomerBGP']['period_to'] : "").'"/></td>
			                                  </tr>
			                                </table>
			                            </td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2 paddingB2">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Cheque No. From <input name="" type="text" class="app_inputBox" style="width:75px;" value="'.$result_data[0]['CustomerBGP']['cheque_number_from'].'"/> to <input name="" type="text" value="'.$result_data[0]['CustomerBGP']['cheque_number_to'].'" class="app_inputBox" style="width:75px;"/></td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                </table>
			                </td>
			              </tr>
			            </table>
			      </td>
			    </tr>
			  </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left" class="paddingT2">
			      <table width="1000" border="0" cellspacing="0" cellpadding="0">
			        <tr>
			         <td class="bold fontsize14 paddingB5">
			          	4.NOMINATION DETAILS (Mandatory)
			          </td>
			        </tr>
			        <tr>
			          <td class="Boxborder paddingL5">
			          	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			              <tr>
			                <td width="520" align="center" class="fontsize14">Name and Address of Nominee</td>
			                <td width="520" align="center" class="fontsize14">Name and Address of Guardian(if Nominee is Minor)</td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                    <table width="1000" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                      <td width="60">Name</td>
			                        <td >  <input name="input3" type="text" class="inputBoxDtl-4" value="'.$result_data[0]['CustomerBGP']['nomination_name'].'"/>
			                        </td>
			                      <td width="60">Name</td>
			                        <td >  <input name="input4" type="text" class="inputBoxDtl-4" value="'.$result_data[0]['CustomerBGP']['nomination_guardian_name'].'"/>
			                        </td>
			                      </tr>
			                    </table>
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="60">Address</td>
			                        <td><input name="input6" type="text" class="inputBoxDtl-2" style="width:926px; float:left;" value="'.$result_data[0]['CustomerBGP']['nomination_address'].'"/></td>
			                      </tr>
			                    </table>
			
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                <table width="1000" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="60">City</td>
			                    <td><input name="input5" type="text" class="inputBoxDtl-2" style="width:380px;" value="'.$result_data[0]['CustomerBGP']['nomination_city'].'"/></td>
			                    <td width="60"> State </td>
			                    <td width="230"><input name="input7" type="text" class="inputBoxDtl-2" style="width:477px;" value="'.$result_data[0]['CustomerBGP']['nomination_state'].'"/></td>
			                  </tr>
			                </table>
			
			                <!--<span style="width:60px; float:left;">&nbsp;&nbsp;</span>
			                  <input name="input5" type="text" class="inputBoxDtl-2" style="width:602px;"/>
			                  City
			                  <input name="input4" type="text" class="inputBoxDtl-2" style="width:280px;"/>-->
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                	<table width="990" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="60">Pin Code</td>
			                    <td><input name="input4" type="text" class="inputBoxDtl-2" style="width:380px;" value="'.$result_data[0]['CustomerBGP']['nomination_pincode'].'"/></td>
			                    <td width="210"> Guardian Relationship with Minor </td>
			                    <td width=""><input name="input7" type="text" class="inputBoxDtl-2" style="width:328px;" value="'.$result_data[0]['CustomerBGP']['nomination_guardian_realtion'].'"/></td>
			                  </tr>
			                </table>
			
			                </td>
			              </tr>
			              
			              <tr>
			                <td class="paddingT2">
			                	<span style="width:130px; float:left;">Relationship with Applicant</span>
			                    <input name="input4" type="text" class="inputBoxDtl-2" style="width:310px;" value="'.$result_data[0]['CustomerBGP']['nomination_applicant_realtion'].'"/>
			                </td>
			                <td rowspan="2" align="right" class="paddingT5 paddingB2" style="padding-right:10px;">
			                	
			                    <table width="450" border="0" align="right" cellpadding="0" cellspacing="0" class="signBox">
			                      <tr>
			                        <td height="45" width="450" valign="middle" style="color:#ccc;">Signature of Guardian</td>
			                      </tr>
			                    </table>
			
			                    
			                </td>
			              </tr>
			              <tr>
			                <td class="paddingT2"><span style="width:130px; float:left;">Date of Birth <br />
			                  (In case of Minor)</span>
			                  <input name="input4" type="text" class="inputBoxDtl-2" style="width:310px;" value="'.(($result_data[0]['CustomerBGP']['nomination_dob'] != "0000-00-00") ? date('d-m-Y',strtotime($result_data[0]['CustomerBGP']['nomination_dob'])) : "").'"/></td>
		                	</tr>
			            </table>
			
			          </td>
			        </tr>
			      </table>
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="left" class="paddingT5">
			<p class="fontsize15">Declaration:-</p>
			<p class="fontsize11" style="text-align:justify;">I propose to enroll with Birla Gold Plus, subject to terms & conditions of the product brochures as amended from time to time. I have read and understood (before Filling the application form)
& Conditions in the product brouchures, and I accept the same. I have neither received nor been induced by an rebate or gifts, directly or indirectly, while enrolling to Birla Gold Plus.I hereby
declare that the subscriptions proposed to be remitted in Birla Gold Plus will be from legitimate sources only and will not be with any intention to contravene/evade/avoid any legal/statutory/regulatory
requirements. I understand that Birla Gold & Precious Metals Ltd.,may, at its absolute discretion, discontinue any or all of the services by giving prior notice to me. I hereby authorise BGPM to debit
my customer ID with the service charges as applicable from time to time. I hereby authorise the aforesaid nominee to receive all the gold accrued to my credit, in the event of my death. Signature of the
nominee acknowledging receipts of the proceeds of Birla Gold shall constitute full discharge of liabilities of Birla Gold in respect of my Customer ID.</p>     
			     
			                                                          
			  </td>
			</tr>
			
			
			<tr>
			  <td align="left" width="450">
			  
			 <p> Date :- '.date('d-m-Y',strtotime($result_data[0]['CustomerBGP']['declaration_date'])).'</p>
			
			<p> Place :- '.$result_data[0]['CustomerBGP']['declaration_place'].' </p>
			  
			  </td>
			  <td align="right" style="padding-right:10px;">
			  	<table width="450" border="0" align="right" cellpadding="0" cellspacing="0" class="signBox">
			      <tr>
			        <td width="450" height="45" valign="middle" style="color:#ccc;">Signature of Investor</td>
			      </tr>
			    </table>
			  </td>
			</tr>
			  
			  
			<tr>
			  <td colspan="2" align="left" class="paddingT5">
			  	
			    <table width="1000" border="0" cellspacing="0" cellpadding="0">
			    
			          <tr>
			        <td colspan="2" align="left"height="10"></td>
			        </tr>
			
			      <tr>
			        <td width="790" align="left" class="paddingT fontsize15 bold" style="border-top:2px dashed #333;">
			    	<div style="text-align:center; display:block; border:2px solid #ccc; height:30px; width:759px; padding-top:10px;"> Acknowledgment Slip (to be filled by Customer) </div>
			    </td>
			         <td width="250" align="center" valign="middle" class="paddingT fontsize15" style="border-top:2px dashed #333;">Application No. - '.$app_no.'</td>
			      </tr>
			    </table>
			    
			  </td>
			  </tr>
			
			<tr>
			  <td colspan="2" align="left" class="paddingT2"><table border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td width="850" valign="top" style="font-size:14px;line-height:30px;">	
				  <p>Received with thanks from Mr./Ms./Mrs_______________________________________________an application for allotment</p><br/>
			<p>of gold gram under BGSP as per the advance payment details below:-<br/></p>
			<p>
			Amount ____________Payment Mode: Cheque/DD/Payorder Instrument No.__________________Date ________________</p><br/>
			
			<p>Bank Name_________________________________________Branch____________________________Tenure__________</p><br/>
			
			<p>Monthly Subscription Option: ECS / Direct Debit / PDC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Monthly Subscription Amount_____________________</p>
			</td>
			      <td align="center" class="paddingL">
			      
			      
			        <table width="180" border="0" cellspacing="0" cellpadding="0" class="">
			          <tr>
			            <td align="center" width="180" style="border:2px dotted #333; height:80px; text-align:center;">
			            <p>&nbsp;</p>
			            Collection Center Date and Stamp
			            </td>
			          </tr>
			        </table>
			      
			      </td>
			    </tr>
			  </table></td>
			  </tr>
			  
			  <tr>
              	<td height="28" valign="bottom" align="left" style="font-size:12px;">
                	Birla Gold and Precious Metals Ltd
                </td>
              	<td height="28" valign="bottom" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
              </tr>
			  </table>
			
			  
			</div>
			
			
			
			</body>
			</html>
			';
			
		
		
			$html2 = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Application Form 5</title>

<style>

/**** form5 ****/
.fontsize18{ font-size:18px;}
.title{ background:#d1d2d4; font-size:18px; line-height:24px; text-align:center;}
.txtjustify{ text-align:justify;}
.monthInput{border-bottom:1px solid #333; width:45px; height:22px; text-align:center; text-transform:uppercase;}
.yearInput{border-bottom:1px solid #333; width:60px; height:22px; text-align:center; text-transform:uppercase;}

</style>

</head>

<body>

<div style="width:1000px; border:0px solid #666; padding:10px 0 0 40px; margin:0 auto;">

  <table width="1000" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="499" valign="top" style="padding-top:15px"><img src="img/logo.jpg" />
                <p class="fontsize14 paddingT"> Birla Gold and Precious Metals Ltd <br />
                  Morya Landmark II,G-002,Ground Floor, <br />
                  New Link Road,Andheri(W),Mumbai-400 053 </p></td>
              <td width="501" align="right" valign="top"><strong class="fontsize15"> Application No. - '.$app_no.'</strong></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" class="paddingB paddingT"><h4 class="fontsize18">Electronic Clearing Service<br />
        RBI-ECS Debit / Direct Debit collection Mandate form</h4></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="paddingB paddingT txtjustify"> I/We the account holders with the Bank as per details below hereby request and authorize the Bank to accept this ECS Debit(Clearing)/Direct Debit
        mandate executed by me/us in favour of <strong>M/s Birla Gold and Precious Metals Private Limited</strong> and submitted by them or through their authorized
        service provider under RBI ECS debit procedures. I/We further request and authorize the bank to debit my/our account to honor the periodical payment
        contribution requests presented by the service provider. Various details of bank account and periodical payment are furnished below: </td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="25" class="title">BANK ACCOUNT DETAILS</td>
        </tr>
        <tr>
          <td class="paddingT paddingB txtjustify"> I/We hereby authorize <strong>Birla Gold and Precious Metals Private Limited</strong> and their authorized service providers to debit my/our following
            bank account by ECS Debit (Clearing)/Direct Debit to account for collection of Monthly Subscription Payments (Applicant should be amongst
            one of bank account holders). </td>
        </tr>
        <tr>
          <td class="paddingB5"> 
          	<table width="990" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                	<table width="990" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="160">Bank Account Number:</td>
                        <td width="830">'.$result_data[0]['CustomerBGP']['ecs_bank_account_number'].'</td>
                      </tr>
                      <tr>
                        <td>Account Type:</td>
                        <td class="paddingB5 paddingT5">
                        <table width="830" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "Saving") ? "checked=checked" : "").' class="checkBox" /> Savings</td>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "Current") ? "checked=checked" : "").' class="checkBox" /> Current</td>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "NRE") ? "checked=checked" : "").' class="checkBox" /> NRE</td>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "NRO") ? "checked=checked" : "").' class="checkBox" /> NRO</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                </td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Account Holders Name (1st holder): '.$result_data[0]['CustomerBGP']['ecs_account_holder_name'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Name:'.$result_data[0]['CustomerBGP']['ecs_bank_name'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Branch Name/Address: '.$result_data[0]['CustomerBGP']['ecs_branch_address'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">
                	<table width="990" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="110">Bank City/Town: </td>
                        <td width="442">'.$result_data[0]['CustomerBGP']['ecs_city'].'</td>
                        <td width="30">&nbsp;</td>
                        <td width="142" align="right">PIN CODE:</td>
                        <td width="266" align="left">'.$result_data[0]['CustomerBGP']['ecs_pincode'].'</td>
                      </tr>
                    </table>

                </td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5"><table width="990" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="260">Bank Branch MICR Number (9 DIGITS) : </td>
                    <td width="342">'.$result_data[0]['CustomerBGP']['ecs_branch_micr'].'</td>
                    <td width="35">&nbsp;</td>
                    <td width="100" align="right">IFSC CODE:</td>
                    <td width="263" align="left">'.$result_data[0]['CustomerBGP']['ecs_ifsc_code'].'</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td style="font-size:13px;">as appearing in Cheque leaf-please attach a copy of cancelled cheque/bankers attestation. MICR Code starting and/or ending with 000 are not valid for ECS.</td>
              </tr>
            </table>

          </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td height="30" align="left" class="paddingT2 title"> PERIODIC PAYMENT DETAILS <span class="fontsize14">(Please refer payment mode section)</span></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="paddingT fontsize15"><table width="980" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="35" valign="middle"> Debit Date (tick applicable date)
            <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['ecs_debit_date'] == "10") ? "checked=checked" : "").' value="" class="checkBox" />
            10
            <input name="input2" type="checkbox" '.(($result_data[0]['CustomerBGP']['ecs_debit_date'] == "20") ? "checked=checked" : "").' value="" class="checkBox" />
            20 </td>
          <td>Amount of Subscription:'.$result_data[0]['CustomerBGP']['ecs_amount_of_subscription'].'</td>
        </tr>
        <tr>
          <td class="paddingT2"> From:
            <input type="text" name="textfield" id="textfield" class="monthInput" placeholder="MM" style="border:0; width:70px !important" value="'.$result_data[0]['CustomerBGP']['ecs_from'].'" />/
            
            To:
            <input type="text" name="textfield" id="textfield" class="monthInput" placeholder="MM" style="width:70px !important" value="'.$result_data[0]['CustomerBGP']['ecs_to'].'" />/
            
          <td class="paddingT2"> Frequency: MONTHLY </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" class="paddingT2 paddingB"><table width="1030" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1030" height="30" class="paddingT2 title"> CONTRIBUTION DETAILS</td>
        </tr>
        <tr>
          <td class="paddingT"><table width="1020" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="450" class="paddingT5">Beneficiary Name: <strong>Birla Gold and Precious Metals Ltd</strong></td>
              <td>Product Code: <strong>BGSP</strong></td>
              <td width="415" align="right">Product Name: <strong> Birla Gold Plus</strong></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="paddingT5 paddingB">Customer ID/Folio No. ___________________________________________________________________________________________________________________________________</td>
        </tr>
        <tr>
          <td class="paddingT5 paddingB">Customer/Contributors Name_____________________________________________________________________________________________________________________________</td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" valign="top" class="paddingT5 paddingB5"><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" class="title">DECLARATION</td>
        </tr>
        <tr>
          <td class="txtjustify paddingT5"> I/We wish to inform you that I/We have registered for the subject scheme for the contribution payment to the bene?ciary as per account details as above
by debit to said Bank Account. I/We express my willingness for participation in ECS/Direct Debit scheme. I declare that the particulars given above
are correct and complete. I/We agree to discharge the responsibility expected of me as a participant under the ECS/Direct Debit scheme. I/We hereby
authorize the bene?ciary or their representatives to get this mandate lodged with bank/get veri?ed and further execute by raising debits on the applicable
dates through ECS/Direct Debit scheme. If the mandate is not lodged/transaction is not collected or delayed for reasons beyond control of the bene?ciary/service
provider representative or on account of incomplete or incorrect information, I/We shall not hold them responsible. I/We shall keep indemni?ed for
claims and actions, that bene?ciary or representative may incur, for execution of transactions in conformity with this mandate.
           </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" class="paddingT5 paddingB5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" class="title">AUTHORISATION</td>
        </tr>
        <tr>
          <td class="txtjustify paddingT paddingB" > I/We hereby request and authorize the bank to honor the periodic debit instructions raised as above and cause my account to be debited accordingly. Charges,
if any, for mandate veri?cation/registration may be debited to my account. I hereby undertake to keep suf?cient funds in the account well prior to the applicable
date and till the date of execution. If the date of debit happens to be a holiday or non working day for the bank or location, the debit may happen on any subsequent
working day. Debited contributions may be passed on to the bene?ciary/representative as per rules, procedures and practices in force. I/We shall not dispute any
debit raised under this mandate and as speci?ed therein and during or for the validity period. I/We shall keep indemni?ed for claims that Bank may incur for reason
of execution in conformity with this mandate. </td>
        </tr>
        <tr>
          <td width="980" class="paddingT">
          <table width="980" border="1" cellspacing="0" cellpadding="0" class="fontsize18 borderBL">
            <tr>
              <td align="center" class="borderTR">As per Bank Record</td>
              <td align="center" class="borderTR">1st Account Holder</td>
              <td align="center" class="borderTR">2nd Account Holder</td>
              <td align="center" class="borderTR">3rd Account Holder</td>
            </tr>
            <tr>
              <td align="center" class="borderTR">Name</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" class="borderTR" style="height:60px">Signature</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr><td height="10"></td></tr>
    <tr>
      <td height="30" align="center" class="paddingT5 title paddingB5"> FOR BANK USE ONLY </td>
    </tr>
    <tr>
      <td class="txtjustify fontsize15 paddingT"> Certified that the bank account details and signatures of the account holders are correct and as per '."bank's".' records. </td>
    </tr>
	
	
	
    <tr>
      <td class="txtjustify fontsize15"><table width="1000%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="527">Date:____________________</td>
          <td width="473" align="center">_______________________________________________</td>
        </tr>
        <tr>
          <td width="527">&nbsp;</td>
          <td align="center" class="paddingT">Stamp & Signature of the Authorized Official of the Bank</td>
        </tr>
      </table></td>
    </tr>
	
	 <tr>
		<td height="28" valign="bottom">
			 <table width="1000" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="500" align="left" style="font-size:12px;">Birla Gold and Precious Metals Ltd</td>
				<td width="500" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/Nov 2015</td>
			  </tr>
			</table>
		</td>
	  </tr>
  </table>
</div>

</body>
</html>
';
			
			//echo "End2"; exit;
			
						$date = date_create();
						$pdf_time = date_timestamp_get($date);
						
						$this->Mpdf->init();
						$this->Mpdf->SetHTMLHeader(" ");
						$this->Mpdf->WriteHTML($html);
						$this->Mpdf->Output(WWW_ROOT."/documents/tempPDF/".$pdf_time."_3.pdf","F");
						
						$this->Mpdf->init();
						$this->Mpdf->SetHTMLHeader(" ");
						$this->Mpdf->WriteHTML($html2);
						$this->Mpdf->Output(WWW_ROOT."/documents/tempPDF/".$pdf_time."_5.pdf","F");
						
						include WWW_ROOT.'/customerPDFmerger.php';
						$pdf = new PDFMerger();		
						$pdf->addPDF(WWW_ROOT.'/documents/tempPDF/'.$pdf_time.'_3.pdf', 'all');			
						$pdf->addPDF(WWW_ROOT.'/documents/tempPDF/'.$pdf_time.'_5.pdf', 'all');			
						$pdf->merge('F', WWW_ROOT.'/documents/customer_regs_form/'.$pdf_time.'.pdf');
						
						
				
				
				
//==================================================================== End ===========================================================				
				
				
				$msg="Dear $toname,<br/><br/>Thank you for becoming a part of Birla Gold Plus.<br/><br/>Application requested is successfully completed. Attach the pre-filled application form.<br/><br/>";
				$msg.="Please fill all the incomplete details, paste your photo and sign the application form and submit at <a href='http://www.shagunn.in/staging/index.php?route=information/contact'>head office</a>.<br/><br/>";
				//$msg.="Link to find the CAMS location <a href='http://www.birlagold.com/locate'>http://www.birlagold.com/locate</a><br/><br/>";
				$msg.="In case you need any further assistance you may call us on 1800 1022 066 or write to us at customerservice.bgp@birlagold.com or visit our website <a href='www.shagunn.in/staging/birla/'>www.shagunn.in/staging/birla/</a><br/><br/>";
				$msg.="Best Regards,<br/>Birla Gold and Precious Metals Ltd.<br/>Customer Care";
				
				$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
				App::uses('CakeEmail', 'Network/Email');

				$email = new CakeEmail();
				$email->emailFormat('html');
				$email->from(array(trim($adminmailid['Adminuser']['email']) => SITE_NAME));
				$email->template('default', 'default');
				$email->to(trim($result_data[0]['CustomerBGP']['contact_email']));
				$subject = "";
				$email->subject(SITE_NAME . " Birla Gold Customer Registration");
				$email->attachments(array(WWW_ROOT.'documents/tempPDF/AC_'.$pdf_time.'.pdf',WWW_ROOT.'documents/customer_regs_form/'.$pdf_time.'.pdf'));
				$email->send($msg);
				$email->reset();
						
				$filePath = WWW_ROOT."/documents/tempPDF/".$pdf_time."_3.pdf";
				if (file_exists($filePath)) {
					unlink($filePath);
				}
				
				$filePath2 = WWW_ROOT."/documents/tempPDF/".$pdf_time."_5.pdf";
				if (file_exists($filePath2)) {
					unlink($filePath2);
				}
				
				$filePath3 = WWW_ROOT."/documents/customer_regs_form/".$pdf_time.".pdf";
				if (file_exists($filePath3)) {
					unlink($filePath3);
				}
				
				
				//$db->Update('customer_master', $d, 'application_no', $_POST['mer_txn']);
				$this->CustomerBGP->updateAll(
					array('send_mail' => "1"),
					array('application_no' => $_POST['mer_txn'])
				);

				
				
				$filePath = WWW_ROOT."/documents/tempPDF/AC_".$pdf_time.".pdf";
				if (file_exists($filePath)) {
					unlink($filePath);
				}
	  		}
	  		
			$this->set("msg", "Your Application registered successfully, requested to please save/download the application form.<br/>Please fill all the incomplete details, paste the photograph and sign the application form and submit at any nearest head office. <br /><br /> <a style='color:#8C472B' href='".BASE_URL."customer/generateForm_dn?id=".$_POST['mer_txn']."'>Download Form</a>&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#8C472B' href='".BASE_URL."customer/generateAC?id=".$_POST['mer_txn']."' >Download Acknowledgement</a> ");
			$this->set("title", "Registration Successful");
		}
		else
		{
			$search = array();
			$search["application_no"] = $_POST["mer_txn"];
			
			$send_mail_flag = $this->CustomerBGP->find("all",array('conditions' => $search));
			
			if(count($send_mail_flag) == 0)
			{		
				$search = array();
				$search["application_no"] = $_POST['mer_txn'];
				$result_data = $this->CustomerBGP->find("all",array('conditions' => $search,
								'joins' => array(
									array(
										'alias' => 'payment',
										'table' => 'payment_master',
										'type' => 'left',
										'conditions' => array('payment.mer_txn = CustomerBGP.application_no','payment.udf9' => $data['PaymentMaster']["udf9"],'payment.f_code' => "'".$_POST['f_code']."'" )
									)
								), 'order' => 'CustomerBGP.customer_id DESC'));
				
				$toname ="";
				$toname = $result_data[0]['CustomerBGP']['applicant_name'];
				
				$msg="Dear $toname,<br/><br/>Thank you for becoming a part of Birla Gold Plus.<br/><br/>Application requested is successfully completed. Attach the pre-filled application form.<br/><br/>";
				$msg.="Please fill all the incomplete details, paste your photo and sign the application form and submit at <a href='http://www.shagunn.in/staging/index.php?route=information/contact'>head office</a>.<br/><br/>";
				//$msg.="Link to find the CAMS location <a href='http://www.birlagold.com/locate'>http://www.birlagold.com/locate</a><br/><br/>";

				$msg.="In case you need any further assistance you may call us on 1800 1022 066 or write to us at customer.service@birlagold.com or visit our website <a href='www.shagunn.in/staging/birla/'>www.shagunn.in/staging/birla/</a><br/><br/>";
				$msg.="Best Regards,<br/>Birla Gold and Precious Metals Ltd.<br/>Customer Care";
				
				$app_no = $result_data[0]['CustomerBGP']['application_no'];
				$dist_data = 'RDIRECT';
				if(isset($result_data[0]['CustomerBGP']['partner_code']) && $result_data[0]['CustomerBGP']['partner_code'] != ''){
					$dist_data = $_GET['partner_code'];
				}
							
		$html = '
			<html>
			<head>
			
			<style>
			/**** Common Style *****/
			div, dl, dt, dd, ul, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
				margin:0;
				padding:0;
			}
			html, body {
				font-size:13px;
				text-align:left;
				color:#373435;
				font-family: Arial, Helvetica, sans-serif;
				direction: ltr;
				font-weight:normal;
				margin:0;
				padding:0px 0 0 0;
				background: #fff;
			}
			
			.paddingT2		{padding-top:2px;}
			.paddingB2		{padding-bottom:2px;}
			
			.paddingT5		{padding-top:5px;}
			.paddingB5		{padding-bottom:5px;}
			.paddingT		{padding-top:10px;}
			.paddingL		{padding-left:10px;}
			.paddingR		{padding-right:10px;}
			.paddingB		{padding-bottom:10px;}
			.marginr15		{margin-right:15px;}
			.paddingL5		{padding-left:5px;}
			.paddingR5		{padding-right:5px;}
			
			.head2{ font-size:18px; color:#373435;}
			.rightTxt{ color:#373435;}
			.rightTxt a {color:#373435; text-decoration:none;}
			.codeBox{border:1px solid #333; width:25px; height:28px;}
			.codeBoxR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center;}
			.heading{ background:#D2D3D5; border:1px solid #333; font-weight:bold; padding:3px 0 3px 5px; width:995px;}
			.boxContent{ border:1px solid #333; border-top:0; padding:5px 0 5px 10px; width:990px; }
			
			.inputBox{ width:60%; padding:2%; border:1px solid #333; margin:0; }
			.taxStatusBorder{width:190px; }
			.inputBoxDtl{ width:180px; padding:22px; border:1px solid #333; margin:0; }
			.inputBoxDtl-2{width:265px; height:22px; border:1px solid #333; margin:0; }
			
			.inputBox_sign{width:210px; height:30px; padding:3px; border:1px solid #333; margin:0; }
			.inputBox-email{width:480px; padding:3px; border:1px solid #333; margin:0; }
			.photoBox{ border:1px solid #333;display:inline-block; padding:5px;} 
			
			/**** Application Form 12-05-2014 ****/
			.paddingT2		{padding-top:2px;}
			.paddingB2		{padding-bottom:2px;}
			
			.inputBoxDtl-2{width:210px; padding:3px; border:1px solid #333; margin:0; }
			.app_inputBox{width:90px; padding:3px; border:1px solid #333; margin:0; }
			.underLine{width:90px;}
			.fontsize11{ font-size:11px;}
			.fontsize12{ font-size:12px;}
			.fontsize14{ font-size:14px;}
			.fontsize15{ font-size:15px;}
			.lF{ float:left;}
			.rF{ float:right;}
			.passPhoto{ border:1px solid #333; display:inline-block; padding:5px; background:#999; vertical-align:middle;}
			.head2{ font-size:18px; color:#373435;}
			.checkBox{ width:12px; width:12px; border:1px solid #666; margin:0; padding:0;}/**/
			.bold{ font-weight:bold;}
			.Boxborder{border:1px solid #333;}
			.borderTR{ border-top:1px solid #333;  border-right:1px solid #333;}
			.borderBL{ border-bottom:1px solid #333;  border-left:1px solid #333;}
			.DetailBox{border:1px solid #333; width:25px; height:28px; background:#d1d2d4; text-align:center; line-height:28px; text-transform:uppercase;}
			.DetailBoxR{border:1px solid #333; border-left:0; width:25px; height:28px; text-align:center; background:#d1d2d4; line-height:28px; text-transform:uppercase;}
			.DateBox{border:1px solid #333; width:25px; height:22px; text-align:center; text-transform:uppercase;}
			.DateBoxR{border:1px solid #333; border-left:0; width:25px; height:22px; text-align:center; text-transform:uppercase;}
			.BoxborderBotm{border-bottom:1px solid #333;}
			.BoxborderRight{border-right:1px solid #333;}
			.BoxborderTop{border-top:1px solid #333;}
			.StatusBox{ width:120px;}
			.codeBoxBg{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
			.GardianDtl{border:1px solid #333; width:25px; height:28px; background:#d1d2d4;}
			.GardianDtlR{border:1px solid #333; border-left:0; width:25px; height:20px; text-align:center; background:#d1d2d4;}
			.paddingTRBL5{ padding:5px;}
			.paddingTRBL{ padding:10px;}
			
			.signBox{ border:2px dotted #333; text-align:center; width:420px; height:45px;}
			lable{ margin:0; padding:0;}
			
			/**** New class ****/ 
			.add_input{border:1px solid #333; width:976px; height:20px; background:#888888;}
			.residence_input{border:1px solid #333; width:846px; height:20px; background:#888888;}
			.inputBoxDtl-3{width:388px; height:22px; border:1px solid #333; margin:0; padding:3px 0;}
			.inputBoxDtl-4{width:427px; height:22px; border:1px solid #333; margin:0; padding:3px 0; }
			table { margin:0; padding:0;}
			</style>
			
			</head>
			<body>
			
			
			<div style="width:1000px; padding:10px 10px 10px 40px; margin:0 auto;">
			
			<table width="1000" border="0" cellspacing="0" cellpadding="0">
			<tr>
			    <td colspan="2" align="left" valign="top">
			    	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			        <td width="840" align="left" valign="top" style="padding-right:10px;">
			            	<table width="820" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="410"><img src="img/logo.jpg" /></td>
			                    <td>
			                        <table width="250" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td colspan="2" class="head2">APPLICATION FORM &nbsp;</td>
			                          </tr>
			                          <tr>
			                            <td colspan="2" width="120" class="fontsize12">
			                            Application No. - '.$app_no.'
			                            </td>
			                          </tr>
			                        </table>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td colspan="2" class="paddingT2">
			                    	<span class="fontsize14">Please select the fulfillment preference</span>';
		if($result_data['fulfilment'] == 'coin'){
			$html.=' <label><input name="" type="checkbox" checked="checked" value="" class="checkBox" /> Coin </label>';
		}else{
			$html.='<label><input name="" type="checkbox" checked="checked" value="" class="checkBox" /> Jewellery </label>';
		}
			                    	
			                        
		$html.=	                        '<span class="fontsize11">(If not selected, default preference is Coin)</span>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td colspan="2" class="paddingT2">
			                       <table width="820" border="0" cellspacing="0" cellpadding="0" class="borderTR">
			                          <tr>
			                            <td class="borderBL fontsize15" align="center">Distributor Code</td>
			                            <td class="borderBL fontsize15" align="center">Sub-Partner Code</td>
			                            <td class="borderBL fontsize15" align="center">For Office Use Only</td>
			                          </tr>
			                          <tr>
			                            <td class="borderBL" style="text-align:center">'.$dist_data.'</td>
			                            <td class="borderBL">'.$result_data[0]['CustomerBGP']['sub_partner_code'].'</td>
			                            <td class="borderBL">&nbsp;</td>
			                          </tr>
			                         
			                      </table>
			                    </td>
			                  </tr>
			                </table>
			
			            </td>
						<td width="40"></td>
			          <td class="passPhoto bold" width="160" height="85" valign="middle" align="center">
			          		<br />Paste1 <br />
			                Passport size <br />
			                photograph
			            </td>
			          </tr>
			        </table>
			
			    </td>
			</tr>
			
			<tr>
			    <td height="15" colspan="2" align="left"><table width="1000%" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td>
			        <table width="1000" border="0" cellspacing="0" cellpadding="0">
			          <tr></tr>
			          <tr>
			            <td width="695" class="bold fontsize14"><strong>1.APPLICANT DETAILS</strong></td>
			            <td width="305" align="left" class="paddingT5">*are Mandatory Fields</td>
			          </tr>
			          <tr>
			            <td colspan="2" class="Boxborder paddingB2 paddingT2" width="1000"><table width="1000" border="0" cellpadding="0" cellspacing="0">
			              <tr>
			                <td valign="top"><table width="1000" border="0" cellspacing="0" cellpadding="0">
			                  
			                  
			                  <tr>
			                    <td class="paddingL" width="850"> *Name of Applicant (as mentioned on ID Proof)
			                      <label>
			                        Title </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_title'] == "Mr") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Mr. </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_title'] == "Ms") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Ms. </label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_title'] == "Mrs") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Mrs. </label></td>
			                    <td width="190" align="right" class="paddingR"> Gender*:
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_gender'] == "Male") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Male</label>
			                      <label>
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_gender'] == "Female") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Female</label></td>
			                  </tr>
			                  
			                </table></td>
			              </tr>
			              <tr>
			                <td class="paddingL">
			                	<input name="" type="text" class="add_input" style=" width:1001px;" value="'. $result_data[0]['CustomerBGP']['applicant_name'].'" />
			                </td>
			              </tr>
			              <tr>
			                <td valign="top" class="paddingL paddingT2 paddingB2">
			                <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
			                  <tr>
			                    <td headers="8"></td>
			                    <td class="paddingR"></td>
			                  </tr>
			                  <tr>
			                  
			                   <td width="670" style="padding:0;"><span style="width:80px;" class="lF">Status </span>
			                   
			                  	<label style="width:140px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "Resident Individual") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Resident Individual </label>
			                      <label style="width:90px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "NRI") ? "checked=checked" : "").' value="" class="checkBox" />
			                        NRI </label>
			                      <label style="width:80px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "HUF") ? "checked=checked" : "").' value="" class="checkBox" />
			                        HUF </label>
			                      <label style="width:140px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_status'] == "On behalf of Minor") ? "checked=checked" : "").' value="" class="checkBox" />
			                        On behalf of Minor </label>
			                      
			                     <div style="clear:both;"></div>
			                        <span style="width:93x;" class="lF">Proof of DOB* </span>
			                      <label style="width:129px;" class="lF paddingL">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Birth Certificate") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Birth Certificate</label>
			                      <label style="width:176px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Passport") ? "checked=checked" : "").' value="" class="checkBox" />
			                        School Leaving Certificate</label>
			                      <label style="width:90px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "School Leaving Certificate") ? "checked=checked" : "").' value="" class="checkBox" />
			                        Passport</label>
			                      <label style="width:131px;" class="lF">
			                        <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />
			                        '.(($result_data[0]['CustomerBGP']['applicant_dob_proof'] == "Other") ? $result_data[0]['CustomerBGP']['applicant_dob_proof_other'] : "Others________").'</label>
			                  
			                  	</td>
			                  	
			                  	
			                  	
			                    
			                    <td width="349" align="right" class="paddingR" style="padding-bottom:3px;"> 
			                      <table width="341" border="0" align="left" cellpadding="0" cellspacing="0">
			                        <tr>
			                          <td width="60">Date of Birth</td>
			                          
			                          <td class="DateBox" colspan="2">'.date('d',strtotime($result_data[0]['CustomerBGP']['applicant_dob'])).'</td>
			                          <td class="DateBoxR" colspan="2">'.date('d',strtotime($result_data[0]['CustomerBGP']['applicant_dob'])).'</td>
			                          <td class="DateBoxR" colspan="4">'.date('d',strtotime($result_data[0]['CustomerBGP']['applicant_dob'])).'</td>
			                          
			                        </tr>
			                      </table></td>
			                  </tr>
			                  
			                </table></td>
			              </tr>
			              <tr>
			              
			              <td class="paddingL BoxborderTop paddingT2" width="790"> Guardian Details (in case applicant is minor)
			                  <label> Title </label>
			                  <label>
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_title'] == "Mr") ? "checked=checked" : "").' value="" class="checkBox"/>
			                    Mr. </label>
			                  <label>
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_title'] == "Ms") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Ms. </label>
		                  </td>
			              
			              </tr>
			              <tr>
			                <td height="" >
			                	&nbsp;<input name="" type="text" class="add_input" style="width:1006px;" value="'.$result_data[0]['CustomerBGP']['applicant_guardian_name'].'"/>
			                </td>
			              </tr>
			              <tr>
			                <td class=" paddingL paddingT2">
			                <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="130">Country of Residence</td>
			                    <td align="left">
			                    	<input name="" type="text" class="residence_input" style="width:870px;" value="'.$result_data[0]['CustomerBGP']['applicant_guardian_country_resident'].'"/>
			                        </td>
			                  </tr>
			                </table>
			                </td>
			              </tr>
			              
			              
			              <tr>
			                <td class="paddingL paddingT2"><label class="lF" style="width:222px;">
			                  Relationship with minor</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship'] == "Father") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Father </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship'] == "Mother") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Mother</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['applicant_guardian_relationship'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Other ___________</label>
			                  </td>
			              </tr>
			            
			              <tr>
			                    <td align="center" class="paddingB2 paddingT2 fontsize14"><strong>
			                    	-----------------------------------------
			                    	Proof of Address Submitted by Applicant (any one of the below)
			                        ---------------------------------------</strong></td>
			                  </tr>
			              <tr>
			                <td class="paddingL"><label class="lF" style="width:182px;">
			                  <input name="input" type="checkbox" value="" class="checkBox " />
			                  UID(Aadhar)</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Driving License </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Passport</label>
			                  <label class="lF" style="width:142px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Voter ID </label>
			                  <label class="lF" style="width:152px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Pan Card</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Other ___________</label></td>
			              </tr>
			            </table></td>
			          </tr>
			          
			        </table></td>
			      </tr>
			    </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left">
			  		<table width="980" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			            <td class="bold fontsize14 paddingT2"><strong>2.MAILING ADDRESS(*Fields are mandatory)</strong></td>
			          </tr>
			          <tr>
			            <td width="980" class=" Boxborder paddingB5 paddingL paddingT5">
			            	<table width="980" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="979">
			                    <textarea cols="" rows="2" style="width:983px;" class="add_txtarea">'.$result_data[0]['CustomerBGP']['mailing_address'].'</textarea>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2">
			                    <table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="70">Landmark</td>
			                        <td ><input name="" type="text" class="add_input" style="width:906px;" value="'.$result_data[0]['CustomerBGP']['mailing_landmark'].'" /></td>
			                      </tr>
			                    </table>
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2"><table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="680">
			                        <table width="680" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70">City*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:607px;" value="'.$result_data[0]['CustomerBGP']['mailing_city'].'" /></td>
			                          </tr>
			                        </table></td>
			                        <td width="300">
			                        	<table width="300" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70" align="center">Pin Code*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:220px;" value="'.$result_data[0]['CustomerBGP']['mailing_pincode'].'" /></td>
			                          </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table></td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2"><table width="980" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="680">
			                        <table width="670" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70">State*</td>
			                            <td ><input name="" type="text" class="add_input" style="width:607px;" value="'.$result_data[0]['CustomerBGP']['mailing_state'].'" /></td>
			                          </tr>
			                        </table></td>
			                        <td width="300">
			                        	<table width="300" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="70" align="center">Country</td>
			                            <td width="30" >&nbsp;</td>
			                            <td width="" ><input name="" type="text" class="add_input" style="width:190px;" value="INDIA" /></td>
			                          </tr>
			                          </table>
			                        </td>
			                      </tr>
			                    </table></td>
			                  </tr>
			                  <tr>
			                    <td>Overseas Address (Mandatory for NRI)</td>
			                  </tr>
			                  <tr>
			                    <td><input name="" type="text" class="add_input" value="'.$result_data[0]['CustomerBGP']['mailing_overseas_address'].'" /></td>
			                  </tr>
			                  <tr>
			                    <td align="center" class="paddingB5 paddingT5 fontsize15"><strong>
			                    	-----------------------------------------
			                    	Proof of Address Submitted by Applicant (any one of the below)
			                        -----------------------------------------
			                    	</strong></td>
			                  </tr>
			                  <tr width="970">
			                    <td class="paddingB5 paddingT5">
			                   <label class="lF" style="width:120px;">
			                  <input name="input" type="checkbox" value="" class="checkBox" />
			                  UID(Aadhar)</label>
			                  <label class="lF" style="width:132px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Driving License </label>
			                  <label class="lF" style="width:110px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Passport</label>
			                  <label class="lF" style="width:111px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Voter ID </label>
			                  
			                    <label class="lF" style="width:112px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Ration Card</label>
			                    <label class="lF" style="width:172px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Lease or Sale Agreement</label>
			                    <label class="lF" style="width:222px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Latest Bank Statement/Passbook</label>
								
			                    
			                        
			                    </td>
			                  </tr>
							  <tr>
							  	<td>
									 <label class="lF" style="width:180px;">
										<input name="input" type="checkbox" value="" class="checkBox lF" />Latest Utility Bill</label>
								<label class="lF" style="width:190px;">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Latest Gas Bill</label>
			                  	<label class="lF">
			                    <input name="input" type="checkbox" value="" class="checkBox" />
			                    Other____________</label>
								</td>
							  </tr>
			                  <tr>
			                    <td class="paddingT5 fontsize11" width="950">
			                    **Not more than 3 months old proof of address issued by any of the following: Bank Managers of Schedule Commercial Bank/Schedule Co-operative Bank/Multinational Foreign Bank
			Gazetted oficer/Notary Public/ElectedRepresentatives to the Representative to the Legislative Assembly/Parliament/Document issued by Govt. or Statutory Authority.
			                    </td>
			                  </tr>
			                  
			                </table>
			
			            </td>
			          </tr>
			        </table>
			
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="left" valign="top" class="paddingB5 paddingT5">
			  <table width="1000" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td class="bold fontsize14 paddingB paddingT">
			      	3. CONTACT DETAILS and PAN DETAIL (*Fields are mandatory)
			      </td>
			    </tr>
			    <tr>
			      <td class="paddingTRBL5" style="padding-left:0;">
			      <table width="1000" border="0" cellspacing="0" cellpadding="0" class="borderBL">
			        <tr>
			          <td width="80" class="paddingT2 paddingB2 borderTR">&nbsp; Phone</td>
			          <td width="120" class="paddingT2 paddingB2 borderTR">&nbsp; Residence</td>
			          <td width="230" class="paddingT2 paddingB2 borderTR">'.$result_data[0]['CustomerBGP']['contact_phone_residence'].'</td>
			          <td width="90" class="paddingT2 paddingB2 borderTR">&nbsp; Office</td>
			          <td width="200" class="paddingT2 paddingB2 borderTR">'.$result_data[0]['CustomerBGP']['contact_phone_office'].'</td>
			          <td width="300" class="paddingT2 paddingB2 borderTR">&nbsp; PAN No.- '.$result_data[0]['CustomerBGP']['contact_pan_no'].'</td>
			        </tr>
			      </table></td>
			    </tr>
			    <tr>
			      <td height="20" >
					  <table width="1010" border="0" cellspacing="0" cellpadding="0">
			        <tr>
			          <td width="480" align="left" >
			          <table width="480" border="0" cellspacing="0" cellpadding="0" class="Boxborder">
			            <tr>
			              <td width="180" class="BoxborderRight">&nbsp; Mobile*</td>
			              <td width="300">'.$result_data[0]['CustomerBGP']['contact_mobile'].'</td>
			            </tr>
			          </table>
			          </td>
			          <td width="30"></td>
			          <td width="488">
			          <table width="490" border="0" align="right" cellpadding="0" cellspacing="0" class="Boxborder">
			            <tr>
			              <td width="170" class="BoxborderRight">&nbsp; E-mail</td>
			              <td width="338">'.$result_data[0]['CustomerBGP']['contact_email'].'</td>
			            </tr>
			          </table>
			          </td>
			        </tr>
			      </table>
				  
				  </td>
			    </tr>
			    <tr>
			      <td class="fontsize11 paddingL5">I agree to receive updates via SMS on my registered mobile and to receive Account Statements / other statutory as well as other information documents on my registered email in lieu of physical documents</td>
			    </tr>
			    <tr>
			    
			    <td class="paddingB5 paddingT5 BoxborderBotm BoxborderTop fontsize11">
			       <span class="lF bold" style="width:90px;">Occupation</span>
			                   <label class="lF" style="width:101px;">
			                  <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Private Sector") ? "checked=checked" : "").' value="" class="checkBox" />
			                   Private Sector</label>
			                  <label class="lF" style="width:129px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Government Service") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Government Service </label>
			                  <label class="lF" style="width:82px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Business") ? "checked=checked" : "").' value="" class="checkBox" />
			                   Business</label>
			                  <label class="lF" style="width:96px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Professional") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Professional </label>
			                  <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Agriculturist") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Agriculturist </label>
			                    <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Retired") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Retired </label>
			                    <label class="lF" style="width:102px;">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Housewife") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Housewife</label>
			                  <label class="lF">
			                    <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['occupation'] == "Other") ? "checked=checked" : "").' value="" class="checkBox" />
			                    Other _______</label>
			                        
            	  </td>
			    </tr>
			  </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left"><table width="1000" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td class="bold fontsize14">3.PAYMENT DETAILS</td>
			    </tr>
			    <tr>
			      <td width="1000" class=" Boxborder  ">
			      		<table width="995" border="0" cellspacing="0" cellpadding="0">
			              <tr>
			                <td width="490" valign="top" class="paddingB2 BoxborderRight paddingL5">
			                	<table width="500" border="0" align="right" cellpadding="0" cellspacing="0">
			                      <tr>
			                        <td class="bold fontsize14  paddingT2 paddingB2">
			                        	<span style="text-decoration:underline;">Initial Subscription Details</span></td>
			                      </tr>
			                      <tr>
			                        <td class="">
			                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                              <tr>
			                                <td width="150">Amount(Rs.)</td>
			                                <td><p>
			                                  <input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value="'.$result_data[0]['CustomerBGP']['initial_amount'].'" />
			                                </p></td>
			                              </tr>
			                              <tr>
			                                <td>Mode of Payment</td>
			                                ';
											if($result_data[0]['CustomerBGP']['initial_pay_by'] == 'Online'){
												$html.= '<td class="paddingT2">
			                                	Online
			                                </td>';
											}else{
												$html.= '<td class="paddingT2">
			                                	<label class="lF" style="width:90px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['initial_pay_by'] == "Cheque") ? "checked=checked" : "").' value="" class="checkBox" /> Cheque </label>
			                                    <label class="lF" style="width:60px;"><input name="" type="checkbox"  value="" class="checkBox" /> DD </label>
			                                    <label class="lF"><input name="" type="checkbox" value="" class="checkBox" /> Payorder </label>
			                                	</td>';
										   }
											
			                               $html.= '</tr>';
			                               
			                              if($result_data[0]['CustomerBGP']['initial_pay_by'] == 'Online'){
				                              	$html.= '
				                              	<tr>
					                                <td>Transaction ID</td>
					                                <td class="paddingT2">'.$result_data[0]['CustomerBGP']['mmp_txn'].'</td>
				                              	</tr>
				                              	<tr>
					                                <td>Transaction Date</td>
					                                <td class="paddingT2">'.date("d-m-Y",strtotime($result_data[0]['CustomerBGP']['date'])).'</td>
				                              	</tr>
				                              	<tr>
					                                <td>Bank Details</td>
					                                <td class="paddingT2">
					                                	'.$result_data[0]['CustomerBGP']['bank_name'].'
					                                </td>
				                              	</tr>
				                              	<tr>
					                                <td>Bank Transaction</td>
					                                <td class="paddingT2">
					                                	'.$result_data[0]['CustomerBGP']['bank_txn'].'
					                                </td>
				                              	</tr>
				                              	';
			                              }else{
				                              	$html.= '<tr>
				                                <td>Cheque/DD/Payorder No.</td>
				                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
				                              </tr>
				                              <tr>
				                                <td>Cheque/DD/Payorder Date</td>
				                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
				                              </tr>
				                              <tr>
				                                <td>Bank Name<br />
				                                Bank Branch</td>
				                                <td class="paddingT2"><input name="" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
				                              </tr>
				                              <tr>
				                                <td>Account Number</td>
				                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-2" style="width:290px;" value=""/></td>
				                              </tr>
				                              <tr>
				                                <td>Account Type</td>
				                                <td class="paddingT5">
					                                <label class="lF" style="width:64px;"><input name="" type="checkbox" value="" class="checkBox" /> Saving </label>
				                                    <label class="lF" style="width:64px;"><input name="" type="checkbox"  value="" class="checkBox" /> Current </label>
				                                    <label class="lF" style="width:50px;"><input name="" type="checkbox" value="" class="checkBox" /> NRE </label>
				                                    <label class="lF"><input name="" type="checkbox" value="" class="checkBox" /> NRO </label>
				                                </td>
				                              </tr>';
			                              }
			                            $html.= '</table>
			                        </td>
			                      </tr>
			                    </table>
			
			                </td>
			                <td width="549" valign="top" class="paddingL5">
			                	 <table width="545" border="0" align="right" cellpadding="0" cellspacing="0">
			                  <tr>
			                     <td>
			                     	<table width="545" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td width="360" class="paddingT2 paddingB5"><span class="bold fontsize14" style="text-decoration:underline;">Monthly Subscription Details</span>
			                            	<div><label class="paddingT2 lF"><input name="" type="checkbox" value="" class="checkBox" /> SIP through Auto-Debit(ECS/Direct Debit)</label></div>
			                            </td>
			                            <td width="20"><input name="" type="checkbox" value="" class="checkBox" '.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "SIP") ? "checked=checked" : "").' /> </td>
										<td width="30"> SIP</td>
			                            <td width="20"><input name="" type="checkbox"  value="" class="checkBox" '.(($result_data[0]['CustomerBGP']['monthly_sip_pdc'] == "PDC") ? "checked=checked" : "").' /> </td>
										<td width="30"> PDC</td>
										<td width="10">&nbsp;</td>
			                          </tr>
			                        </table>
			                     </td>
			                   </tr>
			                  
			                  <tr>
			                    <td>
			                    	
			                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                              <tr>
			                                <td width="150" valign="top">Bank Name<br />
			                                Bank Branch</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-3" style="width:365px;" value="'.$result_data[0]['CustomerBGP']['bank_name'].'" /></td>
			                              </tr>
			                              <tr>
			                                <td>Account Number</td>
			                                <td class="paddingT2"><input name="input2" type="text" class="inputBoxDtl-3" style="width:365px;" value="'.$result_data[0]['CustomerBGP']['account_number'].'"/></td>
			                              </tr>
			                              <tr>
			                                <td>Account Type</td>
			                                <td class="paddingT2">
				                                <label class="lF" style="width:64px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "Saving") ? "checked=checked" : "").' value="" class="checkBox"  /> Saving </label>
			                                    <label class="lF" style="width:64px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "Current") ? "checked=checked" : "").'  value="" class="checkBox"  /> Current </label>
			                                    <label class="lF" style="width:50px;"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "NRE") ? "checked=checked" : "").' value="" class="checkBox"  /> NRE </label>
			                                    <label class="lF"><input name="" type="checkbox" '.(($result_data[0]['CustomerBGP']['account_type'] == "NRO") ? "checked=checked" : "").' value="" class="checkBox" /> NRO </label>
			                                </td>
			                              </tr>
			                          </table> 
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2 BoxborderBotm paddingB2">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Amount (Rs.)</td>
			                            <td> <input name="" type="text" class="app_inputBox" value="'.$result_data[0]['CustomerBGP']['amount'].'" /></td>
			                            <td>Tenure</td>
			                            <td width="80"> <input name="" type="text" value="'.$result_data[0]['CustomerBGP']['tenure'].'" class="app_inputBox" style="width:25px;"/> years</td>
			                            <td>
			                            	<table width="186" border="0" cellspacing="0" cellpadding="0">
			                                  <tr>
			                                    <td width="90">
			                                    	Period From  
			                                    </td>
			                                    <td align="center"><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.$result_data[0]['CustomerBGP']['period_from'].'" /> to</td>
			                                    <td><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.$result_data[0]['CustomerBGP']['period_to'].'"/></td>
			                                  </tr>
			                                </table>
			
			                            </td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                  <tr>
			                  	<td class="paddingT2"><label><input name="" type="checkbox" value="" class="checkBox" /> </label>SIP through Post Dated Cheque</td>
			                  </tr>
			                  <tr>
			                    <td class="">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Amount (Rs.)</td>
			                            <td> <input name="" type="text" class="app_inputBox" value="'.$result_data[0]['CustomerBGP']['amount'].'"/></td>
			                            <td>Tenure</td>
			                            <td width="80"> <input name="" type="text" class="app_inputBox" style="width:25px;" value="'.$result_data[0]['CustomerBGP']['tenure'].'"/> years</td>
			                            <td>
			                            	<table width="186" border="0" cellspacing="0" cellpadding="0">
			                                  <tr>
			                                    <td width="90">
			                                    	Period From  
			                                    </td>
			                                    <td align="center"><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.$result_data[0]['CustomerBGP']['period_from'].'"/> to</td>
			                                    <td><input name="" type="text" class="app_inputBox" style="width:60px;" value="'.$result_data[0]['CustomerBGP']['period_to'].'"/></td>
			                                  </tr>
			                                </table>
			                            </td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                  <tr>
			                    <td class="paddingT2 paddingB2">
			                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                          <tr>
			                            <td>Cheque No. From <input name="" type="text" class="app_inputBox" style="width:75px;" value="'.$result_data[0]['CustomerBGP']['cheque_number_from'].'"/> to <input name="" type="text" value="'.$result_data[0]['CustomerBGP']['cheque_number_to'].'" class="app_inputBox" style="width:75px;"/></td>
			                          </tr>
			                        </table>
			
			                    </td>
			                  </tr>
			                </table>
			                </td>
			              </tr>
			            </table>
			      </td>
			    </tr>
			  </table></td>
			</tr>
			<tr>
			  <td colspan="2" align="left" class="paddingT2">
			      <table width="1000" border="0" cellspacing="0" cellpadding="0">
			        <tr>
			         <td class="bold fontsize14 paddingB5">
			          	4.NOMINATION DETAILS (Mandatory)
			          </td>
			        </tr>
			        <tr>
			          <td class="Boxborder paddingL5">
			          	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			              <tr>
			                <td width="520" align="center" class="fontsize14">Name and Address of Nominee</td>
			                <td width="520" align="center" class="fontsize14">Name and Address of Guardian(if Nominee is Minor)</td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                    <table width="1000" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                      <td width="60">Name</td>
			                        <td >  <input name="input3" type="text" class="inputBoxDtl-4" value="'.$result_data[0]['CustomerBGP']['nomination_name'].'"/>
			                        </td>
			                      <td width="60">Name</td>
			                        <td >  <input name="input4" type="text" class="inputBoxDtl-4" value="'.$result_data[0]['CustomerBGP']['nomination_guardian_name'].'"/>
			                        </td>
			                      </tr>
			                    </table>
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                	<table width="1000" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td width="60">Address</td>
			                        <td><input name="input6" type="text" class="inputBoxDtl-2" style="width:926px; float:left;" value="'.$result_data[0]['CustomerBGP']['nomination_address'].'"/></td>
			                      </tr>
			                    </table>
			
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                <table width="1000" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="60">City</td>
			                    <td><input name="input5" type="text" class="inputBoxDtl-2" style="width:380px;" value="'.$result_data[0]['CustomerBGP']['nomination_city'].'"/></td>
			                    <td width="60"> State </td>
			                    <td width="230"><input name="input7" type="text" class="inputBoxDtl-2" style="width:477px;" value="'.$result_data[0]['CustomerBGP']['nomination_state'].'"/></td>
			                  </tr>
			                </table>
			
			                <!--<span style="width:60px; float:left;">&nbsp;&nbsp;</span>
			                  <input name="input5" type="text" class="inputBoxDtl-2" style="width:602px;"/>
			                  City
			                  <input name="input4" type="text" class="inputBoxDtl-2" style="width:280px;"/>-->
			                </td>
			              </tr>
			              <tr>
			                <td colspan="2" class="paddingT2">
			                	<table width="990" border="0" cellspacing="0" cellpadding="0">
			                  <tr>
			                    <td width="60">Pin Code</td>
			                    <td><input name="input4" type="text" class="inputBoxDtl-2" style="width:380px;" value="'.$result_data[0]['CustomerBGP']['nomination_pincode'].'"/></td>
			                    <td width="210"> Guardian Relationship with Minor </td>
			                    <td width=""><input name="input7" type="text" class="inputBoxDtl-2" style="width:328px;" value="'.$result_data[0]['CustomerBGP']['nomination_guardian_realtion'].'"/></td>
			                  </tr>
			                </table>
			
			                </td>
			              </tr>
			              
			              <tr>
			                <td class="paddingT2">
			                	<span style="width:130px; float:left;">Relationship with Applicant</span>
			                    <input name="input4" type="text" class="inputBoxDtl-2" style="width:310px;" value="'.$result_data[0]['CustomerBGP']['nomination_applicant_realtion'].'"/>
			                </td>
			                <td rowspan="2" align="right" class="paddingT5 paddingB2" style="padding-right:10px;">
			                	
			                    <table width="450" border="0" align="right" cellpadding="0" cellspacing="0" class="signBox">
			                      <tr>
			                        <td height="45" width="450" valign="middle" style="color:#ccc;">Signature of Guardian</td>
			                      </tr>
			                    </table>
			
			                    
			                </td>
			              </tr>
			              <tr>
			                <td class="paddingT2"><span style="width:130px; float:left;">Date of Birth <br />
			                  (In case of Minor)</span>
			                  <input name="input4" type="text" class="inputBoxDtl-2" style="width:310px;" value="'.(($result_data[0]['CustomerBGP']['nomination_dob'] != "0000-00-00") ? date('d-m-Y',strtotime($result_data[0]['CustomerBGP']['nomination_dob'])) : "").'"/></td>
			                </tr>
			            </table>
			
			          </td>
			        </tr>
			      </table>
			  </td>
			</tr>
			<tr>
			  <td colspan="2" align="left" class="paddingT5">
			<p class="fontsize15">Declaration:-</p>
			<p class="fontsize11" style="text-align:justify;">I propose to enroll with Birla Gold Plus, subject to terms & conditions of the product brochures as amended from time to time. I have read and understood (before Filling the application form)
& Conditions in the product brouchures, and I accept the same. I have neither received nor been induced by an rebate or gifts, directly or indirectly, while enrolling to Birla Gold Plus.I hereby
declare that the subscriptions proposed to be remitted in Birla Gold Plus will be from legitimate sources only and will not be with any intention to contravene/evade/avoid any legal/statutory/regulatory
requirements. I understand that Birla Gold & Precious Metals Ltd.,may, at its absolute discretion, discontinue any or all of the services by giving prior notice to me. I hereby authorise BGPM to debit
my customer ID with the service charges as applicable from time to time. I hereby authorise the aforesaid nominee to receive all the gold accrued to my credit, in the event of my death. Signature of the
nominee acknowledging receipts of the proceeds of Birla Gold shall constitute full discharge of liabilities of Birla Gold in respect of my Customer ID.</p>     
			     
			                                                          
			  </td>
			</tr>
			
			
			<tr>
			  <td align="left" width="450">
			  
			 <p> Date :- '.$result_data[0]['CustomerBGP']['declaration_date'].'</p>
			
			<p> Place :- '.$result_data[0]['CustomerBGP']['declaration_place'].' </p>
			  
			  </td>
			  <td align="right" style="padding-right:10px;">
			  	<table width="450" border="0" align="right" cellpadding="0" cellspacing="0" class="signBox">
			      <tr>
			        <td width="450" height="45" valign="middle" style="color:#ccc;">Signature of Investor</td>
			      </tr>
			    </table>
			  </td>
			</tr>
			  
			  
			<tr>
			  <td colspan="2" align="left" class="paddingT5">
			  	
			    <table width="1000" border="0" cellspacing="0" cellpadding="0">
			    
			          <tr>
			        <td colspan="2" align="left"height="10"></td>
			        </tr>
			
			      <tr>
			        <td width="790" align="left" class="paddingT fontsize15 bold" style="border-top:2px dashed #333;">
			    	<div style="text-align:center; display:block; border:2px solid #ccc; height:30px; width:759px; padding-top:10px;"> Acknowledgment Slip (to be filled by Customer) </div>
			    </td>
			         <td width="250" align="center" valign="middle" class="paddingT fontsize15" style="border-top:2px dashed #333;">Application No. - '.$app_no.'</td>
			      </tr>
			    </table>
			    
			  </td>
			  </tr>
			
			<tr>
			  <td colspan="2" align="left" class="paddingT2"><table border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td width="850" valign="top" style="font-size:14px;line-height:30px;">	
				  <p>Received with thanks from Mr./Ms./Mrs_______________________________________________an application for allotment</p><br/>
			<p>of gold gram under BGSP as per the advance payment details below:-<br/></p>
			<p>
			Amount ____________Payment Mode: Cheque/DD/Payorder Instrument No.__________________Date ________________</p><br/>
			
			<p>Bank Name_________________________________________Branch____________________________Tenure__________</p><br/>
			
			<p>Monthly Subscription Option: ECS / Direct Debit / PDC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Monthly Subscription Amount_____________________</p>
			</td>
			      <td align="center" class="paddingL">
			      
			      
			        <table width="180" border="0" cellspacing="0" cellpadding="0" class="">
			          <tr>
			            <td align="center" width="180" style="border:2px dotted #333; height:80px; text-align:center;">
			            <p>&nbsp;</p>
			            Collection Center Date and Stamp
			            </td>
			          </tr>
			        </table>
			      
			      </td>
			    </tr>
			  </table></td>
			  </tr>
			  
			  <tr>
              	<td height="28" valign="bottom" align="left" style="font-size:12px;">
                	Birla Gold and Precious Metals Ltd
                </td>
              	<td height="28" valign="bottom" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
              </tr>
			  </table>
			
			  
			</div>
			
			
			
			</body>
			</html>
			';
			
			$html2 = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Application Form 5</title>

<style>

/**** form5 ****/
.fontsize18{ font-size:18px;}
.title{ background:#d1d2d4; font-size:18px; line-height:24px; text-align:center;}
.txtjustify{ text-align:justify;}
.monthInput{border-bottom:1px solid #333; width:45px; height:22px; text-align:center; text-transform:uppercase;}
.yearInput{border-bottom:1px solid #333; width:60px; height:22px; text-align:center; text-transform:uppercase;}

</style>

</head>

<body>

<div style="width:1000px; border:0px solid #666; padding:10px 0 0 40px; margin:0 auto;">

  <table width="1000" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="1000" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="499" valign="top" style="padding-top:15px"><img src="img/logo.jpg" />
                <p class="fontsize14 paddingT"> Birla Gold and Precious Metals Ltd <br />
                  Morya Landmark II,G-002,Ground Floor, <br />
                  New Link Road,Andheri(W),Mumbai-400 053 </p></td>
              <td width="501" align="right" valign="top"><strong class="fontsize15"> Application No. - '.$app_no.'</strong></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center" class="paddingB paddingT"><h4 class="fontsize18">Electronic Clearing Service<br />
        RBI-ECS Debit / Direct Debit collection Mandate form</h4></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="paddingB paddingT txtjustify"> I/We the account holders with the Bank as per details below hereby request and authorize the Bank to accept this ECS Debit(Clearing)/Direct Debit
        mandate executed by me/us in favour of <strong>M/s Birla Gold and Precious Metals Private Limited</strong> and submitted by them or through their authorized
        service provider under RBI ECS debit procedures. I/We further request and authorize the bank to debit my/our account to honor the periodical payment
        contribution requests presented by the service provider. Various details of bank account and periodical payment are furnished below: </td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="25" class="title">BANK ACCOUNT DETAILS</td>
        </tr>
        <tr>
          <td class="paddingT paddingB txtjustify"> I/We hereby authorize <strong>Birla Gold and Precious Metals Private Limited</strong> and their authorized service providers to debit my/our following
            bank account by ECS Debit (Clearing)/Direct Debit to account for collection of Monthly Subscription Payments (Applicant should be amongst
            one of bank account holders). </td>
        </tr>
        <tr>
          <td class="paddingB5"> 
          	<table width="990" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                	<table width="990" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="160">Bank Account Number:</td>
                        <td width="830">'.$result_data[0]['CustomerBGP']['ecs_bank_account_number'].'</td>
                      </tr>
                      <tr>
                        <td>Account Type:</td>
                        <td class="paddingB5 paddingT5">
                        <table width="830" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "Saving") ? "checked=checked" : "").' class="checkBox" /> Savings</td>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "Current") ? "checked=checked" : "").' class="checkBox" /> Current</td>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "NRE") ? "checked=checked" : "").' class="checkBox" /> NRE</td>
                            <td><input name="input" type="checkbox" value="" '.(($result_data[0]['CustomerBGP']['ecs_bank_account_type'] == "NRO") ? "checked=checked" : "").' class="checkBox" /> NRO</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                </td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Account Holders Name (1st holder): '.$result_data[0]['CustomerBGP']['ecs_account_holder_name'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Name:'.$result_data[0]['CustomerBGP']['ecs_bank_name'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">Bank Branch Name/Address: '.$result_data[0]['CustomerBGP']['ecs_branch_address'].'</td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5">
                	<table width="990" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="110">Bank City/Town: </td>
                        <td width="442">'.$result_data[0]['CustomerBGP']['ecs_city'].'</td>
                        <td width="30">&nbsp;</td>
                        <td width="142" align="right">PIN CODE:</td>
                        <td width="266" align="left">'.$result_data[0]['CustomerBGP']['ecs_pincode'].'</td>
                      </tr>
                    </table>

                </td>
              </tr>
              <tr>
                <td class="paddingB5 paddingT5"><table width="990" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="260">Bank Branch MICR Number (9 DIGITS) : </td>
                    <td width="342">'.$result_data[0]['CustomerBGP']['ecs_branch_micr'].'</td>
                    <td width="35">&nbsp;</td>
                    <td width="100" align="right">IFSC CODE:</td>
                    <td width="263" align="left">'.$result_data[0]['CustomerBGP']['ecs_ifsc_code'].'</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td style="font-size:13px;">as appearing in Cheque leaf-please attach a copy of cancelled cheque/bankers attestation. MICR Code starting and/or ending with 000 are not valid for ECS.</td>
              </tr>
            </table>

          </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td height="30" align="left" class="paddingT2 title"> PERIODIC PAYMENT DETAILS <span class="fontsize14">(Please refer payment mode section)</span></td>
    </tr>
    <tr>
      <td align="left" valign="top" class="paddingT fontsize15"><table width="980" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="35" valign="middle"> Debit Date (tick applicable date)
            <input name="input" type="checkbox" '.(($result_data[0]['CustomerBGP']['ecs_debit_date'] == "10") ? "checked=checked" : "").' value="" class="checkBox" />
            10
            <input name="input2" type="checkbox" '.(($result_data[0]['CustomerBGP']['ecs_debit_date'] == "20") ? "checked=checked" : "").' value="" class="checkBox" />
            20 </td>
          <td>Amount of Subscription:'.$result_data[0]['CustomerBGP']['ecs_amount_of_subscription'].'</td>
        </tr>
        <tr>
          <td class="paddingT2"> From:
            <input type="text" name="textfield" id="textfield" class="monthInput" placeholder="MM" style="border:0;" value="'.$result_data[0]['CustomerBGP']['ecs_from'].'" />
            
            To:
            <input type="text" name="textfield" id="textfield" class="monthInput" placeholder="MM" value="'.$result_data[0]['CustomerBGP']['ecs_to'].'" />
            
          <td class="paddingT2"> Frequency: MONTHLY </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" class="paddingT2 paddingB"><table width="1030" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1030" height="30" class="paddingT2 title"> CONTRIBUTION DETAILS</td>
        </tr>
        <tr>
          <td class="paddingT"><table width="1020" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="450" class="paddingT5">Beneficiary Name: <strong>Birla Gold and Precious Metals Ltd</strong></td>
              <td>Product Code: <strong>BGSP</strong></td>
              <td width="415" align="right">Product Name: <strong> Birla Gold Plus</strong></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td class="paddingT5 paddingB">Customer ID/Folio No. ___________________________________________________________________________________________________________________________________</td>
        </tr>
        <tr>
          <td class="paddingT5 paddingB">Customer/Contributors Name_____________________________________________________________________________________________________________________________</td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" valign="top" class="paddingT5 paddingB5"><table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" class="title">DECLARATION</td>
        </tr>
        <tr>
          <td class="txtjustify paddingT5"> I/We wish to inform you that I/We have registered for the subject scheme for the contribution payment to the bene?ciary as per account details as above
by debit to said Bank Account. I/We express my willingness for participation in ECS/Direct Debit scheme. I declare that the particulars given above
are correct and complete. I/We agree to discharge the responsibility expected of me as a participant under the ECS/Direct Debit scheme. I/We hereby
authorize the bene?ciary or their representatives to get this mandate lodged with bank/get veri?ed and further execute by raising debits on the applicable
dates through ECS/Direct Debit scheme. If the mandate is not lodged/transaction is not collected or delayed for reasons beyond control of the bene?ciary/service
provider representative or on account of incomplete or incorrect information, I/We shall not hold them responsible. I/We shall keep indemni?ed for
claims and actions, that bene?ciary or representative may incur, for execution of transactions in conformity with this mandate.
           </td>
        </tr>
      </table></td>
    </tr>
    <tr><td headers="15">&nbsp;</td></tr>
    <tr>
      <td align="left" class="paddingT5 paddingB5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30" class="title">AUTHORISATION</td>
        </tr>
        <tr>
          <td class="txtjustify paddingT paddingB" > I/We hereby request and authorize the bank to honor the periodic debit instructions raised as above and cause my account to be debited accordingly. Charges,
if any, for mandate veri?cation/registration may be debited to my account. I hereby undertake to keep suf?cient funds in the account well prior to the applicable
date and till the date of execution. If the date of debit happens to be a holiday or non working day for the bank or location, the debit may happen on any subsequent
working day. Debited contributions may be passed on to the bene?ciary/representative as per rules, procedures and practices in force. I/We shall not dispute any
debit raised under this mandate and as speci?ed therein and during or for the validity period. I/We shall keep indemni?ed for claims that Bank may incur for reason
of execution in conformity with this mandate. </td>
        </tr>
        <tr>
          <td width="980" class="paddingT">
          <table width="980" border="1" cellspacing="0" cellpadding="0" class="fontsize18 borderBL">
            <tr>
              <td align="center" class="borderTR">As per Bank Record</td>
              <td align="center" class="borderTR">1st Account Holder</td>
              <td align="center" class="borderTR">2nd Account Holder</td>
              <td align="center" class="borderTR">3rd Account Holder</td>
            </tr>
            <tr>
              <td align="center" class="borderTR">Name</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" class="borderTR" style="height:60px">Signature</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
              <td align="center" class="borderTR">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr><td height="10"></td></tr>
    <tr>
      <td height="30" align="center" class="paddingT5 title paddingB5"> FOR BANK USE ONLY </td>
    </tr>
    <tr>
      <td class="txtjustify fontsize15 paddingT"> Certified that the bank account details and signatures of the account holders are correct and as per '."bank's".' records. </td>
    </tr>
	
	
	
    <tr>
      <td class="txtjustify fontsize15"><table width="1000%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="527">Date:____________________</td>
          <td width="473" align="center">_______________________________________________</td>
        </tr>
        <tr>
          <td width="527">&nbsp;</td>
          <td align="center" class="paddingT">Stamp & Signature of the Authorized Official of the Bank</td>
        </tr>
      </table></td>
    </tr>
	
	 <tr>
		<td height="28" valign="bottom">
			 <table width="1000" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="500" align="left" style="font-size:12px;">Birla Gold and Precious Metals Ltd</td>
				<td width="500" align="right" style="font-size:12px;">Birla Gold Plus/Ver 1.0/May 2014</td>
			  </tr>
			</table>
		</td>
	  </tr>
  </table>
</div>

</body>
</html>
';
			

						$date = date_create();
						$pdf_time = date_timestamp_get($date);
						
						
						$this->Mpdf->init();
						$this->Mpdf->SetHTMLHeader(" ");
						$this->Mpdf->WriteHTML($html);
						$this->Mpdf->Output(WWW_ROOT."/documents/tempPDF/".$pdf_time."_3.pdf","F");
						
						$this->Mpdf->init();
						$this->Mpdf->SetHTMLHeader(" ");
						$this->Mpdf->WriteHTML($html2);
						$this->Mpdf->Output(WWW_ROOT."/documents/tempPDF/".$pdf_time."_5.pdf","F");
						
						include WWW_ROOT.'/customerPDFmerger.php';
						$pdf = new PDFMerger();		
						$pdf->addPDF(WWW_ROOT.'/documents/tempPDF/'.$pdf_time.'_3.pdf', 'all');			
						$pdf->addPDF(WWW_ROOT.'/documents/tempPDF/'.$pdf_time.'_5.pdf', 'all');			
						$pdf->merge('F', WWW_ROOT.'/documents/customer_regs_form/'.$pdf_time.'.pdf');
						
				
						$adminmailid = $this->Adminuser->find('first', array('conditions' => array('admin_id' => '1')));
						App::uses('CakeEmail', 'Network/Email');

						$email = new CakeEmail();
						$email->emailFormat('html');
						$email->from(array(trim($adminmailid['Adminuser']['email']) => SITE_NAME));
						$email->template('default', 'default');
						$email->to(trim($result_data[0]['CustomerBGP']['contact_email']));
						$subject = "";
						$email->subject(SITE_NAME . " Birla Gold Customer Registration");
						$email->attachments(array(WWW_ROOT.'/documents/customer_regs_form/'.$pdf_time.'.pdf'));
						$email->send($msg);
						$email->reset();
						
						
						
						
						$filePath = WWW_ROOT."/documents/tempPDF/".$pdf_time."_3.pdf";
						if (file_exists($filePath)) {
							unlink($filePath);
						}
						
						$filePath2 = WWW_ROOT."/documents/tempPDF/".$pdf_time."_5.pdf";
						if (file_exists($filePath2)) {
							unlink($filePath2);
						}
						
						$filePath3 = WWW_ROOT."/documents/customer_regs_form/".$pdf_time.".pdf";
						if (file_exists($filePath3)) {
							unlink($filePath3);
						}
						
							$this->CustomerBGP->updateAll(
									array('send_mail' => "1"),
									array('application_no' => $_POST['mer_txn'])
								);

					}
			$this->set("msg", "Your Application registered successfully, requested to please save/download the application form.<br/>Please fill all the incomplete details, paste the photograph and sign the application form and submit at head office.<br/><br/> <a style='color:#8C472B' href='".BASE_URL."customer/generateForm_dn?id=".$_POST['mer_txn']."'>Download Form</a>");
			$this->set("title", "Registration Fail");
		}		
		$this->render("../CustomerMaster/thankyou");
	} 

}
