
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
<link rel="stylesheet" type="test/css" href="style.css">
</head>
<a href="vehicles.php">Show Vehicles</a>
<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>
<form method="POST" action="manager.php">
<p><input type="submit" value="Reset" name="reset"></p>
</form>


<h1>Insert values into employees below:</h1>
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
<h2> Update the name by inserting the SIN and new values below: </h2>
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
<!--
<p>
<font size="2">SIN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eSin" size="6"><br>
<font size="2">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eName" size="18"><br>
<font size="2">Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="ePhone" size="18"><br>
<font size="2">Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eAddress" size="18"><br>
<font size="2">Wage:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eWage" size="18"><br>
<font size="2">Job Type:&nbsp;&nbsp;&nbsp;</font><input type="text" name="eJobt" size="18"><br>
<font size="2">Work schedule:&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eWorks" size="18">
-->
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
<font size="2">SIN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eSin" size="6"><br>
<font size="2">Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eName" size="18"><br>
<font size="2">Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="ePhone" size="18"><br>
<font size="2">Address:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eAddress" size="18"><br>
<font size="2">Wage:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eWage" size="18"><br>
<font size="2">Job Type:&nbsp;&nbsp;&nbsp;</font><input type="text" name="eJobt" size="18"><br>
<font size="2">Work schedule:&nbsp;&nbsp;&nbsp;&nbsp;</font><input type="text" name="eWorks" size="18">
<!--define two variables to pass the value-->
      
<input type="submit" value="selection" name="selectionsubmit"></p>
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
<br>employees:<br><table><tr><th>SIN</th><th>Name</th><th>Phone</th><th>Address</th><th>Username</th><th>Password</th><th>Wage</th><th>Job Type</th><th>Work Schedule</th></tr><tr><td>12</td><td>Manning</td><td>604</td><td>ubc</td><td>test</td><td>pass</td><td>10</td><td>driver</td><td>WTF</td></tr><tr><td>10</td><td>Frank</td><td>604</td><td>ubc</td><td>test</td><td>pass</td><td>10</td><td>driver</td><td>WTF</td></tr><tr><td>11</td><td>Jeff</td><td>604</td><td>ubc</td><td>test</td><td>pass</td><td>10</td><td>driver</td><td>WTF</td></tr></table><br>vehicles:<br><table><tr><th>vid</th><th>Capacity</th><th>Mode of Transport</th><th>Cost</th><th>Model</th><th>Age</th></tr><tr><td>15</td><td>5</td><td>taxi</td><td>3</td><td>abc</td><td>5</td></tr></table><br>OpeartedBy:<br><table><tr><th>sin</th><th>vid</th></tr></table>
