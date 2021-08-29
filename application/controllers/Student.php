<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student extends CI_Controller
{
    private $filename = "import_data";

    public function __construct()
    {
        parent::__construct();
        is_logged_in(); //Memanggil Helper is_logged_in dari nyak_helper.php
    }

    public function assessment()
    {
        $data['title'] = 'Assessment Student';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Moora_model');
        $data['assessment'] = $this->Moora_model->joinAssessmentStudent();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('student/assessment', $data);
        $this->load->view('template/footer');
    }

    public function assessmentDelete($assessment_id)
    {
        $this->db->where('id', $assessment_id);
        $this->db->delete('dss_assessment_individual');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Score successfully deleted! </div>');
        redirect('Student/assessment');
    }

    public function assessmentEdit($assessment_id)
    {
        $data['title'] = 'Edit Assessment';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['assessment'] = $this->db->get_where('dss_assessment_individual', ['id' => $assessment_id])->row_array();

        $this->form_validation->set_rules('value', 'Nilai', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('student/edit-assessment', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                "value" => $this->input->post('value', true)
            ];

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('dss_assessment_individual', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Score successfully updated! </div>');
            redirect('Student/assessment');
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
        $this->load->view('student/form-assessment', $data);
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
                    'code_alternative' => $row['E'],
                    'code_criteria' => $row['F'],
                    'value' => $row['G']
                ));
            }

            $numrow++; // Tambah 1 setiap kali looping
        }

        $this->db->insert_batch('dss_assessment_individual', $data);

        redirect("Student/assessment");
    }

    public function resultMoora()
    {
        $data['title'] = 'Result Moora';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Moora_model');
        $data['data'] = $this->Moora_model->getJoinStudent();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('student/result-moora', $data);
        $this->load->view('template/footer');
    }

    public function getResultMoora()
    {
        $this->load->model('Moora_model');
        $id_user = $this->session->userdata('id');

        $this->db->where('user_id', $id_user);
        $this->db->delete('dss_moora_history');

        $this->db->empty_table('dss_moora_individual');

        $criteria = $this->db->get('dss_criteria_individual');
        $alternative = $this->db->get('dss_alternative_individual');

        // (Menentukan nilai akar (SQRT) dari setiap kriteria)
        foreach ($criteria->result() as $value) {
            //var_dump($value);
            $powed = 0; //mendefault variabel powed menjadi 0
            foreach ($this->Moora_model->get('dss_assessment_individual', array('code_criteria' => $value->code_criteria))->result() as $v) {
                //var_dump($v);
                $powed += pow($v->value, 2); //mepengkatkan 2 untuk setiap value
            }
            //var_dump($powed);
            $normalized_criteria[$value->id] = sqrt($powed); //sqrt (akar)
            //var_dump($normalized_criteria[$value->id]);
        }

        //  (Menghitung Matriks Normalisasi)
        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                //var_dump($v);
                $assessed_val = $this->Moora_model->get('dss_assessment_individual', array('code_alternative' => $v->code_alternative, 'code_criteria' => $value->code_criteria))->row('value');
                //var_dump($assessed_val);
                $normalized_matrix[$value->id][$v->id] = $assessed_val / $normalized_criteria[$value->id];
                //var_dump($normalized_matrix[$value->id][$v->id]);
            }
        }

        // (Menghitungan Nilai Optimasi Multiobjektif)
        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                $normalized_weighted_matrix[$value->id][$v->id] = $normalized_matrix[$value->id][$v->id] * $value->weight; //mengalikan matriks normalisasi dengan bobot kriteria              
                //var_dump($normalized_weighted_matrix[$value->id][$v->id]);
            }
        }

        // (Menentukan Variable Nilai Min dan Nilai Max)
        //$max = array();
        //$min = array();
        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                if ($value->attribute_id  == '1') { //attribute_id 1 = benefits
                    $max[$v->id] = 0; //mendefault variabel max menjadi 0
                } else {
                    $min[$v->id] = 0; //mendefault variabel min menjadi 0
                }
            }
        }

        // (Menghitung Jumlah Nilai Max dan Nilai Min)
        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                if ($value->attribute_id  == '1') { //attribute_id 1 = benefits
                    $max[$v->id] += $normalized_weighted_matrix[$value->id][$v->id];
                    //var_dump($max[$v->id]);
                } else {
                    $min[$v->id] += $normalized_weighted_matrix[$value->id][$v->id];
                    //var_dump($min[$v->id]);
                }
                //var_dump($max[$v->id]);
            }
        }

        //(Menentukan Rangking dari hasil perhitungan (Yi))
        foreach ($alternative->result() as $v) {
            $data = [
                'code_alternative'   => $v->code_alternative,
                'score' => $max[$v->id] - $min[$v->id]
            ];
            $this->db->insert('dss_moora_individual', $data);

            $data = [
                'user_id' => $id_user,
                'code_alternative' => $v->code_alternative,
                'score' => $max[$v->id] - $min[$v->id]
            ];
            $this->db->insert('dss_moora_history', $data);
        }

        redirect('Student/resultMoora', 'refresh');
    }

    public function resultTopsis()
    {
        $data['title'] = 'Result Topsis';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Topsis_model');
        $data['data'] = $this->Topsis_model->getJoinStudent();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('student/result-topsis', $data);
        $this->load->view('template/footer');
    }

    public function getResultTopsis()
    {
        $this->load->model('Topsis_model');
        $id_user = $this->session->userdata('id');

        $this->db->where('user_id', $id_user);
        $this->db->delete('dss_topsis_history');

        $this->db->empty_table('dss_topsis_individual');

        $criteria = $this->db->get('dss_criteria_individual');
        $alternative = $this->db->get('dss_alternative_individual');

        // (Menentukan nilai akar (SQRT) dari setiap kriteria)
        foreach ($criteria->result() as $value) {
            //var_dump($value);
            $powed = 0; //mendefault variabel powed menjadi 0
            foreach ($this->Topsis_model->get('dss_assessment_individual', array('code_criteria' => $value->code_criteria))->result() as $v) {
                //var_dump($v);
                $powed += pow($v->value, 2); //mepengkatkan 2 untuk setiap value
            }
            //var_dump($powed);
            $normalized_criteria[$value->id] = sqrt($powed); //sqrt (akar)
            //var_dump($normalized_criteria[$value->id]);
        }

        //  (Menghitung Matriks Normalisasi)
        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                //var_dump($v);
                $assessed_val = $this->Topsis_model->get('dss_assessment_individual', array('code_alternative' => $v->code_alternative, 'code_criteria' => $value->code_criteria))->row('value');
                //var_dump($assessed_val);
                $normalized_matrix[$value->id][$v->id] = $assessed_val / $normalized_criteria[$value->id];
                //var_dump($normalized_matrix[$value->id][$v->id]);
            }
        }

        // (Menghitungan Nilai Optimasi Multiobjektif)
        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                $normalized_weighted_matrix[$value->id][$v->id] = $normalized_matrix[$value->id][$v->id] * $value->weight; //mengalikan matriks normalisasi dengan bobot kriteria              
                //var_dump($normalized_weighted_matrix[$value->id][$v->id]);
            }
        }

        // (Menghitung Jumlah Nilai Max dan Nilai Min)
        foreach ($criteria->result() as $value) {
            if ($value->attribute_id  == '1') { //attribute_id 1 = benefits
                $positif[$value->id] = max($normalized_weighted_matrix[$value->id]);
                $negatif[$value->id] = min($normalized_weighted_matrix[$value->id]);
                //var_dump($positif[$value->id]);
                //var_dump($negatif[$value->id]);
            } else {
                $positif[$value->id] = min($normalized_weighted_matrix[$value->id]);
                $negatif[$value->id] = max($normalized_weighted_matrix[$value->id]);
                //var_dump($negatif[$value->id]);
            }
        }
        //var_dump($positif);
        //var_dump($negatif);

        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                $normalized_positif[$value->id][$v->id] = $positif[$value->id] - $normalized_weighted_matrix[$value->id][$v->id];
                //var_dump($normalized_positif[$value->id][$v->id]);
                $normalized_negatif[$value->id][$v->id] = $negatif[$value->id] - $normalized_weighted_matrix[$value->id][$v->id];
                //var_dump($normalized_negatif[$value->id][$v->id]);
            }
        }

        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                $normalized_positif_pow[$value->id][$v->id] = pow($normalized_positif[$value->id][$v->id], 2);
                //var_dump($normalized_positif_x[$value->id][$v->id]);
                $normalized_negatif_pow[$value->id][$v->id] = pow($normalized_negatif[$value->id][$v->id], 2);
                //var_dump($normalized_negatif[$value->id][$v->id]);
            }
        }

        //$normalized_positif_sum = array();
        //$normalized_negatif_sum = array();
        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                $normalized_positif_sum[$v->id] = 0; //mendefault variabel max menjadi 0
                $normalized_negatif_sum[$v->id] = 0; //mendefault variabel min menjadi 0
            }
        }

        foreach ($criteria->result() as $value) {
            foreach ($alternative->result() as $v) {
                $normalized_positif_sum[$v->id] += $normalized_positif_pow[$value->id][$v->id];
                //var_dump($normalized_positif_y[$v->id]);
                $normalized_negatif_sum[$v->id] += $normalized_negatif_pow[$value->id][$v->id];
            }
            //var_dump($normalized_positif_y[$v->id]);
        }


        foreach ($alternative->result() as $v) {
            $normalized_positif_sqrt[$v->id] = sqrt($normalized_positif_sum[$v->id]);
            //var_dump($normalized_positif_z[$v->id]);
            $normalized_negatif_sqrt[$v->id] = sqrt($normalized_negatif_sum[$v->id]);
            //var_dump($normalized_negatif_z[$v->id]);
        }

        foreach ($alternative->result() as $v) {
            $data = [
                'code_alternative'   => $v->code_alternative,
                'score' => $normalized_negatif_sqrt[$v->id] / ($normalized_positif_sqrt[$v->id] + $normalized_negatif_sqrt[$v->id])
            ];
            $this->db->insert('dss_topsis_individual', $data);

            $data = [
                'user_id' => $id_user,
                'code_alternative' => $v->code_alternative,
                'score' => $normalized_negatif_sqrt[$v->id] / ($normalized_positif_sqrt[$v->id] + $normalized_negatif_sqrt[$v->id])
            ];
            $this->db->insert('dss_topsis_history', $data);
        }

        redirect('Student/resultTopsis', 'refresh');
    }
}
