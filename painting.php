<?php @include 'header.php'?>
<?php @include 'category.php'?>
<?php

@include 'config.php';
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
<header class="header">

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
            
         </tr>

         <?php
            };    
            };
         ?>
      </tbody>
   </table>

</section><!-- product display-->

</header>
</html>