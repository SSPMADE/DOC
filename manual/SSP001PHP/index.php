<?php 
require_once("visitors-log.class.php");
/**
 * Log Site Visit Data
 */
$vlClass = new VisitorLog();
$vlClass->log_site_visit();

//page
$page = str_replace(["-", "_"], " ",$_GET['page'] ?? "home");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Website | <?= ucwords($page) ?> Page</title>
    <!-- Bootstrap 5.3 CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap 5.3 JS-->
    <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sample Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link <?= $page == 'home' ? "active" : '' ?>" href="./">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link <?= $page == 'about_us' ? "active" : '' ?>" href="./?page=about_us">About Us</a>
                </li>
                <li class="nav-item">
                <a class="nav-link <?= $page == 'contact_us' ? "active" : '' ?>" href="./?page=contact_us">Contact Us</a>
                </li>
                <li class="nav-item">
                <a class="nav-link <?= $page == 'site_visits' ? "active" : '' ?>" href="./?page=site_visits">Visit Logs</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="container-md py-4">
        <h4 class="text-center"><strong><?= ucwords($page) ?> Page</strong></h4>
        <?php 
        if($page == "site visits")
            include('site-visits.php');
        ?>
    </div>
    
</body>
</html>



