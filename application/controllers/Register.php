<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

  public function index(){
		$this->_rules();
    $db = $this->db->get('user');
    $dataArray = $db->result_array();
    $newAcc = true;
    
		if($this->form_validation->run() == FALSE){
			$this->load->view('templates_admin/header');
			$this->load->view('register_form');
			$this->load->view('templates_admin/footer');
		}
		else{
			$nama       = $this->input->post('nama');
      $email   = $this->input->post('email');
      $alamat     = $this->input->post('alamat');
      $no_telepon = $this->input->post('no_telepon');
      $password   = md5($this->input->post('password'));
      $role_id    = '2';

      $data = array(
        'nama'       => $nama,
        'email'   => $email,
        'alamat'     => $alamat,
        'no_telepon' => $no_telepon,    
        'password'   => $password,
        'role_id'    => $role_id,
			);
      foreach($dataArray as $i){
        if($i['email'] == $email){
          $newAcc = false;
          break;
        }
      }
			
			if($newAcc){
        $this->rental_model->insert_data($data, 'user');
        $this->session->set_flashdata('loginmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Berhasil register, Silahkan login!
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('auth/login');
      }
      else{
        $this->session->set_flashdata('regismsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Email Telah Digunakan!
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        $this->load->view('templates_admin/header');
        $this->load->view('register_form');
        $this->load->view('templates_admin/footer');
      }
		}
	}


	public function _rules(){
		$this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');
    $this->form_validation->set_rules('no_telepon', 'No. telepon', 'required|numeric');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
	}
}