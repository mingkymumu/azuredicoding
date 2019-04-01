<?php
// include database connection file
include_once("connection.php");

// Check if form is submitted for user update, then redirect to homepage after update
if(isset($_POST['update']))
{   
    $id = $_POST['id'];

    $title=$_POST['title'];
    $description=$_POST['description'];
  

    // update user data
    $result = sqlsrv_query($conn, "UPDATE dbo.products SET title ='$title',description='$description' WHERE id=$id");

    // Redirect to homepage to display updated user in list
    header("Location: index.php");
}
?>
<?php
// Display selected user data based on id
// Getting id from url
$id = $_GET['id'];

// Fetech user data based on id
$result = sqlsrv_query($conn, "SELECT * FROM dbo.products WHERE id=$id");

while($product_data = sqlsrv_fetch_array($result))
{
    $title = $product_data['title'];
    $description = $product_data['description'];
}
?>
<html>
<head>  
    <title>Edit Product Data</title>
</head>

<body>
    <a href="index.php">Home</a>
    <br/><br/>

    <form name="update_user" method="post" action="edit.php">
        <table border="0">
            <tr> 
                <td>Title</td>
                <td><input type="text" name="title" value="<?php echo $title;?>"></td>
            </tr>
            <tr> 
                <td>Description</td>
                <td><input type="text" name="description" value="<?php echo $description;?>"></td>
            </tr>
          
            <tr>
                <td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>
</html>