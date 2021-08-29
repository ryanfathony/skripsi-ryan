<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ForwardUser extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in(); //Memanggil Helper is_logged_in dari nyak_helper.php
    }

    public function diagnosa()
    {
        $data['title'] = 'Diagnosa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Forward_model', 'data');
        $data['diagnosa'] = $this->data->listingOne('forward_knowledge', 'kriteria', 'C001');
        $data['kecerdasan'] = "";

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('forward/diagnosa', $data);
        $this->load->view('template/footer');
    }

    public function proses($kode)
    {
        $this->load->model('Forward_model', 'data');
        $id_user = $this->session->userdata('id');

        $diagnosa_ex = $this->data->listingOne('forward_knowledge', 'kriteria', $kode);
        $kecerdasan = ""; //variabel $kecerdasan di buat empty terlebih dahulu
        $jawaban_masuk = $this->input->post('jawab'); //Menerima input dari radio butten (jawab)

        if ($jawaban_masuk == "0") { //Jika Jawaban yang masuk adalah Tidak (0)
            $kecerdasan = ""; //variabel $kecerdasan di buat empty terlebih dahulu
            $kode_next = $diagnosa_ex->to_no; //mendeklarasikan variabel $kode_next sesuai dengan kode to_no
            $jawaban =  $this->data->listingOne('forward_knowledge', 'kriteria', $kode_next); //Mencari jawaban(kode kriteria) di database forward_knowledge berdasarkan $kode_next
            if (empty($jawaban)) { //Jika jawaban tidak ada di database forward_knowledge
                $kecerdasan = $this->data->listingOne('forward_kecerdasan', 'kode_kecerdasan', $kode_next); //Mencari jawaban(kode kecerdasan) di database forward_kecerdasan berdasarkan $kode_next

                $this->db->where('user_id', $id_user);
                $this->db->delete('forward_history');

                $forward_kecerdasan = $kecerdasan->id;

                $data = [
                    'user_id' => $id_user,
                    'forward_kecerdasan_id' => $forward_kecerdasan
                ];

                $this->db->insert('forward_history', $data);
                if (empty($kecerdasan)) { //Jika jawaban tidak ada di databse forward_kecerdasan
                    $kecerdasan = "Anda Tidak Terdiagnosa";
                }
            }
            //print_r($jawaban);die;

        } else if ($jawaban_masuk == "1") { //Jika Jawaban yang masuk adalah Iya (1)
            $kode_next = $diagnosa_ex->to_yes; //mendeklarasikan variabel $kode_next sesuai dengan kode to_yes
            $jawaban =  $this->data->listingOne('forward_knowledge', 'kriteria', $kode_next); //Mencari jawaban(kode kriteria) di database forward_knowledge berdasarkan $kode_next
            $kecerdasan = ""; //variabel $kecerdasan di buat empty terlebih dahulu
            if (empty($jawaban)) { //Jika jawaban tidak ada di database forward_knowledge
                $kecerdasan = $this->data->listingOne('forward_kecerdasan', 'kode_kecerdasan', $kode_next); //Mencari jawaban(kode kecerdasan) di database forward_kecerdasan berdasarkan $kode_next

                $this->db->where('user_id', $id_user);
                $this->db->delete('forward_history');

                $forward_kecerdasan = $kecerdasan->id;

                $data = [
                    'user_id' => $id_user,
                    'forward_kecerdasan_id' => $forward_kecerdasan
                ];

                $this->db->insert('forward_history', $data);
            }
            //print_r($kode_next);die;
        }

        $data = [
            'diagnosa'  => $jawaban,
            'kecerdasan'  => $kecerdasan
        ];

        $data['title'] = 'Diagnosa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('forward/diagnosa', $data);
        $this->load->view('template/footer');
    }
}
