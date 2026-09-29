<!DOCTYPE html>
<html>

<head>
    <title>Food Information</title>

<style>
    body {
        font-family: Arial;
        background-color: #fff3e0;
        text-align: center;
        padding: 30px;
    }

    h2 {
        color: #e65100;
        font-size: 30px;
    }

    table {
        width: 85%;
        margin: auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        border-radius: 10px;
        overflow: hidden;
    }

    th {
        background-color: #e65100;
        color: white;
        padding: 15px;
    }

    td {
        padding: 13px;
        border: 1px solid #ffcc80;
    }

    tr:nth-child(even) {
        background-color: #fff8e1;
    }

    tr:hover {
        background-color: #ffe0b2;
    }
</style>
</head>

<body>

    <h2>Food Details</h2>

    <?php

    $xml = simplexml_load_file("food.xml")
           or die("Error: Cannot load XML file.");

    echo "<table>";

    echo "<tr>";
    echo "<th>Food Name</th>";
    echo "<th>Category</th>";
    echo "<th>Price</th>";
    echo "<th>Rating</th>";
    echo "</tr>";

    foreach ($xml->food as $food) {

        echo "<tr>";

        echo "<td>" . $food->name . "</td>";
        echo "<td>" . $food->category . "</td>";
        echo "<td>₹" . $food->price . "</td>";
        echo "<td>" . $food->rating . "</td>";

        echo "</tr>";
    }

    echo "</table>";

    ?>

</body>

</html>