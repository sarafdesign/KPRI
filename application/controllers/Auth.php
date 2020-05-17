<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LoginModel');
    }
    
    public function index()
    {
        if ($this->session->userdata('authenticated')) // Jika user sudah login (Session authenticated ditemukan)
            redirect('admin'); // Redirect ke page welcome
        $this->load->view('login'); // Load view login.php
    }
    public function login()
    {
        $Username = $this->input->post('username');
        $Password = $this->input->post('password');
        $user = $this->LoginModel->get($Username);

        if (empty($user)) {
            $this->session->set_flashdata('message', 'Login Gagal');
            redirect('auth');
        } else {
            if ($Password == $user->password) {
                $session = array(
                    'authenticated' => true,
                    'username' => $user->username,
                    'level' => $user->level
                );
                $this->session->set_userdata($session);
                redirect('admin');
            } else {
                $this->session->set_flashdata('message', 'Password Salah');
                redirect('auth');
            }
        }
    }
    public function logout()
    {
        $this->session->sess_destroy(); // Hapus semua session
        redirect('auth'); // Redirect ke halaman login
    }
}
