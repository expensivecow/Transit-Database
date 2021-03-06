<?php session_save_path("/home/p/p2n8/php");
  session_start();?>
<?php if($_SESSION["permissions"] == "EMPLOYEE" || $_SESSION["permissions"] == "MANAGER"):?>
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
            <li><a href="http://www.omfgdogs.com">Contact</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="changepass.php">Change Password</a></li>
            <li><a href="signout.php">Sign Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="starter-template">
        <font size ="6"><?php echo "<center><p class='lead2'>Welcome ". $_SESSION['username'] . "!" . "</p></center>";?></font>
        <font size ="4">
        <?php

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
          function printResult($result) { //prints results from a select statement
              echo "<br>Employee Info<br>";
              echo "<table class='table table-striped'>";
              echo "<tr><th>Username</th>". " " ."<th>Wage</th>". " " ."<th>Job Type</th>". " " ."<th>Work Schedule</th></tr>";

              while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                 echo "<tr><td>" . $row["USERNAME"] . " </td><td>" . $row["WAGE"] . " </td><td>" . $row["JOBT"] . "</td><td>"
                 . " " . $row["WORKS"] . "</td></tr>"; //or just use "echo $row[0]" 
              }
              echo "</table>";
          }

        // Connect Oracle...
        if ($db_conn) {
            $users = $_SESSION["username"];
            printResult(executePlainSQL("select * from employee where username = '$users'"));

            OCICommit($db_conn);
        }
        ?>
        </font>
      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
<?php else:
  echo "ACCESS DENIED";
  endif;
?>