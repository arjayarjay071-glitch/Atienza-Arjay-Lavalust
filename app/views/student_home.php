<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home</title>

    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
</head>

<body>

    <nav class="navbar">

        <div class="brand">
            <span>MinSU Student Portal</span>
        </div>

        <div class="nav-links">
            <a href="<?php echo site_url('student'); ?>">Home</a>
            <a href="<?php echo site_url('student/profile'); ?>">Student Profile</a>
        </div>

    </nav>

    <div class="container">

        <div class="card">

            <h1>Welcome</h1>

            <p class="subtitle">
                Student Home Page
            </p>

            <p>
               
            </p>

            <div class="actions">

                <a href="<?php echo site_url('student'); ?>" class="btn-primary">
                    Home
                </a>

                <a href="<?php echo site_url('student/profile'); ?>" class="btn-accent">
                    Student Profile
                </a>

            </div>

        </div>

    </div>

</body>
</html>