<?php

session_start();

include "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $room_id = $_POST['room_id'];
    $status = $_POST['status'];

    $sql = "UPDATE rooms SET status = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("si", $status, $room_id);

    $stmt->execute();
}


header("Location: admin_dashboard.php");

exit();

?>