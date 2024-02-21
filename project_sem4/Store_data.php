<?php
	$Name = $_POST['Name'];
	$Email = $_POST['Email'];
    $date=$_POST['Date']
	$password = $_POST['password'];
	$cnfpassword = $_POST['cnfpassword'];

	// Database connection
	$conn = new mysqli('localhost','root','','customers');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	                        } 
    else {
		$stmt = $conn->prepare("insert into customers(Name, Email, Date_of_Birth, Password, cnfpassword ) values(?, ?, ?, ?, ?)");
		$stmt->bind_param("ssisss", $Name, $Email, $date, $password, $cnfpassword);
		$execval = $stmt->execute();
		echo $execval;
		echo "Registration successfully...";
		$stmt->close();
		$conn->close();
	}
?>
