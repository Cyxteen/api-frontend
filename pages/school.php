<?php
session_start();
include_once('../resources/activity.php');
if (empty($_SESSION['token'])) {
    header("location: ../index.php");
    die();
} else {
    $token = $_SESSION['token'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schoolname = trim(stripslashes(htmlspecialchars($_POST['school_name'])));
    $schoollevel = trim(stripslashes(htmlspecialchars($_POST['school_level'])));
    $from = trim(stripslashes(htmlspecialchars($_POST['from'])));
    $to = trim(stripslashes(htmlspecialchars($_POST['to'])));

    $apiUrl = 'http://localhost:8000/results/school';
    $data = array(
        'school_name'=> $schoolname,
        'school_level'=> $schoollevel,
        'start_year'=> $from,
        'end_year'=> $to
    );
    $data = json_encode($data);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: ' . $token
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    $response = json_decode($response);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode != 200) {
        $detail = $response->error;
        $msg = "An error occurred. " . $detail;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link rel="stylesheet" href="../resources/styles/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css" />
    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            /* background-color: #fff;
            border: 1px solid #ccc; */
        }

        .ui-autocomplete .ui-menu-item {
            padding: 5px;
            cursor: pointer;
        }
        .ui-autocomplete .ui-state-active {
            background-color: #007bff;
            color: grey;
        }
    </style>
</head>

<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="./index.php">Student</a></li>
                <li class="active"><a href="./school.php">School</a></li>
                <li><a href="./compare.php">Compare</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <main id="schoolpage">
        <div class="container">
            <form action="" method="post">
                <div id="search_container">
                    <select name="school_level" id="school_level">
                        <option value="csee">CSEE</option>
                        <option value="acsee">ACSEE</option>
                    </select>
                    <input type="text" placeholder="Search school" id="search_school" name="school_name" required/>
                    <select name="from" id="from" required>
                        <option value="">From</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>
                    </select>
                    <select name="to" id="to" required>
                        <option value="">To</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>
                    </select>
                    <button>find results</button>
                </div>
            </form>
            <?php
            if (isset($response)) {
                if ($response->error == null) {
                    $school_name = $response->school_name;
                    $registration_number = $response->registration_number;
                    $results = $response->data;

                    echo '
                    <table>
                        <thead>
                            <th colspan="2">School information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="key">School name</td>
                                <td class="value">'.strtoupper($school_name).'</td>
                            </tr>
                            <tr>
                                <td class="key">Registration ID</td>
                                <td class="value">'.$registration_number.'</td>
                            </tr>
                        </tbody>
                    </table>';
                    foreach ($results as $year => $result) {
                        echo '<table>
                        <thead>
                            <th colspan="2">Results</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="key year">Year</td>
                                <td class="value year">'.$year.'</td>
                            </tr>';
                            foreach ($result as $key => $value) {
                                echo '<tr>
                                <td class="key">' . ucfirst(str_replace('_', ' ', $key)) . '</td>
                                <td class="value">' . $value . '</td>
                                </tr>';
                            }
                            echo '</tbody></table>';
                    }
                }else {
                    print($response->error);
                }
            }
            ?>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>Copyright &copy 2023 Arusha technical college</p>
        </div>
    </footer>
    <script src="../resources/utils.js"></script>
</body>

</html>