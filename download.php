<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "berkasektp";

if (isset($_GET['filename']) && !empty($_GET['filename'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $filename = $_GET['filename'];
    $sql = "SELECT suratkelurahan FROM berkas WHERE suratkelurahan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $filename);
    $stmt->execute();
    $stmt->bind_result($suratkelurahan);

    if ($stmt->fetch()) {
        // Set headers for file download
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename='suratkelurahan.pdf'");
        
        // Output the file content
        echo $suratkelurahan;
    } else {
        echo "File not found.";
    }

    $stmt->close();
    $conn->close();
    exit;
} else {
    echo "Invalid request.";
}
?>
