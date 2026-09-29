<?php

include "db_connect.php";

$customer_name = $_POST['customer_name'];
$movie_name = $_POST['movie_name'];
$show_date = $_POST['show_date'];
$show_time = $_POST['show_time'];
$tickets = $_POST['tickets'];
$price = $_POST['price'];

$sql = "INSERT INTO bookings
(customer_name, movie_name, show_date, show_time, tickets, price)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssid",
    $customer_name,
    $movie_name,
    $show_date,
    $show_time,
    $tickets,
    $price
);

if ($stmt->execute()) {
?>

<!DOCTYPE html>
<html>
<head>

<title>Booking Successful</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: lavender;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.success-box {
    width: 450px;
    background: white;
    padding: 40px;
    text-align: center;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
}

.icon {
    width: 70px;
    height: 70px;
    background: #22c55e;
    color: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto 20px;
    font-size: 38px;
    font-weight: bold;
}

h2 {
    color: #16a34a;
}

p {
    color: #666;
    margin-bottom: 25px;
}

.button {
    display: inline-block;
    padding: 12px 20px;
    background: #4f46e5;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    margin: 5px;
}

.button:hover {
    background: #3730a3;
}

</style>

</head>

<body>

<div class="success-box">

    <div class="icon">✓</div>

    <h2>Ticket Booked Successfully!</h2>

    <p>Your movie ticket has been booked successfully.</p>

    <a href="view_bookings.php" class="button">
        View Bookings
    </a>

    <a href="index.html" class="button">
        Book Another Ticket
    </a>

</div>

</body>
</html>

<?php

} else {

    echo "Booking Failed: " . $stmt->error;

}

$stmt->close();
$conn->close();

?>