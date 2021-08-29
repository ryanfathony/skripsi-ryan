<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DSSManagement extends CI_Controller
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

        $data['alternative'] = $this->db->get('dss_alternative')->result_array();

        $this->form_validation->set_rules('nis', 'Nomor Induk Siswa', 'required');
        $this->form_validation->set_rules('name', 'Nama Siswa', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('dss/alternative', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nis' => $this->input->post('nis'),
                'name' => $this->input->post('name')
            ];
            $this->db->insert('dss_alternative', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> New Alternative Added! </div>');
            redirect('DSSManagement/alternative');
        }
    }

    public function alternativeDelete($alternative_id)
    {
        $this->db->where('id', $alternative_id);
        $this->db->delete('dss_alternative');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Alternative successfully deleted! </div>');
        redirect('DSSManagement/alternative');
    }

    public function alternativeEdit($alternative_id)
    {
        $data['title'] = 'Edit Alternative';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['alternative'] = $this->db->get_where('dss_alternative', ['id' => $alternative_id])->row_array();

        $this->form_validation->set_rules('nis', 'Nomor Induk Siswa', 'required');
        $this->form_validation->set_rules('name', 'Nama Siswa', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('dss/edit-alternative', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                "name" => $this->input->post('name', true),
                "nis" => $this->input->post('nis', true)
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('dss_alternative', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Alternative successfully updated! </div>');
            redirect('DSSManagement/alternative');
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
        $this->load->view('dss/form-alternative', $data);
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
                    'nis' => $row['A'],
                    'name' => $row['B']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('dss_alternative', $data);

        redirect("DSSManagement/alternative");
    }

    public function alternativeIndividual()
    {
        $data['title'] = 'Alternative Individual';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['alternative'] = $this->db->get('dss_alternative_individual')->result_array();

        $this->form_validation->set_rules('code_alternative', 'Code Alternative', 'required');
        $this->form_validation->set_rules('alternative', 'Alternative', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('dss/alternative-individual', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'alternative' => $this->input->post('alternative'),
                'code_alternative' => $this->input->post('code_alternative')
            ];
            $this->db->insert('dss_alternative_individual', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> New Alternative Added! </div>');
            redirect('DSSManagement/alternativeIndividual');
        }
    }

    public function alternativeIndividualDelete($alternative_id)
    {
        $this->db->where('id', $alternative_id);
        $this->db->delete('dss_alternative_individual');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Alternative successfully deleted! </div>');
        redirect('DSSManagement/alternativeIndividual');
    }

    public function alternativeIndividualEdit($alternative_id)
    {
        $data['title'] = 'Edit Alternative';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['alternative'] = $this->db->get_where('dss_alternative_individual', ['id' => $alternative_id])->row_array();

        $this->form_validation->set_rules('code_alternative', 'Code Alternative', 'required');
        $this->form_validation->set_rules('alternative', 'Alternative', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('dss/edit-alternative-individual', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                "alternative" => $this->input->post('alternative', true),
                "code_alternative" => $this->input->post('code_alternative', true)
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('dss_alternative_individual', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Alternative successfully updated! </div>');
            redirect('DSSManagement/alternativeIndividual');
        }
    }

    public function alternativeIndividualForm()
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
        $this->load->view('dss/form-alternative-individual', $data);
        $this->load->view('template/footer');
    }

    public function alternativeIndividualImport()
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
                    'code_alternative' => $row['A'],
                    'alternative' => $row['B']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('dss_alternative_individual', $data);

        redirect("DSSManagement/alternativeIndividual");
    }

    public function criteriaIndividual()
    {
        $data['title'] = 'Criteria Individual';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Moora_model');
        $data['model'] = $this->Moora_model->joinTableIndividual();
        $data['attribute'] = $this->db->get('attribute_type')->result_array();

        $this->form_validation->set_rules('code_criteria', 'Code Criteria', 'required');
        $this->form_validation->set_rules('criteria', 'Criteria', 'required');
        $this->form_validation->set_rules('weight', 'Weight', 'required');
        $this->form_validation->set_rules('attribute_id', 'Attribute', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('dss/criteria-individual', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'code_criteria' => $this->input->post('code_criteria'),
                'criteria' => $this->input->post('criteria'),
                'weight' => $this->input->post('weight'),
                'attribute_id' => $this->input->post('attribute_id'),
            ];
            $this->db->insert('dss_criteria_individual', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> New Criteria Added! </div>');
            redirect('DSSManagement/criteriaIndividual');
        }
    }

    public function criteriaIndividualDelete($criteria_id)
    {
        $this->db->where('id', $criteria_id);
        $this->db->delete('dss_criteria_individual');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Criteria successfully deleted! </div>');
        redirect('DSSManagement/criteriaIndividual');
    }

    public function criteriaIndividualEdit($criteria_id)
    {
        $data['title'] = 'Edit Criteria Individual';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['criteria'] = $this->db->get_where('dss_criteria_individual', ['id' => $criteria_id])->row_array();
        $data['attribute'] = $this->db->get('attribute_type')->result_array();

        $this->form_validation->set_rules('code_criteria', 'Code Criteria', 'required');
        $this->form_validation->set_rules('criteria', 'Criteria', 'required');
        $this->form_validation->set_rules('weight', 'Weight', 'required');
        $this->form_validation->set_rules('attribute_id', 'Attribute', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('dss/edit-criteria-individual', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                "code_criteria" => $this->input->post('code_criteria', true),
                "criteria" => $this->input->post('criteria', true),
                "weight" => $this->input->post('weight', true),
                "attribute_id" => $this->input->post('attribute_id', true)
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('dss_criteria_individual', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Criteria successfully updated! </div>');
            redirect('DSSManagement/criteriaIndividual');
        }
    }

    public function criteriaIndividualForm()
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
        $this->load->view('dss/form-criteria-individual', $data);
        $this->load->view('template/footer');
    }

    public function criteriaIndividualImport()
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
                    'code_criteria' => $row['A'],
                    'criteria' => $row['B'],
                    'weight' => $row['C'],
                    'attribute_id' => $row['D'],
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('dss_criteria_individual', $data);

        redirect("DSSManagement/criteriaIndividual");
    }

    public function assessment()
    {
        $data['title'] = 'Assessment Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Moora_model');
        $data['assessment'] = $this->Moora_model->joinAssessment();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('dss/assessment', $data);
        $this->load->view('template/footer');
    }

    public function assessmentDelete($assessment_id)
    {
        $this->db->where('id', $assessment_id);
        $this->db->delete('dss_assessment');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Score successfully deleted! </div>');
        redirect('DSSManagement/assessment');
    }

    public function assessmentEdit($assessment_id)
    {
        $data['title'] = 'Edit Assessment';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['assessment'] = $this->db->get_where('dss_assessment', ['id' => $assessment_id])->row_array();

        $this->form_validation->set_rules('value', 'Nilai Siswa', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('dss/edit-assessment', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                "value" => $this->input->post('value', true)
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('dss_assessment', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Score successfully updated! </div>');
            redirect('DSSManagement/assessment');
        }
    }

    public function assessmentForm()
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

        $data['title'] = 'Import Data Score';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('dss/form-assessment', $data);
        $this->load->view('template/footer');
    }

    public function assessmentImport()
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
                    'nis' => $row['E'],
                    'code_criteria' => $row['F'],
                    'value' => $row['G']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('dss_assessment', $data);

        redirect("DSSManagement/assessment");
    }
}
