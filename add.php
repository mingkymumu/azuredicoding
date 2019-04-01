<html>
<head>
    <title>Add Users</title>
</head>

<body>
    <a href="index.php">Go to Home</a>
    <br/><br/>

    <form action="add.php" method="post" name="form1">
        <table width="25%" border="0">
            <tr> 
                <td>title</td>
                <td><input type="text" name="title"></td>
            </tr>
            <tr> 
                <td>Description</td>
                <td><input type="text" name="description"></td>
            </tr>
            <tr> 
                <td></td>
                <td><input type="submit" name="Submit" value="Add"></td>
            </tr>
        </table>
    </form>

    <?php

    // Check If form submitted, insert form data into users table.
    if(isset($_POST['Submit'])) {
        include_once("connection.php");
        $title = $_POST['title'];
        $description = $_POST['description'];
        $tz = 'Asia/Jakarta';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
        // include database connection file
      
        $var =  array($title,$description,$dt,$dt);
        $tsql ="INSERT INTO dbo.products(title,description,created_at,updated_at) VALUES(?,?,?,?)";
        // Insert user data into table
        if (!sqlsrv_query($conn, $tsql, $var))
               {
                if( ($errors = sqlsrv_errors() ) != null) {
                    foreach( $errors as $error ) {
                        echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                        echo "code: ".$error[ 'code']."<br />";
                        echo "message: ".$error[ 'message']."<br />";
                    }
                }
               }
            // echo "1 record added"; 


        // Show message when user added
        echo "Product added successfully. <a href='index.php'>View Products</a>";
    }
    ?>
</body>
</html>
