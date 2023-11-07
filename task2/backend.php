<?php 

// Database connection 
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'test';
// Create a new PDO connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


if($_POST['comes'] == "backend"){	

	// SQL code to select data from the Mock table
	$query = "SELECT * FROM Mock ";
	$res = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($res);
	
}

if($_POST['comes'] == "save_new"){
	// SQL code to insert data into the Mock table
    $query = "INSERT INTO Mock (name, date_time) VALUES (?, ?)";
    $res=$pdo->prepare($query)->execute([$_POST['name'], $_POST['date_time']]);
    if($res){
    	echo json_encode("success");
    }else{
    	echo json_encode("error");
    }
}

if($_POST['comes'] == "delete"){
	// SQL code to delete data in the Mock table
    $query = "DELETE FROM Mock WHERE id = '".$_POST['id']."'";
    $res=$pdo->prepare($query)->execute();
    if($res){
    	echo json_encode("success");
    }else{
    	echo json_encode("error");
    }
}

if($_POST['comes'] == "update"){
	// SQL code to update data in the Mock table
    $query = "UPDATE Mock SET name = :name, date_time = :date_time WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $_POST['name']);
	$stmt->bindParam(':date_time', $_POST['date_time']);
	$stmt->bindParam(':id', $_POST['id']);
	$res = $stmt->execute();
    if($res){
    	echo json_encode("success");
    }else{
    	echo json_encode("error");
    }
}
?>
