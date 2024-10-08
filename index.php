<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gudang</title>
    <style>
        body {
            font-family:Arial, sans-serif;
            display: flex;
        }

        .navbar {
            width: 250px;
            background-color: navy;
            color: white;
            padding: 15px;
            height: 100vh;
        }

        .navbar h2 {
            text-align: center;
            margin-bottom: 20px;
            border: 2px solid rgb(249, 246, 246);
        }

        .navbar ul {
            list-style-type: none;
            padding: 0;
        }

        .navbar ul li {
            padding: 10px;
            margin: 25px 0;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid black;
        }

        th {
            background-color: navy;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="#">Daftar Gudang</a></li>
            <li><a href="kelola.php">Kelola</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>Daftar Gudang</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Gudang</th>
                    <th>Lokasi</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Waktu Buka</th>
                    <th>Waktu Tutup</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'database.php';

                $database = new Database();
                $conn = $database->getConnection();

                if ($conn) {
                    try {
                        $sql = "SELECT * FROM gudang";
                        $stmt = $conn->query($sql);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['location'] . "</td>";
                            echo "<td>" . $row['capacity'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>" . $row['opening_hour'] . "</td>";
                            echo "<td>" . $row['closing_hour'] . "</td>";
                            echo "</tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='7'>Terjadi kesalahan dalam query: " . $e->getMessage() . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak dapat terhubung ke database.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
