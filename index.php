<!DOCTYPE html>
<html lang="en">

<div>test</div>
<head>
    <meta charset="utf-8" />
    <meta name="keywords" content="HTML, CSS" />
    <link href="styles/style.css" rel="stylesheet" />
    <script src="scripts/Employee.js"></script>
    <title>GotoGro</title>
</head>

<body>
    <header>
        <h1>Mode:</h1>
        <nav>
            <a href="index.html">Employee</a>
            <a href="Manager.html">Manager</a>
        </nav>
    </header>


    <!--Member input-->
    <form action="index.php" method="post">
    <fieldset>
        <legend>Search Data base</legend>
        <label for="firstName">First Name</label>
        <input type="text" name="firstName" id="firstName" value=""/>
        <label for="lastName">Last Name</label>
        <input type="text" name="lastName" id="lastName"/>
        <label for="phoneNo">Phone Number</label>
        <input type="text" name="phoneNo" id="phoneNo"/>
        <label for="email">Email</label>
        <input type="text" name="email" id="email"/>
        <label for="address">Address</label>
        <input type="text" name="address" id="address"/>
    </fieldset>
    <input type="submit" name="addMember" value="Add"/>
    </form>
    <!--Sale input-->

    

<?php
    //ESTABLISHING CONNECTION TO DATABASE
    require_once("SQLSettings.php");
    $conn = new mysqli($host, $user, $pwd, $sql_db);
    if(!$conn){
        echo "<p>Database connection failed</p>";
    }
    else{
    //THIS SECTION PRETAINS TO ADDING USERS
    //Intializing Variables
    $firstName = null;
    $lastName = null;
    $phoneNo = null;
    $email = null;
    $address = null;

    $validInput = false;



    //Catching the Variables from the POST submission form
    catchVar("firstName", $firstName);
    catchVar("lastName", $lastName);
    catchVar("phoneNo", $phoneNo);
    catchVar("email", $email);
    catchVar("address", $address);

    //Testing statment
    //echo "<p>",empty($_POST['firstName']), $firstName, $lastName, $phoneNo, $email, $address,$validInput," </p>";


    //QUERY TO INSERT/ADD MEMBER
    $sql_table = "customer";
    if($validInput){
    $query = "INSERT INTO $sql_table (customerID, firstName, lastName, phoneNo, email, address) 
             VALUES (NULL, '$firstName', '$lastName', '$phoneNo', '$email', '$address')";
            // VALUES (NULL, 'tName', 'tLast', '00000000', 'Email@Email.com', 'AD')";
            $result = mysqli_query($conn, $query);
            if(!$result){
                echo "<p class=\"wrong\">Something went wrong with", $query, $conn->error , "</p>";
            }
            else{
                echo "<p class=\"ok\">Successfully added new order record</p>";
            }
    }

    //THIS SECTION PRETAINS TO ADDING SALES RECORDS THIS WILL BE MOVED TO


    mysqli_close($conn);

    echo "<p>success<p>";
    }

    //CATCHES THE INPUT AND ASSIGNS IT TO VAR, ALSO CHECKS FOR INPUT EXISITENCE, NEED MORE VALIDATIONG/SANITATION OF INPUT
    function catchVar($input, &$var){
        global $validInput;
        if(!empty($_POST[$input])){
            $var = $_POST[$input];
            $validInput = True;
        }
    }

?>
</body>
<footer id="indexFooter">
    <p>&#169; GotoGro</p>
</footer>
</html>