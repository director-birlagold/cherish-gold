<?php

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
	$amount = $amount;
	$txnid = $appid;
	$today = date("d/m/Y H:i:s");
	$returnurl = BASE_URL."/pay/responce";
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

//echo "==IN==";
//print_r($returnData);
//exit;

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
// eof code to generate form action
?>