<?php
if (isset($_POST['comparebtn'])) {
    global $msg;
    $exam_type = trim(stripslashes(htmlspecialchars($_POST['exam_type'])));
    $school_name = trim(stripslashes(htmlspecialchars($_POST['school_name'])));
    $from = trim(stripslashes(htmlspecialchars($_POST['from'])));
    $to = trim(stripslashes(htmlspecialchars($_POST['to'])));

    $school_name = rawurlencode($school_name);
    $host = '127.0.0.1';
    $port = 5000;

    try {
        // tries to connect to the server
        $fp = fsockopen($host, $port, $errno, $errstr, 3);

        // if false then this part runs
        if (!$fp) {
            $msg = "<div class='alert alert-danger' role='alert'>Server not available!</div>";
        } else {
            $header_check = get_headers("http://127.0.0.1:5000");
            $response_code = $header_check[0];
            if ($response_code[9] != 2) {
                $msg = "<div class='alert alert-danger' role='alert'>500 Server Error!</div>";
            } else {
                if ($to != null || $to != "") {
                    $uri = strtolower($school_name) . "/" . strtolower($exam_type) . "/" . $from . "/" . $to;
                    $api_uri = 'http://127.0.0.1:5000/api/v1/comparison/' . $uri;
                    $response = file_get_contents($api_uri);
                    $response = json_decode($response, true);

                    // print_r($response);
                    session_start();
                    $_SESSION['results'] = $response;
                    $_SESSION['start_year'] = $from;
                    header("location:chart.php");
                    // echo $api_uri;
                } else {
                    $uri = strtolower($school_name) . "/" . strtolower($exam_type) . "/" . $from;
                    $api_uri = 'http://127.0.0.1:5000/api/v1/comparison/' . $uri;
                    $response = file_get_contents($api_uri);
                    $response = json_decode($response);

                    $response = (array) $response;

                    session_start();
                    $_SESSION['results'] = $response;
                    $_SESSION['start_year'] = $from;
                    header("location:chart.php");
                    // print($response[0]);
                    // // print_r($response);
                    // echo var_dump($response);
                }
            }
            fclose($fp);
        }
    } catch (Exception $e) {
        print("This error occured " + $e);
    }
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
    <link rel="stylesheet" href="resources/dropdown.css">
    <script>
        function validate() {
            var msg = '';
            var exam_type = document.getElementById("exam_type").value;
            var school_name = document.getElementById("school_name").value;
            var from = document.getElementById("from").value;

            if (exam_type == null || exam_type == "") {
                document.getElementById("exam_type").focus();
                msg = '<div class="alert alert-danger" role="alert">please fill the exam type!</div>';
                document.getElementById("error").innerHTML = msg;
                return false;
            }
            if (school_name == null || school_name == "") {
                document.getElementById("school_name").focus();
                msg = '<div class="alert alert-danger" role="alert">please fill the school name!</div>';
                document.getElementById("error").innerHTML = msg;
                return false;
            }
            if (from == null || from == "") {
                document.getElementById("from").focus();
                msg = '<div class="alert alert-danger" role="alert">please fill the year!</div>';
                document.getElementById("error").innerHTML = msg;
                return false;
            }
        }
    </script>
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
                margin: 30% 0 70% 0;
                /* background-color: rebeccapurple; */
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
                        <li class="nav-item">
                            <a class="nav-link" href="compare.php">compare</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="fo container-sm">
            <div id="error" class="mt-4" name="error"></div>
            <form action="" method="post">
                <div class="mb-3 mt-5">
                    <label for="exam_type" class="form-label">Exam type<b style="color: red;">*</b></label>
                    <select class="form-select" name="exam_type" id="exam_type" oninput="return checktype()">
                        <option selected value="">Choose Result</option>
                        <option value="csee" <?php if (isset($exam_type) && $exam_type == 'csee') echo 'selected'; ?>>Form Four ("CSEE")</option>
                        <option value="acsee" <?php if (isset($exam_type) && $exam_type == 'acsee') echo 'selected'; ?>>Form Six ("ACSEE")</option>
                    </select>
                </div>
                <div class="mb-3 mt-3" id="autocomplete">
                    <label for="school_name" class="form-label">School Name<b style="color: red;">*</b></label>
                    <input type="text" class="form-control text-uppercase" value="<?php if (isset($school_name)) {
                                                                                        echo $school_name;
                                                                                    } ?>" name="school_name" id="school_name" placeholder="e.g ilboru" oninput="return checkname()" onfocus="return onfcs()" autocomplete="off">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="from" class="form-label">From<b style="color: red;">*</b></label>
                        <input type="text" class="form-control" value="<?php if (isset($from)) {
                                                                            echo $from;
                                                                        } ?>" name="from" id="from" placeholder="e.g 2018">
                    </div>
                    <div class="col">
                        <label for="to" class="form-label">To</label>
                        <input type="text" class="form-control" name="to" value="<?php if (isset($to)) {
                                                                                        echo $to;
                                                                                    } ?>" id="to" placeholder="e.g 2022">
                    </div>
                </div>
                <div class="mycentered-text d-grid gap-2 col-4 mx-auto mt-4">
                    <input type="submit" class="btn btn-secondary" name="comparebtn" id="comparebtn" onclick="return validate()" value="compare results">
                </div>
            </form>
            <p style="color: gray; color: red;">* - important</p>
        </div>
    </div>
    <?php echo "<script defer>document.getElementById('error').innerHTML = \"$msg\";</script>"; ?>
    <script src="resources/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="resources/autocomplete2.js"></script>
    <script>
        var school_name = document.getElementById("school_name");
        var school_name_value = document.getElementById("school_name").value;

        function checktype() {
            if (document.getElementById("exam_type").value != null || document.getElementById("exam_type").value != '') {
                document.getElementById("error").innerHTML = "";
                document.getElementById("school_name").removeAttribute('disabled');
            }
        }

        function onfcs() {
            if ((document.getElementById("school_name").value).length >= 3) {
                autocomplete(document.getElementById("school_name"), total_csee_2021);
            } else {}
        }

        function checkname() {
            school_name.addEventListener("keydown", function(e) {
                if (document.getElementById("exam_type").value == null || document.getElementById("exam_type").value == "") {
                    document.getElementById("exam_type").focus();
                    msg = '<div class="alert alert-danger" role="alert">please fill the exam type!</div>';
                    document.getElementById("school_name").setAttribute('disabled', '');
                    document.getElementById("error").innerHTML = msg;
                } else if (document.getElementById("exam_type").value == 'csee') {
                    if ((document.getElementById("school_name").value).length >= 3) {
                        autocomplete(document.getElementById("school_name"), total_csee_2021);
                    }
                } else {
                    if ((document.getElementById("school_name").value).length >= 3) {
                        autocomplete(document.getElementById("school_name"), total_acsee_2022);
                    }
                }
            });
        }
    </script>
</body>

</html>