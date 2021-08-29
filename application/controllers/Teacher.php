<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher extends CI_Controller
{
    private $filename = "import_data";

    public function __construct() //Method Dafult ketika menjalankan Controller Auth.php
    {
        parent::__construct();
        is_logged_in(); //Memanggil Helper is_logged_in dari nyak_helper.php
    }

    public function student()
    {
        $data['title'] = 'Student Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Teacher_model');

        $data['model'] = $this->Teacher_model->joinTable();
        $data['datauser'] = $this->db->get('user')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('teacher/student', $data);
        $this->load->view('template/footer');
    }

    public function studentAdd()
    {
        $data['title'] = 'Add New Student';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Teacher_model');

        $data['model'] = $this->Teacher_model->joinTable();
        $data['active'] = $this->db->get('activated')->result_array();
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);

        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        $this->form_validation->set_rules('is_active', 'Active', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('teacher/add-student', $data);
            $this->load->view('template/footer');
        } else {
            //Cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT), //password_hash adalah fungsi milik php digunakan untuk mengenkripsi password
                'role_id' => 3,
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congratulatetion! student successfully added! </div>');
            redirect('Teacher/student');
        }
    }

    public function studentDelete($users_id)
    {
        $this->db->where('id', $users_id);
        $this->db->delete('user');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Student successfully deleted! </div>');
        redirect('Teacher/student');
    }

    public function studentEdit($users_id)
    {
        $data['title'] = 'Edit Student';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['datauser'] = $this->db->get_where('user', ['id' => $users_id])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();
        $data['active'] = $this->db->get('activated')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('is_active', 'Active', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('teacher/edit-student', $data);
            $this->load->view('template/footer');
        } else {
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $data = [
                'name' => $this->input->post('name'),
                "is_active" => $this->input->post('is_active')
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Student successfully updated! </div>');
            redirect('Teacher/student');
        }
    }
    public function studentForm()
    {
        $this->load->model('Excel_model');

        $data = array(); // Buat variabel $data sebagai array

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            $upload = $this->Excel_model->upload_file($this->filename);

            if ($upload['result'] == "success") {
                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

                $excelreader = new PHPExcel_Reader_Excel2007();
                $loadexcel = $excelreader->load('excel/' . $this->filename . '.xlsx'); // Load file yang tadi diupload ke folder excel
                $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                // Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
                // Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
                $data['sheet'] = $sheet;
            } else {
                $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            }
        }

        $data['title'] = 'Import Data Student';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('teacher/form-student', $data);
        $this->load->view('template/footer');
    }

    public function studentImport()
    {
        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/' . $this->filename . '.xlsx'); // Load file yang telah diupload ke folder excel
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

        // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
        $data = array();

        $numrow = 1;
        foreach ($sheet as $row) {
            // Cek $numrow apakah lebih dari 1
            // Artinya karena baris pertama adalah nama-nama kolom
            // Jadi dilewat saja, tidak usah diimport
            if ($numrow > 1) {
                // Kita push (add) array data ke variabel data
                array_push($data, array(
                    'name' => $row['A'],
                    'email' => $row['B'],
                    'image' => 'default.jpg',
                    'password' => '$2y$10$LblqL2NyVdPjclSi2x9xEOW/XxCLGpI2BnI1HXudNoteGeuQ7LXIK', //default password menjadi 'password' yang telah di hash
                    'role_id' => 3,
                    'is_active' => $row['C']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('user', $data);

        redirect("Teacher/student");
    }

    public function forwardhistory()
    {
        $data['title'] = 'Forward History';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Teacher_model');

        $data['model'] = $this->Teacher_model->joinTable2();
        $data['forwardhistory'] = $this->db->get('forward_history')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('teacher/forwardhistory', $data);
        $this->load->view('template/footer');
    }

    public function forwardhistoryDelete($history_id)
    {
        $this->db->where('id', $history_id);
        $this->db->delete('forward_history');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data successfully deleted! </div>');
        redirect('Teacher/forwardhistory');
    }

    public function mooraHistory()
    {
        $data['title'] = 'Moora History';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Teacher_model');

        $data['model'] = $this->Teacher_model->joinTableMoora();
        $data['moorahistory'] = $this->db->get('dss_moora_history')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('teacher/moora-history', $data);
        $this->load->view('template/footer');
    }

    public function moorahistoryDelete($history_id)
    {
        $this->db->where('id', $history_id);
        $this->db->delete('moora_history');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data successfully deleted! </div>');
        redirect('Teacher/moorahistory');
    }

    public function topsisHistory()
    {
        $data['title'] = 'Topsis History';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Teacher_model');

        $data['model'] = $this->Teacher_model->joinTableTopsis();
        $data['topsishistory'] = $this->db->get('dss_topsis_history')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('teacher/topsis-history', $data);
        $this->load->view('template/footer');
    }

    public function topsisHistoryDelete($history_id)
    {
        $this->db->where('id', $history_id);
        $this->db->delete('dss_topsis_history');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Data successfully deleted! </div>');
        redirect('Teacher/topsis-history');
    }
}
