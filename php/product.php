<?php 
    include "connect.php"; 
    if(isset($_POST['prod_insert'])){
        $prod_image = $_POST['prod_image'];
        $prod_name = $_POST['prod_name'];
        $prod_brand = $_POST['prod_brand'];
        $prod_description = $_POST['prod_description'];
        $prod_quantity = $_POST['prod_quantity'];
        $prod_price = $_POST['prod_price'];
        $category = $_POST['category'];
        $sql = "INSERT INTO products (prod_image, prod_name, prod_brand, prod_description, prod_quantity, prod_price, cat_id)
        VALUES('$prod_image', '$prod_name', '$prod_brand', '$prod_description', '$prod_quantity', '$prod_price', '$category')";
        $query = $conn->query($sql) or die ($conn->error);
        echo "<script>alert('product insert success');location ='../index.php';</script>";
    } 
    if(isset($_POST['prod_delete'])){
        $prod_id = $_POST['prod_id'];
        $sql = "DELETE FROM products WHERE prod_id = '$prod_id'";
        $query = $conn->query($sql) or die ($conn->error);
        echo "<script>alert('product delete success');location ='../index.php';</script>";
    } 
    if(isset($_POST['prod_update'])){
        $prod_id = $_POST['prod_id'];
        $prod_image = $_POST['prod_image'];
        $prod_name = $_POST['prod_name'];
        $prod_brand = $_POST['prod_brand'];
        $prod_description = $_POST['prod_description'];
        $prod_quantity = $_POST['prod_quantity'];
        $prod_price = $_POST['prod_price'];
        $category = $_POST['category'];
        $sql = "UPDATE products SET prod_image = '$prod_image', prod_name = '$prod_name', prod_brand = '$prod_brand', prod_description = '$prod_description', 
        prod_quantity = '$prod_quantity', prod_price = '$prod_price', cat_id = '$category' WHERE prod_id = '$prod_id'";
        $query = $conn->query($sql) or die ($conn->error);
        echo "<script>alert('product update success');location ='../index.php';</script>";
    } 
    if(isset($_POST['prod_defaultVal'])){
        $prod_idVal = $_POST['prod_defaultVal'];
        $prod_sqlVal = "SELECT * FROM products WHERE prod_id = '$prod_idVal'";
        $prod_queryVal = $conn->query($prod_sqlVal) or die ($conn->error);
        $prod_val = $prod_queryVal->fetch_assoc();
        error_reporting(error_reporting() & ~E_NOTICE);
        echo'
            <label for="update_prod_name">New Product Name:</label>
            <input value="'.$prod_val["prod_name"].'" type="text" name="prod_name" id="update_prod_name" required>
            <label for="update_prod_brand">New Product Brand:</label>
            <input value="'.$prod_val["prod_brand"].'" type="text" name="prod_brand" id="update_prod_brand" required>
            <label for="update_prod_desc">New Product Description:</label>
            <input value="'.$prod_val["prod_description"].'" type="text" name="prod_description" id="update_prod_desc" required>
            <label for="update_prod_quant">New Product Quantity:</label>
            <input value="'.$prod_val["prod_quantity"].'" type="number" name="prod_quantity" id="update_prod_quant" required>
            <label for="update_prod_price">New Product Price:</label>
            <input value="'.$prod_val["prod_price"].'" type="number" name="prod_price" id="update_prod_price" step=".01" required>
        ';
    }
?>