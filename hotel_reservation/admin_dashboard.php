<?php

session_start();

include "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}


/* Total Rooms */

$room_query = $conn->query("SELECT COUNT(*) AS total FROM rooms");
$room_data = $room_query->fetch_assoc();
$total_rooms = $room_data['total'];


/* Available Rooms */

$available_query = $conn->query(
    "SELECT COUNT(*) AS total FROM rooms WHERE status = 'Available'"
);

$available_data = $available_query->fetch_assoc();
$available_rooms = $available_data['total'];


/* Total Reservations */

$reservation_query = $conn->query(
    "SELECT COUNT(*) AS total FROM reservations"
);

$reservation_data = $reservation_query->fetch_assoc();
$total_reservations = $reservation_data['total'];


/* Reservation List */

$reservations = $conn->query("
    SELECT 
        reservations.*,
        rooms.room_number,
        rooms.room_type
    FROM reservations
    JOIN rooms
    ON reservations.room_id = rooms.id
    ORDER BY reservations.id DESC
");


/* Room List */

$rooms = $conn->query("
    SELECT * FROM rooms
    ORDER BY id ASC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Grand Stay</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .dashboard-page {
            padding: 50px 7%;
            background: #f8f6f1;
            min-height: 80vh;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .dashboard-header h1 {
            color: #17251f;
            margin-bottom: 8px;
        }

        .dashboard-header p {
            color: #666;
        }

        .logout-btn {
            background: #b08a45;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: #17251f;
        }


        /* Dashboard Cards */

        .dashboard-cards {
            display: flex;
            gap: 25px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            background: white;
            flex: 1;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .dashboard-card h3 {
            color: #666;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .dashboard-card .number {
            font-size: 38px;
            font-weight: bold;
            color: #17251f;
        }


        /* Dashboard Sections */

        .dashboard-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            margin-bottom: 35px;
        }

        .dashboard-section h2 {
            color: #17251f;
            margin-bottom: 25px;
        }


        /* Tables */

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #17251f;
            color: white;
            padding: 14px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        tr:hover {
            background: #faf8f2;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #777;
        }


        /* Room Status */

        .status-available {
            color: #287a32;
            background: #e8f5e9;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
        }

        .status-other {
            color: #c62828;
            background: #ffebee;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
        }


        /* Room Price */

        .room-price {
            font-weight: bold;
            color: #b08a45;
        }


        @media (max-width: 900px) {

            .dashboard-cards {
                flex-direction: column;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
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

        <a href="admin_dashboard.php">Dashboard</a>

    </div>

</nav>


<section class="dashboard-page">


    <!-- Dashboard Header -->

    <div class="dashboard-header">

        <div>

            <p class="small-title">ADMIN PANEL</p>

            <h1>Dashboard</h1>

            <p>
                Welcome,
                <?php echo htmlspecialchars($_SESSION['admin']); ?>.
                Manage your hotel reservations here.
            </p>

        </div>


        <a href="logout.php" class="logout-btn">

            Logout

        </a>

    </div>


    <!-- Dashboard Cards -->

    <div class="dashboard-cards">


        <div class="dashboard-card">

            <h3>Total Rooms</h3>

            <div class="number">

                <?php echo $total_rooms; ?>

            </div>

        </div>


        <div class="dashboard-card">

            <h3>Available Rooms</h3>

            <div class="number">

                <?php echo $available_rooms; ?>

            </div>

        </div>


        <div class="dashboard-card">

            <h3>Total Reservations</h3>

            <div class="number">

                <?php echo $total_reservations; ?>

            </div>

        </div>


    </div>


    <!-- Room Management -->

    <div class="dashboard-section">

        <h2>Room Management</h2>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Room No.</th>

                        <th>Room Type</th>

                        <th>Price / Night</th>

                        <th>Description</th>

                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if ($rooms->num_rows > 0) {

                    while ($room = $rooms->fetch_assoc()) {

                ?>

                    <tr>

                        <td>
                            Room
                            <?php echo htmlspecialchars($room['room_number']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($room['room_type']); ?>
                        </td>

                        <td class="room-price">

                            ₹<?php echo htmlspecialchars($room['price']); ?>

                        </td>

                        <td>
                            <?php echo htmlspecialchars($room['description']); ?>
                        </td>

                        <td>

                            <?php if ($room['status'] == 'Available') { ?>

                                <span class="status-available">

                                    Available

                                </span>

                            <?php } else { ?>

                                <span class="status-other">

                                    <?php echo htmlspecialchars($room['status']); ?>

                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="5" class="no-data">

                            No rooms found.

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- Recent Reservations -->

    <div class="dashboard-section">

        <h2>Recent Reservations</h2>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Guest</th>

                        <th>Email</th>

                        <th>Phone</th>

                        <th>Room</th>

                        <th>Check-in</th>

                        <th>Check-out</th>

                        <th>Guests</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if ($reservations->num_rows > 0) {

                    while ($row = $reservations->fetch_assoc()) {

                ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($row['guest_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['email']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['phone']); ?>
                        </td>

                        <td>

                            Room
                            <?php echo htmlspecialchars($row['room_number']); ?>

                            <br>

                            <?php echo htmlspecialchars($row['room_type']); ?>

                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['check_in']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['check_out']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['guests']); ?>
                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="7" class="no-data">

                            No reservations found.

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>


</section>


<footer>

    <h3>GRAND STAY HOTEL</h3>

    <p>Comfort • Service • Hospitality</p>

    <p>© 2026 Grand Stay Hotel. All Rights Reserved.</p>

</footer>


</body>

</html>