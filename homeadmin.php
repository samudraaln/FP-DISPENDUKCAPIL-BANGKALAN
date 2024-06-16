<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ektp"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all records from the datadiri table
$sql = "SELECT * FROM datadiri";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin DespendukCapil</title>
  <style>
    body,
    html {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    body {
      background: url('asset/bgdashboard.jpg');
      background-size: cover;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 1;
    }

    .dashboard {
      position: absolute;
      width: 100%;
      height: 50px;
      margin: 0;
      padding: 0;
      background-color: #ffee02;
      z-index: 3;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      box-sizing: border-box;
    }

    h1 {
      color: #000000;
      font-size: 20px;
      text-align: left;
      width: 100%;
      margin: 0;
    }

    .profile-container {
      position: relative;
    }

    .profile-logo {
      height: 40px;
      width: 40px;
      border-radius: 50%;
      overflow: hidden;
      cursor: pointer;
    }

    .profile-logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      background-color: #fff;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      z-index: 4;
      border-radius: 5px;
      overflow: hidden;
    }

    .dropdown-menu a {
      display: block;
      padding: 12px 20px;
      color: #333;
      text-decoration: none;
      font-size: 14px;
      transition: background-color 0.3s ease;
    }

    .dropdown-menu a:hover {
      background-color: #f4f4f4;
    }

    .dropdown-menu::before {
      content: '';
      position: absolute;
      top: -10px;
      right: 10px;
      width: 0;
      height: 0;
      border-left: 10px solid transparent;
      border-right: 10px solid transparent;
      border-bottom: 10px solid #fff;
      z-index: 5;
    }

    .content {
      position: absolute;
      top: 60px;
      left: 20px;
      right: 20px;
      bottom: 20px;
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      overflow: auto;
      z-index: 2;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: #f4f4f4;
    }

    .verify-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
    }

    .verify-btn:hover {
      background-color: #45a049;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="dashboard">
      <h1> DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL BANGKALAN </h1>
      <div class="profile-container">
        <div class="profile-logo" onclick="toggleDropdown()">
          <img src="asset/profil.jpg" alt="Profile Logo">
        </div>
        <div class="dropdown-menu" id="dropdownMenu">
          <a href="#">Profil</a>
          <a href="#" onclick="logout()">Log Out</a>
        </div>
      </div>
    </div>
    <div class="overlay"></div>
    <div class="content">
      <h2>Daftar Orang yang Telah Mendaftar</h2>
      <table>
        <thead>
          <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Golongan Darah</th>
            <th>RT/RW</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Agama</th>
            <th>Status Perkawinan</th>
            <th>Pekerjaan</th>
            <th>Tujuan Membuat KTP</th>
            <th>Surat Kelurahan</th>
            <th>Akta Kelahiran</th>
            <th>Kartu Keluarga</th>
            <th>Berkas Tambahan</th>
            <th>Verifikasi</th>
            <th>Status</th>
            <th>Tanggal Dokumentasi</th>
            <th>Waktu Dokumentasi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["nik"] . "</td>";
              echo "<td>" . $row["nama"] . "</td>";
              echo "<td>" . $row["no_hp"] . "</td>";
              echo "<td>" . $row["tempat_lahir"] . "</td>";
              echo "<td>" . $row["tanggal_lahir"] . "</td>";
              echo "<td>" . $row["jenis_kelamin"] . "</td>";
              echo "<td>" . $row["gol_darah"] . "</td>";
              echo "<td>" . $row["rtrw"] . "</td>";
              echo "<td>" . $row["kelurahan"] . "</td>";
              echo "<td>" . $row["kecamatan"] . "</td>";
              echo "<td>" . $row["agama"] . "</td>";
              echo "<td>" . $row["status_perkawinan"] . "</td>";
              echo "<td>" . $row["pekerjaan"] . "</td>";
              echo "<td>" . $row["tujuan_membuat_ktp"] . "</td>";
              echo "<td><a href='" . $row["suratkelurahan"] . "' download>Download</a></td>";
              echo "<td><a href='" . $row["aktakelahiran"] . "' download>Download</a></td>";
              echo "<td><a href='" . $row["kartukeluarga"] . "' download>Download</a></td>";
              echo "<td>";
              if ($row["berkastambahan"]) {
                echo "<a href='" . $row["berkastambahan"] . "' download>Download</a>";
              } else {
                echo "N/A";
              }
              echo "</td>";
              echo "<td>";
              echo "<a href='verifikasi.php?verify=" . $row["nik"] . "'>Verifikasi</a>";
              echo "</td>";
              echo "<td>";
              // Display status based on verified column
              if ($row["verified"] == 1) {
                echo "Sudah diverifikasi";
              } else {
                echo "Belum diverifikasi";
              }
              echo "</td>";
              echo "<td>" . $row["jadwal_dokumentasi"] . "</td>";
              echo "<td>" . $row["waktu_dokumentasi"] . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='21'>No records found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function logout() {
      window.location.href = 'admin.php';
    }

    function toggleDropdown() {
      const dropdown = document.getElementById('dropdownMenu');
      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    window.onclick = function(event) {
      if (!event.target.matches('.profile-logo') && !event.target.closest('.profile-container')) {
        const dropdowns = document.getElementsByClassName('dropdown-menu');
        for (let i = 0; i < dropdowns.length; i++) {
          const openDropdown = dropdowns[i];
          if (openDropdown.style.display === 'block') {
            openDropdown.style.display = 'none';
          }
        }
      }
    }
  </script>
</body>

</html>

<?php
$conn->close();
?>