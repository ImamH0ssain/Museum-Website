<?php

@include 'config.php';

//session connection of admin
session_start();
$admin_id = $_SESSION['admin_id'];

if(!isset($_SESSION['admin_id'])){  //prevents illegal entry
   header('location:login_form.php');
}

if(isset($_GET['logout'])){     //logout
   unset($admin_id);
   session_destroy();
   header('location:login.php');
}

if(isset($_POST['add_product'])){  //adds product to database
   $p_cat = $_POST['p_cat'];
   $p_desc = $_POST['p_desc'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `products`(category,name, description, price, image) VALUES('$p_cat','$p_name','$p_desc', '$p_price', '$p_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product add succesfully';
   }else{
      $message[] = 'could not add the product';
   }
};

if(isset($_GET['delete'])){   //deletes a given product
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:admin_page.php');
      $message[] = 'product has been deleted';
   }else{
      header('location:admin_page.php');
      $message[] = 'product could not be deleted';
   };
};

if(isset($_POST['update_product'])){      //updates product
   $update_p_id = $_POST['update_p_id'];
   $update_p_cat = $_POST['update_p_cat'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_desc = $_POST['update_p_desc'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `products` SET category='$update_p_cat', name = '$update_p_name',description='$update_p_desc', price = '$update_p_price', image = '$update_p_image' WHERE id = '$update_p_id'");

   if($update_query){
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'product updated succesfully';
      header('location:admin_page.php');
   }else{
      $message[] = 'product could not be updated';
      header('location:admin_page.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  11 -->
   <link rel="stylesheet" href="css/style.css"> 
   
 <!--  <link rel="stylesheet" href="css/style2.css">  -->
   
   
   

</head>
<body class="body">
   <?php @include 'header.php'; ?>

   
<div class="container">
   <section>
      <div class="profile">
         <?php
            $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$admin_id'") or die('query failed');
            if(mysqli_num_rows($select) > 0){
               $fetch = mysqli_fetch_assoc($select);
            }
            if($fetch['image'] == ''){
               echo '<img src="images/default-avatar.png">';
            }else{
               echo '<img src="uploaded_img/'.$fetch['image'].'">';
            }
         ?>
         <h3><?php echo $fetch['name']; ?></h3>
         <!--<a href="logout.php" class="delete-btn">logout</a> -->
         <a href="admin_page.php?logout=<?php echo $admin_id; ?>" class="delete-btn">logout</a>
         <p>new <a href="login.php">login</a> or <a href="register.php">register</a></p>
      </div>
   </section>

   <section>
<!-- frontend -->
<form action="" method="post" class="add-product-form" enctype="multipart/form-data">
   <h3>add a new product</h3>
   <input type="text" name="p_cat" placeholder="enter the product category" class="box" required>
   <input type="text" name="p_name" placeholder="enter the product name" class="box" required>
   <input type="text" name="p_desc" placeholder="enter the product description" class="box" required>
   <input type="number" name="p_price" min="0" placeholder="enter the product price" class="box" required>
   <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="submit" value="add the product" name="add_product" class="btn">
</form>

</section>
<!--product display-->
<section class="display-product-table">

   <table>

      <thead>
         <th>product image</th>
         <th>product category</th>
         <th>product name</th>
         <th>product description</th>
         <th>product price</th>
         <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td>
               <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
               <a href="admin_page.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no product added</div>";
            };
         ?>
      </tbody>
   </table>

</section><!-- product display-->

<section class="edit-form-container">  <!-- the separate edit form window-->

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_p_cat" value="<?php echo $fetch_edit['category']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
      <input type="text" class="box" required name="update_p_desc" value="<?php echo $fetch_edit['description']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
      <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the prodcut" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-edit" class="option-btn">
   </form>

   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>



   

</div>
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>