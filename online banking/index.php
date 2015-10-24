<?php

require 'core.inc.php'; //reusable functions
require 'connect.inc.php'; //connect to DB 

//check if user logged in
if(loggedin()){ //function in core.inc.php
	$status = getusersfield('status');//what kind of user
	if($status == "customer"){
		redirect("customer.php");
	} else if($status == "employee") {
		redirect("employee.php");
	} 
} else {	 
	include 'loginform.inc.php'; //if not logged in go to login form
}

?> 