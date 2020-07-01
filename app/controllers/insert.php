<?php

class Insert extends DB {

    private $userID;
    

    function __construct() {
        parent::__construct();

        if (isset($_SESSION['userID'])) {
            $this->userID = $_SESSION['userID'];
        }
    }
    
    function voteResult($candidate, $user, $voteResult) {
        return $this->query("INSERT INTO election_result(candidate_id, student_id, voted) VALUES($candidate, $user, $voteResult);");
    }

    function hasVoted() {
        return $this->query("INSERT INTO voted(student_Id) VALUES ($this->userID);");
    }
}