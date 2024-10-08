<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Gudang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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

        form {
            margin-bottom: 20px;
        }

        form input, form select {
            margin: 5px 0;
            padding: 8px;
            width: 100%;
        }

        form input[type="submit"] {
            background-color: navy;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="index.php">Daftar Gudang</a></li>
            <li><a href="#">Kelola</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>Kelola Gudang</h1>

        <form action="kelola.php" method="POST">
            <?php
            require 'database.php';

            $database = new Database();
            $conn = $database->getConnection();

            $edit_id = '';
            $edit_name = '';
            $edit_location = '';
            $edit_capacity = '';
            $edit_status = '';
            $edit_opening_hour = '';
            $edit_closing_hour = '';

            if (isset($_GET['edit'])) {
                $edit_id = $_GET['edit'];
                $sql = "SELECT * FROM gudang WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$edit_id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $edit_name = $row['name'];
                $edit_location = $row['location'];
                $edit_capacity = $row['capacity'];
                $edit_status = $row['status'];
                $edit_opening_hour = $row['opening_hour'];
                $edit_closing_hour = $row['closing_hour'];
            }
            ?>

            <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            <label for="name">Nama Gudang:</label>
            <input type="text" name="name" id="name" value="<?php echo $edit_name; ?>" placeholder="Masukkan nama gudang" required>

            <label for="location">Lokasi:</label>
            <input type="text" name="location" id="location" value="<?php echo $edit_location; ?>" placeholder="Masukkan lokasi" required>

            <label for="capacity">Kapasitas:</label>
            <input type="number" name="capacity" id="capacity" value="<?php echo $edit_capacity; ?>" placeholder="Masukkan kapasitas" required>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="active" <?php echo $edit_status == 'active' ? 'selected' : ''; ?>>Aktif</option>
                <option value="inactive" <?php echo $edit_status == 'inactive' ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>

            <label for="opening_hour">Waktu Buka:</label>
            <input type="time" name="opening_hour" id="opening_hour" value="<?php echo $edit_opening_hour; ?>" required>

            <label for="closing_hour">Waktu Tutup:</label>
            <input type="time" name="closing_hour" id="closing_hour" value="<?php echo $edit_closing_hour; ?>" required>

            <input type="submit" name="submit" value="Simpan">
        </form>

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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['submit'])) {
                    $id = isset($_POST['id']) ? $_POST['id'] : '';
                    $name = $_POST['name'];
                    $location = $_POST['location'];
                    $capacity = $_POST['capacity'];
                    $status = $_POST['status'];
                    $opening_hour = $_POST['opening_hour'];
                    $closing_hour = $_POST['closing_hour'];

                    if ($id) {
                        $sql = "UPDATE gudang SET name = ?, location = ?, capacity = ?, status = ?, opening_hour = ?, closing_hour = ? WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$name, $location, $capacity, $status, $opening_hour, $closing_hour, $id]);
                    } else {
                        $sql = "INSERT INTO gudang (name, location, capacity, status, opening_hour, closing_hour) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$name, $location, $capacity, $status, $opening_hour, $closing_hour]);
                    }
                }

                if (isset($_GET['delete'])) {
                    $id = $_GET['delete'];
                    $sql = "DELETE FROM gudang WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$id]);
                }

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
                    echo "<td>
                        <a href='kelola.php?edit=" . $row['id'] . "'>Edit</a> | 
                        <a href='kelola.php?delete=" . $row['id'] . "' onclick='return confirm(\"Apakah Anda yakin?\")'>Hapus</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
