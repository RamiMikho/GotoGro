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
        <legend>Add member to Database</legend>
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
    <form action="index.php" method="post">
    <fieldset>

        <legend>Add Sales</legend>
        <ul style="list-style-type: none;">
        <li style="display: inline-block;">
            <input type="checkbox" name="kiwi" class="fruit"/>
            <label for="kiwi"><img src="/gotogro/images/kiwi.png" width="100px">Kiwi</label>
            <label for="quantity">quantity</label>
            <input type="text" name="quantity"/>
        </li>
        </ul>

    </fieldset>
    <input type="submit" name="addSale" value="Add"/>
    </form>

    

<?php
    //ESTABLISHING CONNECTION TO DATABASE
    require_once("SQLSettings.php");
    $conn = new mysqli($host, $user, $pwd, $sql_db);
    if(!$conn){
        echo "<p>Database connection failed</p>";
    }
    else{
    //query to get each item
    $sqlTable = "item";
    $result = mysqli_query($conn, "SELECT * FROM $sqlTable");
    //COME BACK TO THIS MAKE IT PRETTIER
    //THIS SECTION IS FOR DISPLAYING THE SALES ITEMS FROM SQL DB
    echo "
    <form action=\"index.php\" method=\"post\">
    <fieldset>
        <legend>Add Sales</legend>
        <select name=\"customerID\">";
        $names = mysqli_query($conn,"SELECT * FROM customer");
        while($customerRow = mysqli_fetch_assoc($names)){
            $fName = $customerRow["firstName"];
            $IDs = $customerRow["customerID"];
            echo "<option value=\"$IDs\">$fName</option>";
        };
        
        echo "</select>
        <ul style=\"list-style-type: none;\">";

        while ($row = mysqli_fetch_assoc($result)) { 
            echo "<li style=\"display: inline-block;\">";
            $value = $row["productName"];
            echo "<input type=\"checkbox\" name=\"cart\" value=\"$value\" class=\"fruit\"/>
                <label for=\"$value\"><img src=\"/gotogro/images/$value.png\" width=\"100px\">$value</label>
                <label for=\"quantity\">quantity</label>
                <input type=\"text\" name=\"quantity\"/>";
            echo "</li>";
        };
        echo "</ul>";
    echo "</fieldset>
    <input type=\"submit\" name=\"addSale\" value=\"Add\"/>
    </form>

    ";


    //THIS SECTION PRETAINS TO ADDING USERS
    //Intializing Variables
    $firstName = null;
    $lastName = null;
    $phoneNo = null;
    $email = null;
    $address = null;

    $validMemberInput = false;

    //Catching the Variables from the POST submission form
    catchVar("firstName", $firstName);
    catchVar("lastName", $lastName);
    catchVar("phoneNo", $phoneNo);
    catchVar("email", $email);
    catchVar("address", $address);

    //Testing statment
    //echo "<p>",empty($_POST['firstName']), $firstName, $lastName, $phoneNo, $email, $address,$validMemberInput," </p>";

    //QUERY TO INSERT/ADD MEMBER
    $sqlTable = "customer";
    if($validMemberInput){
    $query = "INSERT INTO $sqlTable (customerID, firstName, lastName, phoneNo, email, address) 
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
    //Initializing variables
    $quantity = null;
    $kiwi = null;
    $customerID = null;
    $cart = null;

    $validSaleInput = false;
    

    //Get Item
    catchVarItem("quantity", $quantity);
    catchVarItem("customerID",$customerID);
    catchVarItem("cart", $cart);
    catchVarItem("kiwi", $kiwi);

    $sqlTable="saledetail";
    //Add item 
    if($validSaleInput){ 
        $saleID = mysqli_query($conn, "SELECT saleID FROM sale WHERE customerID=$customerID;")->fetch_row()[0] ?? false;
        $itmeID = mysqli_query($conn, "SELECT itemID FROM item WHERE productName=\"Kiwi\";")->fetch_row()[0] ?? false;
        $price = mysqli_query($conn, "SELECT price FROM item WHERE productName=\"Kiwi\";")->fetch_row()[0] ?? false;
        $query = "INSERT INTO $sqlTable (saleID, itemID, quantity, price) 
        VALUES ($saleID,$itmeID, $quantity, $price*$quantity)";
       $result = mysqli_query($conn, $query);
       if(!$result){
           echo "<p>Something went wrong </p>";
       }
       else{
        foreach ($cart as $fruit){ 
            echo $fruit."<br />";
        }

       }

    }

    //function check if item is checked 


    mysqli_close($conn);

    echo "<p>success<p>";
    }

    //CATCHES THE INPUT AND ASSIGNS IT TO VAR, ALSO CHECKS FOR INPUT EXISITENCE, NEED MORE VALIDATIONG/SANITATION OF INPUT
    function catchVar($input, &$var){
        global $validMemberInput;
        if(!empty($_POST[$input])){
            $var = $_POST[$input];
            $validMemberInput = True;
        }
    }

    //Assigns the variables for the sale of items
    function catchVarItem($input, &$var){
        global $validSaleInput;
        if(isset($_POST[$input])){
            $var = $_POST[$input];
            $validSaleInput = True;
        }
    }

?>
</body>
<footer id="indexFooter">
    <p>&#169; GotoGro</p>
</footer>
</html>

foreach ($row) { // I you want you can right this line like this: foreach($row as $value) {
                 // I just did not use "htmlspecialchars()" function. 