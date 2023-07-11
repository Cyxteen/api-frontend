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
    <title>Login</title>
    <link rel="stylesheet" href="./resources/styles/index.css">
</head>
<body>
    <main id="auth">
        <div class="separator left-separator">
            <div class="separator-wrapper">
                <h1>API Frontend</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nemo totam sint est sit placeat, suscipit blanditiis quod officia error!</p>
            </div>
        </div>
        <div class="separator right-separator">
            <div class="separator-wrapper">
                <div id="mobile-header">
                    <h1>API Frontend</h1>
                    <h3>Login</h3>
                </div>
                <form action="" method="post">
                    <div class="">
                        <label for="username" class="form-label">Username</label>
                        <input type="email" class="" name="username" id="username" placeholder="e.g a@b.com" required>
                    </div>
                    <div class="">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="">
                        <button type="submit" class="" name="login" id="login">Login</button>
                    </div>
                    <?php if (isset($msg)) {echo '<div id="alert" class="show" role="alert">'. $msg .'</div>';} ?>
                    <div class="">
                        <p>Don't have an account? <a href="./auth/register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>