<?php

session_start();

require_once '../Php/membership.php';
$membership = new membership();

$membership->confirm_member();


?>


<!DOCTYPE html>



<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Manage Bookings</title>
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
                    <tr> <td class="unmarked submenu"> <a href="Product.php"> PRODUCTS </a> </td> </tr>
                    <tr> <td class="marked submenu"> <a href="Booking.php"> BOOKINGS </a> </td> </tr>
                    
                    <tr> <td class="phone"> <img src="../Images/orangePhone.png" id="phoneImg" alt="small phone"> 1800 234 567 </td> </tr>
                </table>
            
            </div>
            
        </nav>
        
        
        
        <section>
        
        	<h1>BOOKINGS PANEL</h1>
            
            <p>You can manage the gym bookings from this page.</p>
            <button onclick="location.href='Login.php?status=loggedout'">LOG OUT</button>
            
            	<!-- Administration panel goes here after user has been confirmed. -->
        
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

</body>
</html>
