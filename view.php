<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('HMSLOGO.png');
            /* Add your background image URL here */
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            /* Add an opacity for better visibility */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            justify-content: space-around;
        }

        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #45a049;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to Admin Panel</h1>
        <div class="button-container">
            <div class="dropdown">
                <button class="button">View Data</button>
                <div class="dropdown-content">
                    <a href="view_ct.php">View CT Scanning Machine</a>
                    <a href="view_mri.php">View MRI Scanning Machine</a>
                    <a href="view_inventory.php">View Inventory</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="button">Contact Admin</button>
                <div class="dropdown-content">
                    <a href="mailto:admin@example.com?subject=Request%20for%20Change%20Time%20Time&body=Please%20describe%20your%20request%20here">Request for change the Time slot </a>
                    <div>
                        <form action="mailto:admin@example.com" method="post" enctype="text/plain">
                            <input type="text" name="hospital_name" placeholder="Hospital Name" required><br>
                            <input type="text" name="current_time_slot" placeholder="Current Time Slot" required><br>
                            <input type="text" name="new_time_slot" placeholder="New Time Slot" required><br>
                            <input type="submit" value="Submit">
                        </form>
                    </div>
                    <a href="mailto:admin@example.com?subject=Report%20Issue&body=Please%20describe%20the%20issue%20here">Report Issue</a>
                    <a href="mailto:admin@example.com?subject=Feedback&body=Your%20feedback%20is%20valuable%20to%20us">Feedback</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>