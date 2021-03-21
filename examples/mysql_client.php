<?php
$servername = "localhost";
$username = "coupon";
$password = "fA!86?wr";
$dbname = "coupon_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO users (name, last_name, cod_fisc, email, phone, username, password, luogo_nascita, provincia_nascita, data_nascita, contract_id, contract_date, contract_pr , occupation, flag_privacy, flag_adv, specializzazione, annoInizioSpecializzazione, attivita) VALUES ('', '', '', '', '', '', '', '', '', null, '', null, '', '', '', '', '', '', '')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    echo "<br>";
    echo "New record has id: " . mysqli_insert_id($conn); 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>