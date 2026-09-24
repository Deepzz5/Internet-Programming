<?php

include "db.php";

$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : "";

$sql = "SELECT * FROM rooms WHERE status = 'Available'";
$result = $conn->query($sql);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $guest_name = $_POST['guest_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guests = $_POST['guests'];


    // Check for double booking

    $check_booking = "SELECT id FROM reservations
                      WHERE room_id = ?
                      AND check_in < ?
                      AND check_out > ?";

    $booking_stmt = $conn->prepare($check_booking);

    $booking_stmt->bind_param(
        "iss",
        $room_id,
        $check_out,
        $check_in
    );

    $booking_stmt->execute();

    $booking_result = $booking_stmt->get_result();


    if ($booking_result->num_rows > 0) {

        $message = "Selected room is already booked for these dates.";

    } else {


        // Insert reservation using prepared statement

        $insert = "INSERT INTO reservations
        (guest_name, email, phone, room_id, check_in, check_out, guests)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $insert_stmt = $conn->prepare($insert);

        $insert_stmt->bind_param(
            "sssissi",
            $guest_name,
            $email,
            $phone,
            $room_id,
            $check_in,
            $check_out,
            $guests
        );


        if ($insert_stmt->execute()) {

            $message = "Reservation successful!";

        } else {

            $message = "Reservation failed. Please try again.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reservation - Grand Stay</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .reservation-page {
            min-height: 80vh;
            padding: 70px 8%;
            background: #f8f6f1;
        }

        .reservation-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .reservation-title h1 {
            font-size: 42px;
            color: #17251f;
            margin-bottom: 10px;
        }

        .reservation-title p {
            color: #666;
        }

        .reservation-box {
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 15px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #b08a45;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: #17251f;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #b08a45;
        }

        .success-message {
            background: #e8f5e9;
            color: #287a32;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        @media (max-width: 768px) {

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .reservation-box {
                padding: 25px;
            }

            .reservation-title h1 {
                font-size: 32px;
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


<section class="reservation-page">

    <div class="reservation-title">

        <p class="small-title">BOOK YOUR STAY</p>

        <h1>Make a Reservation</h1>

        <p>Fill in your details and reserve your room.</p>

    </div>


    <div class="reservation-box">


        <?php if ($message == "Reservation successful!") { ?>

            <div class="success-message">

                <?php echo $message; ?>

            </div>

        <?php } ?>


        <?php if (
            $message == "Reservation failed. Please try again." ||
            $message == "Selected room is already booked for these dates."
        ) { ?>

            <div class="error-message">

                <?php echo $message; ?>

            </div>

        <?php } ?>


        <form method="POST"
              onsubmit="return validateReservation();">


            <!-- Guest Name and Email -->

            <div class="form-row">

                <div class="form-group">

                    <label>Guest Name</label>

                    <input type="text"
                           name="guest_name"
                           id="guest_name"
                           placeholder="Enter your name"
                           required>

                </div>


                <div class="form-group">

                    <label>Email</label>

                    <input type="email"
                           name="email"
                           id="email"
                           placeholder="Enter your email"
                           required>

                </div>

            </div>


            <!-- Phone and Guests -->

            <div class="form-row">

                <div class="form-group">

                    <label>Phone Number</label>

                    <input type="tel"
                           name="phone"
                           id="phone"
                           placeholder="Enter 10-digit phone number"
                           maxlength="10"
                           required>

                </div>


                <div class="form-group">

                    <label>Number of Guests</label>

                    <input type="number"
                           name="guests"
                           id="guests"
                           min="1"
                           max="10"
                           value="1"
                           required>

                </div>

            </div>


            <!-- Room Selection -->

            <div class="form-group">

                <label>Select Room</label>

                <select name="room_id"
                        id="room_id"
                        required>

                    <option value="">Choose a room</option>


                    <?php while($room = $result->fetch_assoc()) { ?>

                        <option value="<?php echo $room['id']; ?>"
                            <?php

                            if ($room_id == $room['id']) {

                                echo "selected";

                            }

                            ?>>

                            Room <?php echo $room['room_number']; ?>

                            -

                            <?php echo $room['room_type']; ?>

                            -

                            ₹<?php echo $room['price']; ?>/night

                        </option>

                    <?php } ?>


                </select>

            </div>


            <!-- Dates -->

            <div class="form-row">

                <div class="form-group">

                    <label>Check-in Date</label>

                    <input type="date"
                           name="check_in"
                           id="check_in"
                           required>

                </div>


                <div class="form-group">

                    <label>Check-out Date</label>

                    <input type="date"
                           name="check_out"
                           id="check_out"
                           required>

                </div>

            </div>


            <button type="submit"
                    class="submit-btn">

                Confirm Reservation

            </button>


        </form>

    </div>

</section>


<footer>

    <h3>GRAND STAY HOTEL</h3>

    <p>Comfort • Service • Hospitality</p>

    <p>© 2026 Grand Stay Hotel. All Rights Reserved.</p>

</footer>


<script>

function validateReservation() {

    let name = document.getElementById("guest_name").value.trim();

    let email = document.getElementById("email").value.trim();

    let phone = document.getElementById("phone").value.trim();

    let room = document.getElementById("room_id").value;

    let guests = document.getElementById("guests").value;

    let checkIn = document.getElementById("check_in").value;

    let checkOut = document.getElementById("check_out").value;


    // Guest name validation

    if (name.length < 3) {

        alert("Please enter a valid guest name.");

        return false;

    }


    // Email validation

    let emailPattern =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {

        alert("Please enter a valid email address.");

        return false;

    }


    // Phone validation

    if (!/^[0-9]{10}$/.test(phone)) {

        alert("Please enter a valid 10-digit phone number.");

        return false;

    }


    // Room validation

    if (room === "") {

        alert("Please select a room.");

        return false;

    }


    // Guest count validation

    if (guests < 1 || guests > 10) {

        alert("Number of guests must be between 1 and 10.");

        return false;

    }


    // Date validation

    if (checkIn === "" || checkOut === "") {

        alert("Please select both check-in and check-out dates.");

        return false;

    }


    let today = new Date();

    today.setHours(0, 0, 0, 0);

    let selectedCheckIn = new Date(checkIn);

    let selectedCheckOut = new Date(checkOut);


    if (selectedCheckIn < today) {

        alert("Check-in date cannot be in the past.");

        return false;

    }


    if (selectedCheckOut <= selectedCheckIn) {

        alert("Check-out date must be after check-in date.");

        return false;

    }


    // Final confirmation

    let confirmation = confirm(
        "Are you sure you want to confirm this reservation?"
    );


    if (!confirmation) {

        return false;

    }


    return true;

}


// Prevent past check-in dates

let today = new Date();

let year = today.getFullYear();

let month = String(today.getMonth() + 1).padStart(2, "0");

let day = String(today.getDate()).padStart(2, "0");

let currentDate = year + "-" + month + "-" + day;


document.getElementById("check_in").setAttribute("min", currentDate);

document.getElementById("check_out").setAttribute("min", currentDate);

</script>


</body>

</html>