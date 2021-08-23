<?php

class Data_konsol extends CI_Controller{

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
    $data['konsol'] = $this->rental_model->get_data('konsol')->result();
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/data_konsol', $data);
    $this->load->view('templates_admin/footer');
  }

  public function tambah_konsol(){
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/form_tambah_konsol');
    $this->load->view('templates_admin/footer');
  }

  public function tambah_konsol_aksi(){
    $this->_rules();

    if($this->form_validation->run() == FALSE){
      $this->tambah_konsol();
    }
    else{
      $nama       = $this->security->xss_clean($this->input->post('nama'));
      $stock      = $this->security->xss_clean($this->input->post('stock'));
      $harga      = $this->security->xss_clean($this->input->post('harga'));
      $gambar     = $_FILES['gambar']['name'];
      $desc       = $this->security->xss_clean($this->input->post('desc'));

      if($gambar == ''){
        $gambar = 'default.png';
      }
      else{
        $config['upload_path'] = './assets/upload';
        $config['allowed_types'] = 'jpg|jpeg|png|tiff';

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('gambar')){
          echo "Gambar konsol gagal diupload";
        }
        else{
          $gambar = $this->upload->data('file_name');
        }
      }
      $data = array(
        'nama'    => $nama,
        'stock'  => $stock,
        'harga'   => $harga,
        'gambar'  => $gambar,
        'descKonsol'    => $desc
      );

      $this->rental_model->insert_data($data, 'konsol');
      $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Data berhasil ditambahkan
      <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
      </button></div>');
      redirect('admin/data_konsol');
    }
  }

  public function update_konsol($id){
    $data['konsol'] = $this->db->query("SELECT * FROM konsol WHERE id_konsol = '$id'")->result();
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/form_update_konsol', $data);
    $this->load->view('templates_admin/footer');
  }

  public function update_konsol_aksi(){
    $this->_rules();

    if($this->form_validation->run() == FALSE){
      $id = $this->input->post('id_konsol');
      $this->update_konsol($id);
    }
    else{
      $id         = $this->security->xss_clean($this->input->post('id_konsol'));
      $nama       = $this->security->xss_clean($this->input->post('nama'));
      $stock      = $this->security->xss_clean($this->input->post('stock'));
      $harga      = $this->security->xss_clean($this->input->post('harga'));
      $gambar     = $_FILES['gambar']['name'];
      $desc       = $this->security->xss_clean($this->input->post('desc'));

      if($gambar){
        $config['upload_path'] = './assets/upload';
        $config['allowed_types'] = 'jpg|jpeg|png|tiff';

        $this->load->library('upload', $config);
        
        if($this->upload->do_upload('gambar')){
          $gambar = $this->upload->data('file_name');
          $this->db->set('gambar', $gambar);
        }
        else{
          echo $this->upload->display_error();
        }
      }
      if($gambar == '') {
        $data = array(
          'nama'          => $nama,
          'stock'         => $stock,
          'harga'         => $harga,
          'descKonsol'    => $desc
        );
      } else {
        $data = array(
          'nama'          => $nama,
          'stock'         => $stock,
          'harga'         => $harga,
          'gambar'        => $gambar,
          'descKonsol'    => $desc
        );
      }
      $where = array('id_konsol' => $id);
      $this->rental_model->update_data('konsol', $data, $where);
      $this->session->set_flashdata('konsolmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Data berhasil diupdate
      <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
      </button></div>');
      redirect('admin/data_konsol');
    }
  }

  public function detail_konsol($id){
    $data['detail'] = $this->rental_model->ambil_id_konsol($id);
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/detail_konsol', $data);
    $this->load->view('templates_admin/footer');
  }

  public function delete_konsol($id){
    $where = array('id_konsol' => $id);

    $this->rental_model->delete_data($where, 'konsol');
    $this->session->set_flashdata('konsolmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data berhasil dihapus
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true">&times;</span>
    </button></div>');
    redirect('admin/data_konsol');

  }

  public function _rules(){
    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('harga', 'Harga', 'required|greater_than[0]');
    $this->form_validation->set_rules('stock', 'Stock', 'required|greater_than[-1]');
    $this->form_validation->set_rules('desc', 'Desc', 'required');
  }
}