<?php
session_start();

include("config.php");

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
$Hospital = "";
$hidden = "hidden";
$dateTime[] = "";

//my booking list
$booked = "SELECT * FROM `appointment` WHERE `Username` = '{$_SESSION['username']}'";
$booked_query = mysqli_query($db, $booked);

if (isset($_POST['showTime'])) {
    $Hospital = mysqli_real_escape_string($db, $_POST['hospital']);
    $Date = mysqli_real_escape_string($db, $_POST['date']);
    setcookie('Hospital', $Hospital, time() + (86400 * 30), "/");
    setcookie('Date', $Date, time() + (86400 * 30), "/");
    $hidden = "";

    $appoinment = "SELECT * FROM `appointment` WHERE `Hospital` = '{$Hospital}' AND `Date` = '{$Date}' AND (`Status` = 1 OR `Status` = 2)";
    $appoinment_query = mysqli_query($db, $appoinment);
} else {
    $appoinment = "SELECT * FROM `appointment`";
    $appoinment_query = mysqli_query($db, $appoinment);
}

if (isset($_POST['submit'])) {
    $Time = mysqli_real_escape_string($db, $_POST['time']);

    $insert = "INSERT INTO `appointment` (`Hospital` , `Date`, `Time` , `Username` , `Status`) VALUE ('{$_COOKIE['Hospital']}', '{$_COOKIE['Date']}', '{$Time}', '{$_SESSION['username']}', 1)";
    $insert_query = mysqli_query($db, $insert);


    $to =   $_SESSION['email'];
    $sender =   'yourmail@gmail.com'; // send wenna oni mail eka
    $email_subject  =   " titel "; // mokak hari Subject ekak denna.
    $email_body =   '<p>Dear ' . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . '</p>';
    $email_body .=   "<p> MESSAGE </p><br>"; // userta send wenn oni message eka type karanna
    $email_body .=   " <P> MESSAGE </P><br>"; // optional message. oni naththam me line eka ain karanna.

    $header =   "From: {$sender}\r\nContent-type: text/html;";

    $status = mail($to, $email_subject, $email_body, $header);

    if ($insert_query) {
        setcookie("Hospital", "", time() - 36000);
        setcookie("Date", "", time() - 36000);
        header("location:time.php");
    }
}

if (isset($_GET['cancel'])) {
    $cancel = mysqli_real_escape_string($db, $_GET['cancel']);
    $update = "UPDATE `appointment` SET `Status` = 0 WHERE `ID` = {$cancel}";
    $updateQuery = mysqli_query($db, $update);
    if ($updateQuery) {

        $to =   $_SESSION['email'];
        $sender =   'yourmail@gmail.com'; // send wenna oni mail eka
        $email_subject  =   " titel "; // mokak hari Subject ekak denna.
        $email_body =   '<p>Dear ' . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . '</p>';
        $email_body .=   "<p> MESSAGE </p><br>"; // userta send wenn oni message eka type karanna
        $email_body .=   " <P> MESSAGE </P><br>"; // optional message. oni naththam me line eka ain karanna.

        $header =   "From: {$sender}\r\nContent-type: text/html;";

        $status = mail($to, $email_subject, $email_body, $header);
        header("location: time.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CT Scanning Machine Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>

    <style>
        .NetHub_form_aling {
            max-width: 800px;
            width: 100%;
            margin: auto;
            text-align: center;
            padding: 20px 10px;
            box-sizing: border-box;
        }

        .NetHub_form_aling form {
            text-align: left;
        }

        .NetHub_form_aling form select,
        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid lightgray;
            border-radius: 5px;
        }

        .NetHub_form_aling form input[type="submit"] {
            cursor: pointer;
            color: #fff;
            background-color: #343e50;
            font-weight: bold;
        }

        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
        }

        td {
            border-bottom: 1px solid lightgray;
            padding: 10px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->

    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="index.php"><img src="HMSLOGO.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li>
                                <a href="index.php" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>

                            </li>
                            <li>
                                <a href="table.php" aria-expanded="true"><i class="fa fa-table"></i>
                                    <span>Item Records</span></a>
                            </li>
                            <li class="active">
                                <a href="#" aria-expanded="true"><i class="fa fa-medkit"></i>
                                    <span>Scanning Machines</span></a>
                                <ul class="collapse">
                                    <li><a href="time.php">CT Scanning Machine</a></li>
                                    <li><a href="mri_scanning.php">MRI Scanning Machine</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->

        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="search-box pull-left">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div>
                    </div>

                    <!-- profile info & task notification-->
                    <div class="col-md-6 col-sm-4 clearfix">

                    </div>
                </div>
            </div>
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">CT Scann</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Home</a></li>
                                <li><span>CT Scanning Machine</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="HMSLOGO.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['username']; ?> <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">

                                <a class="dropdown-item" href="index.php?logout='1'">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="NetHub_form">
                <div class="NetHub_form_aling">
                    <br>
                    <h2>CT Scanning Machine Booking</h2>
                    <br>
                    <form method="post">
                        <p>
                            Hospital :
                            <select name="hospital" id="hospital" required>
                                <option value=""> Choose Hospital </option>
                                <option value="Hospital One" <?php if ($Hospital == 'Hospital One') {
                                                                    echo "selected";
                                                                } ?>> Hospital One </option>
                                <option value="Hospital Tow" <?php if ($Hospital == 'Hospital Tow') {
                                                                    echo "selected";
                                                                } ?>> Hospital Tow </option>
                            </select>
                        </p>
                        <br>
                        <p>
                            Date :
                            <input type="date" name="date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $Date; ?>" required>
                        </p>
                        <br>
                        <p>
                            <input type="submit" name="showTime" value="Next">
                        </p>
                    </form>
                    <br>
                    <form method="post" <?php echo $hidden; ?>>
                        <p>
                            Time :
                            <select name="time" id="time" required>
                                <option value=""> Choose Time </option>
                                <?php
                                $count = 1;
                                if (mysqli_num_rows($appoinment_query) > 0) {
                                    while ($fetchDateTime = mysqli_fetch_assoc($appoinment_query)) {
                                        $dateTime[] = $fetchDateTime['Time'];
                                    }
                                }
                                $times = "SELECT * FROM `time` WHERE `Time` NOT IN ('{$dateTime[1]}', '{$dateTime[2]}', '{$dateTime[3]}', '{$dateTime[4]}', '{$dateTime[5]}', '{$dateTime[6]}', '{$dateTime[7]}', '{$dateTime[8]}')";
                                $times_query = mysqli_query($db, $times);
                                if (mysqli_num_rows($times_query) > 0) {
                                    while ($time11 = mysqli_fetch_assoc($times_query)) {
                                        echo "<option value='{$time11['Time']}'>" . $time11['Time'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </p>
                        <br>
                        <p>
                            <input type="submit" name="submit" value="Book Now">
                        </p>
                    </form>

                    <br><br>
                    <?php
                    if (mysqli_num_rows($booked_query) > 0) {
                        echo "<h2>CT Scanning Machine Booked List</h2> <br>";
                        echo "<table>";
                        while ($fetchList = mysqli_fetch_assoc($booked_query)) {
                            $fetchHospital = $fetchList['Hospital'];
                            $fetchDate = $fetchList['Date'];
                            $fetchTime = $fetchList['Time'];
                            $fetchID = $fetchList['ID'];
                            $fetchStatus = $fetchList['Status'];
                            if ($fetchStatus == 1) {
                                $link = "<a href='time.php?cancel={$fetchID}'>Cancel</a>";
                            } elseif ($fetchStatus == 0) {
                                $link = "<p style='color: red;'> Canceled </p>";
                            } elseif ($fetchStatus == 2) {
                                $link = "<p style='color: Blue;'> Accepted </p>";
                            }
                            echo "<tr>
                                <td> $fetchHospital </td>
                                <td> $fetchDate </td>
                                <td> $fetchTime </td>
                                <td> $link </td>
                                </tr>";
                        }
                        echo "</table>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- page container area end -->
    <!-- offset area start -->

    <!-- offset area end -->
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>