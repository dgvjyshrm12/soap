<?php
// **********************************************
// Webservice Demo by  Digvijay
// **********************************************

// =============== Webservice Soap Server =============

// You must sanitize all input data in the real world to fight back hacker attacks!
// This simple sample does not sanitize data

ProcessSoapRequest($_SERVER["HTTP_SOAPACTION"], $HTTP_RAW_POST_DATA);

function ProcessSoapRequest($SoapAction, $RawPostData)
{
	require_once("classUtils.php");
	//include("connect.php");

	$Dom = new DOMDocument("1.0");
	$Dom->loadXML($RawPostData, LIBXML_NOERROR | LIBXML_NOWARNING);
	
	$XPath = new DOMXpath($Dom);
	
	 
	$Username = Utils::GetValue($XPath, "//soapenv:Body/$SoapAction/Username");
	$Password = Utils::GetValue($XPath, "//soapenv:Body/$SoapAction/Password");
	$firstname = Utils::GetValue($XPath, "//soapenv:Body/$SoapAction/firstname");
	$lastname = Utils::GetValue($XPath, "//soapenv:Body/$SoapAction/lastname");
	 
		
	if (empty($Username))
		WriteSoapError("EMPTY_Username", "Username is empty");	
	/*if(!empty($Username)){
	        echo  $sql="select * from tbl_user where username='$Username'";
	        $query=mysql_query($sql);   
			  $numrows=mysql_num_rows($query);
			if($numrows>0){
			    WriteSoapError("Username_Already", "Username is already used");	
                 				
			} 
	}*/
	
	if (empty($Password))
		WriteSoapError("EMPTY_Password", "Password is empty");

    if (empty($firstname))
		WriteSoapError("EMPTY_Firstname", "Firstname is empty");

   if (empty($lastname))
		WriteSoapError("EMPTY_Lastname", "Lastname is empty");		

	switch ($SoapAction)
	{
		 
		case "STR_ValidateRQ": $Username =$Username."is your username"; break;
		default: WriteSoapError("INVALID_ACTION", "Invalid Action: '$SoapAction'");
	}
	
	// Request -> Response
	$SoapAnswer = str_replace("RQ", "RS", $SoapAction);
	
	echo "<?xml version=\"1.0\"?>\r\n".
	     "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n".
	     "   <soapenv:Header/>\r\n".
	     "   <soapenv:Body>\r\n".
	     "      <$SoapAnswer TimeStamp=\"".time()."\">\r\n".	     
		 "        <Username>$Username</Username>\r\n".
		 "        <Password>$Password</Password>\r\n".
		 "        <firstname>$firstname</firstname>\r\n".
		 "        <lastname>$lastname</lastname>\r\n".
	     "      </$SoapAnswer>\r\n".
	     "   </soapenv:Body>\r\n".
	     "</soapenv:Envelope>\r\n";
}

function WriteSoapError($ErrCode, $ErrMessage)
{
	header("HTTP/1.1 500 Internal Server Error");
	echo "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\">\r\n".
	     "  <soapenv:Body>\r\n".
	     "    <soapenv:Fault>\r\n".
	     "      <faultcode>$ErrCode</faultcode>\r\n".
	     "      <faultstring>$ErrMessage</faultstring>\r\n".
	     "    </soapenv:Fault>\r\n".
	     "  </soapenv:Body>\r\n".
	     "</soapenv:Envelope>";
	exit;
}
