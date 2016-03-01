<?php

session_start();
require_once '../Php/membership.php';
$membership = new membership();




    // This part activates only when the user log out and comes back to this page. Kills the session.
if(isset($_GET['status']) && $_GET['status'] == 'loggedout')
{
    $response=$membership->log_User_Out();
}

if(isset($_SESSION['status']) && $_SESSION['status'] == 'authorized')
{
    $response=$membership->log_User_Out();
}



    // Here checks if the user click login and if user and pwd are correct.
if($_POST && !empty($_POST['username']) && !empty($_POST['pwd']))
{
    $userName=mysql_real_escape_string($_POST['username']);
    $userPwd=mysql_real_escape_string($_POST['pwd']);
    $hashPwd=hash('sha256', $userPwd);
    $response = $membership->validate_user(intval($userName), $hashPwd);
}

?>


<!DOCTYPE html>


<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Log In</title>
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
                    <tr> <td class="marked"> <a href="Login.php"> LOG IN </a> </td> </tr>
                    <tr> <td class="phone"> <img src="../Images/orangePhone.png" id="phoneImg" alt="small phone"> 1800 234 567 </td> </tr>
                </table>
            
            </div>
            
        </nav>
        
        
        
        <aside>
        
        	<div class="find">
            	<a href="Timetable.html">Find a Class <img src="../Images/orangeArrow.png" alt="little orange arrow"></a>
            </div>
            
            <div class="contact">
            	<a href="Contact.html">Contact Us <img src="../Images/orangeArrow.png" alt="little orange arrow"></a>
            </div>
            
            
            
            <div class="imageRoll">
            	<img src="../Images/ImgRoll5.jpg" class="imgRoll" alt="Image of the gym">
            </div>
            
            
            
            <div class="imageRoll">
            	<img src="../Images/ImgRoll4.jpg" class="imgRoll" alt="Image of a call center girl">
            </div>
            
        </aside>
        
        
        
        
        <section>
        
            
            <h1>LOG IN <br><small>TO ACCESS THE ADMIN SECTION</small></h1>
            
            
            
            <form class="form-style-7" method="post" action="Login.php">
            <ul>
            <li>
                <label>User ID</label>
                <input type="text" name="username" maxlength="100">
                <span>Enter the user ID here</span>
            </li>
            <li>
                <label>Password</label>
                <input type="password" name="pwd" maxlength="100">
                <span>Enter the password here</span>
            </li>

            <li>
                <input type="submit" value="Submit" name="submit">
            </li>
            </ul>
            </form>
            
<?php

if(isset($response)) {echo "<h4>$response</h4>";}

?>
        
        </section>

	</div> <!-- Close the frame -->
    
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
