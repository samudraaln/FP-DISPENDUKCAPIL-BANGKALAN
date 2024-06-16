<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ektp"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Direktori tempat file akan disimpan
$uploadDir = 'berkasektp/';

// Pastikan direktori upload ada
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Fungsi untuk memeriksa apakah file adalah PDF
function isPdf($file) {
    $fileMime = mime_content_type($file);
    return $fileMime == 'application/pdf';
}

// Periksa apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $gol_darah = $_POST['gol_darah'];
    $rtrw = $_POST['rtrw'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $agama = $_POST['agama'];
    $status_perkawinan = $_POST['status_perkawinan'];
    $pekerjaan = $_POST['pekerjaan'];
    $tujuan_membuat_ktp = $_POST['tujuan_membuat_ktp'];

    $suratkelurahan = $_FILES['suratkelurahan'];
    $aktakelahiran = $_FILES['aktakelahiran'];
    $kartukeluarga = $_FILES['kartukeluarga'];
    $berkastambahan = isset($_FILES['berkastambahan']) ? $_FILES['berkastambahan'] : null;

    // Validasi bahwa semua file adalah PDF
    if (isPdf($suratkelurahan['tmp_name']) && isPdf($aktakelahiran['tmp_name']) && isPdf($kartukeluarga['tmp_name']) && (!$berkastambahan || isPdf($berkastambahan['tmp_name']))) {
        // Pindahkan file yang diupload ke direktori upload
        $suratkelurahanPath = $uploadDir . basename($suratkelurahan['name']);
        $aktakelahiranPath = $uploadDir . basename($aktakelahiran['name']);
        $kartukeluargaPath = $uploadDir . basename($kartukeluarga['name']);
        $berkastambahanPath = $berkastambahan ? $uploadDir . basename($berkastambahan['name']) : null;

        move_uploaded_file($suratkelurahan['tmp_name'], $suratkelurahanPath);
        move_uploaded_file($aktakelahiran['tmp_name'], $aktakelahiranPath);
        move_uploaded_file($kartukeluarga['tmp_name'], $kartukeluargaPath);
        if ($berkastambahan) {
            move_uploaded_file($berkastambahan['tmp_name'], $berkastambahanPath);
        }

        // Masukkan path file ke database
        $sql = "INSERT INTO datadiri (nik, nama, no_hp, tempat_lahir, tanggal_lahir, jenis_kelamin, gol_darah, rtrw, kelurahan, kecamatan, agama, status_perkawinan, pekerjaan, tujuan_membuat_ktp, suratkelurahan, aktakelahiran, kartukeluarga, berkastambahan) VALUES ('$nik', '$nama', '$no_hp', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$gol_darah', '$rtrw', '$kelurahan', '$kecamatan', '$agama', '$status_perkawinan', '$pekerjaan', '$tujuan_membuat_ktp', '$suratkelurahanPath', '$aktakelahiranPath', '$kartukeluargaPath', '$berkastambahanPath')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New record created successfully');</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('All uploaded files must be PDFs.');</script>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Data Diri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #ffeb3b, #9e9e9e);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
        }

        .container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            margin-top: 20px;
        }

        .header {
            background-color: #9e9e9e;
            padding: 20px;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            color: white;
        }

        .form-container {
            padding: 20px;
            max-height: 80vh;
            overflow-y: auto;
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

        .form-group input[type="text"],
        .form-group input[type="tel"],
        .form-group input[type="date"],
        .form-group input[type="file"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input[type="file"] {
            padding: 3px;
        }

        .form-group select {
            appearance: none;
            background: white;
            background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="#aaa" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 8px 10px;
        }

        #tujuanLainnya {
            display: none;
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
        <div class="header">
            <h2>Form Pembuatan eKTP</h2>
        </div>
        <div class="form-container">
            <form action="form.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nik">NIK:</label>
                    <input type="text" id="nik" name="nik" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="noHp">Nomor Handphone:</label>
                    <input type="tel" id="noHp" name="no_hp" required>
                </div>
                <div class="form-group">
                    <label for="tempatLahir">Tempat Lahir:</label>
                    <input type="text" id="tempatLahir" name="tempat_lahir" required>
                </div>
                <div class="form-group">
                    <label for="tanggalLahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggalLahir" name="tanggal_lahir" required>
                </div>
                <div class="form-group">
                    <label for="jenisKelamin">Jenis Kelamin:</label>
                    <select id="jenisKelamin" name="jenis_kelamin" required>
                        <option value="Laki-Laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="golDarah">Golongan Darah:</label>
                    <select id="golDarah" name="gol_darah" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="rtrw">RT/RW:</label>
                    <input type="text" id="rtrw" name="rtrw" required>
                </div>
                <div class="form-group">
                    <label for="kelurahan">Kelurahan:</label>
                    <input type="text" id="kelurahan" name="kelurahan" required>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan:</label>
                    <input type="text" id="kecamatan" name="kecamatan" required>
                </div>
                <div class="form-group">
                    <label for="agama">Agama:</label>
                    <input type="text" id="agama" name="agama" required>
                </div>
                <div class="form-group">
                    <label for="statusPerkawinan">Status Perkawinan:</label>
                    <select id="statusPerkawinan" name="status_perkawinan" required>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Cerai">Cerai</option>
                        <option value="Janda/Duda">Janda/Duda</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pekerjaan">Pekerjaan:</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" required>
                </div>
                <div class="form-group">
                    <label for="tujuanMembuatKtp">Tujuan Membuat KTP:</label>
                    <select id="tujuanMembuatKtp" name="tujuan_membuat_ktp" onchange="checkTujuan()" required>
                        <option value="Sudah 17 Tahun">Sudah 17 Tahun</option>
                        <option value="KTP hilang">KTP hilang</option>
                        <option value="KTP rusak">KTP rusak</option>
                        <option value="Mengubah status identitas">Mengubah status identitas</option>
                        <option value="Pindah domisili">Pindah domisili</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group" id="tujuanLainnya" style="display: none;">
                    <label for="tujuanLainnyaInput">Tujuan Lainnya:</label>
                    <input type="text" id="tujuanLainnyaInput" name="tujuan_lainnya">
                </div>
                <div class="form-group">
                    <label for="suratkelurahan">Surat Kelurahan (PDF):</label>
                    <input type="file" id="suratkelurahan" name="suratkelurahan" accept="application/pdf" required>
                </div>
                <div class="form-group">
                    <label for="aktakelahiran">Akta Kelahiran (PDF):</label>
                    <input type="file" id="aktakelahiran" name="aktakelahiran" accept="application/pdf" required>
                </div>
                <div class="form-group">
                    <label for="kartukeluarga">Kartu Keluarga (PDF):</label>
                    <input type="file" id="kartukeluarga" name="kartukeluarga" accept="application/pdf" required>
                </div>
                <div class="form-group">
                    <label for="berkastambahan">Berkas Tambahan (PDF):</label>
                    <input type="file" id="berkastambahan" name="berkastambahan" accept="application/pdf">
                </div>
                <input type="submit" value="Upload">
            </form>
        </div>
    </div>

    <script>
        function checkTujuan() {
            var tujuan = document.getElementById("tujuanMembuatKtp").value;
            var tujuanLainnya = document.getElementById("tujuanLainnya");
            if (tujuan === "Lainnya") {
                tujuanLainnya.style.display = "block";
            } else {
                tujuanLainnya.style.display = "none";
            }
        }
    </script>
</body>
</html>
