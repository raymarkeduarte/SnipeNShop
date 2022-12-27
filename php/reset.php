<?php
    include "connect.php"; 
	session_start();
	mysqli_query($conn, "UPDATE sellers SET status = '5', lock_date = '' WHERE seller_userName = '$_SESSION[userName]'");
 ?>