<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Users extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('users_model');
    }

    public function index()
    {
        $data['users'] = $this->users_model->all();
        $this->call->view('users_view', $data);
    }
}