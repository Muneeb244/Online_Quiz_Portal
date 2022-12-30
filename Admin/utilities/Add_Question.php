<?php
session_start();
$question_insert = false;
$option_insert = false;
$temp = false;
$_SESSION['duplicate'] = false;
$insert = false;
// $issue = false;
$selected = 0;

function quesNum($con)
{
    $ques_num = ("SELECT * FROM questions ORDER BY sno DESC LIMIT 1");
    $ques_num = $con->query($ques_num);
    $result =  $ques_num->fetch_assoc();
    if (isset($result['sno'])) {
        $result = ++$result['sno'];
    } else {
        $result = 1;
    }
    return $result;
}

function optNum($con)
{
    $ques_num = ("SELECT * FROM questions ORDER BY sno DESC LIMIT 1");
    $ques_num = $con->query($ques_num);
    $result =  $ques_num->fetch_assoc();
    if (isset($result['opt_id'])) {
        $result = ++$result['opt_id'];
    } else {
        $result = 1;
    }
    return $result;
}

function AddQuestion($con, $question)
{
    $result = quesNum($con);

    $dup = "select * from questions where question = '$question'";
    $dup = $con->query($dup);
    if ($dup->num_rows > 0) {
        $_SESSION['duplicate'] = true;
    } else {
        $sql = "INSERT INTO `questions` (`question`, `opt_id`) VALUES ('$question', '$result')";


        if ($con->query($sql) == true) {

            $question_insert = true;
            return $question_insert;
        }
        return false;
    }
}

function AddOption($con, $option1, $option2, $option3, $option4)
{

    $result = quesNum($con) - 1;

    $sql = "INSERT INTO `options` (`ques_option`, `opt_id`) VALUES ('$option1', '$result')";
    $sql1 = "INSERT INTO `options` (`ques_option`, `opt_id`) VALUES ('$option2', '$result')";
    $sql2 = "INSERT INTO `options` (`ques_option`, `opt_id`) VALUES ('$option3', '$result')";
    $sql3 = "INSERT INTO `options` (`ques_option`, `opt_id`) VALUES ('$option4', '$result')";


    if ($con->query($sql) == true && $con->query($sql1) == true && $con->query($sql2) == true && $con->query($sql3) == true) {

        // Flag for successful insertion
        $option_insert = true;
        return $option_insert;
    }
    return false;
}

if (isset($_POST['submit'])  && !empty($_POST['question']) && !empty($_POST['option1']) && !empty($_POST['option2']) && !empty($_POST['option3']) && !empty($_POST['option4']) && isset($_POST['optradio'])) {
    // if (isset($_POST['submit'])) {
    $sever = "localhost";
    $username = "root";
    $password = "";
    $database = "quizdb";
    $con = mysqli_connect($sever, $username, $password, $database);

    if (!$con) {
        die("Connection to this database failed due to" . mysqli_connect_error());
    }


    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    // echo ($option1);
    // echo ($option2);
    // echo ($option3);
    // echo ($option4);

    $result = optNum($con);
    $answer = 0;

    if (isset($_COOKIE['myCookie'])) {
        $cookieValue = $_COOKIE['myCookie'];
        $answer = "";
        if ($cookieValue == "1") {
            $answer = $option1;
        } else if ($cookieValue == "2") {
            $answer = $option2;
        } else if ($cookieValue == "3") {
            $answer = $option3;
        } else if ($cookieValue == "4") {
            $answer = $option4;
        } else {
            $insert = false;
        }
    }

    // echo "$answer";


    $ans = "INSERT INTO `answer` (`answer`, `opt_id`) VALUES ('$answer', '$result')";


    if (AddQuestion($con, $question) == true && AddOption($con, $option1, $option2, $option3, $option4) == true && $con->query($ans) == true) {
        // if (AddQuestion($con, $question) == true) {
        $insert = true;
    }

    $con->close();
}


// Getting data from mysqli and store in an array **********************************

// function dataToArray()
// {
//     $sever = "localhost";
//     $username = "root";
//     $password = "";
//     $database = "quizdb";
//     $con = mysqli_connect($sever, $username, $password, $database);

//     $sql = "select * from questions";
//     $sql = $con->query($sql);
//     $num_rows = mysqli_num_rows($sql);
//     $rows = array();

//     if (!($num_rows > 0)) {
//         echo "no rows";
//     } else {
//         $sql = "SELECT question FROM questions";
//         $result = mysqli_query($con, $sql);
//         if (!$result) {
//             die("Query failed: " . mysqli_error($con));
//         }
//         // var_dump($result);
//         $i = 1;
//         while ($row = mysqli_fetch_assoc($result)) {
//             // echo var_dump($row) . "<br>";
//             echo $row['question'];
//             // $rows[] = $row;
//             // $i = $i + 1;

//         }
//     }
//     // $string = implode(',', $rows);

// }


// dataToArray(); ****************************************************************