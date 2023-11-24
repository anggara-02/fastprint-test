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
            $action = '<a href="#" class="btn btn-info btn-icon" data-id="'.$value['id_produk'].'"><i class="fa fa-edit"></i></a>';
            $action .= '<button class="btn btn-danger btn-icon" onClick="swal_alert('.$value['id_produk'].')" data-id='.$value['id_produk'].'"><i class="fa fa-trash"></i></button>';
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

        $this->session->set_flashdata('status', 200);
        $this->session->set_flashdata('success',$query['msg'] );

        echo json_encode($query);
    }
}