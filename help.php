<?php
session_start();
include 'redir.php';
require_once 'login.php';

echo<<<_HEAD1
<html>
<body>
_HEAD1;

include 'menuf.php';

echo<<<_BODY1
<h1> About this website</h1>
</body>
</html>
_BODY1;
?>
