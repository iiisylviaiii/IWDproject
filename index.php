<?php
session_start();
require_once 'login.php';

if(isset($_POST['fn']) && isset($_POST['sn'])){
   
    echo <<<_HEAD
    <html>
    <body>
_HEAD;

    include 'menuf.php';

    $_SESSION['forname'] = $_POST['fn'];
    $_SESSION['surname'] = $_POST['sn'];
    $dbname=$_SESSION['forname'] . "_" . $_SESSION['surname'];
    $_SESSION['dbname'] = $dbname;

    try {
	    $pdo = new PDO("mysql:host=$hostname",$username, $password);
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    echo "build db success";
    } catch (PDOException $e) {
	    echo "Fail to connect the database" . $e->getMessage();
    }


    echo <<<_TAIL1
    </body>
    </html>
_TAIL1;
    } else {
header('location:https://bioinfmsc8.bio.ed.ac.uk/~s2685732/Website/complib.php');}
?>
