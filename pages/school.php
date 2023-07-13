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
                    <input type="text" placeholder="Search school" id="search_school" />
                    <select name="from" id="from">
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
                    <select name="to" id="to">
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
            <table>
                <thead>
                    <th colspan="2">School information</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="key">School name</td>
                        <td class="value">Arusha technical college</td>
                    </tr>
                    <tr>
                        <td class="key">Registation ID</td>
                        <td class="value">D2005501111</td>
                    </tr>
                    <tr>
                        <td class="key">Region</td>
                        <td class="value">Arusha</td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <th colspan="2">Results</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="key year">Year</td>
                        <td class="value year">2022</td>
                    </tr>
                    <tr>
                        <td class="key">Division I</td>
                        <td class="value">4</td>
                    </tr>
                    <tr>
                        <td class="key">Division II</td>
                        <td class="value">15</td>
                    </tr>
                    <tr>
                        <td class="key">Division III</td>
                        <td class="value">23</td>
                    </tr>
                    <tr>
                        <td class="key">Division IV</td>
                        <td class="value">10</td>
                    </tr>
                    <tr>
                        <td class="key">Fail</td>
                        <td class="value">2</td>
                    </tr>
                </tbody>
            </table>
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