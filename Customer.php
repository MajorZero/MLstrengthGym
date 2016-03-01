<?php

session_start();

require_once '../Php/membership.php';
$membership = new membership();

$membership->confirm_member();

    $customerID='';
    $customerFirstName='';
    $customerLastName='';
    $customerEmail='';
    $customerStreetName='';
    $customerCity='';
    $customerState='';
    $customerPostcode='';
    $customerPrimPhone='';
    $customerSecPhone='';


if(isset($_POST['addCustomer'])  && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['postcode']) && !empty($_POST['primPhone']))
{
    $firstName=mysql_real_escape_string($_POST['firstName']);
    $lastName=mysql_real_escape_string($_POST['lastName']);
    $email=mysql_real_escape_string($_POST['email']);
    $streetName=mysql_real_escape_string($_POST['streetName']);
    $city=mysql_real_escape_string($_POST['city']);
    $state=mysql_real_escape_string($_POST['state']);
    $postcode=mysql_real_escape_string($_POST['postcode']);
    $primPhone=mysql_real_escape_string($_POST['primPhone']);
    $secPhone=mysql_real_escape_string($_POST['secPhone']);
    
    
    $response = $membership->create_customer($firstName, $lastName, $email, $streetName, $city, $state, intval($postcode), $primPhone, $secPhone);
}

if(isset($_POST['editCustomer'])  && !empty($_POST['id']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['postcode']) && !empty($_POST['primPhone']))
{
    $id=mysql_real_escape_string($_POST['id']);
    $firstName=mysql_real_escape_string($_POST['firstName']);
    $lastName=mysql_real_escape_string($_POST['lastName']);
    $email=mysql_real_escape_string($_POST['email']);
    $streetName=mysql_real_escape_string($_POST['streetName']);
    $city=mysql_real_escape_string($_POST['city']);
    $state=mysql_real_escape_string($_POST['state']);
    $postcode=mysql_real_escape_string($_POST['postcode']);
    $primPhone=mysql_real_escape_string($_POST['primPhone']);
    $secPhone=mysql_real_escape_string($_POST['secPhone']);
    
    $response = $membership->edit_customer($id, $firstName, $lastName, $email, $streetName, $city, $state, intval($postcode), $primPhone, $secPhone);
}

if(isset($_GET['status']) && $_GET['status'] == 'delete')
{
    $id=mysql_real_escape_string($_GET['id']);
    $response=$membership->delete_customer(intval($id));
}

if(isset($_GET['status']) && $_GET['status'] == 'edit')
{
    $id=mysql_real_escape_string($_GET['id']);
    $membership->customer_by_id(intval($id));
}

if(isset($_GET['customer']) && $_GET['customer'] == 'true')
{
    $customerID=$_GET['id'];
    $customerFirstName=$_GET['fN'];
    $customerLastName=$_GET['lN'];
    $customerEmail=$_GET['em'];
    $customerStreetName=$_GET['sN'];
    $customerCity=$_GET['c'];
    $customerState=$_GET['s'];
    $customerPostcode=$_GET['p'];
    $customerPrimPhone=$_GET['pP'];
    $customerSecPhone=$_GET['sP'];


    echo '<script> window.onload = function(){hideForm();}</script>';
    
}
    

?>


<!DOCTYPE html>



<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Manage Customers</title>
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
                    <tr> <td class="marked submenu"> <a href="Customer.php"> CUSTOMERS </a> </td> </tr>
                    <tr> <td class="unmarked submenu"> <a href="Product.php"> PRODUCTS </a> </td> </tr>
                    <tr> <td class="unmarked submenu"> <a href="Booking.php"> BOOKINGS </a> </td> </tr>
                    
                    <tr> <td class="phone"> <img src="../Images/orangePhone.png" id="phoneImg" alt="small phone"> 1800 234 567 </td> </tr>
                </table>
            
            </div>
            
        </nav>
        
        
        
        <section>
            
            <h1>CUSTOMER PANEL</h1>
        
        	<p>From this page you can manage your customer's details database.</p>
            <p>If you change the user details remember to <strong>delete the old customer record</strong> to avoid duplication.</p>
            
            
            <h2>Customer list</h2>
        
            <?php
            
            $membership->print_customers();

            if(isset($response)){echo '<hr><p>'.$response.'</p><hr>';}

            ?>
            
            <br><button onclick="hideForm()">Insert New Customer</button>
            
            
            <form class="form-style-7" id="hiddenForm" method="post" action="Customer.php" style="display:none;">
            <ul>
            <li style="display:none;">
                <input type="text" name="id" value="<?php echo $customerID; ?>" maxlength="100">
                
            </li>
            <li>
                <label>First Name</label>
                <input type="text" name="firstName" value="<?php echo $customerFirstName; ?>" maxlength="100">
                <span>Enter the first name here</span>
            </li>
            <li>
                <label>Last Name</label>
                <input type="text" name="lastName" value="<?php echo $customerLastName; ?>" maxlength="100">
                <span>Enter the last name here</span>
            </li>
            <li>
                <label>E-Mail</label>
                <input type="text" name="email" value="<?php echo $customerEmail; ?>" maxlength="100">
                <span>Enter the e-mail here</span>
            </li>
            <li>
                <label>Address - Street Name</label>
                <input type="text" name="streetName" value="<?php echo $customerStreetName; ?>" maxlength="100">
                <span>Enter the street name here (optional)</span>
            </li>
            <li>
                <label>Address - City</label>
                <input type="text" name="city" value="<?php echo $customerCity; ?>" maxlength="100">
                <span>Enter the city name here (optional)</span>
            </li>
            <li>
                <label>Address - State</label>
                <input type="text" name="state" value="<?php echo $customerState; ?>" maxlength="100">
                <span>Enter the state name here (optional)</span>
            </li>
            <li>
                <label>Address - Postcode</label>
                <input type="text" name="postcode" value="<?php echo $customerPostcode; ?>" maxlength="100">
                <span>Enter the postcode here</span>
            </li>
            <li>
                <label>Primary Phone Number</label>
                <input type="text" name="primPhone" value="<?php echo $customerPrimPhone; ?>" maxlength="100">
                <span>Enter the primary phone number here</span>
            </li>
            <li>
                <label>Secondary Phone Number</label>
                <input type="text" name="secPhone" value="<?php echo $customerSecPhone; ?>" maxlength="100">
                <span>Enter the secondary phone number here (optional)</span>
            </li>
                

            <li>
                <input type="submit" value="Insert New" name="addCustomer">
                <input type="submit" value="Edit" name="editCustomer">
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
