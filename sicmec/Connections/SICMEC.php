<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_SICMEC = "localhost";
$database_SICMEC = "sicmec";
$username_SICMEC = "root";
$password_SICMEC = "";
$SICMEC = mysql_pconnect($hostname_SICMEC, $username_SICMEC, $password_SICMEC) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
