<?php
session_start();

echo<<<_HEAD1
<html>
<head>
<title>Login</title>
<body>
_HEAD1;

echo <<<_EOP
<script>
function validate(form){
    fail = ""
    if(form.fn.value =="") 
        fail = "Please Input Forname " 
    if(form.sn.value == "") 
	fail += "Please Input Surname"
    if(fail =="") return true
        else {alert(fail); return false}
   }
</script>

<h1>Login In</h1>
<h3>Please enter your information</h3>
<form action="index.php" method="post" onSubmit="return validate(this)">
<pre>
       First Name <input type="text" name="fn"/>
       Second Name <input type="text" name="sn"/><br>
       <input type="submit" value="go" />
</pre>
</form>
_EOP;


echo <<<_TAIL1
</pre>
</body>
</html>
_TAIL1;
?>
