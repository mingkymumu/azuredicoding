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
        <th>Title</th> <th>Description</th> <th>Created at</th> <th>Update</th> 
    </tr>
    <?php  
    while($product_data = sqlsrv_fetch_array($result)) {         
        echo "<tr>";
        echo "<td>".$product_data['title']."</td>";
        echo "<td>".$product_data['description']."</td>";
        echo "<td>".$product_data['created_at']."</td>";
        echo "<td><a href='edit.php?id=$product_data[id]'>Edit</a> | <a href='delete.php?id=$product_data[id]'>Delete</a></td></tr>";        

          
    }
    ?>
    </table>
</body>
</html>