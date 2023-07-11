<?php
if (isset($_POST['get_results'])) {
    $exam_number = trim(stripslashes(htmlspecialchars($_POST['exam_number'])));
    $exam_type = trim(stripslashes(htmlspecialchars($_POST['exam_type'])));
    // echo $exam_number.' '.$exam_type;

    $myArray = explode('.', $exam_number);
    $school_reg_number = $myArray[0];
    $student_number = $myArray[1];
    $year = $myArray[2];

    $uri = $year . "/" . strtolower($school_reg_number) . "/" . $student_number . "/" . $exam_type;
    $api_uri = 'http://127.0.0.1:5000/api/v1/single-student/' . $uri;
    $response = file_get_contents($api_uri);
    $response = json_decode($response);

    $response = (array) $response;

    // print_r($response);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>API TUTORIAL</title>
    <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <script src="resources/jquery-3.6.1.min.js"></script>
    <style>
        /* import the font style from google */
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');

        .body {
            font-family: 'Open Sans', sans-serif;
        }

        .fo {
            max-width: 620px;
        }

        .mycentered-text {
            text-align: center;
        }

        @media only screen and (max-width: 600px) {
            .fo {
                margin: 50% 0;
            }
            input[type='text']{
                padding: 16px;
            }
            input[type='submit']{
                padding: 10px;
            }
            .form-select{
                padding: 16px;
            }
        }
    </style>
    <script>
        $.get("ACSEE-2015.text", function(contents) {
            var str = "DODOMANA";
            if (contents.indexOf(str) != -1) {
                console.log(str + " found");
            } else {
                console.log(str + " not found");
            }
        });
        // validate the inputs
        function validate() {
            const reguarExp = new RegExp('[S|P|s|p][0-9]*[.][0-9]{4}[.][12][0-9]{3}$', 'gm');
            var msg = '';
            var exam_number = document.getElementById("exam_number").value;
            var exam_type = document.getElementById("exam_type").value;
            let m, z;

            if (exam_number == null || exam_number == "") {
                document.getElementById("exam_number").focus();
                msg = '<div class="alert alert-danger" role="alert">please fill the exam number!</div>';
                document.getElementById("error").innerHTML = msg;
                return false;
            }
            if ((m = reguarExp.exec(exam_number)) !== null) {
                m.forEach((match, groupIndex) => {
                    exam_number = match;
                });
            } else {
                // for not matching
                document.getElementById("exam_number").focus();
                msg = '<div class="alert alert-warning" role="alert">exam number format not correct(eg. S0194.0060.2022)</div>';
                document.getElementById("error").innerHTML = msg;
                return false;
            }
            if (exam_type == null || exam_type == "") {
                document.getElementById("exam_type").focus();
                msg = '<div class="alert alert-danger" role="alert">please fill the exam type!</div>';
                document.getElementById("error").innerHTML = msg;
                return false;
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">API - FRONTEND</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="compare.php">compare</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>
        <div class="fo container-sm">
            <div id="error" class="mt-4"></div>
            <form action="" method="post">
                <div class="mb-3 mt-5">
                    <label for="exampleFormControlInput1" class="form-label">Exam number<b style="color: red;">*</b></label>
                    <input type="text" class="form-control" id="exam_number" name="exam_number" placeholder="e.g S0194.0060.2022" />
                </div>
                <div class="mb-3 mt-3">
                    <label for="exam_type" class="form-label">Exam type<b style="color: red;">*</b></label>
                    <select class="form-select" name="exam_type" id="exam_type">
                        <option selected value="">Choose exam type</option>
                        <option value="csee">CSEE</option>
                        <option value="acsee">ACSEE</option>
                    </select>
                </div>
                <div class="mycentered-text d-grid gap-2 col-4 mx-auto">
                    <input type="submit" class="btn btn-secondary" name="get_results" id="submitbtn" value='get results' onclick="return validate()">
                </div>
            </form>
            <p style="color: gray; color: red;">* - important</p>
            <?php
            if (isset($response)) {
                if ($response['status'] == 200) {
                    echo '
                        <div class="alert alert-success" role="alert">
                            <h4 style="text-align: center;">RESULTS</h4>
                            <p><b>SCHOOL NAME: </b>' . $response['school_name'] . '</p>
                            <p><b>EXAM NUMBER: </b>' . $response['exam_number'] . '</p>
                            <p><b>DIVISION: </b>' . $response['division'] . '</p>
                            <p><b>POINTS: </b>' . $response['point'] . '</p>
                            <p><b>EXAM NUMBER: </b>' . $response['exam_number'] . '</p>
                        </div>
                        ';
                } elseif ($response['status'] == 204) {
                    echo $response['message'];
                } elseif ($response['status'] == 408) {
                    echo $response['message'];
                } else {
                    echo '
                        <div class="alert alert-danger" role="alert">
                            check the exam number and exam type. if they are correct and try again
                        </div>';
                }
            }
            ?>
        </div>
    </div>
    <script src="resources/js/bootstrap.bundle.min.js"></script>
</body>

</html>