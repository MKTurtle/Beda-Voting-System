<?php

class Candidate extends DB {

    private $dprtmntID;

    function __construct() {
        parent::__construct();

        if(isset($_SESSION['userDprtmntID']) && isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
            $this->dprtmntID = $_SESSION['userDprtmntID'];
        }else {
            session_destroy();
            header("Location: ../../index.php");
            exit;
        }
    }

    function getAll() {
        return $this->query("SELECT candidate.id, candidate.student_id, candidate.position_id, candidate.organization_id, student.name FROM candidate 
                             INNER JOIN student ON student.id=candidate.student_id
                             INNER JOIN department ON department.organization_id=candidate.organization_id
                             WHERE department.id=$this->dprtmntID
                             ORDER BY candidate.position_id ASC;");;
    }

    function getPerPosition($currentPos) {
        return $this->query("SELECT candidate.id FROM candidate 
                             INNER JOIN department ON department.organization_id=candidate.organization_id AND department.id=$this->dprtmntID
                             WHERE candidate.position_id=$currentPos;");
    }
}