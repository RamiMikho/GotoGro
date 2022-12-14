<!DOCTYPE html>
<html>

<head>
    <title>Shopping UI</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keyword" content="HTML, CSS, PHP" />
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

</head>

<body>
    <nav>
        <img src="images/goto_logo.png" alt="logo" class="logo" />
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="add-sale.php">Add sale</a></li>
            <li><a href="member-add.php">Add member</a></li>
            <li><a href="search-member.php">Search member</a></li>
            <li><a href="top-sales.php">Top Sales</a></li>
            <li><a href="about.html">About us</a></li>
        </ul>
    </nav>

    <div class="form">
        <?php
    //ESTABLISHING CONNECTION TO DATABASE
    require_once("SQLSettings.php");
    $conn = new mysqli($host, $user, $pwd, $sqlDB);
    session_start();
    if(!$conn){
        echo "<p>Database connection failed</p>";
    }
    else{

    //THIS SECTION IS FOR DISPLAYING THE SALES ITEMS FROM SQL DB
    $sqlTable = "item";
    $result = mysqli_query($conn, "SELECT * FROM $sqlTable");
    echo "
    <form action=\"add-sale.php\" method=\"post\">
    <fieldset>
        <legend>Add Sales</legend>
        <select name=\"customerID\">";
        $names = mysqli_query($conn,"SELECT * FROM customer");
        while($customerRow = mysqli_fetch_assoc($names)){
            $fName = $customerRow["firstName"];
            $lName = $customerRow["lastName"];
            $IDs = $customerRow["customerID"];
            echo "<option value=\"$IDs\">$fName $lName</option>";
        };
        
        echo "</select>
        <ul style=\"list-style-type: none;\">";
        //Loops through the items
        while ($row = mysqli_fetch_assoc($result)) { 
            echo "<li style=\"display: inline-block;\">";
            $value = $row["productName"];
            echo "<input type=\"checkbox\" name=\"cart[]\" value=\"$value\" class=\"fruit\"/>
                <label for=\"$value\"><img src=\"/gotogro/images/$value.png\" width=\"100px\">$value</label>
                <label for=\"quantity\">quantity</label>
                <input type=\"text\" name=\"quantity$value\"/>";
            echo "</li>";
        };
        echo "</ul>";
    echo "</fieldset>
    <input type=\"submit\" name=\"addSale\" value=\"Add\"/>
    </form>";
    echo "
    <form action=\"add-sale.php\" method=\"post\" style=\"width:760px\">
    <fieldset>
        <legend>Edit Sales</legend>
        <select name=\"customerID\">";
        $names = mysqli_query($conn,"SELECT * FROM customer");
        while($customerRow = mysqli_fetch_assoc($names)){
            $fName = $customerRow["firstName"];
            $lName = $customerRow["lastName"];
            $IDs = $customerRow["customerID"];
            echo "<option value=\"$IDs\">$fName $lName</option>";
        };

    echo "</fieldset>
    <input type=\"submit\" name=\"selectCustomerSale\" value=\"Edit Customer Sale\"/>
    </form>";
    }


    //THIS SECTION PRETAINS TO ADDING SALES RECORDS THIS WILL BE MOVED TO
    //Initializing variables
    if(isset($_POST["addSale"])){
    $customerID = $_POST["customerID"];
    $cart = null;
    $validSaleInput = false;
    
    //Get Item
    //catchVarItem("customerID",$customerID);
    catchVarItem("cart", $cart);

    //Add to the Sales sql table
    $sqlTable="sale";
    if($validSaleInput and isset($_POST["addSale"])){
        $currentDate = date("Y-m-d");
        $total = 0;
        //calculate the total
        foreach ($cart as $fruit){  //loop through each item checked, multiply by quantity and sum total
            //catchVarItem("quantity$fruit", $quantity);// quantity$fruit = quanity+fruitname
            $quantity = $_POST["quantity$fruit"];
            $price = mysqli_query($conn, "SELECT price FROM item WHERE productName=\"$fruit\";")->fetch_row()[0] ?? false;
            $total = $total + $price * $quantity;
        }
        //INSERT STATEMENT
        $query = "INSERT INTO $sqlTable (customerID, totalPrice, date) VALUES ($customerID, $total, '$currentDate')";
        $result = mysqli_query($conn, $query);
        if($result){
            echo "<p class='success'>Success</p>";
        }
        else
        {
            echo "<p class='fail'>Error occurred</p>";
        }
    };

    //Add item into sales details
    $sqlTable="saledetail";
    if($validSaleInput and isset($_POST["addSale"])){ 
        $saleID = mysqli_query($conn, "SELECT saleID FROM sale WHERE customerID=$customerID ORDER BY saleID DESC;")->fetch_row()[0] ?? false; //VERY UGLY SOLUTION HERE TOO
        foreach ($cart as $fruit){ 
            $itmeID = mysqli_query($conn, "SELECT itemID FROM item WHERE productName=\"$fruit\";")->fetch_row()[0] ?? false;//gets itemID from database
            $price = mysqli_query($conn, "SELECT price FROM item WHERE productName=\"$fruit\";")->fetch_row()[0] ?? false;//gets price from database
            //catchVarItem("quantity$fruit", $quantity); //catches quantity for fruit
            $quantity = $_POST["quantity$fruit"];
            $query = "INSERT INTO $sqlTable (saleID, itemID, quantity, price) 
            VALUES ($saleID,$itmeID, $quantity, $price*$quantity)";
            $result = mysqli_query($conn, $query);
            if($result){
                echo "<p class='success'>Success</p>";
            }
            else
            {
                echo "<p class='fail'>Error occurred</p>";
            }
        }
    };
    }
    //PRINTS THE FORM FOR EDITING
    if(isset($_POST["selectCustomerSale"])){
        

        $customerID = $_POST["customerID"];
        $_SESSION["customerID"] =  $customerID;
        echo $_SESSION["customerID"];
        echo "
        <form action=\"add-sale.php\" method=\"post\" style=\"width:760px\">
        <fieldset>
        <select name=\"saleID\">";//Display all sales of the customer
        $sales = mysqli_query($conn,"SELECT * FROM sale WHERE customerID = '$customerID'");
        while($saleRow = mysqli_fetch_assoc($sales)){
            $saleID = $saleRow["saleID"];
            $totalPrice = $saleRow["totalPrice"];
            $date = $saleRow["date"];
            echo "<option value=\"$saleID\">Sale ID:$saleID Total Price:$totalPrice Date of Sale:$date</option>";
        };
        echo "</select>
        <ul style=\"list-style-type: none;\">";
        $result = mysqli_query($conn, "SELECT * FROM item");
        //Loops through the items
        while ($row = mysqli_fetch_assoc($result)) { 
            echo "<li style=\"display: inline-block;\">";
            $value = $row["productName"];
            echo "<input type=\"checkbox\" name=\"cart[]\" value=\"$value\" class=\"fruit\"/>
                <label for=\"$value\"><img src=\"/gotogro/images/$value.png\" width=\"100px\">$value</label>
                <label for=\"quantity\">quantity</label>
                <input type=\"text\" name=\"quantity$value\"/>";
            echo "</li>";
        };
        echo "</ul>
        <input type=\"submit\" name=\"editSale\" value=\"Edit a Sale\"/>
        </form>";

    }

    //MODIFIES THE DATABASES VALUES
    if(isset($_POST["editSale"])){

    if(!isset($customerID)){
    $customerID = $_SESSION["customerID"];
    }
    $cart = null;
    $saleID = $_POST["saleID"];

    catchVarItem("cart", $cart);

    $sqlTable="sale";
    if($validSaleInput and isset($_POST["editSale"])){
        $currentDate = date("Y-m-d");
        $total = 0;
        //calculate the total
        foreach ($cart as $fruit){  //loop through each item checked, multiply by quantity and sum total
            //catchVarItem("quantity$fruit", $quantity);// quantity$fruit = quanity+fruitname
            $quantity = $_POST["quantity$fruit"];
            $price = mysqli_query($conn, "SELECT price FROM item WHERE productName=\"$fruit\";")->fetch_row()[0] ?? false;
            $total = $total + $price * $quantity;
        }
        //INSERT into sale table
        $query = "UPDATE $sqlTable SET totalPrice = '$total', date='$currentDate' WHERE saleID = '$saleID'";
        $result = mysqli_query($conn, $query);
        if($result){
            echo "<p class='success'>Success</p>";
        }
        else
        {
            echo "<p class='fail'>Error occurred</p>";
        }
        //delete all previous data
        $query = "DELETE FROM saledetail WHERE saleID=$saleID;";
        $result = mysqli_query($conn, $query);
        if($result){
            echo "<p class='success'>Success</p>";
        }
        else
        {
            echo "<p class='fail'>Error occurred</p>";
        }
        //Add each fruit back into saledetails
        $sqlTable = "saledetail";
        foreach ($cart as $fruit){ 
            $itemID = mysqli_query($conn, "SELECT itemID FROM item WHERE productName=\"$fruit\";")->fetch_row()[0] ?? false;//gets itemID from database
            $price = mysqli_query($conn, "SELECT price FROM item WHERE productName=\"$fruit\";")->fetch_row()[0] ?? false;//gets price from database
            //catchVarItem("quantity$fruit", $quantity); //catches quantity for fruit
            $quantity = $_POST["quantity$fruit"];
            //echo $itemID;
            $itemID = strval($itemID);
            $query = "INSERT INTO $sqlTable (saleID, quantity, price, itemID) 
            VALUES ($saleID, $quantity, $price*$quantity, '$itemID')";
            $result = mysqli_query($conn, $query);
            if($result)
            {
                echo "<p class='success'>Success</p>";
            }
            else
            {
                echo "<p class='fail'>Error occurred</p>";
            }
        }
        session_destroy();
    };

        


    }
    
    //CLOSE CONNECTION
    mysqli_close($conn);
    

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
        foreach($_POST[$input] as $item){
            if(!isset($item)){
                $validSaleInput = false;
            }
            else{
                $var = $_POST[$input];
                $validSaleInput = True;
            }
        }
    }
    }

    //Assings vars of search
    function catchVarSearch($input, &$var){
        global $validSearchInput;
        if(isset($_POST[$input])){
            $var = $_POST[$input];
            $validSearchInput = True;
        }
    }
    function catchVarSaleID($input, &$var){
        global $validSaleIDInput;
        if(isset($_POST[$input])){
            $var = $_POST[$input];
            $validSaleIDInput = True;
        }
    }
    ?>
    </div>


    <footer>
        <h3>Goto Grocery</h3>
        <p>Connect with us</p>
        <ul class="social">
            <li>
                <a href="#"><i class="fa fa-facebook"></i></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-instagram"></i></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-linkedin"></i></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-youtube"></i></a>
            </li>
        </ul>
    </footer>
</body>

</html>
