<?php
session_start();
if (isset($_POST['register'])) {
    $username = trim(stripslashes(htmlspecialchars($_POST['username'])));
    $email = trim(stripslashes(htmlspecialchars($_POST['email'])));
    $password = trim(stripslashes(htmlspecialchars($_POST['password'])));

    $data = array(
        'username' => $username,
        'email' => $email,
        'password' => $password
    );
    $data = json_encode($data);
    $apiUrl = 'http://localhost:8000/user/register';

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    $response = json_decode($response);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode == 201) {
        $_SESSION['email'] = $email;
        header("location: verification.php");
        die();
        // $msg = "Registration successful!";
    } else {
        $detail = $response->detail;
        $msg = "Registration failed. ".$detail;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../resources/styles/index.css">
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
                    <h3>Register</h3>
                </div>
                <form action="" method="post">
                    <div class="">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="" name="username" id="username" placeholder="Username" required>
                    </div>
                    <div class="">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="" name="email" id="email" placeholder="e.g a@b.com" required>
                    </div>
                    <div class="">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="">
                        <button type="submit" class="" name="register" id="register">Register</button>
                    </div>
                    <?php if (isset($msg)) {echo '<div id="alert" class="show" role="alert">'. $msg .'</div>';} ?>
                    <div class="">
                        <p>Already have an account? <a href="../index.php">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>