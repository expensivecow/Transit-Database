<?php session_save_path("/home/p/p2n8/php");
  session_start();?>
<?php if(!isset($_SESSION['username'])) : ?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content>
  <meta name="author" content>

    <title>CPSC304 Project</title>
    <!-- Bootstrap -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="starter-template.css" rel="stylesheet">
<style></style> 

  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Transit</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="#Schedule">Schedule</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="http://www.cs.ubc.ca/~laks/cpsc304/project.html">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
      <div class="starter-template">
        <h1>CPSC304</h1>
        <p class="lead">This is the home page of h3g8's CPSC 304 group project.</p>
  <p class="lead">Click the type of user which corresponds to you:</p>
  <p class="lead"><a href="./managerLogin.php"> Manager </a></p>
  <p class="lead"><a href="./employeeLogin.php"> Employee </a></p>
  <p class="lead"><a href="./customerLogin.php"> Customers </a></p>
      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
<?php else:?>



    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content>
  <meta name="author" content>

    <title>CPSC304 Project</title>
    <!-- Bootstrap -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="starter-template.css" rel="stylesheet">
<style></style> 

  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Transit</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="schedule.php">Schedule</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="http://www.cs.ubc.ca/~laks/cpsc304/project.html">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="signout.php">Sign Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
      <div class="starter-template">
        <font size ="4"><?php echo "<center><p class='lead2'>Welcome ". $_SESSION['username'] . "</p></center>";?></font>
        <font size ="7"><b>
        <?php
        echo "Balance is $";
        $usern = $_SESSION['username'];
        $conn = oci_connect("ora_p2n8", "a36523124", "ug");
        $results = oci_parse($conn, "select credit from customers where username = '$usern'");
        oci_execute($results);
        while ($row = oci_fetch_array($results, OCI_BOTH)) {
          echo "<tr><td>" . " " . $row["CREDIT"] . " </td></tr>";
        }
        oci_close($conn);
        ?>
        </font></b>
      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
<?php endif; ?>