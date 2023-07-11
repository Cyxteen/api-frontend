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
    $apiEndpoint = 'http://localhost:8000/user/register';

    $ch = curl_init($apiEndpoint);
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
    <link rel="stylesheet" href="../resources/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/style.css">
    <title>Register</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="login-form">
                <div class="login align-middle">
                    <h3 style="text-align: center;">Register</h3>
                    <?php if (isset($msg)) {echo '<div class="alert alert-danger" role="alert" style="text-align: center;">'. $msg .'</div>';} ?>
                    <form action="" method="post">
                        <div class="mb-3 mt-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="e.g a@b.com" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="mycentered-text d-grid gap-2 col-4 mx-auto mt-4">
                            <input type="submit" class="btn btn-secondary" name="register" id="register" value="Register">
                        </div>
                        <div class="mycentered-text d-grid gap-2 col-8 mx-auto mt-3">
                            <p>Have an account already? <a href="index.php">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>