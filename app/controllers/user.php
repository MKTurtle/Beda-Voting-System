<?php
class User extends DB {

    private $userID;
    private $userName;
    private $userYearLevel;
    private $userDprtmntID;

    private $allDetails;

    function __construct(){
        parent::__construct();

        if (isset($_SESSION['userID'])) {
            $this->userID = $_SESSION['userID'];
            $this->userName = $_SESSION['userName'];
            $this->userYearLevel = $_SESSION['userYearLevel']; 
            $this->userDprtmntID = $_SESSION['userDprtmntID'];

            $this->allDetails = $this->query("SELECT * FROM student WHERE id = $this->userID;");
        }
    }

    function getAll() {
        
        return $this->allDetails;
    }

    function getID() {
        return $this->userID;
    }

    function getName() {
        return $this->userName;
    }

    function getYearLevel() {
        return $this->userYearLevel;
    }

    function getDepartment() {
        return $this->userDprtmntID;
    }

    function getRowCount() {
        return $this->queryRow("SELECT * FROM student WHERE id = $this->userID;");
    }
}
?>