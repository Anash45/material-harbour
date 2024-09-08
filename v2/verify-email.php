<?php
include 'db_conn.php';
if (isLoggedIn()) {
    header("Location: select-materials.php");
}
if (isset($_SESSION['userActive']) && $_SESSION['userActive'] == true) {
    
} else {
    header("Location: index.php");
}
// print_r($_SESSION);
$info = '';

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Material Harbour</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <?php echo $info; ?>
                    <div class="tab-content p-3 border border-top-0 rounded-bottom" id="authTabsContent">
                        <!-- Login Form -->
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <h3 class="text-center">Log In</h3>
                            <form method="POST" action="login.php?user=<?php echo $user; ?>" novalidate
                                class="needs-validation">
                                <div class="mb-3">
                                    <label for="loginEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="loginEmail" name="loginEmail" required
                                        placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="loginPassword" name="loginPassword"
                                        required placeholder="Enter your password">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" name="login" class="btn btn-primary">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery and Bootstrap JS -->
        <script src="./assets/js/jquery-3.6.1.min.js"></script>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/script.js"></script>
    </body>

</html>