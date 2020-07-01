<?php

class Authenticator extends DB 
{

    private $error = "";

    function __construct()
    {
        parent::__construct();
    }

    function checkLoggedOut()
    {
        if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
            header("Location: ../../index.php");
            exit;
        }
    }

    function checkLoggedIn()
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
            header("Location: ./app/views/vote.php");
            exit;
        }
    }

    function authenticate()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (is_numeric($_POST["student_id"])) {
                $studentID = $_POST["student_id"];
                $existingUser = $this->query("SELECT * FROM student where student.id = $studentID;");
                $hasVoted = $this->query("SELECT * FROM voted where voted.student_id = $studentID;");

                if ($existingUser) {
                    if (!$hasVoted) {
                        $_SESSION['userID'] = $existingUser[0]["id"];
                        $_SESSION['userName'] = $existingUser[0]["name"];

                        if ($existingUser[0]["year_level"] > 4) {
                            $_SESSION['userYearLevel'] = 4;
                        } else {
                            $_SESSION['userYearLevel'] = $existingUser[0]["year_level"];
                        }

                        $_SESSION['userDprtmntID'] = $existingUser[0]["department_id"];

                        $_SESSION['loggedIn'] = true;

                        header("Location: ./app/views/vote.php");
                        exit;
                    }
                    $this->error = "You have already voted";
                } else {
                    $this->error = "You have entered an invalid or non-existing Student ID.";
                }
            }
            else {
                $this->error = "Enter only numbers.";
            }
        }
    }

    function errorMsg()
    {
        return $this->error;
    }
}
