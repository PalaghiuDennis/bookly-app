<?php  
$servername="localhost";
$username="root";
$password = "";
$database="book_store";

$connection=new mysqli($servername, $username, $password, $database);


if (!$connection) {
	echo "Connection failed!";
	exit();
}

