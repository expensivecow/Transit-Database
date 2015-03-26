
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
    <link href="register.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<form class="form-horizontal" action='' method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Register</legend>
    </div>
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="username">Username</label>
      <div class="controls">
        <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
        <p class="help-block">Username can contain any letters or numbers, without spaces</p>
      </div>
    </div>

    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="password">Password</label>
      <div class="controls">
        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
        <p class="help-block">Password should be at least 4 characters</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="address">Address</label>
      <div class="controls">
        <input type="text" id="address" name="address" placeholder="" class="input-xlarge">
        <p class="help-block">Please provide your address</p>
      </div>
    </div>

    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="address">Phone Number</label>
      <div class="controls">
        <input type="text" id="pnumber" name="pnumber" placeholder="" class="input-xlarge">
        <p class="help-block">Please provide your phone number</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button type="submit" value="Register" class="btn btn-success" name ="register">Register</button>
      </div>
    </div>
  </fieldset>
</form>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>

<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_p2n8", "a36523124", "ug");

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
  //echo "<br>running ".$cmdstr."<br>";
  global $db_conn, $success;
  $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

  if (!$statement) {
    echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
    $e = OCI_Error($db_conn); // For OCIParse errors pass the       
    // connection handle
    echo htmlentities($e['message']);
    $success = False;
  }

  $r = OCIExecute($statement, OCI_DEFAULT);
  if (!$r) {
    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
    $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
    echo htmlentities($e['message']);
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
    echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
    $e = OCI_Error($db_conn);
    echo htmlentities($e['message']);
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
      echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
      echo "<script> var data = <?php echo $cmdstr; ?> alert(data);</script>";
      $e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
      echo htmlentities($e['message']);
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
      . " " . $row["PNUMBER"] . "</td></tr>"; //or just use "echo $row[0]" 
  }
  echo "</table>";

}

// Connect Oracle...
if ($db_conn) {
    if (array_key_exists('register', $_POST)) {
      //Getting the values from user and insert data into the table
      $tuple = array (
        ":bind1" => $_POST['username'],
        ":bind2" => $_POST['address'],
        ":bind3" => $_POST['password'],
        ":bind4" => $_POST['pnumber'],
      );
      $alltuples = array (
        $tuple
      );
      executeBoundSQL("insert into customers values (:bind1, :bind2, :bind3, :bind4, null)", $alltuples);
      OCICommit($db_conn);
    }

  if ($_POST && $success) {
    //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
    header("location: register.php");
  } else {
    // Select data...
    $result = executePlainSQL("select * from customers");
    printResult($result);
  }

  //Commit to save changes...
  OCILogoff($db_conn);
} else {
  echo "cannot connect";
  $e = OCI_Error(); // For OCILogon errors pass no handle
  echo htmlentities($e['message']);
}