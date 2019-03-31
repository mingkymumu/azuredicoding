<?php
    $serverName = "webappdicoding.database.windows.net"; // update me
    $connectionOptions = array(
        "Database" => "pos", // update me
        "Uid" => "mingkymumu", // update me
        "PWD" => "mumu81858591_" // update me
    );
    //Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $tsql= "SELECT TOP 20 FROM dbo.products";
    $getResults= sqlsrv_query($conn, $tsql);
    echo ("Reading data from table" . PHP_EOL);
    if ($getResults == FALSE)
        echo (sqlsrv_errors());
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
     echo ($row['title'] . " " . $row['description'] . PHP_EOL);
    }
    sqlsrv_free_stmt($getResults);
?>