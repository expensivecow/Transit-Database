<?php session_save_path("/home/h/h3g8/php");
  session_start();?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  <!-- Adding Navigation Bar-->
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
            <li><a href="./schedule.php">Schedule</a></li>
            <li><a href="./register.php">Register</a></li>
            <li><a href="http://www.cs.ubc.ca/~laks/cpsc304/project.html">About</a></li>
            <li><a href="http://www.omfgdogs.com">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
      <div class="starter-template">
    <div class="container">

      <form class="form-signin" action="customerLogin.php" method="POST">
        <h2 class="form-signin-heading">Please sign in (Customer)</h2>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <button type="submit" value="Login" class="btn btn-lg btn-primary btn-block" name ="Login">Sign in</button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>

<?php
if(isset($_SESSION['username'])){
      header("location: index.php");
    }
//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_p2n8", "a36523124", "ug");

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
  //echo "<br>running ".$cmdstr."<br>";
  global $db_conn, $success;
  $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

  if (!$statement) {
    $e = OCI_Error($db_conn); // For OCIParse errors pass the       
    // connection handle
 echo "<div class='alert alert-danger' role='alert'>";
    echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Error:</span>";
		echo htmlentities($e['message']);
		echo "<br>Cannot parse the following command: " . $cmdstr ."<br>";
    echo "</div>";

    $success = False;
  }

  $r = OCIExecute($statement, OCI_DEFAULT);
  if (!$r) {
    $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
    echo "<div class='alert alert-danger' role='alert'>";
    echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Error:</span>";
		echo htmlentities($e['message']);
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
    echo "</div>";

    $success = False;
  } else {

  }
  return $statement;

}

function executeBoundSQL($cmdstr, $list) {
  /* Sometimes a same statement will be excuted for severl times, only
   the value of variables need to be changed.
   In this case you don't need to create the statement several times; 
   using bind variables can make the statement be shared and just 
   parsed once. This is also very useful in protecting against SQL injection. See example code below for       how this functions is used */

  global $db_conn, $success;
  $statement = OCIParse($db_conn, $cmdstr);

  if (!$statement) {
    $e = OCI_Error($db_conn);
 echo "<div class='alert alert-danger' role='alert'>";
    echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Error:</span>";
		echo htmlentities($e['message']);
		echo "<br>Cannot parse the following command: " . $cmdstr ."<br>";
    echo "</div>";

    $success = False;
  }

  foreach ($list as $tuple) {
    foreach ($tuple as $bind => $val) {
      //echo $val;
      //echo "<br>".$bind."<br>";
      OCIBindByName($statement, $bind, $val);
      unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

    }
    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
      $e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
    echo "<div class='alert alert-danger' role='alert'>";
    echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Error:</span>";
		echo htmlentities($e['message']);
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
    echo "</div>";


      echo "<br>";
      $success = False;
    }
  }

}

function printResult($result) { //prints results from a select statement
  echo "<br>Got data from table customers:<br>";
  echo "<table>";
  echo "<tr><th>User</th>". " " ."<th>Address </th>". " " ."<th>Password </th>". " " ."<th>Phone </th></tr>";

  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "<tr><td>" . " " . $row["USERNAME"] . " </td><td>" . " " . $row["ADDRESS"] . " </td><td>" . " " . $row["PASSWORD"] . "</td><td>"
      . " " . $row["PHONE"] . "</td></tr>"; //or just use "echo $row[0]" 
  }
  echo "</table>";

}

// Connect Oracle...
if ($db_conn) {
    if (!is_writable(session_save_path())) {
          echo "<div class='alert alert-danger' role='alert'>";
    echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Error:</span>";
      echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
    echo "</div>";
    }
    if(array_key_exists('Login', $_POST)) {
        
        $users = $_POST['username'];
        $passw = $_POST['password'];

      //oci_execute(,OCI_DEFAULT);
      $result = executePlainSQL("select username from customers where username = '$users' and password = '$passw'");
      $numrows = oci_fetch_all($result, $res);
      if($numrows == 0){
            echo "<div class='alert alert-danger' role='alert'>";
    echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Error:</span>";

        echo "Invalid User or Password.";
    echo "</div>";
      }
      if($numrows == 1){
        $_SESSION['username'] = $users;
        echo $_SESSION['username'];
        $_SESSION['permissions'] = "USER";
        echo $_SESSION['permissions'];
        header("location: index.php");
      }
      //echo "Printing number of items: " . $result;
    }
    OCICommit($db_conn);

    //Commit to save changes...
    OCILogoff($db_conn);
   // printResult($result);
    //Commit to save changes...
} else {

  $e = OCI_Error(); // For OCILogon errors pass no handle
  echo htmlentities($e['message']);
    echo "<div class='alert alert-danger' role='alert'>";
    echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Error:</span>";
		echo htmlentities($e['message']);
  echo "cannot connect";
    echo "</div>";
}
?>
