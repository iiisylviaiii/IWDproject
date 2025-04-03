<?php
session_start();
require_once 'login.php';

echo <<<_HEAD
<html>
<head>
<title>Result</title>
</head>
<body>
<h1>Search Results</h1>	
_HEAD;

try{

/* connect to the database */
        $dsn="mysql:host=127.0.0.1;dbname=$database;charset=utf8mb4";
	$conn=new PDO($dsn,$username,$password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connect Success";

/* get data  */	
        $protein_family=$_POST['pfamily'];
	$taxonomic_group=$_POST['tgroup'];
} catch(PDOException $e) { 
	echo "<br/><br/><b><font color=\"red\">Connection failed</font></b>:<br/>" . $e->getMessage();
}

echo <<<_TAIL
</body>
</html>
_TAIL;
session_destroy() ;
?>
