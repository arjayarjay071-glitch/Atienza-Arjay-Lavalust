<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
</head>
<body>
    <nav class="navbar">
        <div class="brand">
            MinSU Student Portal
        </div>

        <div class="nav-links">
            <a href="<?php echo site_url('student'); ?>">Home</a>
            <a href="<?php echo site_url('student/profile'); ?>">Student Profile</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h1>Student Information</h1>
            <p class="subtitle">Personal Details</p>

            <div class="info-list">
                <p><strong>Student ID:</strong> <?php echo $student_id; ?></p>
                <p><strong>Name:</strong> <?php echo $name; ?></p>
                <p><strong>Course:</strong> <?php echo $course; ?></p>
                <p><strong>Year Level:</strong> <?php echo $year; ?></p>
                <p><strong>Section:</strong> <?php echo $section; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
            </div>

            <div class="actions">
                <a href="<?php echo site_url('student'); ?>" class="btn-primary">Home</a>
                <a href="<?php echo site_url('student/profile'); ?>" class="btn-accent">Student Profile</a>
            </div>
        </div>
    </div>
</body>
</html>