<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DreamLauncher - Job Seeker Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: LightSkyBlue;
            display: flex;
            justify-content: center;
            padding: 30px;
        }

        .form-box {
            background: white;
            width: 900px;
            padding: 25px;
            border: 3px solid DeepSkyBlue;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: DeepSkyBlue;
            margin-bottom: 20px;
        }

        #registrationForm {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full {
            grid-column: 1 / 3;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .radio-group input {
            width: auto;
            margin-right: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: DeepSkyBlue;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: DodgerBlue;
        }
    </style>
</head>

<body>

<div class="form-box">

    <h2>DreamLauncher Registration</h2>

    <form id="registrationForm" action="register.php" method="post">

        <div>
            <label>Full Name *</label>
            <input type="text" name="fullName" placeholder="Enter full name">
        </div>

        <div>
            <label>Email *</label>
            <input type="text" name="email" placeholder="Enter email">
        </div>

        <div>
            <label>Phone Number *</label>
            <input type="text" name="phone" placeholder="Enter phone number">
        </div>

        <div>
            <label>Password *</label>
            <input type="password" name="password" placeholder="Enter password">
        </div>

        <div>
            <label>Desired Job Role *</label>
            <input type="text" name="jobTitle" placeholder="Enter job role">
        </div>

        <div>
            <label>Years of Experience *</label>
            <input type="number" name="experience" min="0" placeholder="Enter year of experience eg. 2">
        </div>

        <div>
            <label>Previous Job Role *</label>
            <input type="text" name="previousRole" placeholder="Enter previous job role">
        </div>

        <div>
            <label>Gender *</label>
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div>
            <label>Preferred Work Mode *</label>
            <div class="radio-group">
                <input type="radio" name="workMode" value="Remote"> Remote
                <input type="radio" name="workMode" value="Offline"> Offline
            </div>
        </div>

        <div>
            <label>Employment Type *</label>
            <div class="radio-group">
                <input type="radio" name="employmentType" value="Full Time"> Full Time
                <input type="radio" name="employmentType" value="Part Time"> Part Time
            </div>
        </div>

        <div class="full">
            <label>Credit Card Number *</label>
            <input type="text" name="creditCard" maxlength="16" placeholder="Enter 16-digit credit card number">
        </div>

        <div class="full">
            <button type="submit">Register</button>
        </div>

    </form>

</div>

</body>
</html>