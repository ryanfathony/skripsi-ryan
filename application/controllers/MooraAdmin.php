<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MooraAdmin extends CI_Controller
{
    private $filename = "import_data";

    public function __construct()
    {
        parent::__construct();
        is_logged_in(); //Memanggil Helper is_logged_in dari nyak_helper.php
    }

    public function alternative()
    {
        $data['title'] = 'Alternative Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['alternative'] = $this->db->get('moora_alternative')->result_array();

        $this->form_validation->set_rules('alternative', 'Alternative', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('moora/alternative', $data);
            $this->load->view('template/footer');
        } else {
            $this->db->insert('moora_alternative', ['alternative' => $this->input->post('alternative')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> New Alternative Added! </div>');
            redirect('MooraAdmin/alternative');
        }
    }

    public function alternativeDelete($alternative_id)
    {
        $this->db->where('id', $alternative_id);
        $this->db->delete('moora_alternative');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Alternative successfully deleted! </div>');
        redirect('MooraAdmin/alternative');
    }

    public function alternativeEdit($alternative_id)
    {
        $data['title'] = 'Edit Alternative';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['alternative'] = $this->db->get_where('moora_alternative', ['id' => $alternative_id])->row_array();

        $this->form_validation->set_rules('alternative', 'Alternative', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('moora/edit-alternative', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                "alternative" => $this->input->post('alternative', true)
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('moora_alternative', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Alternative successfully updated! </div>');
            redirect('MooraAdmin/alternative');
        }
    }

    public function alternativeForm()
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

        $data['title'] = 'Import Data Alternative';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('moora/form-alternative', $data);
        $this->load->view('template/footer');
    }

    public function alternativeImport()
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
                    'alternative' => $row['A']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('moora_alternative', $data);

        redirect("MooraAdmin/alternative");
    }

    public function criteria()
    {
        $data['title'] = 'Criteria Moora';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Moora_model');
        $data['model'] = $this->Moora_model->joinTable();
        $data['attribute'] = $this->db->get('attribute_type')->result_array();

        $this->form_validation->set_rules('criteria', 'Criteria', 'required');
        $this->form_validation->set_rules('weight', 'Weight', 'required');
        $this->form_validation->set_rules('attribute_id', 'Attribute', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('moora/criteria', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'criteria' => $this->input->post('criteria'),
                'weight' => $this->input->post('weight'),
                'attribute_id' => $this->input->post('attribute_id'),
            ];
            $this->db->insert('moora_criteria', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> New Criteria Added! </div>');
            redirect('MooraAdmin/criteria');
        }
    }

    public function criteriaDelete($criteria_id)
    {
        $this->db->where('id', $criteria_id);
        $this->db->delete('moora_criteria');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Criteria successfully deleted! </div>');
        redirect('MooraAdmin/criteria');
    }

    public function criteriaEdit($criteria_id)
    {
        $data['title'] = 'Edit Criteria';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['criteria'] = $this->db->get_where('moora_criteria', ['id' => $criteria_id])->row_array();
        $data['attribute'] = $this->db->get('attribute_type')->result_array();

        $this->form_validation->set_rules('criteria', 'Criteria', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('moora/edit-criteria', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                "criteria" => $this->input->post('criteria', true),
                "weight" => $this->input->post('weight', true),
                "attribute_id" => $this->input->post('attribute_id', true)
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('moora_criteria', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Criteria successfully updated! </div>');
            redirect('MooraAdmin/criteria');
        }
    }

    public function criteriaForm()
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
        $this->load->view('moora/form-criteria', $data);
        $this->load->view('template/footer');
    }

    public function criteriaImport()
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
                    'criteria' => $row['A'],
                    'weight' => $row['B'],
                    'attribute_id' => $row['C']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('moora_criteria', $data);

        redirect("MooraAdmin/criteria");
    }
}
