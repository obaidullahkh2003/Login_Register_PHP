<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>
    <?php
    // Extract POST data
    extract($_POST);

    // Database connection details
    $serverNAME = 'localhost:3306';
    $dbUserName = 'root';
    $dbPassword = 'admin';
    $dbName = 'customers';

    // Establish database connection
    $conn = mysqli_connect($serverNAME, $dbUserName, $dbPassword, $dbName);

    // Check if connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Calculate prices
    $keyprice = $Key * 10;
    $mouprice = $mou * 8;
    $heaprice = $hea * 20;
    $mobprice = $mob * 5;
    $conprice = $con * 18;
    $phoprice = $pho * 15;

    // Print individual prices
    echo "Your price for Keyboard: $keyprice JD<br>";
    echo "Your price for Mouse: $mouprice JD<br>";
    echo "Your price for Headset: $heaprice JD<br>";
    echo "Your price for Mousepad: $mobprice JD<br>";
    echo "Your price for Controller: $conprice JD<br>";
    echo "Your price for Microphone: $phoprice JD<br>";

    // Calculate total bill
    $total = $keyprice + $mouprice + $heaprice + $mobprice + $conprice + $phoprice;
    echo "Your total bill is: $total JD<br>";

    // Retrieve current credit balance
    $query = "SELECT creditbalance FROM login_pssword WHERE customer_id=$id";
    $r = mysqli_query($conn, $query);

    if (!$r || mysqli_num_rows($r) < 1) {
        header("Location:products.html?error=sqlerror");
        exit();
    } else {
        $row = mysqli_fetch_assoc($r);
        $total1 = $row['creditbalance'];
    }

    // Calculate new credit balance
    $crbalance = $total1 - $total;
    echo "Your balance is: $crbalance JD";

    // Update credit balance in the database
    $sql = "UPDATE login_pssword SET creditbalance=? WHERE customer_id=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:products.html?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $crbalance, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
