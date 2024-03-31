<?php
include('config.php');

// Check if form is submitted
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($db, $_POST['product_name']);
    $quant = mysqli_real_escape_string($db, $_POST['quantity']);

    // Perform your update query here
    $update_query = "UPDATE product SET product_name='$name', quantity='$quant' WHERE product_id=$id";
    mysqli_query($db, $update_query);

    // Redirect to table.php after updating
    header("Location: table.php");
    exit(); // Add exit to stop further execution
}

// Check if ID is provided in URL
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $result = mysqli_query($db, "SELECT * FROM product WHERE product_id=$id");

    $row = mysqli_fetch_array($result);

    if ($row) {
        $name = $row['product_name'];
        $quant = $row['quantity'];
    } else {
        echo "No results!";
        // You might want to handle this case more gracefully, e.g., redirecting to an error page.
    }
} else {
    echo "Invalid ID provided!";
    // You might want to handle this case more gracefully, e.g., redirecting to an error page.
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
</head>

<body  background="HMSLOGO.png">
    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />

        <table border="2">
            <tr>
                <td colspan="2"><b><font color='Red'>Edit Records </font></b></td>
            </tr>
            <tr>
                <td width="179"><b><font>Item Name<em>*</em></font></b></td>
                <td><input type="text" name="product_name" value="<?php echo $name; ?>" /></td>
            </tr>

            <tr>
                <td width="179"><b><font color='#663300'>Quantity<em>*</em></font></b></td>
                <td><input type="text" name="quantity" value="<?php echo $quant; ?>" /></td>
            </tr>

            <tr align="Right">
                <td colspan="2"><input type="submit" name="submit" value="Edit Records"></td>
            </tr>
        </table>
    </form>
</body>

</html>
