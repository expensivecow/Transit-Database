
<html>
<?php

if ($c=OCILogon("ora_p2n8", "a36523124", "ug")) {
  echo "Successfully connected to Oracle.\n";
  OCILogoff($c);
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}

?>
</html>