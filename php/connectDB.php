//connection to DB
<?php
// Database configuration
$host = 'localhost'; // usually 'localhost'
$username = 'sudip';
$password = 'Paudelzone22@#!';
$database = 'bid2buy';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Product ID: " . $row["product_id"]. " - Name: " . $row["name"]. " - Price: " . $row["base_price"]. "<br>";
    }
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
