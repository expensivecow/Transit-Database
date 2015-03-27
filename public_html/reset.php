<form method="POST" action="">
<p><input type="submit" value="Reset" name="reset"></p>
</form>

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

// Connect Oracle...
if ($db_conn) {
    if (array_key_exists('reset', $_POST)) {
    // Drop old table...
    echo "<br> dropping table <br>";
    executePlainSQL("Drop table customers");

    // Create new table...
    echo "<br> creating new table <br>";
    executePlainSQL("create table customers (username varchar2(30), address varchar2(30), password varchar2(30), pnumber varchar2(30),
     credit number, primary key (username))");

    echo "<br> dropping table <br>";
    executePlainSQL("Drop table employees");

    // Create new table...
    echo "<br> creating new table <br>";
    executePlainSQL("create table employees (username varchar2(30), address varchar2(30), password varchar2(30), pnumber varchar2(30),
     credit number, primary key (username))");

    echo "<br> dropping table <br>";
    executePlainSQL("Drop table vehicles");

    // Create new table...
    echo "<br> creating new table <br>";
    executePlainSQL("create table vehicles (username varchar2(30), address varchar2(30), password varchar2(30), pnumber varchar2(30),
     credit number, primary key (username))");

    echo "<br> dropping table <br>";
    executePlainSQL("Drop table managers");

    // Create new table...
    echo "<br> creating new table <br>";
    executePlainSQL("create table managers (username varchar2(30), address varchar2(30), password varchar2(30), pnumber varchar2(30),
     credit number, primary key (username))");

    echo "<br> dropping table <br>";
    executePlainSQL("Drop table branches");

    // Create new table...
    echo "<br> creating new table <br>";
    executePlainSQL("create table branches (username varchar2(30), address varchar2(30), password varchar2(30), pnumber varchar2(30),
     credit number, primary key (username))");

    echo "<br> dropping table <br>";
    executePlainSQL("Drop table schedules");

    // Create new table...
    echo "<br> creating new table <br>";
    executePlainSQL("create table schedules (username varchar2(30), address varchar2(30), password varchar2(30), pnumber varchar2(30),
     credit number, primary key (username))");

    echo "<br> creating new table <br>";
    executePlainSQL("create table schedules (username varchar2(30), address varchar2(30), password varchar2(30), pnumber varchar2(30),
     credit number, primary key (username))");

    OCICommit($db_conn);

    }
    
  if ($_POST && $success) {
    //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
    header("location: index.php");
  } else {
    // Select data...
    $result = executePlainSQL("select * from customers");
  }

  //Commit to save changes...
  OCILogoff($db_conn);
} else {
  echo "cannot connect";
  $e = OCI_Error(); // For OCILogon errors pass no handle
  echo htmlentities($e['message']);
}