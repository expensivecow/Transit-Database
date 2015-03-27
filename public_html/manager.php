<?php session_save_path("/home/p/p2n8/php");
  session_start();?>
<?php if(($_SESSION['permissions'] == "MANAGER")) : ?>
<html lang = "en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Managers</title>
<link href="css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link href="main/starter-template.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<style type="text/css">
    .bs-example{
    	margin: 20px;
    }
</style>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
       <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-e    xpanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Transit</a>
          </div>
          <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li><a href="./index.php">Home</a></li>
              <li><a href="http://www.cs.ubc.ca/~laks/cpsc304/project.html">About</a></li>
              <li><a href="http://www.omfgdogs.com">Contact</a></li>
              <li><a href="employeetable.php">Employee Table</a></li>
            </ul>
          	<ul class="nav navbar-nav navbar-right">
              <li><a href="changepass.php">Change Password</a></li>
              <li><a href="signout.php">Sign Out</a></li>
          	</ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
<div class="container">
<?php
//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_h3g8", "a35788116", "ug");

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
		#echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
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
		#echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
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
		#	echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
    echo "<div class='alert alert-danger' role='alert'>";
    echo "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Error:</span>";
		echo htmlentities($e['message']);
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
    echo "</div>";
			$success = False;
		}
	}

}


function printResult($result) { //prints results from a select statement
	echo "<br>Got data from table tab1:<br>";
	echo "<table>";
	echo "<tr><th>ID</th><th>Name</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["NID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";

}

function printProjection($result, $column){
  echo "<div class=container>";
  echo "<h3>Result of projection/selection query:</h3>";
	echo "<table class='table table-striped'>";
	if(strpos($column, '*') !== FALSE){
		echo "<tr><th>SIN</th><th>Name</th><th>Phone</th><th>Address</th><th>Username</th><th>Password</th><th>Wage</th><th>Job Type</th><th>Work Schedule</th></tr>";
	} else{
    $data = preg_split('/\s+/', $column);
    echo "<tr>";
    for ($x = 0; $x < count($data); $x++){
      echo "<th>$data[$x]</th>";
    }
		echo "</tr>";
	}
	while($row = OCI_FETCH_Array($result, OCI_BOTH)){
		echo "<tr><td>".$row["SIN"]."</td><td>".$row["NAME"]."</td><td>".$row["PHONE"]."</td><td>".$row["ADDRESS"]."</td><td>".$row["USERNAME"]."</td><td>".$row["PASSWORD"]."</td><td>".$row["WAGE"]."</td><td>".$row["JOBT"]  ."</td><td>".$row["WORKS"]."</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
  echo "</div>";



}

function printEmployees($result) { //prints results from a select statement
  echo "<div class=container>";
  echo "<h3>Employees</h3>";
	echo "<table class='table table-striped'>";
	echo "<tr><th>SIN</th><th>Name</th><th>Phone</th><th>Address</th><th>Username</th><th>Password</th><th>Wage</th><th>Job Type</th><th>Work Schedule</th></tr>";
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>".$row["SIN"] . "</td><td>" . $row["NAME"] ."</td><td>" . $row["PHONE"]  ."</td><td>" . $row["ADDRESS"]  ."</td><td>" . $row["USERNAME"]  ."</td><td>" . $row["PASSWORD"]  ."</td><td>" . $row["WAGE"]  ."</td><td>" . $row["JOBT"]  ."</td><td>" . $row["WORKS"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
  echo "</div>";

}


function printVehicles($result) { //prints results from a select statement
  echo "<div class=container>";
  echo "<h3>Vehicles</h3>";
	echo "<table class='table table-striped'>";
	echo "<tr><th>vid</th><th>Capacity</th><th>Mode of Transport</th><th>Cost</th><th>Model</th><th>Age</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["VID"] . "</td><td>" . $row["CAPACITY"] ."</td><td>" . $row["VMODE"]  ."</td><td>" . $row["COST"]  ."</td><td>" . $row["MODEL"]  ."</td><td>" . $row["AGE"]  ."</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
  echo "</div>";
}


function printOperatedBy($result) { //prints results from a select statement

  echo "<div class=container>";
  echo "<h3>OperatedBy</h3>";
	echo "<table class='table table-striped'>";
	echo "<tr><th>sin</th><th>vid</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["SIN"] . "</td><td>" . $row["VID"]  ."</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
  echo "</div>";

}

function printJoin($result){
  echo "<div class=container>";
  echo "<h3>Currently assigned vehicles (JOIN Query) </h3>";
	echo "<table class='table table-striped'>";
  echo "<tr><th>sin</th><th>name</th><th>vid</th><th>vmode</th></tr>";
  while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
    echo "<tr><td>" . $row["SIN"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["VID"]. "</td><td>" . $row["VMODE"] . "</td></tr>";

  }

  echo "</table>";
  echo "</div>";
}

function printEmployeeCount($result){
  echo "<div class=container>";
  echo "<p class=lead>Total employees registered: ";
  while($row = OCI_FETCH_Array($result, OCI_BOTH)){
   echo $row[0];

 }
    echo "</p>";
  echo "</div>";

}

function printVehicleCount($result){
  echo "<div class=container>";
  echo "<p class=lead>Total vehicles registered: ";
 while($row = OCI_FETCH_Array($result, OCI_BOTH)){
  echo $row[0];
 }
  echo "</p>";
  echo "</div>";

}

function printNested($result, $minmax){
  echo "<div class=container>";
  echo "<h3>Showing the ".$minmax." of average wage of job types: </h3>";
	echo "<table class='table table-striped'>";
  echo "<tr><th>Wage</th></tr>";
  
 while($row = OCI_FETCH_Array($result, OCI_BOTH)){
  echo "<tr><td>" . $row[0] . "</td></tr>";
 }
  echo "</table>";
  echo "</div>";

}

function printDivide($result){
  echo "<div class=container>";
	echo "<table class='table table-striped'>";
  echo "<h3>Displaying employees not assigned to a vehicle</h3>";
  echo "<tr><th>sin</th><th>name</th><th>phone</th></tr>";
  while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
    echo "<tr><td>" . $row["SIN"] . "</td><td>" . $row["NAME"] ."</td><td>" . $row["PHONE"]. "</td></tr>";
  }

  echo "</table>";
  echo "</div>";

}

function clean($string) {
//   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return str_replace("'", "", $string); // Removes special chars.
}


// Connect Oracle...
if ($db_conn) {
  




	if (array_key_exists('reset', $_POST)) {
		// Drop old table...
		echo "<br> dropping table <br>";
	//	executePlainSQL("Drop table tab1");
		executePlainSQL("Drop table operatedby");
		executePlainSQL("Drop table employees");
		executePlainSQL("Drop table vehicles");

		// Create new table...
		echo "<br> creating new table <br>";
	//	executePlainSQL("create table tab1 (nid number, name varchar2(30), primary key (nid))");
		executePlainSQL("create table employees (sin number, name varchar2(30), phone number, address varchar2(30), username varchar2(20), password varchar2(20), wage number, jobt varchar(10), works varchar(10), primary key (sin))");
		executePlainSQL("create table vehicles (vid number, capacity number, vmode varchar2(7), cost number, model varchar2(30), age number, primary key(vid))");
		executePlainSQL("create table operatedby (sin number NOT NULL UNIQUE, vid number NOT NULL UNIQUE, foreign key(sin) references employees(sin) on delete cascade, foreign key(vid) references vehicles(vid) on delete cascade )");
		OCICommit($db_conn);

	} else
		if (array_key_exists('insertsubmit', $_POST)) {
			//Getting the values from user and insert data into the table
			$tuple = array (
	//			":bind1" => $_POST['insNo'],
	//			":bind2" => $_POST['insName'],
				":bind3" => $_POST['eSin'],
				":bind4" => $_POST['eName'],
				":bind5" => $_POST['ePhone'],
				":bind6" => $_POST['eAddress'],
				":bind7" => $_POST['eUsername'],
				":bind8" => $_POST['ePassword'],
				":bind9" => $_POST['eWage'],
				":bind10" => $_POST['eJobt'],
				":bind11" => $_POST['eWorks']
			);
			$alltuples = array (
				$tuple
			);
		//	executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $alltuples);
			executeBoundSQL("insert into employees values (:bind3, :bind4, :bind5, :bind6, :bind7, :bind8, :bind9, :bind10, :bind11 )", $alltuples);
			OCICommit($db_conn);

		} else
			if (array_key_exists('updatesubmit', $_POST)) {
      if(!empty($_POST['eSin'])){	
				$sin = $_POST['eSin'];
				$name = $_POST['eName'];
				$phone = $_POST['ePhone'];
				$address = $_POST['eAddress'];
				$username = $_POST['eUsername'];
				$password = $_POST['ePassword'];
				$wage = $_POST['eWage'];
				$jobt = $_POST['eJobt'];
				$works = $_POST['eWorks'];

				$query="update employees set ";
				$query.=(!empty($_POST['eName']))? "name = '$name',":"";
				$query.=(!empty($_POST['ePhone']))? "phone=$phone,":"";
				$query.=(!empty($_POST['eAddress']))? "address='$address',":"";
				$query.=(!empty($_POST['eUsername']))? "username='$username',":"";
				$query.=(!empty($_POST['ePassword']))? "password='$password',":"";
				$query.=(!empty($_POST['eWage']))? "wage=$wage,":"";
				$query.=(!empty($_POST['eJobt']))? "jobt='$jobt',":"";
				$query.=(!empty($_POST['eWorks']))? "works='$works',":"";
				$query=substr($query,0,-1);
				$query.=" where sin = $sin";
				// Update tuple using data from user
				executePlainSQL($query);
				OCICommit($db_conn);
      }
			} else
				if (array_key_exists('dostuff', $_POST)) {
					// Insert data into table...
					executePlainSQL("insert into employees values (10, 'Frank',604,'ubc','test','pass',10,'driver','WTF')");
					executePlainSQL("insert into employees values (11, 'Jeff',604,'ubc','test','pass',10,'driver','WTF')");
					executePlainSQL("insert into employees values (12, 'Manning',604,'ubc','test','pass',10,'driver','WTF')");
					executePlainSQL("insert into vehicles values (15,5,'taxi',3,'abc',5)");
					// Inserting data into table using bound variables
					$list1 = array (
						":bind1" => 6,
						":bind2" => "All"
					);
					$list2 = array (
						":bind1" => 7,
						":bind2" => "John"
					);
					$allrows = array (
						$list1,
						$list2
					);

					OCICommit($db_conn);
				}  else
				if (array_key_exists('selectionsubmit', $_POST)) {
				
					$sin = $_POST['eSin'];
					$name = $_POST['eName'];
					$phone = $_POST['ePhone'];
					$address = $_POST['eAddress'];
					$username = $_POST['eUsername'];
					$password = $_POST['ePassword'];
					$wage = $_POST['eWage'];
					$jobt = $_POST['eJobt'];
					$works = $_POST['eWorks'];
					$pro = $_POST['projection']; 
				if(!empty($_POST['projection'])){
					$result = preg_replace('/[ ]+/',',', trim($pro));
				}
				if(!empty($_POST['eSin'])||!empty($_POST['eName'])||!empty($_POST['ePhone'])||!empty($_POST['eAddress'])||!empty($_POST['eUsername'])||!empty($_POST['ePassword'])||!empty($_POST['eWage'])||!empty($_POST['eJobt'])||!empty($_POST['eWorks']))
				{

				$query="select ";
				if(empty($_POST['projection'])){
					$pro = '*';
				}
				$query.=(!empty($_POST['projection']))? "'$result' from employees ":"* from employees "; 

				$query = clean($query);
					$query.="where ";
				$query.=(!empty($_POST['eSin']))? "sin = '$sin',":"";
				$query.=(!empty($_POST['eName']))? "lower(name) like lower('%$name%'),":"";
				$query.=(!empty($_POST['ePhone']))? "phone='$phone',":"";
				$query.=(!empty($_POST['eAddress']))? "address='$address',":"";
				$query.=(!empty($_POST['eUsername']))? "username='$username',":"";
				$query.=(!empty($_POST['ePassword']))? "password='$password',":"";
				$query.=(!empty($_POST['eWage']))? "wage='$wage',":"";
				$query.=(!empty($_POST['eJobt']))? "jobt='$jobt',":"";
				$query.=(!empty($_POST['eWorks']))? "works='$works',":"";
				$query=substr($query,0,-1);
				};
				#echo $query;
				$employees = executePlainSQL($query);	
				printProjection($employees, $pro);

				} else
				if (array_key_exists('assignsubmit', $_POST)){
						if(!empty($_POST['eSin']) && !empty($_POST['vid'])){
							
						$sin = $_POST['eSin'];
						$vid = $_POST['vid'];
						executePlainSQL("insert into operatedby values ($sin, $vid)");				
						OCICommit($db_conn);
						}

				} else
				if (array_key_exists('deletesubmit', $_POST)){
					if(!empty($_POST['eSin'])){
						$sin = $_POST['eSin'];
						executePlainSQL("delete from employees where sin=$sin");						
					}
					if(!empty($_POST['vid'])){
						$vid = $_POST['vid'];
						executePlainSQL("delete from vehicles where vid=$vid");

					}

					OCICommit($db_conn);
        } else
        if (array_key_exists('joinsubmit', $_POST)){
          $query = "select e.sin, e.name, v.vid, v.vmode from employees e ";
          if(!empty($_POST['join'])){
          $join = $_POST['join'];
         
          $query .= "$join OperatedBy ob on e.sin = ob.sin $join vehicles v on ob.vid = v.vid";
          $table = executePlainSQL($query);
          printJoin($table); 
          }

        } else
          if (array_key_exists('nestsubmit', $_POST)){
            $minmax = $_POST['nest'];          
            $query = "select $minmax(avg(wage)) from employees group by jobt"; 
            $result = executePlainSQL($query);
            printNested($result, $minmax);
          } else
            if (array_key_exists('dividesubmit', $_POST)){
            $query = "select e.sin, e.name, e.phone from employees e where not exists (select ob.sin from OperatedBy ob where ob.sin = e.sin)";
            #$query = "select e.sin, e.name from employees e where not exists ((select v.vid from vehicles v) except (select ob.vid from OperatedBy ob where ob.sid = e.sin))";
            $result = executePlainSQL($query);
            printDivide($result);
            } else
              if (array_key_exists('vinsertsubmit',$_POST)){
			//Getting the values from user and insert data into the table
			$tuple = array (
	//			":bind1" => $_POST['insNo'],
	//			":bind2" => $_POST['insName'],
				":bind1" => $_POST['vid'],
				":bind2" => $_POST['capacity'],
				":bind3" => $_POST['vmode'],
				":bind4" => $_POST['cost'],
				":bind5" => $_POST['model'],
				":bind6" => $_POST['age']
			);
			$alltuples = array (
				$tuple
			);
		//	executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $alltuples);
			executeBoundSQL("insert into vehicles values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6 )", $alltuples);
			OCICommit($db_conn);
              } else
                if (array_key_exists('vupdatesubmit',$_POST)){
      if(!empty($_POST['vid'])){
				$vid = $_POST['vid'];
				$capacity = $_POST['capacity'];
				$vmode = $_POST['vmode'];
				$cost = $_POST['cost'];
				$model = $_POST['model'];
				$age = $_POST['age'];

				$query="update vehicles set ";
				$query.=(!empty($_POST['capacity']))? "capacity=$capacity,":"";
				$query.=(!empty($_POST['vmode']))? "vmode='$vmode',":"";
				$query.=(!empty($_POST['cost']))? "cost='$cost',":"";
				$query.=(!empty($_POST['model']))? "model='$model',":"";
				$query.=(!empty($_POST['age']))? "age='$age',":"";
				$query=substr($query,0,-1);
				$query.=" where vid = $vid";
				// Update tuple using data from user
				executePlainSQL($query);
				OCICommit($db_conn);
      }
                }

    $counte = executePlainSQL("select count(*) from employees");
    $countv = executePlainSQL("select count(*) from vehicles");
    printEmployeeCount($counte);
    printVehicleCount($countv);
		$employees = executePlainSQL("select * from employees");
		$vehicles = executePlainSQL("select * from vehicles");
		$operatedby = executePlainSQL("select * from operatedby");
		printEmployees($employees);
		printVehicles($vehicles);
		printOperatedBy($operatedby);

/*
	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: oracle-test.php");
	} else {
		// Select data...
	//	$result = executePlainSQL("select * from tab1");
		$employees = executePlainSQL("select * from employees");
		$vehicles = executePlainSQL("select * from vehicles");
		$operatedby = executePlainSQL("select * from operatedby");
	//	printResult($result);
		printEmployees($employees);
		printVehicles($vehicles);
		printOperatedBy($operatedby);
	}*/
    
	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database
     You will need to replace "username" and "password" for this to
     to work. 
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment 
     statement */

/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode. 
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode */

/* OCI_Fetch_Array() Returns the next row from the result data as an  
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an 
     optinal second parameter which can be any combination of the 
     following constants:

     OCI_BOTH - return an array with both associative and numeric 
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default 
     behavior.  
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc() 
     works).  
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).  
     OCI_RETURN_NULLS - create empty elements for the NULL fields.  
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.  
     Default mode is OCI_BOTH.  */
?>


<h1>Manager functions:</h1>
<!--
<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>
<form method="POST" action="manager.php">
<p><input type="submit" value="Reset" name="reset"></p>
</form>
-->
<!--
<form method="POST" action= "manager.php" class="navbar-form navbar-left" >
  <div class="form-group">
    <input type="text" name="eSin" class="form-control" placeholder="SIN">
    <input type="text" name="eName" class="form-control" placeholder="Name"><br>
    <input type="text" name="ePhone" class="form-control" placeholder="Phone"><br>
    <input type="text" name="eAddress" class="form-control" placeholder="Address"><br>
    <input type="text" name="eUsername" class="form-control" placeholder="Username"><br>
    <input type="text" name="ePassword" class="form-control" placeholder="Password"><br>
    <input type="text" name="eWage" class="form-control" placeholder="Wage"><br>
    <input type="text" name="eJobt" class="form-control" placeholder="Job Type"><br>
    <input type="text" name="eWorks" class="form-control" placeholder="Work Schedule"><br>
  </div>
  <br>
  <button type="submit" name="insertsubmit" class="btn btn-default">Submit</button>
</form>
-->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">
  Insert employee
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create new employee</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action= "manager.php"  >
        <div class="form-group">
      <input type="text" name="eSin" required class="form-control" placeholder="SIN"><br>
      <input type="text" name="eName" class="form-control" placeholder="Name"><br>
      <input type="text" name="ePhone" class="form-control" placeholder="Phone"><br>
      <input type="text" name="eAddress" class="form-control" placeholder="Address"><br>
      <input type="text" name="eUsername" class="form-control" placeholder="Username"><br>
      <input type="text" name="ePassword" class="form-control" placeholder="Password"><br>
      <input type="text" name="eWage" class="form-control" placeholder="Wage"><br>
      <input type="text" name="eJobt" class="form-control" placeholder="Job Type"><br>
      <input type="text" name="eWorks" class="form-control" placeholder="Work Schedule"><br>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="insertsubmit" class="btn btn-primary">Insert</button>
      </div>
        </form>
    </div>
  </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#updateModal">
  Update employee
</button>
<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="updateModalLabel">Update employee</h4>
      </div>
      <div class="modal-body">
        <p class="lead">Change the values of corresponding to SIN of an Employee:</p>
        <form method="POST" action= "manager.php"  >
        <div class="form-group">
      <input type="text" name="eSin" class="form-control" placeholder="SIN"><br><br>
      <input type="text" name="eName" class="form-control" placeholder="Name">
      <input type="text" name="ePhone" class="form-control" placeholder="Phone">
      <input type="text" name="eAddress" class="form-control" placeholder="Address">
      <input type="text" name="eUsername" class="form-control" placeholder="Username">
      <input type="text" name="ePassword" class="form-control" placeholder="Password">
      <input type="text" name="eWage" class="form-control" placeholder="Wage">
      <input type="text" name="eJobt" class="form-control" placeholder="Job Type">
      <input type="text" name="eWorks" class="form-control" placeholder="Work Schedule">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="updatesubmit" class="btn btn-primary">Update</button>
      </div>
        </form>
    </div>
  </div>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#projectionModal">
 Selection/Projection 
</button>
<!-- Modal -->
<div class="modal fade" id="projectionModal" tabindex="-1" role="dialog" aria-labelledby="projectionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="projectionModalLabel">Selection and Projection Query</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action= "manager.php"  >
        <div class="form-group">
      <p class="lead">Projection:</p> 
      <input type="text" name="projection" class="form-control" placeholder="Projection"><br><br>
      <p class="lead">Selection:</p><br> 
      <input type="text" name="eSin" class="form-control" placeholder="SIN">
      <input type="text" name="eName" class="form-control" placeholder="Name">
      <input type="text" name="ePhone" class="form-control" placeholder="Phone">
      <input type="text" name="eAddress" class="form-control" placeholder="Address">
      <input type="text" name="eUsername" class="form-control" placeholder="Username">
      <input type="text" name="ePassword" class="form-control" placeholder="Password">
      <input type="text" name="eWage" class="form-control" placeholder="Wage">
      <input type="text" name="eJobt" class="form-control" placeholder="Job Type">
      <input type="text" name="eWorks" class="form-control" placeholder="Work Schedule">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="selectionsubmit" class="btn btn-primary">Query</button>
      </div>
        </form>
    </div>
  </div>
</div>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#vinsertModal">
  Insert vehicle
</button>

<!-- Modal -->
<div class="modal fade" id="vinsertModal" tabindex="-1" role="dialog" aria-labelledby="vinsertModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="vinsertModalLabel">Insert new vehicle</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action= "manager.php"  >
        <div class="form-group">
      <input type="text" name="vid" class="form-control" placeholder="vehicle id"><br>
      <input type="text" name="capacity" class="form-control" placeholder="capacity"><br>
      <input type="text" name="vmode" class="form-control" placeholder="mode of transport"><br>
      <input type="text" name="cost" class="form-control" placeholder="cost of transport"><br>
      <input type="text" name="model" class="form-control" placeholder="model of vehicle"><br>
      <input type="text" name="age" class="form-control" placeholder="age of vehicle"><br>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="vinsertsubmit" class="btn btn-primary">Insert</button>
      </div>
        </form>
    </div>
  </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#vupdateModal">
  Update vehicle
</button>

<!-- Modal -->
<div class="modal fade" id="vupdateModal" tabindex="-1" role="dialog" aria-labelledby="vupdateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="vupdateModalLabel">Update vehicle</h4>
      </div>
      <div class="modal-body">
        <p class="lead">Insert new values corresponding to vehicle VID:</p>
        <form method="POST" action= "manager.php"  >
        <div class="form-group">
      <input type="text" name="vid" class="form-control" placeholder="vehicle id"><br><br>
      <input type="text" name="capacity" class="form-control" placeholder="capacity">
      <input type="text" name="vmode" class="form-control" placeholder="mode of transport">
      <input type="text" name="cost" class="form-control" placeholder="cost of transport">
      <input type="text" name="model" class="form-control" placeholder="model of vehicle">
      <input type="text" name="age" class="form-control" placeholder="age of vehicle">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="vupdatesubmit" class="btn btn-primary">Update</button>
      </div>
        </form>
    </div>
  </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#assignModal">
 Assign vehicle
</button>
<!-- Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="assignModalLabel">Assign employee(SIN) to vehicle(VID)</h4>
      </div>
      <div class="modal-body">
        <form method="POST" action= "manager.php"  >
        <div class="form-group">
      <p class="lead">Employee:</p> 
      <input type="text" name="eSin" class="form-control" placeholder="SIN"><br>
      <p class="lead">Vehicle:</p> 
      <input type="text" name="vid" class="form-control" placeholder="vid">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="assignsubmit" class="btn btn-primary">Assign</button>
      </div>
        </form>
    </div>
  </div>
</div>



<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#deleteModal">
  Delete
</button>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="deleteModalLabel">Deletion</h4>
      </div>
      <div class="modal-body">
        <p class="lead">Insert Employee(SIN) or Vehicle(VID) to delete:</p>
        <form method="POST" action= "manager.php"  >
        <div class="form-group">
    
      <p class="lead">Employee:</p> 
      <input type="text" name="eSin" class="form-control" placeholder="SIN"><br>

      <p class="lead">Vehicle:</p> 
      <input type="text" name="vid" class="form-control" placeholder="VID"><br>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="deletesubmit" class="btn btn-primary">Delete</button>
      </div>
        </form>
    </div>
  </div>
</div>
<br><br><br>
<h4> Show current employees' assigned vehicles (JOIN query) </h4>
<p>
<form method="POST" action="manager.php">
<!--refresh page when submit-->
<!--define two variables to pass the value-->
<select class="form-control" name="join" size="1">
  <option value="INNER JOIN" selected="selected">Inner join</option>
  <option value="LEFT JOIN">Left join</option>
  <option value="RIGHT JOIN">Right join</option>
  <option value="FULL JOIN">Full join</option>
</select>
<button type="submit" class="btn btn-default" name="joinsubmit">Show assigned vehicles</button>
</form>
<br>
<h4> Show min or max of average wage of employees (Nested aggregation with group-by) </h4>
<p>
<form method="POST" action="manager.php">
<!--refresh page when submit-->
<!--define two variables to pass the value-->
<select class="form-control" name="nest" size="1">
  <option value="MAX" selected="selected">Maximum</option>
  <option value="MIN">Minimum</option>
</select>
<button type="submit" class="btn btn-default" name="nestsubmit">Show min/max of average wage</button>
<!--
<input type="submit" value="Show min/max of average wage" name="nestsubmit"></p>
-->
</form>
<br>

<h4> Find employees who have not been assigned to a vehicle (Division Query) </h4>
<p>
<form method="POST" action="manager.php">
<!--refresh page when submit-->
<!--define two variables to pass the value-->
<button type="submit" class="btn btn-default" name="dividesubmit">Show unassigned employees</button>
<!--
<input type="submit" value="Show unassigned employees" name="dividesubmit"></p>
-->
</form>

</div>
</body>
<?php else : 
echo "ACCESS DENIED";
endif;?>
