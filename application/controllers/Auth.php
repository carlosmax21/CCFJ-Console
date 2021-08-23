<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller{

  public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

  public function login(){
    $this->_rules();
    $captcha_response = trim($this->input->post('g-recaptcha-response'));

    if($this->form_validation->run() == FALSE){
      $this->load->view('templates_admin/header');
      $this->load->view('form_login');
      $this->load->view('templates_admin/footer');
    }
    else{
      $email = $this->security->xss_clean($this->input->post('email'));
      $password = md5($this->input->post('password'));
      $keySecret = '6LepxdIaAAAAABCjWWXBY4n0h-37lPJCDFSkGINe';

      $cek = $this->rental_model->cek_login($email, $password);
      $check = array(
				'secret'		=>	$keySecret,
				'response'		=>	$this->input->post('g-recaptcha-response')
			);

			$startProcess = curl_init();

			curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

			curl_setopt($startProcess, CURLOPT_POST, true);

			curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));

			curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);

			curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

			$receiveData = curl_exec($startProcess);

			$finalResponse = json_decode($receiveData, true);

      if($cek == FALSE){
        $this->session->set_flashdata('loginmsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Email atau Password salah
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        $this->load->view('templates_admin/header');
        $this->load->view('form_login');
        $this->load->view('templates_admin/footer');
      }
      else if(!$finalResponse['success']){
        $this->session->set_flashdata('loginmsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Captcha Tidak Benar!
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        $this->load->view('templates_admin/header');
        $this->load->view('form_login');
        $this->load->view('templates_admin/footer');
      }
      else if($captcha_response == ''){
        $this->session->set_flashdata('loginmsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Mohon isi capthca
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        $this->load->view('templates_admin/header');
        $this->load->view('form_login');
        $this->load->view('templates_admin/footer');
      }
      else{
        $this->session->set_userdata('id_user', $cek->id_user);
        $this->session->set_userdata('email', $cek->email);
        $this->session->set_userdata('role_id', $cek->role_id);
        $this->session->set_userdata('nama', $cek->nama);

        switch($cek->role_id){
          case 1: redirect('admin/dashboard');
          break;
          case 2: redirect('customer/dashboard');
          break;
          default:
          break;
        }
      }
    }
  }

  public function logout(){
    $this->session->sess_destroy();
    $this->session->set_flashdata('loginmsg', '');
    redirect('customer/dashboard');
  }

  public function ganti_password(){
    $this->load->view('templates_admin/header');
    $this->load->view('ganti_password');
    $this->load->view('templates_admin/footer');
  }

  public function ganti_password_aksi(){
    $pass_baru = $this->input->post('pass_baru');
    $ulang_pass = $this->input->post('ulang_pass');

    $this->form_validation->set_rules('pass_baru', 'Password Baru', 'required|matches[ulang_pass]');
    $this->form_validation->set_rules('ulang_pass', 'Password Baru', 'required');

    if($this->form_validation->run() == FALSE){
      $this->load->view('templates_admin/header');
      $this->load->view('ganti_password');
      $this->load->view('templates_admin/footer');
    }
    else{
      if($pass_baru == $ulang_pass){
      $data = array('password' => md5($pass_baru));
      $id = array('id_user' => $this->session->userdata('id_user'));

      $this->rental_model->update_password($id, $data, 'user');
      $this->session->set_flashdata('loginmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Password berhasil diupdate, silahkan login.
      <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
      </button></div>');
      redirect('auth/login');
      }
      else{

      }
    }
  }

  public function validate_captcha() {
    if($this->input->post('captcha'))
    {
        $this->form_validation->set_message('validate_captcha', 'Wrong captcha code, hmm are you the Terminator?');
        return false;
    }else{
        return true;
    }
  }

  public function _rules(){
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');
  }
}