<?php

include "db_connect.php";

$sql = "SELECT * FROM bookings ORDER BY booking_date DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>All Movie Bookings</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background:lavender;
        }

        .container {
            width: 95%;
            max-width: 1200px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            color: #4f46e5;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #4f46e5;
            color: white;
            padding: 14px;
        }

        td {
            padding: 13px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f1f5ff;
        }

        .empty {
            text-align: center;
            color: #777;
        }

        .back {
            text-align: center;
            margin-top: 25px;
        }

        .back a {
            display: inline-block;
            padding: 12px 20px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .back a:hover {
            background: #3730a3;
        }

    </style>

</head>

<body>

<div class="container">

    <h2>🎬 All Movie Bookings</h2>

    <table>

        <tr>
            <th>Booking ID</th>
            <th>Customer</th>
            <th>Movie</th>
            <th>Show Date</th>
            <th>Show Time</th>
            <th>Tickets</th>
            <th>Price</th>
            <th>Booking Date</th>
        </tr>

        <?php if ($result->num_rows > 0) { ?>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo $row['booking_id']; ?>
                    </td>

                    <td>
                        <?php echo $row['customer_name']; ?>
                    </td>

                    <td>
                        <?php echo $row['movie_name']; ?>
                    </td>

                    <td>
                        <?php echo $row['show_date']; ?>
                    </td>

                    <td>
                        <?php echo $row['show_time']; ?>
                    </td>

                    <td>
                        <?php echo $row['tickets']; ?>
                    </td>

                    <td>
                        ₹<?php echo $row['price']; ?>
                    </td>

                    <td>
                        <?php echo $row['booking_date']; ?>
                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>

                <td colspan="8" class="empty">
                    No bookings found.
                </td>

            </tr>

        <?php } ?>

    </table>

    <div class="back">

        <a href="index.html">
            ← Book Another Ticket
        </a>

    </div>

</div>

</body>

</html>

<?php

$conn->close();

?>