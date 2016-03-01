<?php

require_once 'mysql.php';

class membership
{
    function validate_user($un, $pwd)
    {
        $mysql = new mysql();
        
        $ensure_credentials = $mysql->verify_username_and_pass ($un, $pwd);
        
        if($ensure_credentials)
        {
            $_SESSION['status'] = "authorized";
            header("location:Admin.php?status=authorized");
        }
        else {return "Please enter correct username and password.";}
    }
    
    function log_User_Out()
    {
        
        if(isset($_SESSION['status']))
        {
            unset($_SESSION['status']);
            
            if(isset($_COOKIE[session_name()]))
            {
                setcookie(session_name(), '', time(), -1000);
                
            }
        }
        session_destroy();
        return "You have been Logged Out.";
    }
    
    function confirm_member()
    {
        if($_SESSION['status'] != "authorized")
        {
            header("location:Login.php?status=loggedout");
        }
    }
    
    function create_user($anId, $pwd)
    {
        $mysql = new mysql();
        
        $userLog = $mysql->edit_user_password($anId, $pwd);
        
        return $userLog;
    }
    
    function print_users()
    {
        $mysql=new mysql();
        $users = $mysql->display_all_users();
        
        echo '<table class="usersTable">';
        echo '<tr><th>ID</th> <th>First Name</th> <th>Last Name</th> <th>Employment Date</th> <th>Position</th> <th>Phone N.</th></tr>';
        foreach($users as $person)
        {
            echo '<tr>';
            foreach($person as $value)
            {
                echo '<td>'.$value.'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }
    
    function create_customer($firstName, $lastName, $email, $streetName, $city, $state, $postcode, $primPhone, $secPhone)
    {
        $mysql = new mysql();
        $userLog = $mysql->create_new_customer($firstName, $lastName, $email, $streetName, $city, $state, $postcode, $primPhone, $secPhone);
        
        return $userLog;
    }
    
    function edit_customer($id, $firstName, $lastName, $email, $streetName, $city, $state, $postcode, $primPhone, $secPhone)
    {
        $mysql = new mysql();
        $userLog = $mysql->edit_customer_by_id($id, $firstName, $lastName, $email, $streetName, $city, $state, $postcode, $primPhone, $secPhone);
        
        return $userLog;
    }
    
    function print_customers()
    {
        $mysql=new mysql();
        $users = $mysql->display_all_customers();
        
        echo '<table class="usersTable">';
        echo '<tr><th>Last Name</th> <th>Name</th> <th>E-mail</th> <th>Street</th> <th>City</th> <th>N. Invoices</th> <th> Edit </th></tr>';
        foreach($users as $person)
        {
            $i=0;
            echo '<tr>';
            foreach($person as $value)
            {
                if($i<=5)
                {
                    echo '<td>'.$value.'</td>';
                }
                else
                {
                    $id=$value;
                }
                $i++;
            }
            $deleteString="Customer.php?status=delete&amp;id=".$id;
            $editString="Customer.php?status=edit&amp;id=".$id;
            echo '<td> <a href="'.$deleteString.'"> <img src="../Images/trash.png" alt="delete element" height="16" width="16"> </a>
                        <a href="'.$editString.'"> <img src="../Images/edit_small.png" alt="edit element" height="16" width="16"> </a></td>  </tr>';
        }
        echo '</table>';
    }
    
    function customer_by_id($anId)
    {
        $mysql=new mysql();
        $row = $mysql->get_customer_by_id($anId);
        $user=array();
        
        
        foreach($row as $customer)
        {
            $i=0;
            foreach($customer as $value)
            {
                $user[$i]=$value;
                $i++;
            }
        }
        
        $userByUrl='location:Customer.php?customer=true&id='.$user[0].'&fN='.$user[1].'&lN='
                    .$user[2].'&em='.$user[3].'&sN='.$user[4].'&c='.$user[5].'&s='.$user[6].'&p='
                    .$user[7].'&pP='.$user[8].'&sP='.$user[9];
        
        header($userByUrl);
        
    }
    
    function delete_customer($anId)
    {
        $mysql = new mysql();
        $productLog = $mysql->delete_customer_by_id($anId);
        
        return $productLog;
    }
    
    function print_products()
    {
        $mysql=new mysql();
        $products = $mysql->display_all_products();
        
        echo '<table class="usersTable">';
        echo '<tr><th>Product Name</th> <th>Price</th> <th>In Stock</th> 
                <th style="border-left:solid 1px grey;"> </th> <th> Edit </th> <th style="border-right:solid 1px grey;"> </th></tr>';
        
        foreach($products as $item)
        {
            $i=0;
            echo '<tr>';
            foreach($item as $value)
            {
                if($i<=2)
                {
                    echo '<td>'.$value.'</td>';
                }
                else
                {
                    $id=$value;
                }
                $i++;
            }
            $deleteString="Product.php?status=delete&amp;id=".$id;
            $addString="Product.php?status=add&amp;id=".$id;
            $takeawayString="Product.php?status=takeaway&amp;id=".$id;
            echo '<td class="editButton"> <a href="'.$deleteString.'"> <img src="../Images/trash.png" alt="delete element" height="16" width="16"> </a> </td>
                    <td class="editButton"> <a href="'.$addString.'"> <img src="../Images/plus_small.png" alt="add element" height="16" width="16"> </a> </td>
                    <td class="editButton"> <a href="'.$takeawayString.'"> <img src="../Images/minus_small.png" alt="subtract element" height="16" width="16"> </a> </td>  </tr>';
        }
        echo '</table>';
    }
    
    function delete_product($anId)
    {
        $mysql = new mysql();
        $productLog = $mysql->delete_product_by_id($anId);
        
        return $productLog;
    }
    
    function create_product($aName, $aPrice, $aStock)
    {
        $mysql = new mysql();
        $productLog = $mysql->create_new_product($aName, $aPrice, $aStock);
        
        return $productLog;
    }
    
    function add_product($anId)
    {
        $mysql = new mysql();
        $productLog = $mysql->add_product_by_id($anId);
        
        return $productLog;
    }
    
    function takeaway_product($anId)
    {
        $mysql = new mysql();
        $productLog = $mysql->takeaway_product_by_id($anId);
        
        return $productLog;
    }
}