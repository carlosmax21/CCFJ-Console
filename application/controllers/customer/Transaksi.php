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
    elseif($this->session->userdata('role_id') != '2'){
      $this->session->set_flashdata('rolemsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Mohon Logout dari akun admin terlebih dahulu!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('admin/dashboard');
    }
  }

  public function index(){
    $data['transaksi'] = $this->db->query("SELECT * FROM transaksi WHERE id_user =" . $this->session->userdata('id_user').  " ORDER BY id_transaksi DESC")->result();
    $this->load->view('templates_customer/header');
    $this->load->view('customer/transaksi', $data);
    $this->load->view('templates_customer/footer');
  }

  public function konfirmasi_rental(){
    $this->load->view('templates_customer/header');
    $this->load->view('customer/konfirmasi_rental');
    $this->load->view('templates_customer/footer');
  }

  public function checkout_aksi(){
    $id_user      = $this->session->userdata('id_user');
    $query        = $this->db->query("SELECT id_konsol FROM keranjang WHERE id_user IN ( SELECT id_user FROM keranjang where id_user = ". $this->session->userdata('id_user') . ")")->result();
    $alamat       = $this->security->xss_clean($this->input->post('alamat'));
    $totalHarga   = $this->input->post('harga');
    $lamaHari     = $this->input->post('lamaHari');

    if($alamat == null){
      $this->session->set_flashdata('cartmsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Harap isi alamat tujuan
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('customer/keranjang');
    }
    else{
      $dataTransaksi = array(
        'id_user'       => $id_user,
        'totalHarga'    => $totalHarga,
        'alamat'        => $alamat,
        'lamaHari'      => $lamaHari,
        'keterangan'    => 'Sedang Dikirim'
      );
  
      $id_transaksi = $this->rental_model->insert_transaksi($dataTransaksi, 'transaksi');
  
      foreach($query as $qr)
      {
        $data = array(
          'id_transaksi'  => $id_transaksi,
          'id_user'       => $id_user,
          'id_konsol'     => $qr->id_konsol
        );  
  
        $this->rental_model->insert_data($data, 'detailTransaksi');
      }
  
      $where = array('id_user' => $id_user);
      $this->rental_model->delete_data($where, 'keranjang');
      $this->session->set_flashdata('konsoldatamsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Transaksi berhasil, silahkan checkout!
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('customer/data_konsol');
    }
  }

  public function view_detail($id){
    $data['detail'] = $this->db->query("SELECT * FROM detailTransaksi dt, konsol ks WHERE dt.id_transaksi = '$id' && ks.id_konsol = dt.id_konsol")->result();
    $this->load->view('templates_customer/header');
    $this->load->view('customer/detail_transaksi', $data);
    $this->load->view('templates_customer/footer');
  }

  public function confirm_rental($id){
    $data = array(
      'keterangan'  => 'Siap di Pick-up'
    ); 

    $where = array('id_transaksi' => $id);
    $this->rental_model->update_data('transaksi', $data, $where);
    $this->session->set_flashdata('transactionmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Transaksi berhasil, silahkan checkout!
      <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
      </button></div>');
      redirect('customer/transaksi');
  }

  public function delete($id){
    $where = array('id_transaksi' => $id);

    $this->rental_model->delete_data($where, 'detailtransaksi');
    $this->rental_model->delete_data($where, 'transaksi');

    $this->session->set_flashdata('transactionmsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Transaksi berhasil dibatalkan
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true">&times;</span>
    </button></div>');
    redirect('customer/transaksi');
  }

  public function batal_transaksi($id){
    $where = array('id_transaksi' => $id);

    $data = $this->rental_model->get_where($where, 'transaksi')->row();
    
    $where2 = array('id_konsol' => $data->id_konsol);
    $data2 = array('status' => '1');

    $this->rental_model->update_data('konsol', $data2, $where2);
    $this->rental_model->delete_data($where, 'transaksi');
    $this->session->set_flashdata('transactionmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Transaksi berhasil dibatalkan
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true">&times;</span>
    </button></div>');
    redirect('customer/transaksi');
  }


}