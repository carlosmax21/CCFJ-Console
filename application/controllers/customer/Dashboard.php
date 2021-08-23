<?php

class Dashboard extends CI_Controller{

  public function __construct(){
    parent::__construct();

    if($this->session->userdata('role_id') != null){
      if($this->session->userdata('role_id') != '2'){
        $this->session->set_flashdata('rolemsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Mohon Logout dari akun admin terlebih dahulu!</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>');
        redirect('admin/dashboard');
      }
    }
  }

  public function index(){
    $data['konsol'] = $this->rental_model->get_data('konsol')->result();
    $this->load->view('templates_customer/header');
    $this->load->view('customer/dashboard', $data);
    $this->load->view('templates_customer/footer');
  }


}