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
        $name = $_POST['title'];
        $descrription = $_POST['description'];

        // include database connection file
        include_once("connection.php");

        // Insert user data into table
        $result = sqlsrv_query($mysqli, "INSERT INTO users(name,email,mobile) VALUES('$title','$description')");

        // Show message when user added
        echo "Product added successfully. <a href='index.php'>View Products</a>";
    }
    ?>
</body>
</html>
F