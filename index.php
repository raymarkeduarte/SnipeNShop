<?php session_start(); include "php/connect.php";  ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>snipenshop</title>
        <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="javascript/script.js?v=<?php echo time(); ?>" defer></script>
    </head>
    <body>
        <header class="main-header">
            <nav>
                <div class="nav-left">
                    <a href="index.php"><img src="images/logo2.png" alt=""></a>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a id="showLogIn">Log in</a></li>
                        <li><a id="showRegister" style="display:none;">Add Account</a></li>
                        <form action="php/log.php" method="post">
                            <li id="LogOut" style="display:none;"><a><label for="logout-input">Log out</label></a></li>
                            <input id="logout-input" type="submit" name="logout" style="display:none;">
                        </form>
                    </ul>
                </div>
                <div class="nav-right">
                    <label for="">
                        <?php  
                            if(isset($_SESSION['firstName'])){
                                echo $_SESSION['firstName'] . " " .$_SESSION['lastName'] ."<img src='images/profile copy.png'>";
                            }
                        ?>
                    </label>
                    <form action="" method="get" style='display:flex'>
                        <input type="text" name="search" placeholder="Search" required>
                        <button type="submit"><img src="images/search.png" alt=""></button>
                    </form>
                </div>
            </nav>
        </header>
        <div class="categories-container" id="categories-container">
            <h1>Categories
                <?php if(isset($_SESSION['firstName'])){ ?>
                    <style>
                        #LogOut, #showRegister{
                            display:block!important;
                        }
                        #showLogIn{
                            display:none;
                        }
                    </style>
                    <div class="modifyButtons" style="display:inline;" >
                        <button id="modifyCategory">Edit Category</button>
                        <div class="modify modify-category">
                            <button id="insertCategory">Insert category</button>
                            <button id="updateCategory">Update category</button>
                            <button id="deleteCategory">Delete category</button>
                        </div>
                    </div>
                <?php } ?> 
            </h1>
            <div class='categories'>
                <?php 
                    if(isset($_GET['getCategory'])){
                        $get_cat_id = $_GET['getCategory'];
                        $cat_sql = "SELECT * FROM categories WHERE cat_id = '$get_cat_id'";
                        $cat_query = $conn->query($cat_sql) or die ($conn->error);
                    }else{
                        $cat_sql = "SELECT * FROM categories";
                        $cat_query = $conn->query($cat_sql) or die ($conn->error);
                    }
                    while($categories = $cat_query->fetch_assoc()){
                        if(isset($_GET['getCategory'])){
                            echo '
                                <div class="product-list-container" style="width:100%;margin:0 -20px;">
                                    <div class="product-list">
                                        <table>
                                            <tr>
                                                <th>Image</th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                            </tr>
                                            <tr>
                                                <td><img src="images/'.$categories['cat_image'].'"></td>
                                                <td>'.$categories['cat_id'].'</td>
                                                <td>'.$categories['cat_name'].'</td>
                                                <td>'.$categories['cat_description'].'</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            ';
                        }else{
                            echo "
                                <div class='category'>
                                    <label for='getCategory".$categories['cat_id']."'>
                                        <img src='images/".$categories['cat_image']."'>
                                    <label>
                                    <form>
                                        <input type='submit' id='getCategory".$categories['cat_id']."' name='getCategory' value='".$categories['cat_id']."' style='display:none;'>
                                    </form>
                                </div>
                            ";
                        }
                    }     
                ?>
            </div>
        </div>
        <div class="product-list-container">
            <h1 style="display:inline;">Products
                <?php if(isset($_SESSION['firstName'])){ ?>
                    <div class="modifyButtons" style="display:inline;">
                        <button id="modifyProduct">Edit Product</button>
                        <div class="modify modify-product">
                            <button id="insertProduct">insert product</button>
                            <button id="updateProduct">update product</button>
                            <button id="deleteProduct">delete product</button>
                        </div>
                    </div>  
                <?php }?>
            </h1>
            <div class="product-list">
                <table>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Category</th>
                    </tr>
                    <?php 
                        if(isset($_GET['search'])){
                            $search = $_GET['search'];
                            $sql = "SELECT products.*, categories.* FROM products INNER JOIN categories ON products.cat_id = categories.cat_id
                            WHERE products.prod_id LIKE '%$search%' 
                            OR products.prod_name LIKE '%$search%' 
                            OR products.prod_brand LIKE '%$search%'
                            OR products.prod_description LIKE '%$search%' 
                            OR products.prod_price LIKE '%$search%' 
                            OR categories.cat_name LIKE '%$search%'
                            OR categories.cat_description LIKE '%$search%'";
                            $query = $conn->query($sql) or die ($conn->error);
                            $result = $query->num_rows;
                            echo "<style>.cat_list{display:none;}</style>";
                            if($result > 0){
                                echo "You searched for ".$search."<br>".
                                $result . " result/s";
                            }else echo "NO RESULT";
                        }
                        elseif(isset($_GET['getCategory'])){
                            $get_cat_id = $_GET['getCategory'];
                            $sql = "SELECT products.*, categories.cat_name FROM products LEFT JOIN categories ON products.cat_id = categories.cat_id
                            WHERE products.cat_id = '$get_cat_id'";
                            $query = $conn->query($sql) or die ($conn->error);
                        }else{
                            $sql = "SELECT products.*, categories.cat_name FROM products LEFT JOIN categories ON products.cat_id = categories.cat_id";
                            $query = $conn->query($sql) or die ($conn->error);
                        }
                        while($products = $query->fetch_assoc()){
                            echo "
                                <tr>
                                    <td><img src='images/".$products['prod_image']."'></td>
                                    <td>".$products['prod_id']."</td>
                                    <td>".$products['prod_name']."</td>
                                    <td>".$products['prod_brand']."</td>
                                    <td>".$products['prod_description']."</td>
                                    <td>".$products['prod_quantity']."</td>
                                    <td>PHP: ".$products['prod_price']."</td>
                                    <td>".$products['cat_name']."</td>
                                </tr>
                            ";
                        }     
                ?>
                </table>
            </div>
        </div>
    <!-- MODAL START -->
        <div class="modal-container" id="modal-login">
            <div class="modal">
                <form action="php/log.php" method="post">
                    <h2>LOG IN </h2>
                    <h4 id="demo" style="color:white"></h4>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                    <input type="submit" name="login" value="Log In">
                    <input type="button" class="closeModal" value="Cancel">
                </form>
            </div>
        </div>
        <?php if(isset($_SESSION['firstName'])){ ?>
            <div class="modal-container" id="modal-register">
                <div class="modal">
                    <form action="php/log.php" method="post">
                        <h2>REGISTER</h2>
                        <h4 id="demo" style="color:white"></h4>
                        <label for="firstname">First Name:</label>
                        <input type="text" name="firstname" id="firstname" required pattern="[a-zA-Z -]{1,50}">
                        <label for="lastname">Last Name:</label>
                        <input type="text" name="lastname" id="lastname" required pattern="[a-zA-Z -]{1,50}">
                        <label for="username1">Username:</label>
                        <input type="text" name="username" id="username1" required pattern="[a-zA-Z -]{1,50}">
                        <label for="password1">Password:</label>
                        <input type="password" name="password" id="password1" minlength="8" maxlength="50" required>
                        <input type="submit" name="register" value="Register">
                        <input type="button" class="closeModal" value="Cancel">
                    </form>
                </div>
            </div>
            <div class="modal-container" id="modal-insertProduct">
                <div class="modal">
                    <form action="php/product.php" method="post">
                        <h2>INSERT PRODUCT</h2>
                        <label for="add_prod_img">Product Image:</label>
                        <input type="file" name="prod_image" id="add_prod_img" required>
                        <label for="add_prod_name">Product Name:</label>
                        <input type="text" name="prod_name" id="add_prod_name" required>
                        <label for="add_prod_brand">Product Brand:</label>
                        <input type="text" name="prod_brand" id="add_prod_brand" required>
                        <label for="add_prod_desc">Product Description:</label>
                        <input type="text" name="prod_description" id="add_prod_desc" required>
                        <label for="add_prod_quant">Product Quantity:</label>
                        <input type="number" name="prod_quantity" id="add_prod_quant" required>
                        <label for="add_prod_price">Product Price:</label>
                        <input type="number" name="prod_price" id="add_prod_price" step=".01" required>
                        <label for="add_prod_cat">Category</label>
                        <select name="category" id="add_prod_cat" required>
                            <option value="">Select Category</option>
                            <?php
                                $cat_sql = "SELECT cat_id, cat_name FROM categories";
                                $cat_query = $conn->query($cat_sql) or die ($conn->error);
                                while($categories = $cat_query->fetch_assoc()){
                                    echo "<option value='".$categories['cat_id']."'>".$categories['cat_name']."</option>";
                                }
                            ?>
                        </select>
                        <input type="submit" value="INSERT" name="prod_insert">
                        <input type="button" class="closeModal" value="Cancel">
                    </form>
                </div>  
            </div>  
            <div class="modal-container" id="modal-deleteProduct">
                <div class="modal">
                    <form action="php/product.php" method="post">
                        <h2>DELETE PRODUCT</h2>
                        <label for="del_prod">Enter Product ID:</label>
                        <input type="number" name="prod_id" id="del_prod" required>
                        <input type="submit" value="DELETE" name="prod_delete">
                        <input type="button" class="closeModal" value="Cancel">
                    </form>
                </div>  
            </div>  
            <div class="modal-container" id="modal-updateProduct">
                <div class="modal">
                    <form action="php/product.php" method="post">
                        <h2>UPDATE PRODUCT</h2>
                        <label for="update_prod_id">Enter Product ID:</label>
                        <input type="number" name="prod_id" id="update_prod_id" required>
                        <label for="update_prod_img">New Product Image:</label>
                        <input type="file" name="prod_image" id="update_prod_img" required>
                        <div id="updateProdDiv">
                            <label for="update_prod_name">New Product Name:</label>
                            <input type="text" name="prod_name" id="update_prod_name" required>
                            <label for="update_prod_brand">New Product Brand:</label>
                            <input type="text" name="prod_brand" id="update_prod_brand" required>
                            <label for="update_prod_desc">New Product Description:</label>
                            <input type="text" name="prod_description" id="update_prod_desc" required>
                            <label for="update_prod_quant">New Product Quantity:</label>
                            <input type="number" name="prod_quantity" id="update_prod_quant" required>
                            <label for="update_prod_price">New Product Price:</label>
                            <input type="number" name="prod_price" id="update_prod_price" step=".01" required>
                        </div>
                        <label for="update_prod_cat">New Category</label>
                        <select name="category" id="update_prod_cat" required>
                            <option value="">Select Category</option>
                            <?php
                                $cat_sql = "SELECT cat_id, cat_name FROM categories";
                                $cat_query = $conn->query($cat_sql) or die ($conn->error);
                                while($categories = $cat_query->fetch_assoc()){
                                    echo "<option value='".$categories['cat_id']."'>".$categories['cat_name']."</option>";
                                }
                            ?>
                        </select>
                        <input type="submit" value="UPDATE" name="prod_update">
                        <input type="button" class="closeModal" value="Cancel">
                    </form>
                </div>  
            </div>
            <div class="modal-container" id="modal-insertCategory">
                <div class="modal">
                    <form action="php/category.php" method="post">
                        <h2>INSERT CATEGORY</h2>
                        <label for="add_cat_img">Category Image:</label>
                        <input type="file" name="cat_image" id="add_cat_img" required>
                        <label for="add_cat_name">Category Name:</label>
                        <input type="text" name="cat_name" id="add_cat_name" required>
                        <label for="add_cat_desc">Category Description:</label>
                        <input type="text" name="cat_description" id="add_cat_desc" required>
                        <input type="submit" value="INSERT" name="cat_insert">
                        <input type="button" class="closeModal" value="Cancel">
                    </form>
                </div>  
            </div>
            <div class="modal-container" id="modal-deleteCategory">
                <div class="modal">
                    <form action="php/category.php" method="post">
                        <h2>DELETE CATEGORY</h2>
                        <label for="del_cat">Enter Category ID:</label>
                        <input type="number" name="cat_id" id="del_cat" required>
                        <input type="submit" value="DELETE" name="cat_delete">
                        <input type="button" class="closeModal" value="Cancel">
                    </form>
                </div>  
            </div>
            <div class="modal-container" id="modal-updateCategory">
                <div class="modal">
                    <form action="php/category.php" method="post">
                        <h2>UPDATE CATEGORY</h2>
                        <label for="update_cat_id">Enter Category ID:</label>
                        <input type="number" name="cat_id" id="update_cat_id" required>
                        <div id="updateCatDiv">
                            <label for="update_cat_img">New Category Image:</label>
                            <input type="file" name="cat_image" id="update_cat_img" required>
                            <label for="update_cat_name">New Category Name:</label>
                            <input type="text" name="cat_name" id="update_cat_name" required>
                            <label for="update_cat_desc">New Category Description:</label>
                            <input type="text" name="cat_description" id="update_cat_desc" required>
                        </div>
                        <input type="submit" value="UPDATE" name="cat_update">
                        <input type="button" class="closeModal" value="Cancel">
                    </form>
                </div>  
            </div>
        <?php } ?> 
    <!-- MODAL END -->
        <script>
            // Set the date we're counting down to
            var database_lock_date = "<?php 
                    include "php/connect.php"; 
                    $get_lock_date = mysqli_query($conn, "SELECT * FROM sellers WHERE seller_userName = '$_SESSION[userName]'");
                    $row = mysqli_fetch_assoc($get_lock_date);
                    echo $row['lock_date'];
                ?>";
            var countDownDate = new Date(database_lock_date).getTime();
            // Update the count down every 1 second
            var x = setInterval(function() {
        
                // Get today's date and time
                var now = new Date().getTime();
        
                // Find the distance between now and the count down date
                var distance = countDownDate - now;
        
                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
                // Display the result in the element with id="demo"
                if(database_lock_date != "")
                    document.getElementById("demo").innerHTML = "Account '<?php echo $_SESSION['userName'];?>' will be unlocked in:<br>" + 
                    minutes + "m " + seconds + "s";
        
                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "";
                    $.ajax({
                        url: "php/reset.php",
                    });
                }
            }, 1000);
       </script>
    </body>
</html>