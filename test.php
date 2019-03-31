<?php
$myServer = "webappdicoding.database.windows.net";
$myUser = "mingkymumu";
$myPass = "mumu81858591_";
$myDB = "pos";

$dbhandle = mssql_connect($myServer, $myUser, $myPass)
  or die("Couldn't connect to SQL Server on $myServer"); 
?>