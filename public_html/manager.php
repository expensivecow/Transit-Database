
<!--Test Oracle file for UBC CPSC304 2011 Winter Term 2
  Created by Jiemin Zhang
  Modified by Simona Radu
  This file shows the very basics of how to execute PHP commands
  on Oracle.  
  specifically, it will drop a table, create a table, insert values
  update values, and then query for values
 
  IF YOU HAVE A TABLE CALLED "tab1" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->
<html lang = "en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Managers</title>
<link href="css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link href="starter-template.css" rel="stylesheet">
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
              <li><a href="main">Home</a></li>
              <li><a href="http://www.cs.ubc.ca/~laks/cpsc304/project.html">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>

<div class="container">
<h1>Manager functions:</h1>
<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>
<form method="POST" action="manager.php">
<p><input type="submit" value="Reset" name="reset"></p>
</form>


<h3>Insert values into employees below:</h3>
<form method="POST" action="manager.php">
<!--refresh page when submit-->
<p>
<font size="2">SIN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eSin" size="6"><br>
<font size="2">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eName" size="18"><br>
<font size="2">Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="ePhone" size="18"><br>
<font size="2">Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eAddress" size="18"><br>
<font size="2">Username:&nbsp;&nbsp;</font><input type="text" name="eUsername" size="18"><br>
<font size="2">Password:&nbsp;&nbsp;&nbsp;</font><input type="text" name="ePassword" size="18"><br>
<font size="2">Wage:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eWage" size="18"><br>
<font size="2">Job Type:&nbsp;&nbsp;&nbsp;</font><input type="text" name="eJobt" size="18"><br>
<font size="2">Work schedule:&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eWorks" size="18">

<!--define two variables to pass the value-->
<input type="submit" value="insert" name="insertsubmit"></p>
</form>


<!-- create a form to pass the values. See below for how to 
get the values--> 
<h3> Update the name by inserting the SIN and new values below: </h3>
<form method="POST" action="manager.php">
<!--refresh page when submit-->

<p>
<font size="2">&nbsp;SIN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eSin" size="8"><br><br>
<font size="2">&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<font size="2">Phone&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<font size="2">Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<font size="2">Wage&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<font size="2">Job Type&nbsp;&nbsp;&nbsp;</font>
<font size="2">Work schedule&nbsp;&nbsp;&nbsp;&nbsp;</font><br>
<input type="text" name="eName" size="8"><input type="text" name="ePhone" size="8"><input type="text" name="eAddress" size="8"><input type="text" name="eWage" size="8"><input type="text" name="eJobt" size="8"><input type="text" name="eWorks" size="8">
<!--define two variables to pass the value-->
<br>      
<input type="submit" value="update" name="updatesubmit"></p>
<input type="submit" value="run hardcoded queries" name="dostuff"></p>
</form>


<h3> Selection and projection query </h3>
<p>
<form method="POST" action="manager.php">
<!--refresh page when submit-->

<p>
<font size="2">Projection:&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="projection" size="6"><br>
</p>

<p>
<font size="2">Selection:</font><br>
<!--
<font size="2">SIN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eSin" size="6"><br>
<font size="2">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eName" size="18"><br>
<font size="2">Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="ePhone" size="18"><br>
<font size="2">Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eAddress" size="18"><br>
<font size="2">Wage:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eWage" size="18"><br>
<font size="2">Job Type:&nbsp;&nbsp;&nbsp;</font><input type="text" name="eJobt" size="18"><br>
<font size="2">Work schedule:&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eWorks" size="18">
-->

<font size="2">&nbsp;SIN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<font size="2">&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<font size="2">Phone&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<font size="2">Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<font size="2">Wage&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<font size="2">Job Type&nbsp;&nbsp;&nbsp;</font>
<font size="2">Work schedule&nbsp;&nbsp;&nbsp;&nbsp;</font><br>
<input type="text" name="eSin" size="8"><input type="text" name="eName" size="8"><input type="text" name="ePhone" size="8"><input type="text" name="eAddress" size="8"><input type="text" name="eWage" size="8"><input type="text" name="eJobt" size="8"><input type="text" name="eWorks" size="8">
<!--define two variables to pass the value-->
      
<input type="submit" value="query" name="selectionsubmit"></p>
</form>

<h4> Assign vehicles </h4>
<p>
<form method="POST" action="manager.php">
<!--refresh page when submit-->
<font size="2">Assign employee(SIN) to vehicle(vid)</font><br>
<font size="2">&nbsp;SIN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><font size="2">VID</font>
<br>
<!--define two variables to pass the value-->
      <input type="text" name="eSin" size="6">
<input type="text" name="vid" size="6"><br>

<input type="submit" value="assign" name="assignsubmit"></p>
</form>

<h4> Delete </h4>
<p>
<form method="POST" action="manager.php">
<!--refresh page when submit-->
<font size="2">Delete element from a table:</font><br>
<font size="2">Employee(SIN):&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eSin" size="6"><br>
<font size="2">Vehicle(vid):&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="vid" size="6"><br>
<!--define two variables to pass the value-->
<input type="submit" value="delete" name="deletesubmit"></p>
</form>
</div>
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

function executeSQL($cmdstr) {

	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);
	$success = False;

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

		
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}else{

}
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
			$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
			echo htmlentities($e['message']);
			echo "<br>";
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
	echo "<br>Result of projection query:<br>";
	echo "<table>";
	if(strpos($column, '*') !== FALSE){
		echo "<tr><th>SIN</th><th>Name</th><th>Phone</th><th>Address</th><th>Username</th><th>Password</th><th>Wage</th><th>Job Type</th><th>Work Schedule</th></tr>";
	} else{
		echo "<tr><th><b>$column</b></th></tr>";
	}
	while($row = OCI_FETCH_Array($result, OCI_BOTH)){
		echo "<tr><td>".$row["SIN"]."</td><td>".$row["NAME"]."</td><td>".$row["PHONE"]."</td><td>".$row["ADDRESS"]."</td><td>".$row["USERNAME"]."</td><td>".$row["PASSWORD"]."</td><td>".$row["WAGE"]."</td><td>".$row["JOBT"]  ."</td><td>".$row["WORKS"]."</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";




}

function printEmployees($result) { //prints results from a select statement
	echo "<br>employees:<br>";
	echo "<table>";
	echo "<tr><th>SIN</th><th>Name</th><th>Phone</th><th>Address</th><th>Username</th><th>Password</th><th>Wage</th><th>Job Type</th><th>Work Schedule</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>".$row["SIN"] . "</td><td>" . $row["NAME"] ."</td><td>" . $row["PHONE"]  ."</td><td>" . $row["ADDRESS"]  ."</td><td>" . $row["USERNAME"]  ."</td><td>" . $row["PASSWORD"]  ."</td><td>" . $row["WAGE"]  ."</td><td>" . $row["JOBT"]  ."</td><td>" . $row["WORKS"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";

}


function printVehicles($result) { //prints results from a select statement
	echo "<br>vehicles:<br>";
	echo "<table>";
	echo "<tr><th>vid</th><th>Capacity</th><th>Mode of Transport</th><th>Cost</th><th>Model</th><th>Age</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["VID"] . "</td><td>" . $row["CAPACITY"] ."</td><td>" . $row["VMODE"]  ."</td><td>" . $row["COST"]  ."</td><td>" . $row["MODEL"]  ."</td><td>" . $row["AGE"]  ."</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";

}


function printOperatedBy($result) { //prints results from a select statement
	echo "<br>OpeartedBy:<br>";
	echo "<table>";
	echo "<tr><th>sin</th><th>vid</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["SIN"] . "</td><td>" . $row["VID"]  ."</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";

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
		executePlainSQL("create table employees (sin number, name varchar2(30), phone number, address varchar2(30), username varchar2(20), password varchar2(20), wage number, jobt varchar(10), works varchar(7), primary key (sin))");
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
				executeSQL($query);
				OCICommit($db_conn);

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
//					executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $allrows); //the function takes a list of lists
					// Update data...
					//executePlainSQL("update tab1 set nid=10 where nid=2");
					// Delete data...
					//executePlainSQL("delete from tab1 where nid=1");
					OCICommit($db_conn);
				}  else
				if (array_key_exists('selectionsubmit', $_POST)) {
/*
					if(!empty($_POST['projection'])){
						$pro = $_POST['projection'];
						$result = preg_replace('/[ ]+/',',', trim($pro));
						$query = "select ";
						$query .= "$result from employees";
			//			echo $query;
						$employees = executePlainSQL($query);
			//			printEmployees($employees);
						printProjection($employees, $pro);
				}*/					
				
				
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
				$query="select ";
				if(empty($_POST['projection'])){
					$pro = '*';
				}
				$query.=(!empty($_POST['projection']))? "'$result' from employees ":"* from employees "; 

				$query = clean($query);
				if(!empty($_POST['eSin'])||!empty($_POST['eName'])||!empty($_POST['ePhone'])||!empty($_POST['eAddress'])||!empty($_POST['eUsername'])||!empty($_POST['ePassword'])||!empty($_POST['eWage'])||!empty($_POST['eJobt'])||!empty($_POST['eWorks']))
				{
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
				echo $query;
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
				}

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

		$employees = executePlainSQL("select * from employees");
		$vehicles = executePlainSQL("select * from vehicles");
		$operatedby = executePlainSQL("select * from operatedby");
		printEmployees($employees);
		printVehicles($vehicles);
		printOperatedBy($operatedby);
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

