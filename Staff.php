<?php

session_start();

require_once '../Php/membership.php';
$membership = new membership();

$membership->confirm_member();

if($_POST && !empty($_POST['userId']) && !empty($_POST['newPwd']))
{
    $userId=mysql_real_escape_string($_POST['userId']);
    $userPwd=mysql_real_escape_string($_POST['newPwd']);
    
        //When the system creates a new access sends an email to the admin to keep track of all the accesses before the pasword are hashed.
    //mail('admin@mlstrength.com.au', 'New user activation', 'The new password: '.$userPwd.' has been assigned to the user: '.$userId.'.');
    
    $hashPwd=hash('sha256', $userPwd);
    $response = $membership->create_user(intval($userId), $hashPwd);
}

?>


<!DOCTYPE html>



<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Manage Staff</title>
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
                    <tr> <td class="marked submenu"> <a href="Staff.php"> STAFF </a> </td> </tr>
                    <tr> <td class="unmarked submenu"> <a href="Customer.php"> CUSTOMERS </a> </td> </tr>
                    <tr> <td class="unmarked submenu"> <a href="Product.php"> PRODUCTS </a> </td> </tr>
                    <tr> <td class="unmarked submenu"> <a href="Booking.php"> BOOKINGS </a> </td> </tr>
                    
                    <tr> <td class="phone"> <img src="../Images/orangePhone.png" id="phoneImg" alt="small phone"> 1800 234 567 </td> </tr>
                </table>
            
            </div>
            
        </nav>
        
        
        
        <section>
        
        	<h1>STAFF PANEL</h1>
            
            <p>From this page you can assign password for your staff members in order to access the admin system.</p>
            
            
            
            <h2>Staff list</h2>
        
            <?php
            
            $membership->print_users();

            if(isset($response)) {echo '<hr><p>'.$response.'</p><hr>';}

            ?>
            
            <br><button onclick="hideForm()">Assign Password</button>

            
            <form class="form-style-7" id="hiddenForm" method="post" action="Staff.php" style="display:none;">
            <ul>
            <li>
                <label>User ID</label>
                <input type="text" name="userId" maxlength="100">
                <span>Enter the user ID here</span>
            </li>
            <li>
                <label>New Password</label>
                <input type="text" name="newPwd" maxlength="100">
                <span>Enter the new password here</span>
            </li>

            <li>
                <input type="submit" value="Edit" name="submit">
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
