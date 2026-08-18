<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller {

    public function index() {
        $data['title'] = 'Student Home - Arjay Atienza';
        $this->call->view('student_home', $data);
    }

    public function profile() {
        $student = [
            'student_id' => 'MCC2024-00059',
            'name'       => 'Arjay Atienza',
            'course'     => 'BSIT',
            'year'       => '3rd Year',
            'section'    => '2F3',
            'email'      => 'arjayarjay071@gmail.com'
        ];

        $this->call->view('student_profile', $student);
    }
}
?>