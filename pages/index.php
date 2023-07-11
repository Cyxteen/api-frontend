<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./resources/styles/index.css">
</head>
<body>
    <nav id="homenav">
        <div class="container">
            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="./pages/school.php">School</a></li>
                <li><a href="./pages/compare.php">Compare</a></li>
            </ul>
        </div>
        <form action="" method="post">
            <div id="search_container">
                <input type="text" placeholder="Enter exam number"/>
                <select name="" id="">
                    <option value="csee">CSEE</option>
                    <option value="acsee">ACSEE</option>
                </select>
                <button>find results</button>
            </div>
        </form>
    </nav>
    <main id="homepage">
        <div class="container">
            <table>
                <thead>
                    <th colspan="2">Student information</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="key">Exam number</td>
                        <td class="value">200555012432</td>
                    </tr>
                    <tr>
                        <td class="key">Name</td>
                        <td class="value">Derek Miagi</td>
                    </tr>
                    <tr>
                        <td class="key">School</td>
                        <td class="value">Arusha technical college</td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <th colspan="2">Results</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="key">Civics</td>
                        <td class="value">D</td>
                    </tr>
                    <tr>
                        <td class="key">English</td>
                        <td class="value">A</td>
                    </tr>
                    <tr>
                        <td class="key">Geography</td>
                        <td class="value">B</td>
                    </tr>
                    <tr>
                        <td class="key">Biology</td>
                        <td class="value">D</td>
                    </tr>
                    <tr>
                        <td class="key">History</td>
                        <td class="value">A</td>
                    </tr>
                    <tr>
                        <td class="key">Physics</td>
                        <td class="value">B</td>
                    </tr>
                    <tr>
                        <td class="key">Mathematics</td>
                        <td class="value">B</td>
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