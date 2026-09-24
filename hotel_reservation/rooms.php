<?php
include "db.php";

$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Rooms - Grand Stay</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        .rooms-page {
            padding: 70px 8%;
            background: #f8f6f1;
            min-height: 80vh;
        }

        .rooms-heading {
            text-align: center;
            margin-bottom: 45px;
        }

        .rooms-heading .small-title {
            color: #b08a45;
        }

        .rooms-heading h1 {
            font-size: 42px;
            margin-bottom: 12px;
        }

        .rooms-heading p {
            color: #666;
        }

        .rooms-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        .room-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            padding: 30px;
        }

        .room-number {
            color: #b08a45;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .room-card h2 {
            margin: 10px 0;
            color: #17251f;
        }

        .room-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .room-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price {
            font-size: 22px;
            font-weight: bold;
            color: #17251f;
        }

        .price span {
            font-size: 13px;
            color: #777;
            font-weight: normal;
        }

        .book-btn {
            background: #17251f;
            color: white;
            padding: 11px 18px;
            text-decoration: none;
            border-radius: 5px;
        }

        .book-btn:hover {
            background: #b08a45;
        }

        .available {
            display: inline-block;
            margin-top: 5px;
            color: green;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .rooms-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="logo">GRAND STAY</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="rooms.php">Rooms</a>
        <a href="reservation.php">Reservation</a>
        <a href="login.php">Admin</a>
    </div>
</nav>

<section class="rooms-page">

    <div class="rooms-heading">
        <p class="small-title">STAY WITH COMFORT</p>
        <h1>Our Rooms</h1>
        <p>Choose a room that suits your stay.</p>
    </div>

    <div class="rooms-container">

        <?php while($room = $result->fetch_assoc()) { ?>

            <div class="room-card">

                <div class="room-number">
                    ROOM <?php echo $room['room_number']; ?>
                </div>

                <h2><?php echo $room['room_type']; ?></h2>

                <p>
                    <?php echo $room['description']; ?>
                </p>

                <span class="available">
                    ● <?php echo $room['status']; ?>
                </span>

                <div class="room-bottom">

                    <div class="price">
                        ₹<?php echo $room['price']; ?>
                        <span>/ night</span>
                    </div>

                    <a href="reservation.php?room_id=<?php echo $room['id']; ?>"
                       class="book-btn">
                        Book Now
                    </a>

                </div>

            </div>

        <?php } ?>

    </div>

</section>

<footer>
    <h3>GRAND STAY HOTEL</h3>
    <p>Comfort • Service • Hospitality</p>
    <p>© 2026 Grand Stay Hotel. All Rights Reserved.</p>
</footer>

</body>
</html>