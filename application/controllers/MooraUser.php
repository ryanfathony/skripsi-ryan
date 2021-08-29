<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MooraUser extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in(); //Memanggil Helper is_logged_in dari nyak_helper.php
    }

    public function assessment()
    {
        $data['title'] = 'Assessment';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['alternative'] = $this->db->get('moora_alternative');
        $data['criteria'] = $this->db->get('moora_criteria');

        $this->form_validation->set_rules('value[]', 'Value', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('moora/assessment', $data);
            $this->load->view('template/footer');
        } else {
            $this->db->empty_table('moora_assessment');
            $this->db->empty_table('moora_result');
            $this->db->empty_table('moora_sqrt');
            $this->db->empty_table('moora_normalisasi');
            $this->db->empty_table('moora_optimasi');
            $this->db->empty_table('moora_minmax');

            $val = $this->input->post('value');
            $alternative = $this->input->post('alternative');
            foreach ($this->input->post('criteria') as $k => $v) {
                $data = [
                    'alternative_id'    => $alternative[$k],
                    'criteria_id'       => $v,
                    'value'             => $val[$k]
                ];
                $this->db->insert('moora_assessment', $data);
            }
            redirect('MooraUser/result', 'refresh');
        }
    }

    public function result()
    {
        $data['title'] = 'Result';
        $data['title2'] = 'SQRT';
        $data['title3'] = 'Normalisasi';
        $data['title4'] = 'Optimasi';
        $data['title5'] = 'Min Max';
        $data['title6'] = 'Assessment';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Moora_model');

        $data['data'] = $this->Moora_model->get_result();
        $data['sqrt'] = $this->Moora_model->joinTable2();
        $data['normalisasi'] = $this->Moora_model->joinTable3();
        $data['optimasi'] = $this->Moora_model->joinTable4();
        $data['minmax'] = $this->Moora_model->joinTable5();
        $data['assessment'] = $this->Moora_model->joinTable6();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('moora/result', $data);
        $this->load->view('template/footer');
    }

    public function get_result()
    {
        $id_user = $this->session->userdata('id');
        $this->load->model('Moora_model');

        // First, we empty the previous result
        $this->db->empty_table('moora_result');
        $this->db->empty_table('moora_sqrt');
        $this->db->empty_table('moora_normalisasi');
        $this->db->empty_table('moora_optimasi');
        $this->db->empty_table('moora_minmax');

        $this->db->where('user_id', $id_user);
        $this->db->delete('moora_history');

        // Get alternative and criteria
        $criteria = $this->db->get('moora_criteria');
        $alternative = $this->db->get('moora_alternative');

        // (Menentukan nilai akar (SQRT) dari setiap kriteria)
        foreach ($criteria->result() as $key => $value) {
            //var_dump($value);
            $powed = 0; //mendefault variabel powed menjadi 0
            foreach ($this->Moora_model->get('moora_assessment', array('criteria_id' => $value->id))->result() as $k => $v) {
                //var_dump($v);
                $powed += pow($v->value, 2); //mepengkatkan 2 untuk setiap value
            }
            //var_dump($powed);
            $normalized_criteria[$value->id] = sqrt($powed); //sqrt (akar)

            $data = [
                'id_criteria' => $value->id,
                'sqrt' => $normalized_criteria[$value->id]
            ];
            $this->db->insert('moora_sqrt', $data);
            //var_dump($normalized_criteria[$value->id]);
        }

        //  (Menghitung Matriks Normalisasi)
        foreach ($criteria->result() as $key => $value) {
            foreach ($alternative->result() as $k => $v) {
                //var_dump($v);
                $assessed_val = $this->Moora_model->get('moora_assessment', array('alternative_id' => $v->id, 'criteria_id' => $value->id))->row('value');
                //var_dump($assessed_val);
                $normalized_matrix[$value->id][$v->id] = $assessed_val / $normalized_criteria[$value->id];

                $data = [
                    'id_alternative' => $v->id,
                    'id_criteria' => $value->id,
                    'normalisasi' =>  $normalized_matrix[$value->id][$v->id]
                ];
                $this->db->insert('moora_normalisasi', $data);
                //var_dump($normalized_matrix[$value->id][$v->id]);
            }
        }

        // (Menghitungan Nilai Optimasi Multiobjektif)
        foreach ($criteria->result() as $key => $value) {
            foreach ($alternative->result() as $k => $v) {
                $normalized_weighted_matrix[$value->id][$v->id] = $normalized_matrix[$value->id][$v->id] * $value->weight; //mengalikan matriks normalisasi dengan bobot kriteria

                $data = [
                    'id_alternative' => $v->id,
                    'id_criteria' => $value->id,
                    'optimasi' => $normalized_weighted_matrix[$value->id][$v->id]
                ];
                $this->db->insert('moora_optimasi', $data);
                //var_dump($normalized_weighted_matrix[$value->id][$v->id]);
            }
        }

        // (Menentukan Variable Nilai Min dan Nilai Max)
        $max = array();
        $min = array();
        foreach ($criteria->result() as $key => $value) {
            foreach ($alternative->result() as $k => $v) {
                if ($value->attribute_id  == '1') { //attribute_id 1 = benefits
                    $max[$v->id] = 0; //mendefault variabel max menjadi 0
                } else {
                    $min[$v->id] = 0; //mendefault variabel min menjadi 0
                }
            }
        }

        // (Menghitung Jumlah Nilai Max dan Nilai Min)
        foreach ($criteria->result() as $key => $value) {
            foreach ($alternative->result() as $k => $v) {
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
        //var_dump($max[$v->id]);
        //var_dump($min[$v->id]);

        // foreach ($alternative->result() as $k => $v) {
        //     $data = [
        //         'id_alternative'    => $v->id,
        //         'min'               => $min[$v->id],
        //         'max'               => $max[$v->id]
        //     ];
        //     $this->db->insert('moora_minmax', $data);
        // }

        //var_dump($max[$v->id]);
        //var_dump($min[$v->id]);

        // And the last, find value of Yi and insert them to the database (Menentukan Rangking dari hasil perhitungan (Yi))
        $yi = array();
        foreach ($alternative->result() as $k => $v) {
            $data = [
                'alternative_id'    => $v->id,
                'score'             => $max[$v->id] - $min[$v->id]
            ];
            $this->db->insert('moora_result', $data);

            $data = [
                'user_id' => $id_user,
                'moora_alternative_id' => $v->id,
                'score' => $max[$v->id] - $min[$v->id]
            ];
            $this->db->insert('moora_history', $data);
        }

        redirect('MooraUser/result', 'refresh');
    }
}
