<?php
session_start();
if (empty($_SESSION['email'])) {
    header("location: ../index.php");
    die();
}
if (!empty($_SESSION['email'])) {
    $email = $_SESSION['email'];    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = $email;
    $verification_code = trim(stripslashes(htmlspecialchars($_POST['verification_code'])));

    $data = [
        'email' => $user_email,
        'verification_code' => $verification_code
    ];

    $apiEndpoint = 'http://localhost:8000/auth/verify-email';

    $ch = curl_init($apiEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $response = json_decode($response);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode == 202) {
        session_destroy();
        unset($_SESSION['email']);
        header("location: ../index.php");
        die();
    } else {
        $msg = "Verification failed!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
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
                    <h3>Login</h3>
                </div>
                <form action="" method="post">
                    <h2 style="text-align: center;">Email Verification</h2>
                    <p style="text-align: center; margin-bottom: 20px; color: gray;">Message with the verification code was sent to this email address. Check your email</p>
                    <div class="">
                        <label for="username" class="form-label">Username</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $email ?>" disabled>
                    </div>
                    <div class="">
                        <label for="password" class="form-label">Verification Code</label>
                        <input type="text" class="form-control" name="verification_code" id="verification_code" placeholder="" required>
                    </div>
                    <div class="">
                        <button type="submit" class="" name="login" id="login">Verify</button>
                    </div>
                    <?php if (isset($msg)) {echo '<div id="alert" class="show" role="alert">'. $msg .'</div>';} ?>
                </form>
            </div>
        </div>
    </main>
</body>
</html>