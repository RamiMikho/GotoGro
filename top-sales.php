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
