<?php

define("DEBUG_SQL", 0);
define("DEBUG", 0);
error_reporting(E_ALL);

include("lib.database.php");

$file = "references.txt";
$contents = file_get_contents($file);
$contents = str_replace("\r\n", "\n", $contents);
$contents = str_replace("\r", "\n", $contents);
$lines = explode("\n", $contents);

$DB = new db("references", "localhost", "root", "******");
$DB->q('SET NAMES %s', 'UTF8');

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
      References import sciprt
    </title>
  </head>
  <body>
  <?php
	foreach($lines as $line) {
      echo $line;
      $line = trim($line);
      if ($line == '') {
		echo "<BR>";
		continue;
	  }
      
      $existing = $DB->q("MAYBEVALUE SELECT ref_id FROM all_ref WHERE ref_text = %s", $line);
      if ($existing > 0) {
		  echo 'Already exists:' . $existing;
	  }
	  else {
		  $inserted = $DB->q("returnid INSERT INTO all_ref (`ref_text`) VALUES (%s)", $line);
		  echo 'Inserted:' . $inserted;
	  }
      echo "<BR>";
	}
  ?>
  </body>
</html>
  
