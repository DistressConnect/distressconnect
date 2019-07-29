<?php
	# mysqli database configuration
	$hostName 	= "localhost";			//HOSTNAME
	$dbName 	= "distress_endpoint";	//DATABASE NAME
	$userName 	= "phpmyadmin";      	//USER NAME
	$password 	= "123";      			//PASSWORD
	
	
	$con = mysqli_connect($hostName,$userName,$password,$dbName) or die("Mysqli Connection Error! Please check your database connection.");

	session_start();
	date_default_timezone_set('Asia/Kolkata');

	define('MQTT_SERVER', "guru-cool.com");
	define('MQTT_PORT', 1883);
	define('MQTT_USERNAME', "");
	define('MQTT_PASSWORD', "");
?>