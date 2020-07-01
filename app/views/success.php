<?php
session_start();

require "../models/database.php";
require "../controllers/authenticator.php";
require "../controllers/user.php";
require "../controllers/position.php";
require "../controllers/candidate.php";
require "../controllers/special.php";
require "../controllers/insert.php";

$authenticator = new Authenticator();
$user = new User();
$position = new Position();
$candidate = new Candidate();
$special = new Special();
$insert = new Insert();
?>

<!DOCTYPE html>
<html>

<head>

</head>

<body>
    <?php

    if (isset($_POST['vote']) || isset($_POST['spVote'])) {

        if (isset($_POST['vote'])) {
            $vote = array($_POST['vote']);

            foreach ($position->getAll() as $pos) {
                $currentPos = $pos['id'];
                $currentYearLevel = $pos['year_level'];
                $votedForCurrentPos = $vote[0][$currentPos];

                foreach ($candidate->getPerPosition($currentPos) as $can) {
                    if ($currentYearLevel === NULL || $currentYearLevel == $user->getYearLevel()) {
                        $currentCandidate = $can['id'];
                        $voteResult = ($votedForCurrentPos != null && $currentCandidate == $votedForCurrentPos) ? 1 : 0;
                        $insert->voteResult($currentCandidate, $user->getID(), $voteResult);
                    } else {
                        continue;
                    }
                }
            }
        }

        if (isset($_POST['spVote'])) {
            $vote = array($_POST['spVote']);

            foreach ($special->getPosition() as $spPos) {
                $currentPos = $spPos['id'];
                $currentYearLevel = $spPos['year_level'];
                $votedForCurrentPos = $vote[0][$currentPos];

                foreach ($special->getPerPosition($currentPos) as $spCan) {
                    if ($currentYearLevel === NULL || $currentYearLevel == $user->getYearLevel()) {
                        $currentCandidate = $spCan['id'];
                        $voteResult = ($votedForCurrentPos != null && $currentCandidate == $votedForCurrentPos) ? 1 : 0;
                        $insert->voteResult($currentCandidate, $user->getID(), $voteResult);
                    } else {
                        continue;
                    }
                }
            }
        }
        $insert->hasVoted();
        session_destroy();
        header("Location: ../../index.php");
        exit;
    }

    if (!isset($_POST['vote']) && !isset($_POST['spVote'])) {
        session_destroy();
        header("Location: ../../index.php");
        exit;
    }

    session_destroy();
    header("Location: ../../index.php");
    exit;
?>

</body>

</html>