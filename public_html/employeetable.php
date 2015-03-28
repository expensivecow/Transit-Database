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
              <li><a href="index.php">Home</a></li>
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
      <h2>Employees</h2>       
        <table class="table table-striped">
          <thead>
            <tr>
              <th>SIN</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Username</th>
              <th>Password</th>
              <th>Wage</th>
              <th>Job Type</th>
              <th>Work Schedule</th>
            </tr>
          </thead>
        <?php
        $conn = oci_connect("ora_h3g8", "a35788116", "ug");
        $results = oci_parse($conn, "select * from employees");
        oci_execute($results);
        while ($row = oci_fetch_array($results, OCI_BOTH)) {
		echo "<tr><td>".$row["SIN"] . "</td><td>" . $row["NAME"] ."</td><td>" . $row["PHONE"]  ."</td><td>" . $row["ADDRESS"]  ."</td><td>" . $row["USERNAME"]  ."</td><td>" . $row["PASSWORD"]  ."</td><td>" . $row["WAGE"]  ."</td><td>" . $row["JOBT"]  ."</td><td>" . $row["WORKS"] . "</td></tr>"; //or just use "echo $row[0]" 
        }
        oci_close($conn);
        ?>
        </table>

      <h2>Vehicles</h2>       
        <table class="table table-striped">
          <thead>
            <tr>
              <th>VID</th>
              <th>Capacity</th>
              <th>Mode</th>
              <th>Cost</th>
              <th>Model</th>
              <th>Age</th>
            </tr>
          </thead>
        <?php
        $conn = oci_connect("ora_h3g8", "a35788116", "ug");
        $results = oci_parse($conn, "select * from vehicles");
        oci_execute($results);
        while ($row = oci_fetch_array($results, OCI_BOTH)) {
		echo "<tr><td>" . $row["VID"] . "</td><td>" . $row["CAPACITY"] ."</td><td>" . $row["VMODE"]  ."</td><td>" . $row["COST"]  ."</td><td>" . $row["MODEL"]  ."</td><td>" . $row["AGE"]  ."</td></tr>"; //or just use "echo $row[0]" 
          
        }
        oci_close($conn);
        ?>
        </table>


      <h2>Vehicles operated by Employees</h2>       
        <table class="table table-striped">
          <thead>
            <tr>
              <th>SIN</th>
              <th>VID</th>
            </tr>
          </thead>
        <?php
        $conn = oci_connect("ora_h3g8", "a35788116", "ug");
        $results = oci_parse($conn, "select * from OperatedBy");
        oci_execute($results);
        while ($row = oci_fetch_array($results, OCI_BOTH)) {
		echo "<tr><td>" . $row["SIN"] . "</td><td>" . $row["VID"]  ."</td></tr>"; //or just use "echo $row[0]" 
          
        }
        oci_close($conn);
        ?>
        </table>



      </div>
</body>

