<?php

$ques_remove = false;
$check = false;
$remove = 0;

if (isset($_POST['delete'])) {

    $sever = "localhost";
    $username = "root";
    $password = "";
    $database = "quizdb";
    $con = mysqli_connect($sever, $username, $password, $database);

    if (!$con) {
        die("Connection to this database failed due to" . mysqli_connect_error());
    }


    if (!isset($_COOKIE['remove'])) {
        $check = true;

    }else{
        $remove = $_COOKIE['remove'];   
    }

    if (deleteQuestion($con, $remove) && deleteOption($con, $remove) && deleteAnswer($con, $remove)) {
        $ques_remove = true;
    }
}



function deleteQuestion($con, $remove)
{
    $sql = "DELETE FROM `questions` WHERE `questions`.`opt_id` = $remove";
    $result = $con->query($sql);
    if ($result == true) {
        return true;
    }
    return false;
}

function deleteOption($con, $remove)
{
    $sql = "DELETE FROM `options` WHERE `options`.`opt_id` = $remove";
    $result = $con->query($sql);
    if ($result == true) {
        return true;
    }
    return false;
}

function deleteAnswer($con, $remove)
{
    $sql = "DELETE FROM `answer` WHERE `answer`.`opt_id` = $remove";
    $result = $con->query($sql);
    if ($result == true) {
        return true;
    }
    return false;
}
