<?php
$connectionInfo = array("UID" => "mingkymumu@webappdicoding", "pwd" => "{your_password_here}", "Database" => "pos", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:webappdicoding.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
if($conn){
    echo "berhasil connect";
}
else
{
    echo  "gagal cokkkk";
}


?>