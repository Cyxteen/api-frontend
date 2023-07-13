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
    $examnumber = trim(stripslashes(htmlspecialchars($_POST['exam_number'])));
    $examtype = trim(stripslashes(htmlspecialchars($_POST['exam_type'])));
    $array = explode('.', $examnumber);

    $apiUrl = 'http://localhost:8000/results/student';
    $data = array(
        'school_registration_number' => $array[0],
        'student_exam_number' => $array[1],
        'student_level' => $examtype,
        'year_completed' => $array[2]
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
        $detail = $response->detail;
        $msg = "An error occurred. " . $detail;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../resources/styles/index.css">
</head>

<body>
    <nav id="homenav">
        <div class="container">
            <ul>
                <li class="active"><a href="./index.php">Student</a></li>
                <li><a href="./school.php">School</a></li>
                <li><a href="./compare.php">Compare</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
        <form action="" method="post">
            <div id="search_container">
                <input type="text" placeholder="s0192.0056.2017" name="exam_number" required />
                <select name="exam_type" id="exam_type" required>
                    <option value="csee">CSEE</option>
                    <option value="acsee">ACSEE</option>
                </select>
                <button>find results</button>
            </div>
        </form>
    </nav>
    <main id="homepage">
        <div class="container">
            <?php
            if (isset($response)) {
                if ($response->error == null) {
                    // Extract the required values
                    $examNumber = $response->exam_number;
                    $school = $response->school_name;
                    $gender = $response->gender;
                    $division = $response->division;
                    $point = $response->point;

                    // Extract the subject results
                    $results = $response->subjects;

                    // Generate the HTML
                    $html = '
                    <div class="container">
                        <table>
                            <thead>
                                <th colspan="2">Student information</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="key">School</td>
                                    <td class="value">' . $school . '</td>
                                </tr>
                                <tr>
                                    <td class="key">Exam number</td>
                                    <td class="value">' . $examNumber . '</td>
                                </tr>
                                <tr>
                                    <td class="key">Gender</td>
                                    <td class="value">' . $gender . '</td>
                                </tr>
                                <tr>
                                    <td class="key">Division</td>
                                    <td class="value">' . $division . '</td>
                                </tr>
                                <tr>
                                    <td class="key">Points</td>
                                    <td class="value">' . $point . '</td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <th colspan="2">Results</th>
                            </thead>
                    <tbody>';

                    foreach ($results as $subject => $grade) {
                        $html .= '
                    <tr>
                        <td class="key">' . $subject . '</td>
                        <td class="value">' . $grade . '</td>
                    </tr>';
                    }

                    $html .= '
                            </tbody>
                        </table>
                    </div>';

                    // Print the generated HTML
                    echo $html;
                } else {
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
</body>

</html>