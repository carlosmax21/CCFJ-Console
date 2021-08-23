<?php

class Data_customer extends CI_Controller{

  public function __construct(){
    parent::__construct();
    
    if(empty($this->session->userdata('email'))){
      $this->session->set_flashdata('loginmsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Anda belum login!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('auth/login');
    }
    elseif($this->session->userdata('role_id') != '1'){
      $this->session->set_flashdata('autherror', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Anda tidak punya akses ke halaman ini!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('customer/dashboard');
    }
  }

  public function index(){
    $data['user'] = $this->db->query("SELECT * FROM user WHERE role_id = 2")->result();
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/data_customer', $data);
    $this->load->view('templates_admin/footer');
  }

  public function tambah_customer(){
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/form_tambah_customer');
    $this->load->view('templates_admin/footer');
  }

  public function tambah_customer_aksi(){
    $db = $this->db->get('user');
    $datadb = $db->result_array();
    $newAcc = true;
    $this->_rules();
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

    if($this->form_validation->run() == FALSE){
      $this->tambah_customer();
    }
    else{
      $nama       = $this->security->xss_clean($this->input->post('nama'));
      $email      = $this->security->xss_clean($this->input->post('email'));
      $alamat     = $this->security->xss_clean($this->input->post('alamat'));
      $no_telepon = $this->security->xss_clean($this->input->post('no_telepon'));
      $password   = $this->security->xss_clean(md5($this->input->post('password')));

      $data = array(
        'nama'       => $nama,
        'email'      => $email,
        'alamat'     => $alamat,
        'no_telepon' => $no_telepon,   
        'password'   => $password,
        'role_id'    => 2,
      );
      foreach($datadb as $i){
        if($i['email'] == $email){
          $newAcc = false;
          break;
        }
      }

      if($newAcc) {
        $this->rental_model->insert_data($data, 'user');
        $this->session->set_flashdata('custmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data Customer berhasil ditambahkan
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('admin/data_customer');
      } else {
        $this->session->set_flashdata('custmsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Email Telah Digunakan!
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('admin/data_customer');
      }
    }
  }

  public function update_customer($id){
    $data['user'] = $this->db->query("SELECT * FROM user WHERE id_user = '$id'")->result();
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/form_update_customer', $data);
    $this->load->view('templates_admin/footer');
  }

  public function update_customer_aksi(){
    $db = $this->db->get('user');
    $datadb = $db->result_array();
    $newAcc = true;
    $this->_rules();

    if($this->form_validation->run() == FALSE){
      $id = $this->security->xss_clean($this->input->post('id_user'));
      $this->update_customer($id);
    }
    else{
      $id         = $this->security->xss_clean($this->input->post('id_user'));
      $nama       = $this->security->xss_clean($this->input->post('nama'));
      $email      = $this->security->xss_clean($this->input->post('email'));
      $alamat     = $this->security->xss_clean($this->input->post('alamat'));
      $no_telepon = $this->security->xss_clean($this->input->post('no_telepon'));

      $data = array(
        'nama'       => $nama,
        'email'      => $email,
        'alamat'     => $alamat,
        'no_telepon' => $no_telepon,
      );
      foreach($datadb as $i){
        if($i['email'] == $email){
          $newAcc = false;
          break;
        }
      }

      if($newAcc) {
        $where = array('id_user' => $id);
        $this->rental_model->update_data('user', $data, $where);
        $this->session->set_flashdata('custmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data Customer berhasil diupdate
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('admin/data_customer');
      } else {
        $this->session->set_flashdata('custmsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Email Telah Digunakan!
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('admin/data_customer');
      }
    }
  }

  public function delete_customer($id){
    $where = array('id_user' => $id);
    $this->rental_model->delete_data($where, 'user');
    $this->session->set_flashdata('custmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data Customer berhasil dihapus
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true">&times;</span>
    </button></div>');
    redirect('admin/data_customer');
  }


  public function _rules(){
    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('email', 'email', 'required|valid_email');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');
    $this->form_validation->set_rules('no_telepon', 'No. telepon', 'required|numeric');
  }
}