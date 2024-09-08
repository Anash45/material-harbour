<?php
require './db_conn.php';
if(isLoggedIn()){
    header("Location: select-materials.php");
}
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
            <h1 class="text-center mb-4">Welcome to Material Harbour</h1>
            <p class="text-center mb-4">Please choose your role to proceed:</p>
            <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Manufacturer</h5>
                            <p class="card-text">Register as a Manufacturer to find materials and suppliers for your
                                needs.</p>
                            <a href="login.php?user=Manufacturer" class="btn btn-primary">I am a Manufacturer</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Supplier</h5>
                            <p class="card-text">Register as a Supplier to offer your materials to potential
                                manufacturers.</p>
                            <a href="login.php?user=Supplier" class="btn btn-info">I am a Supplier</a>
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