<?php

// ***CONNECTION***

    // The file Constants contains the information about the server.
require_once 'constants.php';


    // The class mysql buils the object that holds the connection with the DB.
class mysql
{
    private $conn;
    
        // The construct function activates the DB connection as an mysql object is created.
    function __construct()
    {
            // The constructor is used automatically to create the connection with the DB when a new mysql instance is created
        
        $this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die ("Problem with DB connection");
    }

    
// ***USERS***
    
    
        // Match the username and password from user input with the DB list of users.
    function verify_username_and_pass ($un,$pwd)
    {
            //This function is using prepared statements as the values it needs for the query are coming from the user input.
        
        $query = "SELECT * FROM employee WHERE employeeID=? AND password=? LIMIT 1;";
        
        if($stmt = $this->conn->prepare($query))
        {
            $stmt->bind_param('is', $un, $pwd);
            $stmt->execute();
            
            if($stmt->fetch())
            {
                $stmt->close();
                return true;
            }
            else{return false;}
        }
    }
    
        // Change or set a new password for an existing user.
    function edit_user_password($anId, $pwd)
    {
            //This function is using prepared statements.
        
        $query1 = "SELECT * FROM employee WHERE employeeID=? LIMIT 1";
        
        if($stmt1 = $this->conn->prepare($query1))
        {
            $stmt1->bind_param('i', $anId);
            $stmt1->execute();
            
            if($stmt1->fetch())
            {
                $stmt1->close();
                
                $query2 = "UPDATE employee SET password=? WHERE employeeID=?";
                
                if($stmt2 = $this->conn->prepare($query2))
                {
                    $stmt2->bind_param('si', $pwd, $anId);
                    $stmt2->execute();
                    $stmt2->close();
                    return "User's password has been updated.";
                }
                else
                {
                    $stmt1->close();
                    return "Second query not properly prepared!";
                }
            }
            else
            {
                $stmt1->close();
                return "An user with this User ID doesn't exist!";
            }
        }
        else
        {
            $stmt1->close();
            return "First query not properly prepared!";
        }
    }
    
        // Retrieve all the users from the DB.
    function display_all_users()
    {
            //No prepared statements here, the query is directly executed
        
        $users=array();
        $query1 = "SELECT employeeID, firstName, lastName, dateOfEmployment, positionDesc, phoneNum FROM `employee` INNER JOIN position 
                    WHERE employee.positionID=position.positionID ORDER BY employeeID;";
        
        if($stmt = $this->conn->query($query1))
        {
            $i=0;
            while($row=$stmt->fetch_assoc())
            {
                $users[$i]=$row;
                $i++;
            }
        }
        else
        {
            die('There was a problem with the DB connection.');
        }
        
        return $users;
    }
    
    
// ***CUSTOMERS***
    
    
        // Insert a new customer built from user input.
    function create_new_customer($firstName, $lastName, $email, $streetName, $city, $state, $postcode, $primPhone, $secPhone)
    {
            //This function is using prepared statements.
                    
                $query1 = "INSERT INTO member (firstName, lastName, email, streetName, city, state, postcode, primPhone, secPhone) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
                
                if($stmt1 = $this->conn->prepare($query1))
                {
                    $stmt1->bind_param('ssssssiss', $firstName, $lastName, $email, $streetName, $city, $state, $postcode, $primPhone, $secPhone);
                    $stmt1->execute();
                    $stmt1->close();
                    return "A new customer has been insert.";
                }
                else
                {
                    return "Customer NOT created!";
                }
         
    }
    
        // Chenge the informations about a specific customer from user input.
    function edit_customer_by_id($id, $firstName, $lastName, $email, $streetName, $city, $state, $postcode, $primPhone, $secPhone)
    {
        
            //This function is using prepared statements.
        $query1 = 'UPDATE member SET firstName=?, lastName=?, email=?, streetName=?, city=?, state=?, postcode=?, primPhone=?, secPhone=? WHERE memberID=?';
                
                if($stmt1 = $this->conn->prepare($query1))
                {
                    $stmt1->bind_param('ssssssissi', $firstName, $lastName, $email, $streetName, $city, $state, $postcode, $primPhone, $secPhone, $id);
                    $stmt1->execute();
                    $stmt1->close();
                    return "The customer ".$id." has been updated.";
                }
                else
                {
                    return "Customer NOT created!";
                }
    }
    
        // Retrieve a list of all the customers and the number of invoices for each one.
    function display_all_customers()
    {
            //No prepared statements here, the query is directly executed
        
        $users=array();
        
        $query1 = "SELECT lastName, firstName, email, streetName, city, COUNT(invoiceID) AS nInvoices, member.memberID 
                    FROM member LEFT OUTER JOIN invoice ON member.memberID=invoice.memberID 
                    GROUP BY member.memberID;";
                
        if($stmt = $this->conn->query($query1))
        {
            $i=0;
            while($row=$stmt->fetch_assoc())
            {
                $users[$i]=$row;
                $i++;
            }
        }
        else
        {
            die('There was a problem with the DB connection.');
        }
        
        return $users;
    }
    
        // Retrieve a specific customer by id.
    function get_customer_by_id($anId)
    {
        
            //This function is not using prepared statements.
        $user=array();
        $query1 = 'SELECT * FROM member WHERE memberID='.$anId.' LIMIT 1;';
        
        if($stmt = $this->conn->query($query1))
        {
            $i=0;
            while($row=$stmt->fetch_assoc())
            {
                $user[$i]=$row;
                $i++;
            }
        }
        else
        {
            die('There was a problem with the DB connection.');
        }
        
        
        return $user;
        
    }
    
        // Delete a specific customer from the DB by its ID.
    function delete_customer_by_id($anId)
    {
                
                $query1 = "DELETE FROM member WHERE memberID=?;";
                
                if($stmt1 = $this->conn->prepare($query1))
                {
                    $stmt1->bind_param('i', $anId);
                    $stmt1->execute();
                    $stmt1->close();
                    return 'The customer with ID '.$anId.' has been deleted.';
                }
                else
                {
                    $stmt1->close();
                    return "Query not properly prepared!";
                }
    
    }
    
    
    
// ***PRODUCTS***
    
    
        // Retrieve a list of all the products.
    function display_all_products()
    {
            //No prepared statements here, the query is directly executed
        
        $products=array();
        $query1 = "SELECT productName, price, stock, productID FROM product;";
        
        if($stmt = $this->conn->query($query1))
        {
            $i=0;
            while($row=$stmt->fetch_assoc())
            {
                $products[$i]=$row;
                $i++;
            }
        }
        else
        {
            die('There was a problem with the database connection.');
        }
        
        return $products;
    }
    
        // Create a new product from user input.
    function create_new_product($aName, $aPrice, $aStock)
    {
            //This function is using prepared statements.
        
        $query1 = "SELECT * FROM product WHERE productName=? LIMIT 1";
        
        if($stmt1 = $this->conn->prepare($query1))
        {
            $stmt1->bind_param('s', $aName);
            $stmt1->execute();
            
            if($stmt1->fetch())
            {
                //this product already exists.
                $stmt1->close();
                
                return 'The product '.$aName.' already exist.';
               
            }
            else
            {
                //create new product here
                $stmt1->close();
                
                $query2 = "INSERT INTO product (productName, price, stock) VALUES (?, ?, ?);";
                
                if($stmt2 = $this->conn->prepare($query2))
                {
                    $stmt2->bind_param('sii', $aName, $aPrice, $aStock);
                    $stmt2->execute();
                    $stmt2->close();
                    return "A new product has been insert.";
                }
                else
                {
                    return "Second query not properly prepared!";
                }
            }
        }
        else
        {
            $stmt1->close();
            return "First query not properly prepared!";
        }
    }
    
     //Delete a product by its id.
    function delete_product_by_id($anId)
    {
        $query1 = "SELECT productName FROM product WHERE productID=? LIMIT 1;";
        
        if($stmt1 = $this->conn->prepare($query1))
        {
            $stmt1->bind_param('i', $anId);
            $stmt1->execute();
            $res = $stmt1->get_result();
            $productName = $res->fetch_assoc();
            
            if(isset($productName))
            {
                //delete the product
                
                $stmt1->close();
                
                $query2 = "DELETE FROM product WHERE productID=?;";
                
                if($stmt2 = $this->conn->prepare($query2))
                {
                    $stmt2->bind_param('i', $anId);
                    $stmt2->execute();
                    $stmt2->close();
                    return 'The product '.$productName['productName'].' has been deleted.';
                }
                else
                {
                    $stmt2->close();
                    return "Second query not properly prepared!";
                }
               
            }
            else
            {
                //No product match found
                $stmt1->close();
                
                return 'The product with ID: '.$anId.' does not exist!';
            }
        }
        else
        {
            $stmt1->close();
            return "First query not properly prepared!";
        }
    }
    
        // Increase the 'stock' value of a specific product.
    function add_product_by_id($anId)
    {
        $query1 = "SELECT productName FROM product WHERE productID=? LIMIT 1;";
        
        if($stmt1 = $this->conn->prepare($query1))
        {
            $stmt1->bind_param('i', $anId);
            $stmt1->execute();
            $res = $stmt1->get_result();
            $productName = $res->fetch_assoc();
            
            if(isset($productName))
            {
                
                $stmt1->close();
                
                $query2 = "UPDATE product SET stock=stock+1 WHERE productID=?;";
                
                if($stmt2 = $this->conn->prepare($query2))
                {
                    $stmt2->bind_param('i', $anId);
                    $stmt2->execute();
                    $stmt2->close();
                    return 'The product '.$productName['productName'].' has been updated.';
                }
                else
                {
                    $stmt2->close();
                    return "Second query not properly prepared!";
                }
               
            }
            else
            {
                //No product match found
                $stmt1->close();
                
                return 'The product with ID: '.$anId.' does not exist!';
            }
        }
        else
        {
            $stmt1->close();
            return "First query not properly prepared!";
        }
    }
    
        // Decrease the 'stock' value of a specific product.
    function takeaway_product_by_id($anId)
    {
        $query1 = "SELECT productName FROM product WHERE productID=? LIMIT 1;";
        
        if($stmt1 = $this->conn->prepare($query1))
        {
            $stmt1->bind_param('i', $anId);
            $stmt1->execute();
            $res = $stmt1->get_result();
            $productName = $res->fetch_assoc();
            
            if(isset($productName))
            {
                
                $stmt1->close();
                
                $query2 = "UPDATE product SET stock=stock-1 WHERE productID=?;";
                
                if($stmt2 = $this->conn->prepare($query2))
                {
                    $stmt2->bind_param('i', $anId);
                    $stmt2->execute();
                    $stmt2->close();
                    return 'The product '.$productName['productName'].' has been updated.';
                }
                else
                {
                    $stmt2->close();
                    return "Second query not properly prepared!";
                }
               
            }
            else
            {
                //No product match found
                $stmt1->close();
                
                return 'The product with ID: '.$anId.' does not exist!';
            }
        }
        else
        {
            $stmt1->close();
            return "First query not properly prepared!";
        }
    }
}