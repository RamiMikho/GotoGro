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
        <li><a href="about.html">About me</a></li>

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
          <input type="text" name="firstname" id="firstname" maxlength="25" pattern="^[A-Za-z]{1,25}$" placeholder="First name" required="required"/>
          <label for="firstname">First name</label>
        </div>

        <div class="input">
          <input type="text" name="lastname" id="lastname" maxlength="25" pattern="^[A-Za-z]{1,25}$" placeholder="Last name" required="required"/>
          <label for="lastname">Last name</label>
        </div>

        <div class="input">
          <input type="email" name="email" id="email" placeholder="Email address" required="required"/>
          <label for="email">Email address</label>
        </div>

        <div class="input">
          <input type="text" name="phonenumber" id="phone-number" maxlength="10" placeholder="Your phone number" pattern="[0-9]{1,10}" required="required"/>
          <label for="phonenumber">Phone number</label>
        </div>

        <div class="input">
          <input type="text" name="address" id="address" placeholder="Address" required="required"/>
          <label for="address">Address</label>
        </div>

  

        <div class="button">
          <input type="submit" name="submit" value="Add member" />
          <input type="reset" value="Reset form" />
        </div>
      </form>
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
    <script src="script/enquire.js"></script>
  </body>
</html>

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
    mysqli_close($con);
}
?>