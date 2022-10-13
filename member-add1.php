<?php
if(isset($_POST['submit']))
{
    //database details for connecting frontend form to database
    $host = "localhost";
    $username = "database_user";
    $password = "database_user";
    $dbname = "go_to_grocery";

    //creating connection to database
    $con = mysqli_connect($host, $username, $password, $dbname);

    //checking if connection is working or not
    if(!$con)
    {
        die("Connection to database failed". mysqli_connect_error());
    }

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $address = $_POST['address'];

    //code for sending form details to database
    $sql = "INSERT INTO customer (firstName, lastName, phoneNo, email, address)
    VALUES ('$firstname', '$lastname', '$phonenumber', '$email', '$address')";

    //saving details into database
    $save = mysqli_query($con, $sql);
    if($save)
    {
        echo "Member Created Successfully";
    }
    else
    {
        echo "Error occurred!! Please try again";
    }

    //closing connection to database
    mysql_close($con);
}
?>