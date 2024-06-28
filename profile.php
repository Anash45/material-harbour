<?php
// Include the database connection file
require 'db_conn.php';
$info = '';
// Get userType and userID from the URL
$userType = isset($_GET['userType']) ? strtolower(trim($_GET['userType'])) : '';
$userID = isset($_GET['userID']) ? intval($_GET['userID']) : 0;

// Initialize variables to hold user data
$userData = [];

// Determine the table to query based on the userType
if ($userType === 'manufacturer' || $userType === 'supplier') {
    $table = $userType === 'manufacturer' ? 'manufacturers' : 'suppliers';

    // Prepare the SQL query to fetch the user data
    $sql = "SELECT * FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user was found
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        $info = "<div class='alert alert-danger'>User not found.</div>";
    }

    $stmt->close();
} else {
    $info = "<div class='alert alert-danger'>Invalid user type specified.</div>";
}

// Close the database connection
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
        <?php
        include './header.php';
        ?>
        <div class="container mt-5">
            <?php echo $info; ?>
            <?php if (!empty($userData)): ?>
                <div class="card">
                    <div class="card-header">
                        <h4><?php echo ucfirst($userType); ?> Profile</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-decoration-underline"><?php echo htmlspecialchars($userData['company_name']); ?></h5>
                        <p class="card-text"><strong>Location:</strong>
                            <?php echo htmlspecialchars($userData['location']); ?></p>
                        <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
                        <p class="card-text"><strong>Phone:</strong> <?php echo htmlspecialchars($userData['contact_phone']); ?></p>
                        <p class="card-text"><strong>Offers:</strong> <?php echo htmlspecialchars($userData['offers']); ?>
                        </p>
                        <p class="card-text"><strong>Description:</strong>
                            <?php echo htmlspecialchars($userData['description']); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">No profile data available.</div>
            <?php endif; ?>
        </div>
        <!-- jQuery and Bootstrap JS -->
        <script src="./assets/js/jquery-3.6.1.min.js"></script>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/script.js"></script>
    </body>

</html>