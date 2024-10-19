<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $file = fopen('user.csv', 'r');

    if ($file !== false) {
        $userFound = false;

        while (($data = fgetcsv($file)) !== false) {
            list($storedEmail, $storedPasswordHash) = $data;

            if ($storedEmail === $email && password_verify($password, $storedPasswordHash)) {
                $_SESSION['email'] = $email;
                $_SESSION['message'] = "Login successful! Welcome, $email!";
                $userFound = true;
                header("Location: admin.php");
                fclose($file);
                exit();
            }
        }

        fclose($file);


        if (!$userFound) {
            $error = "Incorrect username or password!";
        }
    } else {
        $error = "File could not be read";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card" style="width: 400px;">
            <div class="card-header text-center">
                <h4>Login</h4>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <?php
                if (isset($error)): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $error;
                        ?>
                    </div>
                <?php endif;
                ?>
            </div>
            <div class="card-footer text-center">
                <a href="register.php" class="text">Don't have an account? Signup</a>
            </div>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>