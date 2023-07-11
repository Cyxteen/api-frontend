<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare</title>
    <link rel="stylesheet" href="../resources/styles/index.css">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="./index.php">Student</a></li>
                <li><a href="./school.php">School</a></li>
                <li class="active"><a href="./compare.php">Compare</a></li>
            </ul>
        </div>
    </nav>
    <main id="compare">
        <form action="" method="post">
            <div class="container">
                <div id="search_container">
                    <div>
                        <label for="first-school">First school</label>
                        <input type="text" placeholder="First school" name="first-school"/>
                    </div>
    
                    <div>
                        <label for="second-school">Second school</label>
                        <input type="text" placeholder="Second school" name="second-school"/>
                    </div>
                    
                    <div>
                        <label for="result-year">Result year</label>
                        <select name="result-year" id="">
                            <option value="1">Latest results</option>
                            <option value="2">Last 2 years</option>
                            <option value="3">Last 3 years</option>
                        </select>
                    </div>
    
                    <button>Compare</button>
                </div>
            </div>
        </form>
    </main>
    <footer>
        <div class="container">
            <p>Copyright &copy 2023 Arusha technical college</p>
        </div>
    </footer>
</body>
</html>