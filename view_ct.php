<?php
session_start();

// Define time slots
$timeSlots = array(
    'slot1' => '9:00 AM - 10:00 AM',
    'slot2' => '10:00 AM - 11:00 AM',
    'slot3' => '11:00 AM - 12:00 PM',
    'slot4' => '01:00 PM - 02:00 PM',
    'slot5' => '02:00 PM - 03:00 PM',
    'slot6' => '03:00 PM - 04:00 PM',
    'slot7' => '04:00 PM - 05:00 PM',
    // Add more slots if needed
);

// Initialize availability for each slot
if (!isset($_SESSION['availability'])) {
    $_SESSION['availability'] = array_fill_keys(array_keys($timeSlots), true);
}

// Check if slot is available
function isSlotAvailable($slot) {
    return isset($_SESSION['availability'][$slot]) && $_SESSION['availability'][$slot];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanning Machine Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #45a049;
        }

        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<h2>Scanning Machine Booking</h2>

<form method="post">
    <table>
        <tr>
            <th>Time Slot</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach($timeSlots as $slot => $time): ?>
            <tr>
                <td><?php echo $time; ?></td>
                <td><?php echo (isSlotAvailable($slot) ? 'Available' : 'Not Available'); ?></td>
                <td>
                    <!-- Remove booking and cancel options -->
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</form>
<!-- Removed booking and cancel options -->

<form method="post" action="login.php">
    <button type="submit">Logout</button>
</form>

<form method="post" action="view.php">
    <button type="submit">Back</button>
</form>

</body>
</html>
