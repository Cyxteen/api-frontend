<?php
session_start();
if (empty($_SESSION['email'])) {
    header("location: ../index.php");
    die();
}
if (!empty($_SESSION['email'])) {
    $email = $_SESSION['email'];    
}

if (isset($_POST['verify'])) {
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
        header("location: index.php");
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
    <link rel="stylesheet" href="../resources/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/style.css">
    <title>Email Verification</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="login-form">
                <div class="login align-middle">
                    <h3 style="text-align: center;">Email Verification</h3>
                    <?php if (isset($msg)) {
                        echo '<div class="alert alert-danger" role="alert" style="text-align: center;">'. $msg .'</div>';} ?>
                    <form action="" method="post">
                        <div class="mb-3 mt-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo $email ?>" disabled>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="verification_code" class="form-label">Verification Code</label>
                            <input type="text" class="form-control" name="verification_code" id="verification_code" placeholder="" required>
                        </div>
                        <div class="mycentered-text d-grid gap-2 col-4 mx-auto mt-4">
                            <input type="submit" class="btn btn-secondary" name="verify" id="verify" value="Verify">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>