<?php
session_start();

include("config.php");

$BookingData = "SELECT * FROM `appointment_mri` WHERE `Status` = 1 ORDER BY `Date`";
$BookingData_query = mysqli_query($db, $BookingData);

$AllData = "SELECT * FROM `appointment_mri` WHERE `Status` != 1 ORDER BY `Date`";
$AllData_query = mysqli_query($db, $AllData);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> MRI Scanning Machine Booking </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .navigation {
            width: 100%;
            height: 80px;
            background-color: #4CAF50;
        }

        .navigation nav {
            width: 1366px;
            height: 80px;
            margin: auto;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
        }

        .navigation nav i {
            color: #fff;
            font-size: 20px;
            padding: 10px;
            box-sizing: border-box;
        }

        .content {
            width: 1366px;
            margin: auto;
            padding: 15px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            padding-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="navigation">
        <nav>
            <a href="view.php">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
        </nav>
    </div>
    <div class="content">
        <?php
        if (mysqli_num_rows($BookingData_query) > 0) {
            echo "<h1>
                    New Booking
                </h1>
                <table>
            <thead>
                <tr>
                    <th> Name </th>
                    <th> Hospital </th>
                    <th> Date </th>
                    <th> Time </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>";
            while ($fetchData = mysqli_fetch_assoc($BookingData_query)) {
                $ID = $fetchData['ID'];
                $Hospital = $fetchData['Hospital'];
                $Date = $fetchData['Date'];
                $Time = $fetchData['Time'];
                $Username = $fetchData['Username'];
                $Status = $fetchData['Status'];

                $user = "SELECT `first_name`, `last_name` FROM `register` WHERE `username` = '{$Username}'";
                $user_Query = mysqli_query($db, $user);

                if ($user_Query) {
                    $userFetch = mysqli_fetch_assoc($user_Query);
                    $Name = $userFetch['first_name'] . " " . $userFetch['last_name'];
                }

                echo "<tr>";
                echo "<td> $Name </td>";
                echo "<td> $Hospital </td>";
                echo "<td> $Date </td>";
                echo "<td> $Time </td>";
                echo "<td> <a href='accept.php?MRIID={$ID}'> Accept </a> | <a href='cancel.php?MRIID={$ID}'> Cancel </a> </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<br><br><br>";
        }

        if (mysqli_num_rows($AllData_query) > 0) {
            echo "<h1>
                    Booking List
                </h1>
                <table>
            <thead>
                <tr>
                    <th> Name </th>
                    <th> Hospital </th>
                    <th> Date </th>
                    <th> Time </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>";
            while ($fetchAllData = mysqli_fetch_assoc($AllData_query)) {
                $ID = $fetchAllData['ID'];
                $Hospital = $fetchAllData['Hospital'];
                $Date = $fetchAllData['Date'];
                $Time = $fetchAllData['Time'];
                $Username = $fetchAllData['Username'];
                $Status = $fetchAllData['Status'];

                if ($Status == 0) {
                    $action = "<span style='color: red;'> Canceled </span>";
                } elseif ($Status == 2) {
                    $action = "<span style='color: blue;'> Acceped </span>";
                }

                $user = "SELECT `first_name`, `last_name` FROM `register` WHERE `username` = '{$Username}'";
                $user_Query = mysqli_query($db, $user);

                if ($user_Query) {
                    $userFetch = mysqli_fetch_assoc($user_Query);
                    $Name = $userFetch['first_name'] . " " . $userFetch['last_name'];
                }

                echo "<tr>";
                echo "<td> $Name </td>";
                echo "<td> $Hospital </td>";
                echo "<td> $Date </td>";
                echo "<td> $Time </td>";
                echo "<td> $action </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<br><br><br>";
        }
        ?>
    </div>
</body>

</html>