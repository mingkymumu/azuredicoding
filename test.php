<?php
   $serverName = "tcp:webappdicoding.database.windows.net,1433";
   $userName = 'mingkymumu@webappdicoding.database.windows.net';
   $userPassword = 'mumu81858591_';
   $dbName = "pos";
   $table = "products";

   $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);

   sqlsrv_configure('WarningsReturnAsErrors', 0);
   $conn = sqlsrv_connect( $serverName, $connectionInfo);
   if($conn === false)
   {
     FatalError("Failed to connect...");
   }
// phpinfo();

// Show just the module information.
// phpinfo(8) yields identical results.
// phpinfo(INFO_MODULES);


?>