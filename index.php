<?php
session_start();

require "./app/models/database.php";
require "./app/controllers/authenticator.php";

$authenticator = new Authenticator();
$authenticator->checkLoggedIn();
$authenticator->authenticate();

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <title>Courses</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        html {
            position: relative;

            background-color: red;
            width: 100%;
            background: url(./web/images/bg.png) no-repeat center center fixed; 
            background-size: cover;
        }

        body {
            position: relative;
            
        }

        .powered {
            position: absolute;
            bottom: 0;
            right: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;	

            width: 30%;
            margin: 5px;
        }

        img {
            width: 30%;
        }

        .container {
            position: relative;
            display: flex;
            flex-wrap: wrap;

            width: 45%;
            margin: 0 auto;
            padding: 40px;

            text-align: center;

            background-color: white;
        }

        h1 {
            display: block;
            margin: 0 auto;
            font-size: 18px;
        }

        form {
            width: 100%;
            padding: 40px;

            text-align: center;
        }

        .txt {
            display: block;

            width: 60%;
            margin: 10px auto;
        }

        .btn { /* W3School Design */
            display: block;
            margin: 25px auto;
            padding: 5px 15px;

            background-color: #77dd77;
            color: #282828;
            border: 1px solid #282828;;
            border-radius: 5px;

            font-size: 16px;
            text-align: center;
            text-decoration: none;

            cursor: pointer;
        }

        .error {
            margin: 0 auto;
        }

        @media only screen and (max-width: 500px) {
			.container {
				width: 90%;
			}
			
			.txt {
                width: 90%;
            }

            .btn {
                display: block;

                margin: 20 auto;
                padding: 5px 15px;

                font-size: 14px;
            }
			
		}

		/* Tablet Styles */
		@media only screen and (min-width: 501px) and (max-width: 960px) {
			.container {
				width: 70%;
			}
			
			.txt {
                width: 60%;
            }

            .btn {
                display: block;

                margin: 20 auto;
                padding: 5px 25px;

                font-size: 16px;
            }
			
		}

		/* Desktop Styles */
		@media only screen and (min-width: 961px) {
			
		}
    </style>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>

<body>
    <div class="container"> 

        <h1> ENTER STUDENT ID </h1>
        
        <form method="post" autocomplete="off"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input class="txt" type="text" name="student_id" autofocus>
            <input class="btn" type="submit" name="submit_student">
        </form>

        <span class="error"> <?php echo $authenticator->errorMsg(); ?> </span>

    </div>
    
</body>
</html>