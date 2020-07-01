<?php

class Position extends DB {

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
        return $this->query("SELECT DISTINCT position.id, position.year_level FROM position
                             INNER JOIN candidate ON candidate.position_id=position.id
                             INNER JOIN department ON department.organization_id=position.organization_id AND department.organization_id=candidate.organization_id
                             WHERE department.id = $this->dprtmntID
                             ORDER BY candidate.position_id ASC;");
    }

    function getRowCount() {
        return $this->queryRow("SELECT DISTINCT position.id FROM position
                                INNER JOIN candidate ON candidate.position_id=position.id
                                INNER JOIN department ON department.organization_id=position.organization_id AND department.organization_id=candidate.organization_id
                                WHERE department.id = $this->dprtmntID
                                ORDER BY candidate.position_id ASC;");
    }
    
}