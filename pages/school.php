<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link rel="stylesheet" href="../resources/styles/index.css">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li class="active"><a href="./school.php">School</a></li>
                <li><a href="./compare.php">Compare</a></li>
            </ul>
        </div>
    </nav>
    <main id="schoolpage">
        <div class="container">
            <form action="" method="post">
                <div id="search_container">
                    <input type="text" placeholder="Search school"/>
                    <select name="" id="">
                        <option value="csee">CSEE</option>
                        <option value="acsee">ACSEE</option>
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
</body>
</html>