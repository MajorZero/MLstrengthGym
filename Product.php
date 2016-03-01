<?php

session_start();

require_once '../Php/membership.php';
$membership = new membership();

$membership->confirm_member();

if($_POST && !empty($_POST['productName']) && !empty($_POST['price']) && !empty($_POST['stock']))
{
    $productName=mysql_real_escape_string($_POST['productName']);
    $price=mysql_real_escape_string($_POST['price']);
    $stock=mysql_real_escape_string($_POST['stock']);
    $response = $membership->create_product($productName, intval($price), intval($stock));
}

if(isset($_GET['status']) && $_GET['status'] == 'delete')
{
    $id=mysql_real_escape_string($_GET['id']);
    $response=$membership->delete_product(intval($id));
}

if(isset($_GET['status']) && $_GET['status'] == 'add')
{
    $id=mysql_real_escape_string($_GET['id']);
    $response=$membership->add_product(intval($id));
}

if(isset($_GET['status']) && $_GET['status'] == 'takeaway')
{
    $id=mysql_real_escape_string($_GET['id']);
    $response=$membership->takeaway_product(intval($id));
}

?>


<!DOCTYPE html>



<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Manage Products</title>
	<link rel="stylesheet" href="../CSS/Style1.css" />
    <link rel="icon" href="../Images/ML_favicon.png" type="image/x-icon">
</head>

<body>
	<div class="frame">
    	
        
        
        <nav>
        	
            <div class="logo">
            	<a href="Index.html"><img src="../Images/ML_logo.png" id="logo" alt="business logo"></a>
            </div>
            
            <div class="buttons">
            
            	<table class="menu">
                	<tr> <td class="unmarked"> <a href="Index.html"> HOME </a> </td> </tr>
                    <tr> <td class="unmarked"> <a href="AboutUs.html"> ABOUT </a> </td> </tr>
                    <tr> <td class="unmarked"> <a href="Timetable.html"> TIMETABLE </a> </td> </tr>
                    <tr> <td class="unmarked"> <a href="Contact.html"> CONTACT </a> </td> </tr>
                    <tr> <td class="unmarked"> <a href="Login.php"> LOG IN </a> </td> </tr>
                    
                        <!-- copy this submenu in all the secured pages -->
                    <tr> <td class="unmarked submenu"> <a href="Admin.php"> ADMIN </a> </td> </tr>
                    <tr> <td class="unmarked submenu"> <a href="Staff.php"> STAFF </a> </td> </tr>
                    <tr> <td class="unmarked submenu"> <a href="Customer.php"> CUSTOMERS </a> </td> </tr>
                    <tr> <td class="marked submenu"> <a href="Product.php"> PRODUCTS </a> </td> </tr>
                    <tr> <td class="unmarked submenu"> <a href="Booking.php"> BOOKINGS </a> </td> </tr>
                    
                    <tr> <td class="phone"> <img src="../Images/orangePhone.png" id="phoneImg" alt="small phone"> 1800 234 567 </td> </tr>
                </table>
            
            </div>
            
        </nav>
        
        
        
        <section>
        
        	<h1>PRODUCTS PANEL</h1>
            
            <p>From this page you can handle your product's warehouse.</p>
            
            
            <h2>Products list</h2>
        
            <?php
            

            $membership->print_products();

            //This line display an error messager if there are any:
            if(isset($response)){echo '<hr><p>'.$response.'</p><hr>';}

            ?>
            
            <br><button onclick="hideForm()">Insert New Product</button>
            
            
            <form class="form-style-7" id="hiddenForm" method="post" action="Product.php" style="display:none;">
            <ul>
            <li>
                <label>Product Name</label>
                <input type="text" name="productName" maxlength="100">
                <span>Enter the product name here</span>
            </li>
            <li>
                <label>Price</label>
                <input type="text" name="price" maxlength="100">
                <span>Enter the price here (in AUD)</span>
            </li>
            <li>
                <label>Stock</label>
                <input type="text" name="stock" maxlength="100">
                <span>Enter the current stock here</span>
            </li>

            <li>
                <input type="submit" value="Insert" name="addProduct">
            </li>
            </ul>
            </form>
            
            <br><button onclick="location.href='Login.php?status=loggedout'">LOG OUT</button>
        
        </section>


	</div>	
    
    <!-- The footer will be set on the bottom-right side of the page -->
        <footer>
        
        <p>
    	&copy; ML Strength 2015 | Website by Dorian Trevisan | 
            
            <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!" />
        </a>
            </p>
    </footer>
    
    <!-- Include script file -->
    <script src="../Script/script.js"></script>  

</body>
</html>
