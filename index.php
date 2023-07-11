<?php
if (isset($_POST['login'])) {
    // Retrieve the submitted username and password
    $username = trim(stripslashes(htmlspecialchars($_POST['username'])));
    $password = trim(stripslashes(htmlspecialchars($_POST['password'])));
    // Authentication successful

    // Make a POST request to the API endpoint with the user details
    $apiUrl = 'http://localhost:8000/auth/login';
    $postData = array(
        'username' => $username,
        'password' => $password
    );

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

    $response = curl_exec($ch);
    $response = json_decode($response);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get the HTTP status code
    curl_close($ch);

    if ($httpCode === 200) {
        session_start();
        $access_token = $response->access_token;
        $token_type = $response->access_token;

        header('Location: ../compare.php');
        exit();
    } else {
        $detail = $response->detail;
        $msg = $detail;
        $msg = '<div class="alert alert-danger" role="alert" style="text-align: center;">'. $msg .'</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./resources/style.css">
    <title>Login</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="login-form">
                <div class="login align-middle">
                    <h3 style="text-align: center;">Login</h3>
                    <?php if (isset($msg)) {echo $msg;} ?>
                    <form action="" method="post">
                        <div class="mb-3 mt-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="email" class="form-control" name="username" id="username" placeholder="e.g a@b.com" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="mycentered-text d-grid gap-2 col-4 mx-auto mt-4">
                            <input type="submit" class="btn btn-secondary" name="login" id="login" value="Login">
                        </div>
                        <div class="mycentered-text d-grid gap-2 col-8 mx-auto mt-3">
                            <p>Don't have an account? <a href="./auth/register.php">Register</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>