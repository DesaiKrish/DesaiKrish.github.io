<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $rating = $_POST["rating"];

    // Create a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "intro";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "INSERT INTO feedback (name, email, message, rating) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error: Unable to prepare statement. " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("sssi", $name, $email, $message, $rating);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        echo "Feedback submitted successfully!";
        // Redirect to the dashboard or desired page
        header("Location: main_file.html");
        exit(); // Terminate the script after redirect
    } else {
        echo "Error: Unable to submit feedback.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
