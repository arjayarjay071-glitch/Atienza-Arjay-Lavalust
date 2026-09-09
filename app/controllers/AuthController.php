<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->model('users_model');
        $this->call->library('session');
    }

    public function login()
    {
        if ($this->io->method() == 'post') {

            $username = $this->io->post('username');
            $password = $this->io->post('password');

            $user = $this->users_model->find_by('username', $username);

            if ($user && password_verify($password, $user['password'])) {

                $this->session->set_userdata([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'logged_in' => true
                ]);

                redirect('products');
            }

            $data['error'] = 'Invalid username or password.';
            $this->call->view('auth/login', $data);
            return;
        }

        $this->call->view('auth/login');
    }

    public function logout()
    {
        $this->session->unset_userdata([
            'user_id',
            'username',
            'logged_in'
        ]);

        redirect('login');
    }
}