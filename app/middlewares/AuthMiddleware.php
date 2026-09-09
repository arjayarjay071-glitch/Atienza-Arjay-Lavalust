<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    public function handle(Closure $next)
    {
        $session = load_class('Session', 'libraries');

        if ($session->userdata('logged_in') !== true) {
            redirect('login');
        }

        return $next();
    }
}