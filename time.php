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

// Book a slot
function bookSlot($slot) {
    if (isSlotAvailable($slot)) {
        $_SESSION['availability'][$slot] = false;
        $_SESSION['booked_slots'][$slot] = true; // Store booked slot in session
    }
}

// Cancel a booking
function cancelBooking($slot, $password) {
    // Check if password is correct
    $correctPassword = "123"; // Change this to your desired password
    if ($password !== $correctPassword) {
        return false; // Password incorrect
    }

    if (isset($_SESSION['booked_slots'][$slot])) {
        $_SESSION['availability'][$slot] = true;
        unset($_SESSION['booked_slots'][$slot]); // Remove booked slot from session
        return true; // Booking cancelled successfully
    }

    return false; // Booking not found
}

// Handle booking request
if (isset($_POST['action']) && isset($_POST['slots'])) {
    $action = $_POST['action'];
    $slots = $_POST['slots'];

    if ($action === 'book') {
        foreach ($slots as $slot) {
            bookSlot($slot);
        }
    }
}

// Handle cancellation request
if (isset($_POST['cancel_action']) && isset($_POST['cancel_slots'])) {
    $password = $_POST['password']; // Get password from form
    $cancel_slots = $_POST['cancel_slots'];
    foreach ($cancel_slots as $slot) {
        cancelBooking($slot, $password);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CT Scanning Machine Booking</title>
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

        th,
        td {
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

    <h2>CT Scanning Machine Booking</h2>

    <form method="post">
        <table>
            <tr>
                <th>Time Slot</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($timeSlots as $slot => $time) : ?>
                <tr>
                    <td><?php echo $time; ?></td>
                    <td><?php echo (isSlotAvailable($slot) ? 'Available' : 'Not Available'); ?></td>
                    <td>
                        <?php if (isSlotAvailable($slot)) : ?>
                            <input type="checkbox" name="slots[]" value="<?php echo $slot; ?>">
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit" name="action" value="book">Book Selected Slots</button>
    </form>

    <!-- Cancellation form -->
    <form method="post">
        <h3>Cancel Booking</h3>
        <?php if (isset($_SESSION['booked_slots']) && !empty($_SESSION['booked_slots'])) : ?>
            <table>
                <tr>
                    <th>Time Slot</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($_SESSION['booked_slots'] as $slot => $value) : ?>
                    <tr>
                        <td><?php echo $timeSlots[$slot]; ?></td>
                        <td>
                            <input type="checkbox" name="cancel_slots[]" value="<?php echo $slot; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit" name="cancel_action" value="cancel" onclick="return confirm('Are you sure you want to cancel selected booking?')">Cancel Selected Booking</button>
        <?php else : ?>
            <p>No bookings to cancel.</p>
        <?php endif; ?>
    </form>

    
 <br><br> <br>  
<form style="display: inline-block; margin-right: 10px;" method="post" action="login.php">
    <button type="submit" name="logout" style="background-color: #f44336;">Logout</button>
</form>

<form style="display: inline-block;" method="post" action="index.php">
    <button type="submit" name="back_to_dashboard">Back to Dashboard</button>
    
</form>


</body>

</html>
