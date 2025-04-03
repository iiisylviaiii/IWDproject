<?php
session_start();
require_once 'login.php'; 
include 'redir.php';

echo<<<_HEAD1
<html>
<body>
_HEAD1;

include 'menuf.php';

$fn=$_SESSION['forname'];
$sn=$_SESSION['surname'];
$dbname=$_SESSION['dbname'];

if(isset($_POST['pfamily'])&&isset($_POST['tgroup'])){
    $pfamily = $_POST['pfamily'];
    $tgroup = $_POST['tgroup']; 
    $nseq = $_POST['nseq'];
    $maxlen = $_POST['maxlen'];
    $minlen = $_POST['minlen'];

    $lpfamily = strtolower($pfamily);
    $ltgroup = strtolower($tgroup);

    if ($nseq == 'all'){
	    $command = "python download.py " . $lpfamily . " " . $ltgroup;} 
    else {
	    $nseq_int = (int) $nseq;
	    $command = "python download.py " . $lpfamily . " " . $ltgroup . " --nseq " . $nseq_int;}
    echo $command;
    $result = shell_exec($command);
    echo $result;

    try{
	$dsn = "mysql:host=127.0.0.1;dbname=$database;charset=utf8mb4";
	$conn = new PDO($dsn, $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "\nConnect Success!";
    }catch(PDOException $e) {   
	echo "<br/><br/><b><font color=\"red\">Connection failed</font></b>:<br/>" . $e->getMessage();}

}

echo <<<_TAIL
<h3>Please enter the family information:</h3>
<form action="query1.php" method="post">

    <label for="pfamily">Protein Family:</label> 
    <input type="text" value="glucose-6-phosphatase" name="pfamily" required/><br>

    <label for="tgroup">Taxonomic Group:</label>
    <input type="text" value="Aves" name="tgroup" required/><br>

    <label for="nseq">Select number of sequences:</label>
    <select id="n_sequences" name="nseq">
	<option value="5">5</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="all">Show all</option>
    </select><br>

    <label for="maxlen">Set the max of length:</label>
    <input type="number" value=10000 name="maxlen">
    <br>

    <label for="minlen">Set the min of length:</label>
    <input type="number" value=0 name="minlen"><br>

    <input type="submit" value="Search"/>
</form>

</body>
</html>
_TAIL;

?>
