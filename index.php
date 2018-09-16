<?php

function register ($firstname, $lastname, $email, $phonenumber1, $phonenumber2, $comment) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "clients";
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$countEmail = $conn->prepare("SELECT * FROM users WHERE email=:email");
	$countEmail->bindParam(':email', $email);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Invalid email format"; 
	} else {
		$countEmail->execute();
		$emailRow=$countEmail->rowCount();
		if($emailRow > 0){
			echo "Please select another email";
		} else {
			$countNr = $conn->prepare("SELECT * FROM users WHERE phonenumber1=:phonenumber1");
			$countNr->bindParam(':phonenumber1', $phonenumber1);
			$countNr->execute();
			$nrRow=$countNr->rowCount();
			if($nrRow > 0){
				echo "Please type another phone number";
			} else {
				$statement = $conn->prepare("INSERT INTO users (firstname, lastname, email, phonenumber1, phonenumber2, comment) VALUES (:firstname, :lastname, :email, :phonenumber1, :phonenumber2, :comment)");
				$statement->bindParam(':firstname', $firstname);
				$statement->bindParam(':lastname', $lastname);
				$statement->bindParam(':email', $email);
				$statement->bindParam(':phonenumber1', $phonenumber1);
				$statement->bindParam(':phonenumber2', $phonenumber2);
				$statement->bindParam(':comment', $comment);
				$statement->execute();
				$conn = null;
			}
		}
	} 	
}
function delete ($id) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "clients";
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$statement = $conn->prepare("DELETE FROM users WHERE id=:id");
	$statement->bindParam(':id', $id);
	$statement->execute();
	$conn = null;
}

function update ($id, $firstname, $lastname, $email, $phonenumber1, $phonenumber2, $comment) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "clients";
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$countEmail = $conn->prepare("SELECT * FROM users WHERE email=:email");
	$countEmail->bindParam(':email', $email);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Invalid email format"; 
	} else {
		$countEmail->execute();
		$emailRow=$countEmail->rowCount();
		if($emailRow > 0){
			echo "Please select another email";
		} else {
			$countNr = $conn->prepare("SELECT * FROM users WHERE phonenumber1=:phonenumber1");
			$countNr->bindParam(':phonenumber1', $phonenumber1);
			$countNr->execute();
			$nrRow=$countNr->rowCount();
			if($nrRow > 0){
				echo "Please type another phone number";
			} else {
				$statement = $conn->prepare("UPDATE users SET firstname=:firstname, lastname=:lastname, phonenumber1=:phonenumber1, phonenumber2=:phonenumber2, email=:email, comment=:comment WHERE id=:id");
				$statement->bindParam(':id', $id);
				$statement->bindParam(':firstname', $firstname);
				$statement->bindParam(':lastname', $lastname);
				$statement->bindParam(':email', $email);
				$statement->bindParam(':phonenumber1', $phonenumber1);
				$statement->bindParam(':phonenumber2', $phonenumber2);
				$statement->bindParam(':comment', $comment);
				$statement->execute();
				$conn = null;
			}
		}
	} 
}

function importcsv ($filename) {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "clients";
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$file = fopen($filename, "r");
	while ($row = fgetcsv($file)) {
		$value = "'". implode(',', $row) ."'";
		$statement = $conn->prepare("INSERT INTO users (firstname, lastname, email, phonenumber1, phonenumber2, comment) VALUES (:firstname, :lastname, :email, :phonenumber1, :phonenumber2, :comment)");
		$statement->bindParam(':firstname', $row[0]);
		$statement->bindParam(':lastname', $row[1]);
		$statement->bindParam(':email', $row[2]);
		$statement->bindParam(':phonenumber1', $row[3]);
		$statement->bindParam(':phonenumber2', $row[4]);
		$statement->bindParam(':comment', $row[5]);
		$statement->execute();
	}
	$conn = null;
}

?>