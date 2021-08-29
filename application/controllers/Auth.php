<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct() //Method Dafult ketika menjalankan Controller Auth.php
  {
    parent::__construct();
    $this->load->library('form_validation'); //Memanggil Library form_validation
  }

  public function index()
  {
    if ($this->session->userdata('email')) { //Jika Session masih memiliki data berupa Email
      redirect('user');
    }

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'Login Page';
      $this->load->view('template/auth_header', $data);
      $this->load->view('auth/login');
      $this->load->view('template/auth_footer');
    } else {
      $this->_login(); //Memanggil Method _login (Private)
    }
  }

  private function _login() //Method Private yang hanya bisa di akses oleh kelas Auth.php
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    if ($user) { //Jika User ada
      if ($user['is_active'] == 1) { //Jika User active = 1
        if (password_verify($password, $user['password'])) { //Jika Password benar, fungsi php password_verify untuk menyamakan password yang di inputkan dengan passowrd yang telah di has di database
          $data = [ //Menyimpan data email dan role_id kedalam variable $data
            'id' => $user['id'],
            'email' => $user['email'],
            'role_id' => $user['role_id']
          ];
          $this->session->set_userdata($data); //Menyimpan variable $data ke session
          if ($user['role_id'] == 1) { //Jika role_id 1 (Admin)
            redirect('admin');
          } else { //Jika role_id bukan 1 (Admin)
            redirect('user');
          }
        } else { //Jika Password salah
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong Password! </div>');
          redirect('auth');
        }
      } else { //User tidak aktif = 2
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email is not been activated! </div>');
        redirect('auth');
      }
    } else { //User tidak ada
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email is not registered! </div>');
      redirect('auth');
    }
  }

  public function registration()
  {
    if ($this->session->userdata('email')) { //Jika Session masih memiliki data berupa Email
      redirect('user');
    }

    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
      'is_unique' => 'This email has already registered!'
    ]);

    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
      'matches' => 'Password dont match!',
      'min_length' => 'Password too short!'
    ]);

    $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'User Registration';
      $this->load->view('template/auth_header', $data);
      $this->load->view('auth/registration');
      $this->load->view('template/auth_footer');
    } else {
      $data = [
        'name' => htmlspecialchars($this->input->post('name', true)),
        'email' => htmlspecialchars($this->input->post('email', true)),
        'image' => 'default.jpg',
        'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT), //password_hash adalah fungsi milik php digunakan untuk mengenkripsi password
        'role_id' => 3, //default 3 adalah user pendaftar sebagai Siswa
        'is_active' => 1, //default 1 untuk user active
      ];

      $this->db->insert('user', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congatulatetion! your account has been created. Please Login </div>');
      redirect('auth');
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('email'); //Membersihkan Session Email sebelumnya
    $this->session->unset_userdata('role_id'); //Membersihkan Session Role Id sebelumnya
    $this->db->empty_table('dss_assessment_individual');
    $this->db->empty_table('dss_moora_individual');
    $this->db->empty_table('dss_topsis_individual');
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> You has been logged out! </div>');
    redirect('auth');
  }

  public function blocked() //Method Blocked ketika ada User yang mengakses halaman yang bukan haknya
  {
    $this->load->view('auth/blocked');
  }
}
