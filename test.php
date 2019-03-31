<?php
$myServer = "webappdicoding.database.windows.net";
$myUser = "mingkymumu";
$myPass = "mumu81858591_";
$myDB = "pos";

$conn = mssql_connect($myServer,$myUser,$myPass);
if (!$conn)
{ 
  die('Not connected : ' . mssql_get_last_message());
} else
{
    echo "Konek cuy";
}
$db_selected = mssql_select_db($myDB, $conn);
if (!$db_selected) 
{
  die ('Can\'t use db : ' . mssql_get_last_message());
} 