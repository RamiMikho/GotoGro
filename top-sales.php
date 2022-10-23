<!-- PHP code to establish connection with the localserver -->
<?php

//ESTABLISHING CONNECTION TO DATABASE
require_once("SQLSettings.php");

$mysqli = new mysqli($host, $user, $pwd, $sqlDB);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

// SQL query to select data from database
$sql = " SELECT item.productName, sum(saleDetail.quantity)
FROM saleDetail
INNER JOIN item ON item.itemID = saleDetail.itemID 
GROUP BY productName ORDER BY sum(saleDetail.quantity) DESC LIMIT 3
";

$result = $mysqli->query($sql);
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="GotoGro Internal Website" />
    <meta name="keyword" content="HTML, CSS, Javascript, PHP" />
    <title>GotoGro Manager</title>
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/topsales.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
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

    <section>
        <h1>Goto Grocery Top Sales</h1>
        <!-- TABLE CONSTRUCTION -->
        <table>
            <tr>
                <th>ProductName</th>
                <th>Quantity of Sold</th>
            </tr>
            <!-- PHP CODE TO FETCH DATA FROM ROWS -->
            <?php
                // LOOP TILL END OF DATA
                while($rows=$result->fetch_assoc())
                {
            ?>
            <tr>
                <!-- FETCHING DATA FROM EACH
                    ROW OF EVERY COLUMN -->
                <!-- <td><?php echo $rows['productName'];?></td> -->
                <td><?php echo $rows['productName'];?></td>
                <td><?php echo $rows['sum(saleDetail.quantity)'];?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </section>

    <?php
    //ESTABLISHING CONNECTION TO DATABASE
    require_once("SQLSettings.php");
    $conn = new mysqli($host, $user, $pwd, $sqlDB);
    if(!$conn){
        echo "<p>Database connection failed</p>";
    }
    else{
    //THIS SECTION IS FOR SAVING FILES
    if(isset($_POST["generateSales"])) {
      $result = mysqli_query($conn, "SELECT * FROM sale");
      $dataToFile = null;
      while($dataToWrite = mysqli_fetch_assoc($result)){
          $dataToFile = $dataToFile . $dataToWrite["saleID"] ."," . $dataToWrite["customerID"] . "," . $dataToWrite["totalPrice"] . "," . $dataToWrite["date"] . PHP_EOL;
      }
      writeAFile("salesData.csv",$dataToFile);
  };
  if(isset($_POST["generateWeekly"])) {
      $result = mysqli_query($conn, "SELECT * FROM sale WHERE date >= (CURDATE()-INTERVAL 7 DAY);");
      $dataToFile = null;
      while($dataToWrite = mysqli_fetch_assoc($result)){
          $dataToFile = $dataToFile . $dataToWrite["saleID"] ."," . $dataToWrite["customerID"] . "," . $dataToWrite["totalPrice"] . "," . $dataToWrite["date"] . PHP_EOL;
      }
      writeAFile("Weekly.csv", $dataToFile);
  };
  if(isset($_POST["generateMonthly"])) {
      $result = mysqli_query($conn, "SELECT * FROM sale WHERE date >= (CURDATE()-INTERVAL 1 Month);");
      $dataToFile = null;
      while($dataToWrite = mysqli_fetch_assoc($result)){
          $dataToFile = $dataToFile . $dataToWrite["saleID"] ."," . $dataToWrite["customerID"] . "," . $dataToWrite["totalPrice"] . "," . $dataToWrite["date"] . PHP_EOL;
      }
      writeAFile("Monthly.csv", $dataToFile);
  };
  if(isset($_POST["generateYearly"])) { 
      $result = mysqli_query($conn, "SELECT * FROM sale WHERE date >= (CURDATE()-INTERVAL 1 Year);");
      $dataToFile = null;
      while($dataToWrite = mysqli_fetch_assoc($result)){
          $dataToFile = $dataToFile . $dataToWrite["saleID"] ."," . $dataToWrite["customerID"] . "," . $dataToWrite["totalPrice"] . "," . $dataToWrite["date"] . PHP_EOL;
      }
      writeAFile("Yearly.csv", $dataToFile);
  };
  if(isset($_POST["generateMemberAnalysis"])) {
      $customerID = $_POST["customerID"]; 
      if(0 < strlen($_POST["customerID"])){
      $result = mysqli_query($conn, "SELECT * FROM sale WHERE customerID = $customerID");
      $dataToFile = null;
      while($dataToWrite = mysqli_fetch_assoc($result)){
          $dataToFile = $dataToFile . $dataToWrite["saleID"] ."," . $dataToWrite["customerID"] . "," . $dataToWrite["totalPrice"] . "," . $dataToWrite["date"] . PHP_EOL;
      }
      writeAFile("Member $customerID.csv", $dataToFile);
    }
    else{
      echo "<p class='fail' >Error occurred</p>";
    }
  };



  if(isset($_POST["generateTopSale"])) {
    $result = mysqli_query($conn, "SELECT item.productName, sum(saleDetail.quantity) FROM saleDetail
    INNER JOIN item ON item.itemID = saleDetail.itemID GROUP BY productName ORDER BY sum(saleDetail.quantity) DESC");
    $dataToFile = null;
    while($dataToWrite = mysqli_fetch_assoc($result)){
        $dataToFile = $dataToFile . $dataToWrite["productName"] . "," . $dataToWrite["sum(saleDetail.quantity)"] . PHP_EOL;
    }
    writeAFile("TopSale.csv", $dataToFile);
};



if(isset($_POST["generateMemberAnalysisa"])) {
  $result = mysqli_query($conn, "");
  $dataToFile = null;
  while($dataToWrite = mysqli_fetch_assoc($result)){
      $dataToFile = $dataToFile;//design output here
  }
  writeAFile("Member $customerID.csv", $dataToFile);
};


      //CLOSE CONNECTION
      mysqli_close($conn);
    }
  function writeAFile($fileName, $dataToFile){
    $createFile = fopen($fileName, "w");
    fwrite($createFile, $dataToFile);
    fclose($createFile);
    echo "<a class='download' href=\"$fileName\" download>Download $fileName Report</a>";
}
    ?>
    <!-- Generating the reports -->
    <form action="top-sales.php" method="post">
    <label for="customerID">Customer ID</label>
    <input type="text" name="customerID" id="customerID"/>
    <input  type="submit" name="generateMemberAnalysis" value="Generate Member Report">
    <input  type="submit" name="generateSales" value="Generate Sales Report">
    <input  type="submit" name="generateWeekly" value="Generate Weekly Sales Report">
    <input  type="submit" name="generateMonthly" value="Generate Monthly Sales Report">
    <input  type="submit" name="generateYearly" value="Generate Yearly Sales Report">
    <input  type="submit" name="generateTopSale" value="Generate Top Sale Report">
    
    </form>

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
