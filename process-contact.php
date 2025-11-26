<?php
// process-contact.php - ULTRA SIMPLE GUARANTEED WORKING VERSION

// Show everything that happens
echo "<h2>🔧 DEBUG MODE - Watching Everything</h2>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $education = $_POST['education'];
    $interest = $_POST['interest'] ?? 'Not specified';
    $message = $_POST['message'];
    
    echo "<h3>📨 Received Data:</h3>";
    echo "Name: $name<br>";
    echo "Email: $email<br>";
    echo "Phone: $phone<br>";
    echo "Age: $age<br>";
    echo "Education: $education<br>";
    echo "Interest: $interest<br>";
    echo "Message: $message<br>";
    
    // Connect to database
    echo "<h3>🔗 Connecting to Database...</h3>";
    $conn = mysqli_connect("localhost", "root", "", "women_empowerment");
    
    if (!$conn) {
        die("❌ Connection failed: " . mysqli_connect_error());
    }
    echo "✅ Connected successfully!<br>";
    
    // Insert data using simple method
    echo "<h3>💾 Inserting Data...</h3>";
    $sql = "INSERT INTO registrations (name, email, phone, age, education, interest, message) 
            VALUES ('$name', '$email', '$phone', $age, '$education', '$interest', '$message')";
    
    echo "SQL: $sql<br>";
    
    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        echo "✅ <strong style='color: green; font-size: 20px;'>SUCCESS! Data inserted with ID: $last_id</strong><br>";
    } else {
        echo "❌ <strong style='color: red; font-size: 20px;'>ERROR: " . mysqli_error($conn) . "</strong><br>";
    }
    
    // Show ALL data in table
    echo "<h3>📊 Checking Table Contents...</h3>";
    $result = mysqli_query($conn, "SELECT * FROM registrations");
    
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Age</th><th>Date</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['phone']}</td>";
            echo "<td>{$row['age']}</td>";
            echo "<td>{$row['submission_date']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ <strong>Table is EMPTY - no records found!</strong><br>";
    }
    
    mysqli_close($conn);
    
    echo "<br><br><a href='index.html' style='padding: 10px 20px; background: #8A2BE2; color: white; text-decoration: none; border-radius: 5px;'>← Back to Form</a>";
    
} else {
    header("Location: index.html");
    exit();
}
?>