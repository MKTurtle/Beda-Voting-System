<?php
class Election extends DB {

    private $department_id;

    function __construct() {
        parent::__construct();

        if(isset($_SESSION['userDprtmntID'])) {
            $this->department_id = $_SESSION['userDprtmntID'];
        }
    }

    function getPositions() {
        return $this->query("SELECT DISTINCT candidate.position_id, position.year_level FROM candidate 
                             INNER JOIN position ON candidate.position_id=position.id
                             WHERE candidate.department_id = $this->department_id AND position.department_id = $this->department_id
                             ORDER BY candidate.position_id ASC;");
    }

    function getCandidates() {
        return $this->query("SELECT candidate.id, candidate.student_id, candidate.position_id, student.name FROM candidate 
                             INNER JOIN student ON candidate.student_id=student.id
                             WHERE candidate.department_id = $this->department_id
                             ORDER BY candidate.position_id ASC;");
    }

    function getCandidateByPosition($current_position, $user_department_id) {
        return $this->query("SELECT candidate.id FROM candidate WHERE candidate.position_id=$current_position AND candidate.department_id=$user_department_id;");
    }

    /*


    HIWALAY MO SA DALAWA. POSITION AT CANDIDATE, AT AYUSIN MO ANG MGA METHODS.
    CAMELCASE MO LAHAT NG MGA VARIABLE.


    */
}
?>