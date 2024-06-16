<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ektp";

$jadwal_dokumentasi = $waktu_dokumentasi = "";
$jadwal_dokumentasi_err = $waktu_dokumentasi_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $jadwal_dokumentasi = trim($_POST["jadwal_dokumentasi"] ?? '');
    $waktu_dokumentasi = trim($_POST["waktu_dokumentasi"] ?? '');

    if (empty($jadwal_dokumentasi)) {
        $jadwal_dokumentasi_err = "Tanggal Dokumentasi harus diisi";
    }

    if (empty($waktu_dokumentasi)) {
        $waktu_dokumentasi_err = "Waktu Dokumentasi harus diisi";
    }

    // Process form if there are no errors
    if (empty($jadwal_dokumentasi_err) && empty($waktu_dokumentasi_err)) {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if 'verify' parameter is set in the URL
        if (isset($_GET['verify'])) {
            $nik = $_GET['verify'];

            // Prepare SQL update statement
            $sql_update = "UPDATE datadiri SET jadwal_dokumentasi = ?, waktu_dokumentasi = ?, verified = TRUE WHERE nik = ?";
            if ($stmt = $conn->prepare($sql_update)) {
                // Bind parameters
                $stmt->bind_param("sss", $jadwal_dokumentasi, $waktu_dokumentasi, $nik);
                // Execute statement
                if ($stmt->execute()) {
                    // Redirect to displaydata.php after successful update
                    header("Location: homeadmin.php");
                    exit();
                } else {
                    echo "Error updating dokumentasi date and time: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Invalid request: Missing 'verify' parameter.";
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanggal Pengambilan Foto dan Tanda Tangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #ffeb3b, #9e9e9e);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            padding: 20px;
        }

        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="date"],
        .form-group input[type="time"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input[type="time"] {
            padding: 10px;
        }

        span.error {
            color: red;
        }

        input[type="submit"] {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tanggal Pengambilan Foto dan Tanda Tangan</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?verify=<?php echo isset($_GET['verify']) ? $_GET['verify'] : ''; ?>">
            <div class="form-group">
                <label for="jadwal_dokumentasi">Tanggal:</label>
                <input type="date" id="jadwal_dokumentasi" name="jadwal_dokumentasi" value="<?php echo htmlspecialchars($jadwal_dokumentasi); ?>" required>
                <span class="error"><?php echo $jadwal_dokumentasi_err; ?></span>
            </div>
            <div class="form-group">
                <label for="waktu_dokumentasi">Waktu:</label>
                <input type="time" id="waktu_dokumentasi" name="waktu_dokumentasi" value="<?php echo htmlspecialchars($waktu_dokumentasi); ?>" required>
                <span class="error"><?php echo $waktu_dokumentasi_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Kirim">
            </div>
        </form>
    </div>
</body>
</html>
