<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';

class Authentication extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('user');
    }

    public function login_post() {
            // Get the post data
            $id = $this->post('id');
            $username = $this->post('username');
            $password = $this->post('password');
            
            // Validate the post data
            if(!empty($username) && !empty($password)){
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'id' => $id,
                    'username' => $username,
                    'password' => md5($password),
                    'status' => 1
                );
                $user = $this->user->getRows($con);
                
                if($user){
                    $this->response([
                        'status' => TRUE,
                        'message' => 'User login sukses.',
                        'data' => $user
                    ], REST_Controller::HTTP_OK);
                }else{
                   
                    $this->response("Salah username atau password.", REST_Controller::HTTP_BAD_REQUEST);
                }
            }else{
               
                $this->response("Tidak ditemukan username and password.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    
        public function registration_post() {
            $id = $this->post('id');
            $username = strip_tags($this->post('username'));
            $password = $this->post('password');
            
          
            if(!empty($username) && !empty($password)){
                $con['returnType'] = 'count';
                $con['conditions'] = array(
                    'username' => $username,
                );
                $userCount = $this->user->getRows($con);
                
                if($userCount > 0){
                    $this->response("Username telah terdaftar.", REST_Controller::HTTP_BAD_REQUEST);
                }else{
                    $userData = array(
                        'id' => $id,
                        'username' => $username,
                        'password' => md5($password)
                    );
                    $insert = $this->user->insert($userData);                 
                    if($insert){
                            $this->response([
                            'status' => TRUE,
                            'message' => 'User berhasil ditambahkan.',
                            'data' => $insert
                        ], REST_Controller::HTTP_OK);
                    }else{
                        $this->response("Ada sedikit masalah, Silahkan coba kembali.", REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }else{
                $this->response("Provide complete user info to add.", REST_Controller::HTTP_BAD_REQUEST);
            }
    }
    }
?>