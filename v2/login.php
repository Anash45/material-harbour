<?php
include 'db_conn.php';
if (isLoggedIn()) {
    header("Location: select-materials.php");
}
if (isset($_GET['user'])) {
    $user = $_GET['user'];
} else {
    header("Location: index.php");
}
// print_r($_SESSION);
$info = '';
// Handle the sign-up form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $company = $_POST['signupCompany'];
    $location = $_POST['signupLocation'];
    $email = $_POST['signupEmail'];
    $phone = $_POST['signupPhone'];
    $offers = $_POST['signupOffers'];
    $description = $_POST['signupDescription'];
    $password = $_POST['signupPassword'];
    $confirmPassword = $_POST['signupConfirmPassword'];

    if ($password === $confirmPassword) {

        $password = password_hash($password, PASSWORD_DEFAULT);
        $user = $_GET['user']; // Get the user type from the URL

        // Check if the email already exists in the appropriate table
        if (strtolower($user) === 'manufacturer') {
            $table = 'manufacturers';
        } elseif (strtolower($user) === 'supplier') {
            $table = 'suppliers';
        }

        $emailCheckSql = "SELECT id FROM $table WHERE email = ?";
        $stmt = $conn->prepare($emailCheckSql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $info = "<div class='alert alert-danger'>Email already exists.</div>";
        } else {
            // Generate OTP code
            $otp = rand(100000, 999999); // Generate a 6-digit OTP

            // Insert the new user into the appropriate table with OTP
            $insertSql = "INSERT INTO $table (company_name, location, email, contact_phone, offers, description, password, otp, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param('ssssssss', $company, $location, $email, $phone, $offers, $description, $password, $otp);

            if ($stmt->execute()) {
                $userId = $conn->insert_id;

                // Send OTP to the user's email
                $subject = "Your OTP Code";
                $message = "Hello $company,\n\nYour OTP code is: $otp\nPlease use this code to verify your email.\n\nThanks!";
                $headers = "From: no-reply@f4futuretech.com";

                if (mail($email, $subject, $message, $headers)) {
                    // Email sent successfully to the user
                } else {
                    $info = "<div class='alert alert-danger'>Failed to send OTP to the user's email.</div>";
                }

                // Send an email to the admin about the new registration
                $adminSubject = "New User Registration";
                $adminMessage = "A new user has registered with the following details:\n\n";
                $adminMessage .= "Name: $company\n";
                $adminMessage .= "Email: $email\n";
                $adminMessage .= "Company: $company\n";
                $adminMessage .= "User Type: " . ucfirst($user) . "\n";
                mail('futuretest45@gmail.com', $adminSubject, $adminMessage, $headers);

                // Store user data in session and redirect to verify-user.php
                $_SESSION['userType'] = ucfirst($user); // Capitalize first letter
                $_SESSION['email'] = $email;
                $_SESSION['userId'] = $userId;
                $_SESSION['companyName'] = $company;
                $_SESSION['userActive'] = false;

                // Redirect to the verify-user.php page
                header('Location: verify-email.php');
                exit();
            } else {
                $info = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
    } else {
        $info = "<div class='alert alert-danger'>Passwords do not match.</div>";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];
    $user = $_GET['user']; // Get the user type from the URL

    // Determine the appropriate table based on the user type
    if (strtolower($user) === 'manufacturer') {
        $table = 'manufacturers';
    } elseif (strtolower($user) === 'supplier') {
        $table = 'suppliers';
    } else {
        $info = "<div class='alert alert-danger'>Invalid user type.</div>";
    }

    $loginSql = "SELECT id, company_name, password FROM $table WHERE email = ?";
    $stmt = $conn->prepare($loginSql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($userId, $companyName, $hashedPassword);
    $stmt->fetch();

    if ($userId && password_verify($password, $hashedPassword)) {
        // Login successful, store user information in session
        $_SESSION['userType'] = ucfirst($user); // Capitalize first letter
        $_SESSION['email'] = $email;
        $_SESSION['userId'] = $userId;
        $_SESSION['companyName'] = $companyName;
        $_SESSION['userActive'] = $row['userActive'];

        if ($_SESSION['userActive'] == true) {
            $info = "<div class='alert alert-success'>Login successful! Welcome, $companyName.</div>";
            // Redirect to a dashboard or home page
            header('location:select-materials.php');
        } else {
            $info = "<div class='alert alert-warning'>You need to verify your email first, redirecting in 3 seconds!</div>";
            // Redirect to a dashboard or home page
            header('location:verify-email.php');
        }

    } else {
        $info = "<div class='alert alert-danger'>Invalid email or password.</div>";
    }

    $stmt->close();
}
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
                    <ul class="nav nav-tabs" id="authTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login"
                                type="button" role="tab" aria-controls="login" aria-selected="true">Log In</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup"
                                type="button" role="tab" aria-controls="signup" aria-selected="false">Sign Up</button>
                        </li>
                    </ul>
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
                        <!-- Signup Form -->
                        <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                            <h3 class="text-center">Sign Up</h3>
                            <form method="POST" action="login.php?user=<?php echo $user; ?>" novalidate
                                class="needs-validation">
                                <div class="mb-3">
                                    <label for="signupCompany" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" required id="signupCompany"
                                        name="signupCompany" placeholder="Enter company name">
                                </div>
                                <div class="mb-3">
                                    <label for="signupLocation" class="form-label">Location</label>
                                    <input type="text" class="form-control" required id="signupLocation"
                                        name="signupLocation" placeholder="Enter location">
                                </div>
                                <div class="mb-3">
                                    <label for="signupEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" required id="signupEmail"
                                        name="signupEmail" placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label for="signupPhone" class="form-label">Contact Phone Number</label>
                                    <input type="text" class="form-control" required id="signupPhone" name="signupPhone"
                                        placeholder="Enter contact phone number">
                                </div>
                                <div class="mb-3">
                                    <label for="signupOffers" class="form-label">What the company offers</label>
                                    <select class="form-control" required id="signupOffers" name="signupOffers">
                                        <option value="">Select from list...</option>
                                        <option value="Aluminum">Aluminum</option>
                                        <option value="ALClad">ALClad</option>
                                        <option value="Stainless Steel">Stainless Steel</option>
                                        <option value="Steel">Steel</option>
                                        <option value="Titanium">Titanium</option>
                                        <option value="Carbon">Carbon</option>
                                        <option value="Epoxy">Epoxy</option>
                                        <option value="Fiberglass">Fiberglass</option>
                                        <option value="Glass">Glass</option>
                                        <option value="Phenolic">Phenolic</option>
                                        <option value="Resin">Resin</option>
                                        <option value="Plastic">Plastic</option>
                                        <option value="Rubber/ Elastomer">Rubber/ Elastomer</option>
                                        <option value="Milled part">Milled part</option>
                                        <option value="Casting">Casting</option>
                                        <option value="Weldment">Weldment</option>
                                        <option value="3D Printing">3D Printing</option>
                                        <option value="Machining">Machining</option>
                                        <option value="Forging">Forging</option>
                                        <option value="Molding">Molding</option>
                                        <option value="Etc.">Etc.</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="signupDescription" class="form-label">Description</label>
                                    <textarea class="form-control" required id="signupDescription"
                                        name="signupDescription" rows="3"
                                        placeholder="Enter a brief description"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="signupPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control"
                                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}"
                                        required id="signupPassword" name="signupPassword"
                                        placeholder="Enter your password">
                                    <div class="invalid-feedback">Password should contain following: <br>Atleast 1
                                        uppercase alphabet<br>Atleast 1 lowercase alphabet<br>Atleast 1 digit<br>Atleast
                                        1 special character</div>
                                </div>
                                <div class="mb-3">
                                    <label for="signupConfirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" required id="signupConfirmPassword"
                                        name="signupConfirmPassword" placeholder="Enter your password again">
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="enable_2FA"
                                            name="enable_2FA">
                                        <label class="form-check-label" for="enable_2FA"> Enable two factor
                                            authentication on login? </label>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" name="signup" class="btn btn-success">Sign Up</button>
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