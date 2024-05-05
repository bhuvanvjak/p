<?php
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your actual password (avoid storing empty passwords)
$dbname = "loginDB";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname,3307);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit1'])) {
    $email = ($_POST['mail']); // Sanitize email to prevent XSS
    $password = $_POST['passkey'];

    // Prepare a safe SQL statement
    $sql = "SELECT * FROM credentials WHERE email = ? and password=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters to prevent SQL injection
        mysqli_stmt_bind_param($stmt, "ss", $email,$password);
        

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            // Check if a user with matching email exists
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

               
                    header("Location:welcome.php"); // Successful login
               
            } else {
                echo '<script>
                window.location.href="index.php";
                alert("Login failed. Invalid email or password");
                </script>';
            }

            // Free result set
            mysqli_free_result($result);
        } else {
            echo "Error executing prepared statement: " . mysqli_stmt_error($stmt);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
