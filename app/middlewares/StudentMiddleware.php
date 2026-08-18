<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle(Closure $next)
    {
        if (!session_id()) {
            session_start();
        }

        // Simpleng access condition para sa Lab Activity 3
        $_SESSION['student_access'] = true;

        if (!isset($_SESSION['student_access']) || $_SESSION['student_access'] !== true) {
            redirect('student');
        }

        return $next();
    }
}