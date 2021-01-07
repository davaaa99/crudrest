<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pegawai extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pegawai_model','pegawai');
        $this->methods['index_get']['limit'] = 100;
    }

    public function pegawai_get(){
        $id = $this->get('id');
        if($id == null){
            $pegawai = $this->pegawai->getPegawai();
        }
        else{
            $pegawai = $this->pegawai->getPegawai($id);
        }
        
        
        if ($pegawai){
            $this->response([
                'status' => true,
                'data' => $pegawai,
            ], REST_Controller::HTTP_OK);
        }
        else{
            $this->response([
                'status' => false,
                'message' => 'Pegawai Not Found'
            ],REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function pegawai_delete(){
        $id = $this->delete('id');

        if ($id == null){
            $this->response([
                'status' => false,
                'message' => 'ID Uncreated'
            ],REST_Controller::HTTP_BAD_REQUEST);
        }
        elseif ($this->pegawai->pegawaidelete($id)>0){
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'Data deleted'
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Data Not Found'
                ],REST_Controller::HTTP_BAD_REQUEST);
            }
        
    }

    public function pegawai_post()
    {
        $data = [
            'id' => $this->post('id'),
            'nama' => $this->post('nama'),
            'alamat' => $this->post('alamat'),
            'telepon'=> $this->post('telepon')
        ];

        if ($this->pegawai->createPegawai($data)) {
            $this->response([
                'status' => true,
                'message' => 'Data has been created.'
            ], REST_Controller::HTTP_CREATED);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Failed to created data.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function pegawai_put()
    {
        $id = $this->put('id');
        $data = [
            'id' => $this->put('id'),
            'nama' => $this->put('nama'),
            'alamat' => $this->put('alamat'),
            'telepon'=> $this->put('telepon')
        ];
        if($this->pegawai->updatePegawai($data,$id)){
            $this->response([
                'status' => true,
                'message' => 'Data has been updated.'
            ], REST_Controller::HTTP_OK);
            
        }
        else{
            $this->response([
                'status' => false,
                'message' => 'Failed to updated data.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
}

?>