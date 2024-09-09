<?php
require './db_conn.php';

// if (!isLoggedIn()) {
//   header('Location: ./index.php');
// }

// print_r($_POST);
$show = $info = '';
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
  // Retrieve user type from the session
  $userType = isset($_SESSION['userType']) ? $_SESSION['userType'] : 'Guest';
  // Sanitize and retrieve input data
  $materialStandard = isset($_POST['material_standard']) ? trim($_POST['material_standard']) : '';
  $materialType = isset($_POST['material_type']) ? trim($_POST['material_type']) : '';
  $alloy = (isset($_POST['alloy']) && !empty($_POST['alloy'])) ? trim($_POST['alloy'][0]) : '';
  if (isset($_POST['type']) && !empty($_POST['type'])) {
    $type = trim($_POST['type'][0]);
  } else {
    $type = '';
  }
  $condition = (isset($_POST['condition']) && !empty($_POST['condition'])) ? trim($_POST['condition'][0]) : '';
  $form = (isset($_POST['form']) && !empty($_POST['form'])) ? trim($_POST['form'][0]) : '';
  $supplierId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

  if (strtolower($userType) === 'manufacturer' || strtolower($userType) === 'guest') {
    // Manufacturer: List all materials and corresponding suppliers

    // SQL query to get all materials with their suppliers
    $sql = "SELECT m.*, s.company_name AS supplier_name
    , s.id AS supplier_id
              FROM materials m
              JOIN suppliers s ON m.supplier_id = s.id WHERE m.material_standard = '$materialStandard' AND m.material_type = '$materialType' AND m.alloy = '$alloy' AND m.type = '$type' AND m.form = '$form' AND m.condition = '$condition'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $show .= "<h2 class='text-center mt-4'>Available Materials and Suppliers</h2>";
      $show .= "<table class='table table-bordered'>";
      $show .= "<thead><tr><th>Material Standard</th><th>Material Type</th><th>Alloy</th><th>Type</th><th>Condition</th><th>Form</th><th>Supplier</th></tr></thead>";
      $show .= "<tbody>";
      while ($row = $result->fetch_assoc()) {
        $show .= "<tr>";
        $show .= "<td>" . htmlspecialchars($row['material_standard']) . "</td>";
        $show .= "<td>" . htmlspecialchars($row['material_type']) . "</td>";
        $show .= "<td>" . htmlspecialchars($row['alloy']) . "</td>";
        $show .= "<td>" . htmlspecialchars($row['type']) . "</td>";
        $show .= "<td>" . htmlspecialchars($row['condition']) . "</td>";
        $show .= "<td>" . htmlspecialchars($row['form']) . "</td>";
        $show .= "<td><a class='fw-bold text-primary' href='profile.php?userType=supplier&userID=" . $row['supplier_id'] . "'>" . htmlspecialchars($row['supplier_name']) . "</a></td>";
        $show .= "</tr>";
      }
      $show .= "</tbody>";
      $show .= "</table>";
    } else {
      $info = "<p class='alert alert-danger'>No materials found.</p>";
    }
  } elseif (strtolower($userType) === 'supplier') {
    // Supplier: Insert a new material into the materials table

    // Check if the material with the same details already exists
    $sql1 = "SELECT * FROM materials WHERE material_standard = '$materialStandard' AND material_type = '$materialType' AND alloy = '$alloy' AND `type` = '$type' AND `form` = '$form' AND `condition` = '$condition' AND `supplier_id` = '$supplierId'";
    $checkSql1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($checkSql1) > 0) {
      $info = "<div class='alert alert-danger'>This material already exists in the database from same supplier.</div>";
    } else {
      // Insert the new material
      $insertSql = "INSERT INTO materials (material_standard, material_type, alloy, `type`, `condition`, `form`, supplier_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
      $stmt = $conn->prepare($insertSql);
      $stmt->bind_param('ssssssi', $materialStandard, $materialType, $alloy, $type, $condition, $form, $supplierId);

      if ($stmt->execute()) {
        $info = "<div class='alert alert-success'>Material added successfully!</div>";
      } else {
        $info = "<div class='alert alert-danger'>Error adding material: " . $stmt->error . "</div>";
      }
    }
  }
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
      <h2 class="text-center">Select Material <?php
      if (isSupplier()) {
        echo ' - To Supply';
      } elseif (isManufacturer()) {
        echo ' - To Manufacture';
      } else {
        echo ' - as Guest';
      }
      ?></h2>
      <?php echo $info; ?>
      <form action="" method="POST" novalidate class="needs-validation mb-5">
        <div id="material-selection">
          <select id="material-select" required name="material_standard" class="form-control">
          </select>
        </div>
        <div class="text-center mt-3">
          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </div>
      </form>
      <?php echo $show; ?>
    </div>
    <!-- jQuery and Bootstrap JS -->
    <script src="./assets/js/jquery-3.6.1.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/script.js?v=1"></script>
  </body>

</html>