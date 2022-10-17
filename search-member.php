<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Creating Web Application" />
    <meta name="keyword" content="HTML, CSS, Javascript" />
    <meta name="author" content="Hayden Tran" />
    <title>Search Customer</title>
    <link rel="stylesheet" href="style/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  </head>
  <body>
    <nav>
      <img src="images/goto_logo.png" alt="logo" class="logo" />

      <ul>
        <li><a href="indexOld.html">Home</a></li>
        <li><a href="product.html">Add sale</a></li>
        <li><a href="member-add.php">Add member</a></li>
        <li><a href="search-member.php">Search member</a></li>
        <li><a href="about.html">About us</a></li>
      </ul>
    </nav>

    <!-- <form action="search-member.php" method="post">
        <fieldset>
            <legend>Search</legend>
            <label for="customerIDSearch">Customer ID</label>
            <input type="text" name="customerIDSearch" id="customerIDSearch"/>
        </fieldset>
        <input type="submit" name="searchSale" value="Search"/>
    </form>
    
    <?php
      if(isset($_POST['submit']))
      {

        //database details for connecting frontend form to database
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "GotoGro";

        //creating connection to database
        $con = mysqli_connect($host, $username, $password, $dbname);
        
        //checking if connection is working or not
        if(!$con)
        {
            die("Connection to database failed". mysqli_connect_error());
        }

        //THIS SECTION IS FOR THE SEARCH RESULTS(CAN BE CONVERTED TO ANYLYSIS OF MEMBER NEEDS)
        //catch search input
        $customerID = null;
        $validSearchInput = false;
        catchVarSearch("customerIDSearch", $customerID);

        $sqlTable = "sale";
        if($validSearchInput and isset($_POST["searchSale"])){
        $query = "SELECT * FROM $sqlTable WHERE customerID = $customerID;";
        $result = mysqli_query($conn, $query);
        if(!$result){
            echo $conn->error;
        }
        else{
            echo "<table class=\"Sale\">\n";
                echo "<tr>\n"
                    ."<th scope=\"col\">Sale ID</th>\n"
                    ."<th scope=\"col\">Customer ID</th>\n"
                    ."<th scope=\"col\">Total</th>\n"
                    ."<th scope=\"col\">Date</th>\n"
                    ."</tr>\n";

                while ($row = mysqli_fetch_assoc($result)){
                    echo "<tr>\n";
                    echo "<td>", $row["saleID"], "</td>\n";
                    echo "<td>", $row["customerID"], "</td>\n";
                    echo "<td>", $row["totalPrice"], "</td>\n";
                    echo "<td>", $row["date"], "</td>\n";
                    echo "</tr>\n";
                }
                echo "</table>\n";
            }
          
        };
      }
?> -->


      <!--Member input-->

    <!--Sale input-->
    <!--This is done in php now-->


    <!--Sale Search-->
    <form action="search-member.php" method="post">
    <fieldset>
        <legend>Search</legend>
        <label for="customerIDSearch">Customer ID</label>
        <input type="text" name="customerIDSearch" id="customerIDSearch"/>
    </fieldset>
    <input type="submit" name="searchSale" value="Search"/>
    </form>

     <!--Sale Detail-->
     <form action="search-member.php" method="post">
    <fieldset>
        <legend>Sale Detail</legend>
        <label for="saleID">Sale ID</label>
        <input type="text" name="saleID" id="saleID"/>
    </fieldset>
    <input type="submit" name="printSale" value="Search"/>
    </form>

    <div class = "display">
    <?php
    //ESTABLISHING CONNECTION TO DATABASE
    require_once("SQLSettings.php");
    $conn = new mysqli($host, $user, $pwd, $sqlDB);
    if(!$conn){
        echo "<p>Database connection failed</p>";
    }
    else{

    //THIS SECTION IS FOR DISPLAYING THE SALES ITEMS FROM SQL DB
    $sqlTable = "item";
    $result = mysqli_query($conn, "SELECT * FROM $sqlTable");
    
    
    //Get Item
    catchVarItem("customerID",$customerID);
    catchVarItem("cart", $cart);

    //THIS SECTION IS FOR THE SEARCH RESULTS(CAN BE CONVERTED TO ANYLYSIS OF MEMBER NEEDS)
    //catch search input
    $customerID = null;
    $validSearchInput = false;
    catchVarSearch("customerIDSearch", $customerID);

    $sqlTable = "sale";
    if($validSearchInput and isset($_POST["searchSale"])){
    $query = "SELECT * FROM $sqlTable WHERE customerID = $customerID;";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo $conn->error;
    }
    else{
        echo "<table class=\"Sale\">\n";
            echo "<tr>\n"
                ."<th scope=\"col\">Sale ID</th>\n"
                ."<th scope=\"col\">Customer ID</th>\n"
                ."<th scope=\"col\">Total</th>\n"
                ."<th scope=\"col\">Date</th>\n"
                ."</tr>\n";

            while ($row = mysqli_fetch_assoc($result)){
                echo "<tr>\n";
                echo "<td>", $row["saleID"], "</td>\n";
                echo "<td>", $row["customerID"], "</td>\n";
                echo "<td>", $row["totalPrice"], "</td>\n";
                echo "<td>", $row["date"], "</td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
        }
    
    };

    //CLOSE CONNECTION
    mysqli_close($conn);
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

