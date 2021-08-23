<?php

class Transaksi extends CI_Controller{

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
    $data['transaksi'] = $this->db->query("SELECT * FROM transaksi ts, user us WHERE ts.id_user = us.id_user ORDER BY id_transaksi DESC")->result();
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/data_transaksi', $data);
    $this->load->view('templates_admin/footer');
  }

  public function update_transaksi($id){
    $data['transaksi'] = $this->db->query("SELECT * FROM transaksi WHERE id_transaksi = '$id'")->result();
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/form_update_transaksi', $data);
    $this->load->view('templates_admin/footer');
  }

  public function update_transaksi_aksi(){    
      $id         = $this->security->xss_clean($this->input->post('id_transaksi'));
      $lamaHari   = $this->security->xss_clean($this->input->post('lamaHariNew'));
      $alamat     = $this->security->xss_clean($this->input->post('alamat'));
      $totalHarga = $this->security->xss_clean($this->input->post('totalHarga'));
      $newTotal   = ($totalHarga / $this->input->post('lamaHariOld') * $lamaHari);

      $data = array(
        'id_transaksi'=> $id,
        'lamaHari'  => $lamaHari,
        'alamat' => $alamat,
        'totalHarga' => $newTotal
      );

    $where = array('id_transaksi' => $id);
    $this->rental_model->update_data('transaksi', $data, $where);
    $this->session->set_flashdata('transmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data Transaksi berhasil diupdate
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true">&times;</span>
    </button></div>');
    redirect('admin/transaksi');

  }

  public function detail_transaksi($id){
    $data['detail'] = $this->db->query("SELECT * FROM detailTransaksi dt, konsol ks WHERE dt.id_transaksi = '$id' && ks.id_konsol = dt.id_konsol")->result();
    $this->load->view('templates_admin/header');
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/detail_transaksi', $data);
    $this->load->view('templates_admin/footer');
  }

  public function konfirmasi_transaksi($id){
    $dataTransaksi = array(
      'keterangan'  => 'Sudah Dikirim'
    );
    $query = $this->db->query("SELECT ks.stock, ks.id_konsol FROM transaksi ts, detailTransaksi dt, konsol ks WHERE dt.id_transaksi = '$id' && ks.id_konsol = dt.id_konsol && ts.id_transaksi = dt.id_transaksi")->result();

    foreach($query as $qr)
    {
      $id_konsol = $qr->id_konsol;
      $newStock  = $qr->stock - 1;
      $data = array(
        'stock' => $newStock
      );  
      $where = array('id_konsol' => $id_konsol);
      $this->rental_model->update_data('konsol', $data, $where);
    }


    $where = array('id_transaksi' => $id);
    $this->rental_model->update_data('transaksi', $dataTransaksi, $where);
    $this->session->set_flashdata('transmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Transaksi berhasil, silahkan checkout!
      <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
      </button></div>');
      redirect('admin/transaksi');
  }


  public function delete_transaksi($id){
    $where = array('id_transaksi' => $id);
    $data = $this->rental_model->get_where($where, 'transaksi')->row();

    $this->rental_model->delete_data($where, 'transaksi');
    $this->session->set_flashdata('transmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Transaksi berhasil dibatalkan
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true">&times;</span>
    </button></div>');
    redirect('admin/transaksi');
  }


  public function transaksi_selesai($id){
    $dataTransaksi = array(
      'keterangan'  => 'Selesai'
    );
    $query = $this->db->query("SELECT ks.stock, ks.id_konsol FROM transaksi ts, detailTransaksi dt, konsol ks WHERE dt.id_transaksi = '$id' && ks.id_konsol = dt.id_konsol && ts.id_transaksi = dt.id_transaksi")->result();
    foreach($query as $qr)
    {
      $id_konsol = $qr->id_konsol;
      $newStock  = $qr->stock + 1;
      $data = array(
        'stock' => $newStock
      );  
      $where = array('id_konsol' => $id_konsol);
      $this->rental_model->update_data('konsol', $data, $where);
    }
    $where = array('id_transaksi' => $id);
    $this->rental_model->update_data('transaksi', $dataTransaksi, $where);
    $this->session->set_flashdata('transmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Transaksi berhasil, silahkan checkout!
      <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
      </button></div>');
      redirect('admin/transaksi');
  }
}