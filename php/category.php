<?php 
    include "connect.php"; 
    if(isset($_POST['cat_insert'])){
        $cat_name = $_POST['cat_name'];
        $cat_image = $_POST['cat_image'];
        $cat_description = $_POST['cat_description'];
        
        $sql = "INSERT INTO categories (cat_image, cat_name, cat_description) VALUES('$cat_image', '$cat_name', '$cat_description')";
        $query = $conn->query($sql) or die ($conn->error);
        echo "<script>alert('category insert success');location ='../index.php';</script>";
    } 
    if(isset($_POST['cat_delete'])){
        $cat_id = $_POST['cat_id'];
        $sql = "DELETE FROM categories WHERE cat_id = '$cat_id'";
        $query = $conn->query($sql) or die ($conn->error);
        echo "<script>alert('category delete success');location ='../index.php';</script>";
    } 
    if(isset($_POST['cat_update'])){
        $cat_id = $_POST['cat_id'];
        $cat_image = $_POST['cat_image'];
        $cat_name = $_POST['cat_name'];
        $cat_description = $_POST['cat_description'];
        $sql = "UPDATE categories SET cat_image = '$cat_image', cat_name = '$cat_name', cat_description = '$cat_description' WHERE cat_id = '$cat_id'";
        $query = $conn->query($sql) or die ($conn->error);
        echo "<script>alert('category update success');location ='../index.php';</script>";
    } 
    if(isset($_POST['cat_defaultVal'])){
        $cat_idVal = $_POST['cat_defaultVal'];
        $cat_sqlVal = "SELECT * FROM categories WHERE cat_id = '$cat_idVal'";
        $cat_queryVal = $conn->query($cat_sqlVal) or die ($conn->error);
        $cat_val = $cat_queryVal->fetch_assoc();
        error_reporting(error_reporting() & ~E_NOTICE);
        echo'
            <label for="update_cat_img">New Category Image:</label>
            <input type="file" name="cat_image" id="update_cat_img" required>
            <label for="update_cat_name">New Category Name:</label>
            <input value="'.$cat_val["cat_name"].'" type="text" name="cat_name" id="update_cat_name" required>
            <label for="update_cat_desc">New Category Description:</label>
            <input value="'.$cat_val["cat_description"].'" type="text" name="cat_description" id="update_cat_desc" required>
        ';
    }
?>