<?php
// **********************************************
// Webservice Demo by  Digvijay
// **********************************************
?>
<html>
<head>
<title>Soap WebService Client Demo</title>
<style>
h1  { color:#000066; }
h3  { color:#666600; }
pre { background-color:#FFFFE0; padding:5px; border:1px solid #666600; }
</style>
</head>
<body>
<h1>User Soap Service</h1>

<?php
// ----------- localhost Soap Webservice --------------
//include("connect.php");
require_once("classUtils.php");
require_once("classWebservice.php");

//echo $SERVER_URL = Utils::GetBaseUrl() . "Server_Soap1.php";
  $SERVER_URL =  "http://www.lifewinnersclub.co.uk/soap/Server_Soap1.php";
$Service = new Webservice($SERVER_URL, "SOAP", "utf-8");

$Action  = $_REQUEST["Action"]; 
$Username = $_REQUEST["Username"];
$Password = $_REQUEST["Password"];
$firstname = $_REQUEST["firstname"]; 
$lastname = $_REQUEST["lastname"];  
 
$Username = str_replace("<", "", $Username); // should be encoded for XML
$Username = str_replace(">", "", $Username);
$Username = str_replace("&", "", $Username);
$Password = str_replace("<", "", $Password); // should be encoded for XML
$Password = str_replace(">", "", $Password);
$Password = str_replace("&", "", $Password); 
$firstname = str_replace("<", "", $firstname); // should be encoded for XML
$firstname = str_replace(">", "", $firstname);
$firstname = str_replace("&", "", $firstname);
$lastname = str_replace("<", "", $lastname); // should be encoded for XML
$lastname = str_replace(">", "", $lastname);
$lastname = str_replace("&", "", $lastname);

$Soap = "<?xml version=\"1.0\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\">
  <soapenv:Header/>
  <soapenv:Body>
    <$Action>
      
	  <Username>$Username</Username>
	  <Password>$Password</Password>
	   <firstname>$firstname</firstname>
	   <lastname>$lastname</lastname>
    </$Action>
  </soapenv:Body>
</soapenv:Envelope>";

if ($_REQUEST["Debug"] == "on") $Service->PRINT_DEBUG = true;

flush();
$Response = $Service->SendRequest($Soap, $Action);
 
 
$XPath = $Response["XPath"];

$Answer = str_replace("RQ", "RS", $Action);

echo "<h3>Result:</h3><pre>";
echo "<b>Error</b>:   " .Utils::GetValue($XPath, "//soapenv:Body/soapenv:Fault/faultstring")."<br>";
echo "<b>Action</b>:  $Action<br>";
echo "<b>Answer</b>:  $Answer<br>";
echo "<b>Message</b>: " .Utils::GetValue ($XPath, "//soapenv:Body/$Answer/Message")."<br>";
echo "<b>Username</b>: " .Utils::GetValue ($XPath, "//soapenv:Body/$Answer/Username")."<br>";
echo "<b>Password</b>: " .Utils::GetValue ($XPath, "//soapenv:Body/$Answer/Password")."<br>";
echo "<b>Firstname</b>: " .Utils::GetValue ($XPath, "//soapenv:Body/$Answer/firstname")."<br>";
echo "<b>Lastname</b>: " .Utils::GetValue ($XPath, "//soapenv:Body/$Answer/lastname")."<br>";

 $error=Utils::GetValue($XPath, "//soapenv:Body/soapenv:Fault/faultstring");
if(empty($error)){
     //$sql="Insert into tbl_user SET username='$Username',password=MD5('$Password'),firstname='$firstname',lastname='$lastname'";
	       // $query=mysql_query($sql); 
			//if($query){
			  // echo"Inserted";
			 
			//} 


}


echo "</pre>";

?>
<b><a href="client1.html">Back to Startpage</a></b>
</body>
</html>

