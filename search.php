<?php
session_start();
require_once 'login.php';
include 'redir.php';

echo<<<_HEAD1
<html>
<body>
_HEAD1;

include 'menuf.php';


echo <<<_TAIL
<h3>Please enter the family information:</h3>
<form action="result1.php" method="post">

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

    <input type="submit" value="Search"/>
</form>

</body>
</html>
_TAIL;

?>
