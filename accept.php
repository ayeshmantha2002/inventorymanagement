<?php

include("config.php");

if (isset($_GET['CTID'])) {
    $ID = mysqli_real_escape_string($db, $_GET['CTID']);

    $update = "UPDATE `appointment` SET `Status` = 2 WHERE ID = {$ID}";
    $update_query = mysqli_query($db, $update);

    if ($update_query) {
        header("location: view_ct.php");
    }
}


if (isset($_GET['MRIID'])) {
    $ID = mysqli_real_escape_string($db, $_GET['MRIID']);

    $update = "UPDATE `appointment_mri` SET `Status` = 2 WHERE ID = {$ID}";
    $update_query = mysqli_query($db, $update);

    if ($update_query) {
        header("location: view_mri.php");
    }
}
