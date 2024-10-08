<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="./index.php">Material Harbour</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link text-dark">Hey
                        <b><?php echo $user_type = (isset($_SESSION['companyName'])) ? $_SESSION['companyName'] : 'Guest'; ?></b>!</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="select-materials.php">Home</a>
                </li>
                <?php
                if (isLoggedIn()) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="profile.php?userType=<?php echo strtolower($_SESSION['userType']); ?>&userID=<?php echo $_SESSION['userId']; ?>">Profile</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>