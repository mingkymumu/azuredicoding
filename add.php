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
        $title = $_POST['title'];
        $description = $_POST['description'];

        // include database connection file
        include_once("connection.php");
        $var =  array($title,$description,date('Y/m/d'));
        $tsql ="INSERT INTO products(title,description,created_at) VALUES(?,?,?)";
        // Insert user data into table
        if (!sqlsrv_query($conn, $tsql, $var))
                 {
            die('Error: ' .sqlsrv_errors());
                 }
            // echo "1 record added"; 


        // Show message when user added
        echo "Product added successfully. <a href='index.php'>View Products</a>";
    }
    ?>
</body>
</html>
