<?php
 try {
    $conn = new PDO("sqlsrv:server = tcp:webappdicoding.database.windows.net,1433; Database = pos", "mingkymumu", "mumu81858591_");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}
// phpinfo();
?>