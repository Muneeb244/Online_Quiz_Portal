<?php
session_start();

// Connect to the database
$sever = "localhost";
$username = "root";
$password = "";
$database = "quizdb";
$conn = mysqli_connect($sever, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query the database
$result = mysqli_query($conn, "SELECT question FROM questions");
echo $result->num_rows . "<br>";

// Initialize an empty array
$rows = array();
$i = 0;

// Fetch the rows from the result set
while ($row = mysqli_fetch_assoc($result)) {
    // Add the row to the array
    $rows[$i] = $row['question'];
    // echo $rows[$i]  . "<br>";
    $i++;
}

// Close the connection
mysqli_close($conn);

for ($i = 0; $i < count($rows); $i++) {
    echo $rows[$i] . "<br>";
}

// store $rows array in session

$json = json_encode($rows);
$_SESSION['questions'] = $json;
echo $json;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>temp</title>
</head>

<body>

    <script>
        // Parse the JSON string into a JavaScript array
        var data = JSON.parse('<?php echo $_SESSION['questions']; ?>');
        data.map(value => {
            console.log(value);
        })
    </script>
</body>

</html>