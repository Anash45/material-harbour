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

    if ($userType == 'supplier') {
        // Prepare the SQL query to select materials based on supplier_id
        $sql1 = "SELECT m.*, s.company_name AS supplier_name
        FROM materials m
        JOIN suppliers s ON m.supplier_id = s.id
        WHERE m.supplier_id = ?";

        // Prepare the statement
        $stmt1 = $conn->prepare($sql1);

        // Bind the supplier_id parameter
        $stmt1->bind_param('i', $userID);

        // Execute the query
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        // Fetch all rows into an array
        $materials = $result1->fetch_all(MYSQLI_ASSOC);

        // Close the statement and connection
        $stmt1->close();
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
                        <h5 class="card-title fw-bold text-decoration-underline">
                            <?php echo htmlspecialchars($userData['company_name']); ?>
                        </h5>
                        <p class="card-text"><strong>Location:</strong>
                            <?php echo htmlspecialchars($userData['location']); ?></p>
                        <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
                        <p class="card-text"><strong>Phone:</strong>
                            <?php echo htmlspecialchars($userData['contact_phone']); ?></p>
                        <p class="card-text"><strong>Offers:</strong> <?php echo htmlspecialchars($userData['offers']); ?>
                        </p>
                        <p class="card-text"><strong>Description:</strong>
                            <?php echo htmlspecialchars($userData['description']); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">No profile data available.</div>
            <?php endif; ?>
            <?php if ($userType == 'supplier'): ?>
                <h4 class="mt-5 text-center fw-bold">Materials Offered by <?php echo htmlspecialchars($userData['company_name']); ?></h4>
                    <?php
                    echo "<table class='table table-bordered'>";
                    echo "<thead><tr><th>Material Standard</th><th>Material Type</th><th>Alloy</th><th>Type</th><th>Condition</th><th>Form</th></tr></thead>";
                    echo "<tbody>";
                    foreach ($materials as $material) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($material['material_standard']) . "</td>";
                        echo "<td>" . htmlspecialchars($material['material_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($material['alloy']) . "</td>";
                        echo "<td>" . htmlspecialchars($material['type']) . "</td>";
                        echo "<td>" . htmlspecialchars($material['condition']) . "</td>";
                        echo "<td>" . htmlspecialchars($material['form']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    ?>
                <?php endif; ?>
        </div>
        <!-- jQuery and Bootstrap JS -->
        <script src="./assets/js/jquery-3.6.1.min.js"></script>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/script.js"></script>
    </body>

</html>