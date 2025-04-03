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

    // 1.Accept the parameters 
    $pfamily = $_POST['pfamily'];
    $tgroup = $_POST['tgroup'];
    $nseq = $_POST['nseq'];

    $lpfamily = strtolower($pfamily);
    $ltgroup = strtolower($tgroup);

    // 2.Download sequences
    if ($nseq == 'all'){
            $command = "python download.py " . $lpfamily . " " . $ltgroup;}
    else {
            $nseq_int = (int) $nseq;
            $command = "python download.py " . $lpfamily . " " . $ltgroup . " --nseq " . $nseq_int;}
    $result = shell_exec($command);
    echo $result;

    if(empty($result)){
	echo "<p style='color: red; font-size: 20px; font-weight: bold; background-color: yellow;'>No sequence can be found for your query!</p>";
	exit;
    }

    // 3.Save the data
    if (file_put_contents('seq.fasta', $result)) {
        echo "Fasta file has been successfully saved.";
    } else {
        echo "Failed to save the Fasta file.";
    }


    // 4.Perform alignment
    $command2 = "clustalo -i seq.fasta -o aligned_output.aln --force";
    $result2 = shell_exec($command2);

    $command3 = "plotcon -sequence aligned_output.aln -winsize 20 -graph png";
    $plot = shell_exec($command3);
    if (!$plot) {
        echo "Error executing plotcon.";
        exit; }

    
    // 5.Connect to database
    try{
	$dsn = "mysql:host=127.0.0.1;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "\nConnect Success!";

	$sql = "CREATE TABLE IF NOT EXISTS sequences(
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        species VARCHAR(255),
        seq TEXT NOT NULL)";
	$pdo->exec($sql);

	$sql2 = "TRUNCATE TABLE sequences";
	$pdo->exec($sql2);

    // 6.Save the data in table
	$lines = explode("\n", $result);
	$name = "";
	$seq = "";

	foreach ($lines as $line) {
            if (strpos($line, '>') === 0) {
		    if ($name !== "") {
			preg_match('/\\[(.*?)\\]/', $name, $matches);
                        $species = isset($matches[1]) ? $matches[1] : '';
                        $name = preg_replace('/\\[[^\\]]*\\]/', '', $name);
                        $stmt = $pdo->prepare("INSERT INTO sequences(name,species,seq) VALUES (:name, :species, :seq)");
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':species', $species);
                        $stmt->bindParam(':seq', $seq);
                        $stmt->execute();
		    }
		    $name = substr($line,1);
                    $seq = "";
	    }else{
		    $seq .= $line;
	    }
	}

	if($name!=""){
                        $stmt = $pdo->prepare("INSERT INTO sequences(name,species,seq) VALUES (:name, :species, :seq)");
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':species', $species);
                        $stmt->bindParam(':seq', $seq);
                        $stmt->execute();}
        echo "Save success";

                              

    } catch(PDOException $e) {
        echo "<br/><br/><b><font color=\"red\">Connection failed</font></b>:<br/>" . $e->getMessage();}
}

?>
