<?php
defined('BASEPATH') or exit('No direct script access allowed');

class home extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $model = __class__.'Model';
        $this->load->model('HomeModel');
        $this->model = new $model();
    }

    public function index()
    {
        $this->load->view('home');
    }

    public function data()
    {
        date_default_timezone_set('Asia/Singapore');
        
        $time = date('H');

        $tanggal    = date('d');
        $bulan      = date('m');
        $tahun      = date('y');

        $username = 'tesprogrammer' . $tanggal . $bulan . $tahun . 'C' . $time;
        $password = 'bisacoding-' . $tanggal . '-' . $bulan . '-' . $tahun;
        $password = md5($password);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://recruitment.fastprint.co.id/tes/api_tes_programmer',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('username' => $username, 'password' => $password),
            CURLOPT_HTTPHEADER => array(
                'Cookie: ci_session=2439h7cgksqnhoocepkdsk820i6i8vhh'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        return json_decode($response, true);
    }

    public function store_data()
    {
        $data = $this->data();
        $kategori   = [];
        $status     = [];
    
        foreach ($data['data'] as $key => $value) {
            $kategori[$value['kategori']][] = array(
                'id_produk' => $value['id_produk'],
                'nama_produk' => $value['nama_produk'],
            );  
            $status[$value['status']][]   = array(
                'id_produk' => $value['id_produk'],
                'nama_produk' => $value['nama_produk'],
            ); 
        }

        $json_data = array('kategori' => $kategori, 'status' => $status, 'produk' => $data['data']);
        $data_store = $this->model->store_data($json_data);
        
    }

    public function get_datatable(){
        $result_data = $this->model->get_dataTable();

        $json = [
            'recordsTotal'      => $result_data['total_data'],
            'data'              => array()
        ];
        
        $no = 1;
        foreach ($result_data['data'] as $key => $value) {
            $action = '<button type="button" class="btn btn-primary btn-small" style="margin-right: 5px;" onCLick="edit_produk('.$value['id_produk'].')" data-id='.$value['id_produk'].'"><i class="fa fa-edit"></i></button>';
            $action .= '<button type="button" class="btn btn-danger btn-small" style="margin-left: 5px;" onClick="delete_produk('.$value['id_produk'].')" data-id='.$value['id_produk'].'"><i class="fa fa-trash"></i></button>';
            $data = array(
                'no'            => $no,
                'nama_produk'   => $value['nama_produk'],
                'kategori'      => $value['kategori'],
                'harga'         => $value['harga'],
                'action'        => $action,
            );            
            $no++;
            $json['data'][] = $data;
        }
        echo json_encode($json);
    }

    public function delete_by_id(){
        $id = $_POST['id_produk'];    
        $query = $this->model->delete_by_id($id);

        $this->session->set_flashdata('status', $query['status']);
        $this->session->set_flashdata('msg',$query['msg'] );

        echo json_encode($query);
    }

    public function update_by_id(){
        $this->validation();
        $data_update['data'] = array(
            'nama_produk'   => $_POST['nama_produk_edit'],
            'kategori_id'   => $_POST['kategori_edit'],
            'harga'         => $_POST['harga_edit'],
            'status_id'     => $_POST['status']
        );
        $data_update['id_produk'] = $_POST['id_produk'];

        $query = $this->model->update_by_id($data_update);
        
        $this->session->set_flashdata('status', $query['status']);
        $this->session->set_flashdata('msg', $query['msg'] );

        echo json_encode($query);
    }

    public function get_by_id(){
        $id = $_POST['id_produk'];
        $query = $this->model->get_by_id($id);
        
        if ($query['status'] != 200) {
            $this->session->set_flashdata('status', $query['status']);
            $this->session->set_flashdata('msg',$query['msg'] );
        }

        $query['kategori'] = $this->model->get_kategori();
        $query['status_produk'] = $this->model->get_status();
        
        echo json_encode($query);
    }

    public function validation(){
        $json = array();
        $json['inputerror'] = array();
        $json['msg']        = array();
        $json['status']     = true;

        if ($_POST['nama_produk_edit'] == '') {
            $json['inputerror'] = 'nama_produk_edit';
            $json['msg']        = 'Nama produk tidak boleh kosong';
            $json['status']     = false;
        }

        if (!is_numeric($_POST['harga_edit']) || $_POST['harga_edit'] == '') {
            $json['inputerror'] = 'harga_edit';
            $json['msg']        = 'Harga harus numeric dan tidak boleh kosong';
            $json['status']     = false;
        }

        if ($json['status'] == false) {
            echo json_encode($json);
        }
    }
}