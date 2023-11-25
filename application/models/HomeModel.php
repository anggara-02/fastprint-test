<?php

class HomeModel extends CI_Model{

    /* funsgi di jalankan ketika pertama kali hit API untuk save data kedalam database */
    public function store_data($json_data){
        $tempKategori = [];
        $tempStatus = [];

        /* Get data dari table produk */
        $query_produk   = $this->db->get('produk');
        
        /* Jalankan untuk cek db kategori dan status */
        $this->check_db($json_data);
        
        /* Select/GET data dari table status dan kategori */
        $get_status = $this->db->get('status')->result();
        $get_kategori = $this->db->get('kategori')->result();

        /* Cek jika table produk kosong maka insert data */ 
        if ($query_produk->num_rows() <= 0 ) {
            /*  Bentuk array untuk mencari id kategori dan id status untuk data produk 
                ==> Looping untuk merubah value 'kategori' menjadi 'id_kategori' yang didapat dari table kategori. 
                    Jika kategori pada produk sama dengan nama kategori pada table kategori, maka 'kategori' => id_kategori.
                ==> Untuk mencari id_statu sama dnegan mencari id_kategori hanya saja yang digunakan untuk looping adalah
                    array dari kategori yang sudah di looping sebelumnya. 
            */
            foreach($json_data['produk'] as $key => $row) {
                foreach ($get_kategori as $value_kategori) {

                    /* Jika kategori sama dengan nama kategori pada table kategori*/
                    if ($row['kategori'] == $value_kategori->nama_kategori) {
                        $tempKategori[] = [
                            'id_produk'     => $row['id_produk'],
                            'nama_produk'   => $row['nama_produk'],
                            'kategori'      => $value_kategori->id_kategori,
                            'harga'         => $row['harga'],
                            'status'        => $row['status']
                        ];
                    }
                }
                foreach ($get_status as $value_status) {
                    /* Jika status pada array kategori sama dengan nama status pada table status */
                    if ($tempKategori[$key]['status'] == $value_status->status) {
                        $tempStatus[] = [
                            'id_produk'     => $tempKategori[$key]['id_produk'],
                            'nama_produk'   => $tempKategori[$key]['nama_produk'],
                            'kategori'      => $tempKategori[$key]['kategori'],
                            'harga'         => $tempKategori[$key]['harga'],
                            'status'        => $value_status->id_status,
                        ];
                    }
                }
            }

            /* insert ke database tiap data menggunakan looping */
            foreach ($tempStatus as $key => $value) {
                $produk = array(
                    'nama_produk'   => $value['nama_produk'],
                    'harga'         => $value['harga'],
                    'kategori_id'   => $value['kategori'],
                    'status_id'     => $value['status'],
                );
                $this->db->insert('produk', $produk);
                $this->db->insert_id();
            }
        }

        // return [
        //     'msg'       => 'Data Syncron Berhasil',
        //     'status'    => 200
        // ];
    } 

    public function get_datatable(){
        $this->db->from('produk');
        $this->db->where(array('status_id' => '1'));
        $this->db->order_by('id_produk', 'DESC');
        $query = $this->db->get();

        $data = [];
        foreach ($query->result() as $key => $value) {
            $data[] = [
                'id_produk'     => $value->id_produk,
                'nama_produk'   => $value->nama_produk,
                'kategori'      => $this->kategori_name($value->kategori_id),
                'harga'         => $value->harga,
            ];
        }

        $json['data'] = $data;
        $json['total_data'] = $query->num_rows();
        
        return $json;
    }

    //Mencari nama kategori berdasarkan id_kategori
    public function kategori_name($id){
        $query = $this->db->get_where('kategori', array('id_kategori' => $id));
        
        $kategori_name = '';
        foreach ($query->result() as $key => $value) {
            $kategori_name = $value->nama_kategori;
        }
        return $kategori_name;
    }

    /*======================== CEK & INSERT JIKA TABLE KATEGORI DAN STATUS KOSONG ===========================*/
    public function check_db($json_data){
        $query_kategori = $this->db->get('kategori');
        $query_status   = $this->db->get('status');
        
        //Insert kategori
        if ($query_kategori->num_rows() == 0) {
            foreach ($json_data['kategori'] as $key => $value) {
                $kategori = array('nama_kategori' => $key);
                $this->db->insert('kategori', $kategori);
                $this->db->insert_id();
            }
        }
        
        // //Insert kategori
        if ($query_status->num_rows() == 0) {
            foreach ($json_data['status'] as $key => $value) {
                $status = array('status' => $key);
                $this->db->insert('status', $status);
                $this->db->insert_id();
            }
        }
    }

    public function get_kategori(){
        $query = $this->db->get('kategori');

        if ($query->num_rows() > 0) {
            $json['status'] = 200;
            $json['msg'] = 'DATA DI TEMUKAN';
            $json['data'] = $query->result();
        } else {
            $json['status'] = 200;
            $json['msg'] = 'DATA DI TEMUKAN';
        }        

        return $json;
    }
    
    public function get_status(){
        $query = $this->db->get('status');

        if ($query->num_rows() > 0) {
            $json['status'] = 200;
            $json['msg'] = 'DATA DI TEMUKAN';
            $json['data'] = $query->result();
        } else {
            $json['status'] = 200;
            $json['msg'] = 'DATA DI TEMUKAN';
        }        

        return $json;
    }

    public function delete_by_id($id){
        $this->db->where('id_produk', $id);
        $query = $this->db->delete('produk');

        return [
            'msg' => 'DATA BERHASIL DI HAPUS', 
            'status' => 200
        ];
    }

    public function get_by_id($id){
        $this->db->where('id_produk', $id);
        $query = $this->db->get('produk');
        $json = [];
        if ($query->num_rows() > 0) {
            $json['status'] = 200;
            $json['msg'] = 'DATA DI TEMUKAN';
            $json['data'] = $query->result();
        }else{
            $json['status'] = 404;
            $json['msg'] = 'DATA TIDAK DI TEMUKAN';
        }

        return $json;
    }
}