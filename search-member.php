<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keyword" content="HTML, CSS, PHP" />
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
        <li><a href="add-sale.php">Add sale</a></li>
        <li><a href="member-add.php">Add member</a></li>
        <li><a href="search-member.php">Search member</a></li>
        <li><a href="about.html">About us</a></li>
      </ul>
    </nav>
  <!-- DISPLAY CUSTOMER DB -->
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
    $sqlTable = "customer";
    $result = mysqli_query($conn, "SELECT * FROM $sqlTable");
    
    
    //Get Item
    catchVarItem("customerID",$customerID);
    catchVarItem("cart", $cart);

    //THIS SECTION IS FOR THE SEARCH RESULTS(CAN BE CONVERTED TO ANYLYSIS OF MEMBER NEEDS)
    //catch search input
    $customerID = null;
    $validSearchInput = false;
    catchVarSearch("customerIDSearch", $customerID);

    $sqlTable = "customer";
  
    $query = "SELECT * FROM $sqlTable;";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo $conn->error;
    }
    else{
        echo "<table class=\"Sale\">\n";
            echo "<tr>\n"
                ."<th scope=\"col\">Customer ID</th>\n"
                ."<th scope=\"col\">First name</th>\n"
                ."<th scope=\"col\">Last name</th>\n"
                ."<th scope=\"col\">Phone</th>\n"
                ."<th scope=\"col\">Email</th>\n"
                ."<th scope=\"col\">Address</th>\n"
                ."</tr>\n";

            while ($row = mysqli_fetch_assoc($result)){
                echo "<tr>\n";
                echo "<td>", $row["customerID"], "</td>\n";
                echo "<td>", $row["firstName"], "</td>\n";
                echo "<td>", $row["lastName"], "</td>\n";
                echo "<td>", $row["phoneNo"], "</td>\n";
                echo "<td>", $row["email"], "</td>\n";
                echo "<td>", $row["address"], "</td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
        }
    
    };

    //CLOSE CONNECTION
    mysqli_close($conn);

?>  
    </div>

    <!--Sale Search-->
    <form action="search-member.php" method="post">
    <fieldset>
        <legend>Search</legend>
        <label for="customerIDSearch">Customer ID</label>
        <input type="text" name="customerIDSearch" id="customerIDSearch"/>
    </fieldset>
    <input type="submit" name="searchSale" value="Search"/>
    </form>
    <!-- DISPLAY USER PURCHASE -->
    <div class = "display">
    <?php
    //ESTABLISHING CONNECTION TO DATABASE
    require_once("SQLSettings.php");
    $conn = new mysqli($host, $user, $pwd, $sqlDB);
    if(!$conn){
        echo "<p>Database connection failed</p>";
    }
    else{
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

     <!--Sale Detail-->
     <form action="search-member.php" method="post">
    <fieldset>
        <legend>Sale Detail</legend>
        <label for="saleID">Sale ID</label>
        <input type="text" name="saleID" id="saleID"/>
    </fieldset>
    <input type="submit" name="printSale" value="Search"/>
    </form>

    <!-- DISPLAY SALE DETAIL BASED ON SALE ID -->
    <div class = "display">
    <?php
    //ESTABLISHING CONNECTION TO DATABASE
    require_once("SQLSettings.php");
    $conn = new mysqli($host, $user, $pwd, $sqlDB);
    if(!$conn){
        echo "<p>Database connection failed</p>";
    }
    else{
      $saleID = null;
      $validSaleIDInput = false;
      catchVarSaleID("saleID", $saleID);
  
      $sqlTable = "saledetail";
      if($validSaleIDInput and  isset($_POST["printSale"])){
      $query = "SELECT saledetail.saleID, item.productName, saledetail.quantity, saledetail.price FROM saledetail, item WHERE saledetail.saleID = \"$saleID\" AND item.itemID = saledetail.itemID"; 
      $result = mysqli_query($conn, $query);
      if(!$result){
          echo $conn->error;
      }
      else{
          echo "<table class=\"Sale\">\n";
              echo "<tr>\n"
                  ."<th scope=\"col\">Sale ID</th>\n"
                  ."<th scope=\"col\">Product</th>\n"
                  ."<th scope=\"col\">Quantity</th>\n"
                  ."<th scope=\"col\">Price</th>\n"
                  ."</tr>\n";
  
              while ($row = mysqli_fetch_assoc($result)){
                  echo "<tr>\n";
                  echo "<td>", $row["saleID"], "</td>\n";
                  echo "<td>", $row["productName"], "</td>\n";
                  echo "<td>", $row["quantity"], "</td>\n";
                  echo "<td>", $row["price"], "</td>\n";
                  echo "</tr>\n";
              }
              echo "</table>\n";
          }
          
      };    
    };
    //CLOSE CONNECTION
    mysqli_close($conn);
  
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

