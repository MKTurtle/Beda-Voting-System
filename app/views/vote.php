<?php
session_start();

require "../models/database.php";
require "../controllers/authenticator.php";
require "../controllers/user.php";
require "../controllers/position.php";
require "../controllers/candidate.php";
require "../controllers/special.php";

$authenticator = new Authenticator();
$user = new User();
$position = new Position();
$candidate = new Candidate();
$special = new Special();

$authenticator->checkLoggedOut();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <title>Voting System</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        html {
            background-color: red;
            width: 100%;
            background: url(../../web/images/bg.png) no-repeat center center fixed; 
            background-size: cover;
        }
		
		h1 {
			padding: 5px;
		
			color: white;
		
			text-align: center;
		}
        
        h3 {
            position: absolute;
            top: 0;
            left: 0;

            margin: 20px;
        }

        .tab {
            position: relative;
			display: none;
			flex-wrap: wrap;
			justify-content: center;
			align-items: flex-end;	
            
            width: 80%;
            margin: 30px auto;
            padding: 20px;

			background-color: white;
            border-radius: 5px;
        }


        .candidate {
            position: relative;
            display: inline-block;

            width: 80%;
            margin: 15px;

            border-radius: 5px;

            text-align: center;
        }

        .powered {
            position: absolute;
            bottom: 0;
            left: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;	

            width: 30%;
            margin: 5px;
        }

        .img {
            width: 15%;
            margin: 0px 10px;
        }

        .warning {
            display: block;
            position: absolute;
            bottom: 0;
            right: 0;

            color: red;
            background-color: white;

            font-size: 16px;
        }

        img {
            width: 100%;
		
			border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        span {
			display: block;
			
			padding: 10px 10px;
			
			background-color: #f1f1f1;
			
            font-size: 16px;
        }

        input {
            position: absolute;
			
            opacity: 0;
        }

        label {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;

            width: 100%;
            height: 100%;

            cursor: pointer;
            z-index: 999;
        }

        .checker {
            background-color: #ff6961;
            width: 100%;
            padding: 5%;

            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        input:checked+label+div {
            background-color: #77dd77;
        }

        .btnHandler {
            position: relative;

            width: 80%;
            margin: 0 auto;

            text-align: right;
        }

        .btn { /* W3School Design */
            display: inline-block;
            
            margin: 5px;
            padding: 10px 30px;

            background-color: #77dd77;
            color: #282828;
            border: 1px solid #282828;;
            border-radius: 5px;

            font-size: 18px;
            text-align: center;
            text-decoration: none;

            cursor: pointer;
        }
		
		@media only screen and (max-width: 500px) {
			.container {
				width: 90%;
			}
			
			span {
				font-size: 13px;
			}

            h3 {
                margin: 15px;

                font-size: 14px;
            }
			
			.checker {
				padding: 4%;
			}

            .btnHandler {
                text-align: center;
            }

            .warning {
                position: relative;
                margin: 10px;
            }
			
		}

		/* Tablet Styles */
		@media only screen and (min-width: 501px) and (max-width: 960px) {
			.container {
				width: 70%;
			}
			
			span {
				padding: 15px 10px;
				font-size: 14px;
			}

            .btnHandler {
                text-align: center;
            }
			
		}

		/* Desktop Styles */
		@media only screen and (min-width: 961px) {
			.candidate {
				width: 25%;
			
			}
		}



    </style>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>

<body>
    <?php
    echo "<form method='post' id='regForm' action='success.php' class='voting_form'>";

    if ($position->getRowCount() > 0) {
        foreach ($position->getAll() as $pos) {
            $posID = $pos['id'];
            $posYearLevel = $pos['year_level'];
    
            if ($posYearLevel === NULL || $posYearLevel == $user->getYearLevel()) {
                echo "<div class='tab'>";

                    foreach ($candidate->getAll() as $can) {
                        $canID = $can['id'];
                        $canName = $can['name'];
                        $posToken = $can['position_id'];
                        
                        if ($posID == $posToken) {
                            echo "<div class='candidate'>";
                                echo "<img src='../../web/images/candidate/$canID.png' alt='Candidate no. $canID'/>";
                                echo "<span> $canName </span>";

                                echo "<input type='radio' id='$canID' name='vote[$posID]' value=$canID>";
                                echo "<label for='$canID'></label>";

                                echo "<div class='checker'></div>";
                            echo "</div>";
                        }
                    }
                echo "</div>";
            } else {
                continue;
            }
        }
    } else {
        echo "<div class='tab'>";
            echo "There are no candidates currently running for your organization. Please Click Next.";          
        echo "</div>";
    }
    
    if($special->getPositionRowCount() > 0) {
        foreach ($special->getPosition() as $spPos) {
            $spPosID = $spPos['id'];
            $spPosName = $spPos['name'];
            $spPosYearLevel = $spPos['year_level'];
    
            if ($spPosYearLevel === NULL && $special->getRowToken($spPosID) > 0 || $spPosYearLevel == $user->getYearLevel()) {
                echo "<div class='tab'>";
                    echo" <h3> $spPosName </h3>";
                    foreach ($special->getCandidate() as $spCan) {
                        $spCanID = $spCan['id'];
                        $spCanName = $spCan['name'];
                        $spPosToken = $spCan['position_id'];
                        
                        if ($spPosID == $spPosToken) {
                            echo "<div class='candidate'>";
                                echo "<img src='../../web/images/specialcandidate/$spCanID.png' alt='Candidate no. $spCanID'/>";
                                echo "<span> $spCanName </span>";

                                echo "<input type='radio' id='$spCanID' name='spVote[$spPosID]' value=$spCanID>";
                                echo "<label for='$spCanID'></label>";

                                echo "<div class='checker'></div>";
                            echo "</div>";
                        }
                    }
                    echo"<span class='warning'>*Red means abstain, Green means vote. <br> *Click the candidate to vote.</span>";
                echo "</div>";
            } else {
                continue;
            }
        }
    } else {
        echo "<div class='tab'>";
            echo "There are no SEC candidates currently running for this school year. Please Click Next.";
        echo "</div>";
    }
    
    
    ?>
    
    <div style="overflow:auto;">
        <div class="btnHandler">
            <button class="btn" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button class="btn" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </div>
    </form>

    <script>
        $("input:radio").on("click", function (e) {
            var inp = $(this); //cache the selector
            if (inp.is(".theone")) { //see if it has the selected class
                inp.prop("checked", false).removeClass("theone");
                return;
            }
            $("input:radio[name='" + inp.prop("name") + "'].theone").removeClass("theone");
            inp.addClass("theone");
        });

    </script>
</body>

<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form ...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "flex";
        // ... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName("tab");

        x[currentTab].style.display = "none";

        currentTab = currentTab + n;

        if (currentTab >= x.length) {
            if (confirm("Are you sure?")) {
                document.getElementById("regForm").submit();
                return false;
            } else {
                currentTab = currentTab - n;
            } 
        }
        showTab(currentTab);
    }
</script>

</html>