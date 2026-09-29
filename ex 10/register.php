<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $jobTitle = trim($_POST['jobTitle'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $previousRole = trim($_POST['previousRole'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $workMode = $_POST['workMode'] ?? '';
    $employmentType = $_POST['employmentType'] ?? '';
    $creditCard = trim($_POST['creditCard'] ?? '');

    if (empty($fullName)) {
        $errors[] = "Full Name is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid Email address is required.";
    }

    if (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Phone Number must be exactly 10 digits.";
    }

    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if (empty($jobTitle)) {
        $errors[] = "Desired Job Role is required.";
    }

    if ($experience === "" || !is_numeric($experience) || $experience < 0) {
        $errors[] = "Valid Years of Experience is required.";
    } else {
        if ($experience > 0 && empty($previousRole)) {
            $errors[] = "Previous Job Role is required since experience is greater than 0.";
        }
    }

    if (empty($gender)) {
        $errors[] = "Gender must be selected.";
    }

    if (empty($workMode)) {
        $errors[] = "Preferred Work Mode must be selected.";
    }

    if (empty($employmentType)) {
        $errors[] = "Employment Type must be selected.";
    }

    if (empty($creditCard) || !preg_match('/^[0-9]{16}$/', $creditCard)) {
        $errors[] = "Credit Card Number must be exactly 16 digits.";
    }

} else {
    header("Location: index.php");
    exit();
}

$maskedCard = "";
if (strlen($creditCard) == 16) {
    $maskedCard = "****-****-****-" . substr($creditCard, -4);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: LightSkyBlue;
            padding: 30px;
        }

        .details-container {
            width: 650px;
            margin: 50px auto;
            background: white;
            padding: 25px 30px;
            border: 3px solid DeepSkyBlue;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: DeepSkyBlue;
        }

        .error-box {
            background-color: #ffe6e6;
            color: #d9534f;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ebccd1;
            margin-bottom: 20px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background-color: DeepSkyBlue;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-btn:hover {
            background-color: DodgerBlue;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eeeeee;
            word-break: break-word;
        }

        td.label {
            font-weight: bold;
            color: #555555;
            width: 40%;
        }
    </style>
</head>
<body>

<div class="details-container">

    <?php if (!empty($errors)): ?>
        <h2>Validation Failed!</h2>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="javascript:history.back()" class="back-btn">Go Back and Fix Errors</a>

    <?php else: ?>
        <h2>Registration Successful!</h2>

        <table>
            <tr>
                <td class="label">Full Name:</td>
                <td><?php echo htmlspecialchars($fullName); ?></td>
            </tr>
            <tr>
                <td class="label">Email:</td>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <td class="label">Phone Number:</td>
                <td><?php echo htmlspecialchars($phone); ?></td>
            </tr>
            <tr>
                <td class="label">Password:</td>
                <td>********</td>
            </tr>
            <tr>
                <td class="label">Desired Job Role:</td>
                <td><?php echo htmlspecialchars($jobTitle); ?></td>
            </tr>
            <tr>
                <td class="label">Years of Experience:</td>
                <td><?php echo htmlspecialchars($experience); ?> Years</td>
            </tr>
            <tr>
                <td class="label">Previous Job Role:</td>
                <td>
                    <?php 
                        if (empty(trim($previousRole))) {
                            echo "Fresher";
                        } else {
                            echo htmlspecialchars($previousRole);
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="label">Gender:</td>
                <td><?php echo htmlspecialchars($gender); ?></td>
            </tr>
            <tr>
                <td class="label">Preferred Work Mode:</td>
                <td><?php echo htmlspecialchars($workMode); ?></td>
            </tr>
            <tr>
                <td class="label">Employment Type:</td>
                <td><?php echo htmlspecialchars($employmentType); ?></td>
            </tr>
            <tr>
                <td class="label">Credit Card Number:</td>
                <td><?php echo htmlspecialchars($maskedCard); ?></td>
            </tr>
        </table>
    <?php endif; ?>

</div>

</body>
</html>