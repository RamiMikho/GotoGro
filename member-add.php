<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keyword" content="HTML, CSS, PHP" />
    <title>Add member</title>
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
        <li><a href="member-add.php">Add Member</a></li>
        <li><a href="search-member.php">Search member</a></li>
        <li><a href="top-sales.php">Top Sales</a></li>
        <li><a href="about.html">About us</a></li>

      </ul>
    </nav>

    <div class="form">
      <div class="form-title">
        <h1>Add membership form</h1>
      </div>

      <!-- All data from this form wll be added into
        database using member-add.php-->
      <form method="POST" action="member-add.php">
        <div class="input">
          <input type="text" name="firstName" id="firstName" maxlength="25" pattern="^[A-Za-z]{1,25}$" placeholder="First name" required="required"/>
          <label for="firstName">First name</label>
        </div>

        <div class="input">
          <input type="text" name="lastName" id="lastName" maxlength="25" pattern="^[A-Za-z]{1,25}$" placeholder="Last name" required="required"/>
          <label for="lastName">Last name</label>
        </div>

        <div class="input">
          <input type="email" name="email" id="email" placeholder="Email address" required="required"/>
          <label for="email">Email address</label>
        </div>

        <div class="input">
          <input type="text" name="phoneNumber" id="phone-number" maxlength="10" placeholder="Your phone number" pattern="[0-9]{1,10}" required="required"/>
          <label for="phoneNumber">Phone number</label>
        </div>

        <div class="input">
          <input type="text" name="address" id="address" placeholder="Address" required="required"/>
          <label for="address">Address</label>
        </div>

        <div class="button">
          <input type="submit" name="addMember" value="Add member" />
          <input type="reset" value="Reset form" />
        </div>
      </form>
    </div>
    


    <div class="form">
      <div class="form-title">
        <h1>Edit membership form</h1>
      </div>

      <!-- All data from this form wll be added into
        database using member-add.php-->
      <form method="POST" action="member-add.php">
        
        <div class="input">
          <input type="text" name="customerID" id="customerID" maxlength="10" pattern="[0-9]{1,10}" placeholder="Customer ID" required="required"/>
          <label for="customerID">Customer ID</label>
        </div>

        <div class="input">
          <input type="text" name="firstName" id="firstName" maxlength="25" pattern="^[A-Za-z]{1,25}$" placeholder="First name" required="required"/>
          <label for="firstName">First name</label>
        </div>

        <div class="input">
          <input type="text" name="lastName" id="lastName" maxlength="25" pattern="^[A-Za-z]{1,25}$" placeholder="Last name" required="required"/>
          <label for="lastName">Last name</label>
        </div>

        <div class="input">
          <input type="email" name="email" id="email" placeholder="Email address" required="required"/>
          <label for="email">Email address</label>
        </div>

        <div class="input">
          <input type="text" name="phoneNumber" id="phone-number" maxlength="10" placeholder="Your phone number" pattern="[0-9]{1,10}" required="required"/>
          <label for="phoneNumber">Phone number</label>
        </div>

        <div class="input">
          <input type="text" name="address" id="address" placeholder="Address" required="required"/>
          <label for="address">Address</label>
        </div>

        <div class="button">
          <input type="submit" name="editMember" value="Edit member" />
          <input type="reset" value="Reset form" />
        </div>
      </form>
    </div>




<?php
require_once("SQLSettings.php");
$conn = new mysqli($host, $user, $pwd, $sqlDB);

  //checking if connection is working or not
  if(!$conn)
  {
      die("Connection to database failed". mysqli_connect_error());
  }
  else{
  if(isset($_POST['addMember']))
  {
      $firstName = $_POST['firstName'];
      $lastName = $_POST['lastName'];
      $email = $_POST['email'];
      $phoneNumber = $_POST['phoneNumber'];
      $address = $_POST['address'];

      //code for sending form details to database
      $query = "INSERT INTO customer (firstName, lastName, phoneNo, email, address)
      VALUES ('$firstName', '$lastName', '$phoneNumber', '$email', '$address')";

      //saving details into database
      $save = mysqli_query($conn, $query);
      if($save)
      {
          echo "<p>Member Created Successfully</p>";
      }
      else
      {
          echo "<p>Error occurred!! Please try again</p>";
      }

    
    }
    if(isset($_POST['editMember']))
    {
      $customerID = $_POST['customerID'];
      $firstName = $_POST['firstName'];
      $lastName = $_POST['lastName'];
      $email = $_POST['email'];
      $phoneNumber = $_POST['phoneNumber'];
      $address = $_POST['address'];

      //update statement
      $query = "UPDATE customer SET firstName = '$firstName', lastName = '$lastName', 
      phoneNo = '$phoneNumber', email = '$email', address = '$address' WHERE customerID = '$customerID'";

      $results = mysqli_query($conn, $query);
      if($results)
      {
          echo "<p>Member edited Successfully</p>";
      }
      else
      {
          echo "<p>Error occurred!! Please try again</p>";
      }

    }
      //closing connection to database
      mysqli_close($conn);
}
?>

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
    <script src="script/enquire.js"></script>
  </body>
</html>
