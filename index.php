<?php
// Create database connection using config file
include_once("connection.php");

// Fetch all users data from database
$result = sqlsrv_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<html>
<head>    
    <title>Product List</title>
</head>

<body>
<a href="add.php">Add New Product</a><br/><br/>

    <table width='80%' border=1>

    <tr>
        <th>Name</th> <th>description</th> 
    </tr>
    <?php  
    while($product_data = sqlsrv_fetch_array($result)) {         
        echo "<tr>";
        echo "<td>".$product_data['title']."</td>";
        echo "<td>".$product_data['description']."</td>";
          
    }
    ?>
    </table>
</body>
</html>