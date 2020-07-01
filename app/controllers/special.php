<?php

class Special extends DB {

    private $department_id;

    function __construct() {
        parent::__construct();

        if(isset($_SESSION['userDprtmntID']) && isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
            $this->department_id = $_SESSION['userDprtmntID'];
        }else {
            session_destroy();
            header("Location: ../../index.php");
            exit;
        }
    }

    function getCandidate() {
        return $this->query("SELECT special_candidate.id, special_candidate.student_id, special_candidate.position_id, student.name FROM special_candidate
                             INNER JOIN student ON student.id=special_candidate.student_id;");
    }

    function getPosition() {
        return $this->query("SELECT * FROM special_position;");
    }

    function getPerPosition($currentPos) {
        return $this->query("SELECT special_candidate.id FROM special_candidate 
                             WHERE special_candidate.position_id=$currentPos;");
    }

    function getPositionRowCount() {
        return $this->queryRow("SELECT * FROM special_position;");
    }

    function getRowToken($posToken) {
        return $this->queryRow("SELECT * from special_candidate
                                INNER JOIN special_position on special_position.id=special_candidate.position_id
                                WHERE special_position.id=$posToken;");
    }
}