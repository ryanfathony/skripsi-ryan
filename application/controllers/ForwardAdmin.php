<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ForwardAdmin extends CI_Controller
{
    private $filename = "import_data";

    public function __construct()
    {
        parent::__construct();
        is_logged_in(); //Memanggil Helper is_logged_in dari nyak_helper.php
    }

    public function kecerdasan()
    {
        $data['title'] = 'Kecerdasan Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['kecerdasan'] = $this->db->get('forward_kecerdasan')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('forward/kecerdasan', $data);
        $this->load->view('template/footer');
    }

    public function kecerdasanAdd()
    {
        $data['title'] = 'Add New Intelligence';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('kode_kecerdasan', 'Kode Kecerdasan', 'required|trim');
        $this->form_validation->set_rules('nama_kecerdasan', 'Nama Kecerdasan', 'required|trim');
        $this->form_validation->set_rules('kriteria', 'Kriteria Kecerdasan', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi Kecerdasan', 'required|trim');
        // $this->form_validation->set_rules('informasi', 'Informasi Kecerdasan', 'required|trim');
        // $this->form_validation->set_rules('stimulasi', 'Stimulasi Kecerdasan', 'required|trim');
        // $this->form_validation->set_rules('jurusan', 'Jurusan', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('forward/add-kecerdasan', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'kode_kecerdasan' => $this->input->post('kode_kecerdasan'),
                'nama_kecerdasan' => $this->input->post('nama_kecerdasan'),
                'kriteria' => $this->input->post('kriteria'),
                'deskripsi' => $this->input->post('deskripsi')
                // 'informasi' => $this->input->post('informasi'),
                // 'stimulasi' => $this->input->post('stimulasi'),
                // 'jurusan' => $this->input->post('jurusan')
            ];
            $this->db->insert('forward_kecerdasan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congatulatetion! Intelligence successfully added! </div>');
            redirect('ForwardAdmin/kecerdasan');
        }
    }

    public function kecerdasanDelete($kecerdasan_id)
    {
        $this->db->where('id', $kecerdasan_id);
        $this->db->delete('forward_kecerdasan');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Kecerdasan successfully deleted! </div>');
        redirect('ForwardAdmin/kecerdasan');
    }

    public function kecerdasanEdit($kecerdasan_id)
    {
        $data['title'] = 'Edit Kecerdasan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['kecerdasan'] = $this->db->get_where('forward_kecerdasan', ['id' => $kecerdasan_id])->row_array();

        $this->form_validation->set_rules('kode_kecerdasan', 'Kode Kecerdasan', 'required|trim');
        $this->form_validation->set_rules('nama_kecerdasan', 'Nama Kecerdasan', 'required|trim');
        $this->form_validation->set_rules('kriteria', 'Kriteria Kecerdasan', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi Kecerdasan', 'required|trim');
        // $this->form_validation->set_rules('informasi', 'Informasi Kecerdasan', 'required|trim');
        // $this->form_validation->set_rules('stimulasi', 'Stimulasi Kecerdasan', 'required|trim');
        // $this->form_validation->set_rules('jurusan', 'Jurusan', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('forward/edit-kecerdasan', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                "kode_kecerdasan" => $this->input->post('kode_kecerdasan', true),
                "nama_kecerdasan" => $this->input->post('nama_kecerdasan', true),
                "kriteria" => $this->input->post('kriteria', true),
                "deskripsi" => $this->input->post('deskripsi', true)
                // "informasi" => $this->input->post('informasi', true),
                // "stimulasi" => $this->input->post('stimulasi', true),
                // "jurusan" => $this->input->post('jurusan', true)
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('forward_kecerdasan', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Kecerdasan successfully updated! </div>');
            redirect('ForwardAdmin/kecerdasan');
        }
    }

    public function kecerdasanForm()
    {
        $this->load->model('Excel_model');

        $data = array(); // Buat variabel $data sebagai array

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
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

        $data['title'] = 'Import Data Kecerdasan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('forward/form-kecerdasan', $data);
        $this->load->view('template/footer');
    }

    public function kecerdasanImport()
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
                    'kode_kecerdasan' => $row['A'],
                    'nama_kecerdasan' => $row['B'],
                    'kriteria' => $row['C'],
                    'deskripsi' => $row['D']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('forward_kecerdasan', $data);

        redirect("ForwardAdmin/kecerdasan");
    }

    public function kriteria()
    {
        $data['title'] = 'Criteria Forward';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['kriteria'] = $this->db->get('forward_kriteria')->result_array();

        $this->form_validation->set_rules('kode_kriteria', 'Kode Kriteria', 'required');
        $this->form_validation->set_rules('nama_kriteria', 'Nama Kriteria', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('forward/kriteria', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'kode_kriteria' => $this->input->post('kode_kriteria'),
                'nama_kriteria' => $this->input->post('nama_kriteria')
            ];
            $this->db->insert('forward_kriteria', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> New Kriteria Added! </div>');
            redirect('ForwardAdmin/kriteria');
        }
    }

    public function kriteriaDelete($kriteria_id)
    {
        $this->db->where('id', $kriteria_id);
        $this->db->delete('forward_kriteria');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Kriteria successfully deleted! </div>');
        redirect('ForwardAdmin/kriteria');
    }

    public function kriteriaEdit($kriteria_id)
    {
        $data['title'] = 'Edit Kriteria';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['kriteria'] = $this->db->get_where('forward_kriteria', ['id' => $kriteria_id])->row_array();

        $this->form_validation->set_rules('kode_kriteria', 'Kode Kriteria', 'required');
        $this->form_validation->set_rules('nama_kriteria', 'Nama Kriteria', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('forward/edit-kriteria', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'kode_kriteria' => $this->input->post('kode_kriteria'),
                'nama_kriteria' => $this->input->post('nama_kriteria')
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('forward_kriteria', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Kriteria successfully updated! </div>');
            redirect('ForwardAdmin/kriteria');
        }
    }

    public function kriteriaForm()
    {
        $this->load->model('Excel_model');

        $data = array(); // Buat variabel $data sebagai array

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
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

        $data['title'] = 'Import Data Criteria';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('forward/form-kriteria', $data);
        $this->load->view('template/footer');
    }

    public function kriteriaImport()
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
                    'kode_kriteria' => $row['A'],
                    'nama_kriteria' => $row['B']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('forward_kriteria', $data);

        redirect("ForwardAdmin/kriteria");
    }

    public function knowledge()
    {
        $data['title'] = 'Knowledge Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['knowledge'] = $this->db->get('forward_knowledge')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('forward/knowledge', $data);
        $this->load->view('template/footer');
    }

    public function knowledgeAdd()
    {
        $data['title'] = 'Add New Intelligence';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['kriteria'] = $this->db->get('forward_kriteria')->result_array();
        $data['kecerdasan'] = $this->db->get('forward_kecerdasan')->result_array();

        $this->form_validation->set_rules('kode_kriteria', 'Kriteria Kecerdasan', 'required|trim');
        $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required|trim');
        $this->form_validation->set_rules('is_yes', 'Jawaban Ya', 'required|trim');
        $this->form_validation->set_rules('is_no', 'Jawaban Tidak', 'required|trim');
        $this->form_validation->set_rules('jenis_yes', 'Jika Ya', 'required|trim');
        $this->form_validation->set_rules('jenis_no', 'Jika Tidak', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('forward/add-knowledge', $data);
            $this->load->view('template/footer');
        } else {
            $to_yes = "";
            $to_no = "";

            if ($this->input->post('jenis_yes') == "kecerdasan_yes") {
                $to_yes = $this->input->post('to_yes_kecerdasan');
            } else {
                $to_yes = $this->input->post('to_yes_kriteria');
            }

            if ($this->input->post('jenis_no') == "kecerdasan_no") {
                $to_no = $this->input->post('to_no_kecerdasan');
            } else {
                $to_no = $this->input->post('to_no_kriteria');
            }
            $data = [
                'kriteria' => $this->input->post('kode_kriteria'),
                'pertanyaan' => $this->input->post('pertanyaan'),
                'is_yes' => $this->input->post('is_yes'),
                'is_no' => $this->input->post('is_no'),
                'to_yes' => $to_yes,
                'to_no' => $to_no
            ];
            $this->db->insert('forward_knowledge', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congatulatetion! Intelligence successfully added! </div>');
            redirect('ForwardAdmin/knowledge');
        }
    }

    public function knowledgeDelete($knowledge_id)
    {
        $this->db->where('id', $knowledge_id);
        $this->db->delete('forward_knowledge');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Knowledge successfully deleted! </div>');
        redirect('ForwardAdmin/knowledge');
    }

    public function knowledgeEdit($knowledge_id)
    {
        $data['title'] = 'Edit Knowledge';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['knowledge'] = $this->db->get_where('forward_knowledge', ['id' => $knowledge_id])->row_array();

        $data['kriteria'] = $this->db->get('forward_kriteria')->result_array();
        $data['kecerdasan'] = $this->db->get('forward_kecerdasan')->result_array();

        $this->form_validation->set_rules('kode_kriteria', 'Kriteria Kecerdasan', 'required|trim');
        $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required|trim');
        $this->form_validation->set_rules('is_yes', 'Jawaban Ya', 'required|trim');
        $this->form_validation->set_rules('is_no', 'Jawaban Tidak', 'required|trim');
        $this->form_validation->set_rules('jenis_yes', 'Jika Ya', 'required|trim');
        $this->form_validation->set_rules('jenis_no', 'Jika Tidak', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('forward/edit-knowledge', $data);
            $this->load->view('template/footer');
        } else {
            $to_yes = "";
            $to_no = "";

            if ($this->input->post('jenis_yes') == "kecerdasan_yes") {
                $to_yes = $this->input->post('to_yes_kecerdasan');
            } else {
                $to_yes = $this->input->post('to_yes_kriteria');
            }

            if ($this->input->post('jenis_no') == "kecerdasan_no") {
                $to_no = $this->input->post('to_no_kecerdasan');
            } else {
                $to_no = $this->input->post('to_no_kriteria');
            }

            $data = [
                'kriteria' => $this->input->post('kode_kriteria'),
                'pertanyaan' => $this->input->post('pertanyaan'),
                'is_yes' => $this->input->post('is_yes'),
                'is_no' => $this->input->post('is_no'),
                'to_yes' => $to_yes,
                'to_no' => $to_no
            ];
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('forward_knowledge', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Knowledge successfully updated! </div>');
            redirect('ForwardAdmin/knowledge');
        }
    }

    public function knowledgeForm()
    {
        $this->load->model('Excel_model');

        $data = array(); // Buat variabel $data sebagai array

        if (isset($_POST['preview'])) { // Jika user menekan tombol Preview pada form
            // lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
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

        $data['title'] = 'Import Data Criteria';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('forward/form-knowledge', $data);
        $this->load->view('template/footer');
    }

    public function knowledgeImport()
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
                    'kriteria' => $row['A'],
                    'pertanyaan' => $row['B'],
                    'is_yes' => $row['C'],
                    'is_no' => $row['D'],
                    'to_yes' => $row['E'],
                    'to_no' => $row['F']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('forward_knowledge', $data);

        redirect("ForwardAdmin/knowledge"); // Redirect ke halaman awal (ke controller siswa fungsi index)
    }
}
