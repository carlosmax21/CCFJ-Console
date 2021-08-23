<?php

class Keranjang extends CI_Controller{

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
    $data['keranjang'] = $this->db->query("SELECT * FROM keranjang kr, konsol ks WHERE kr.id_konsol=ks.id_konsol && kr.id_user =" . $this->session->userdata('id_user').  " ORDER BY id_keranjang DESC")->result();
    $this->load->view('templates_customer/header');
    $this->load->view('customer/keranjang', $data);
    $this->load->view('templates_customer/footer');
  }

  public function tambah_keranjang($id){
    $data['detail'] = $this->rental_model->ambil_id_konsol($id);
    $this->load->view('templates_customer/header');
    $this->load->view('customer/konfirmasi_keranjang', $data);
    $this->load->view('templates_customer/footer'); 
  }

  public function tambah_keranjang_aksi(){
    $query = $this->db->query("SELECT * FROM keranjang WHERE id_user = " . $this->session->userdata('id_user'))->result();
    $id_user      = $this->session->userdata('id_user');
    $id_konsol    = $this->input->post('id_konsol');
    $newData      = true;
    $data = array(
      'id_user'       => $id_user,
      'id_konsol'     => $id_konsol,
    );

    foreach($query as $i){
      if($i->id_konsol == $id_konsol){
        $newData = false;
      }
    }

    if($newData){
      $this->rental_model->insert_data($data, 'keranjang');
    
    
    $this->session->set_flashdata('konsoldatamsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Keranjang berhasil ditambah, silahkan checkout!
      <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
      </button></div>');
      redirect('customer/data_konsol');
    }
    else{
      $this->session->set_flashdata('konsoldatamsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Setiap pelanggan tidak dapat memesan lebih dari satu konsol yang sama
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>');
    redirect('customer/data_konsol');
    }
  }

  public function checkout_keranjang(){
    $this->_rules();
    if($this->input->post('harga') == 0){
      $this->session->set_flashdata('konsoldatamsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Kayanya keranjang kamu masih kosong, masukin barang dulu yuk
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>');
      redirect('customer/data_konsol');
    }
    else{
      $harga        = $this->input->post('harga');
      $lamaHari     = $this->input->post('lama');
      $total        = $harga * (int)$lamaHari;
      $query = $this->db->query("SELECT alamat FROM user WHERE id_user =" . $this->session->userdata('id_user'))->row();
      $alamat = $query->alamat;

      if($lamaHari <= 0 || $lamaHari == null){
        $this->session->set_flashdata('cartmsg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Masukan Lama hari peminjaman konsol
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('customer/keranjang');
      }
      else
      {
        $data = array(
          'total' => $total,
          'alamat' => $alamat,
          'lamaHari' => $lamaHari
        );
    
        $this->load->view('templates_customer/header');
        $this->load->view('customer/konfirmasi_rental', $data);
        $this->load->view('templates_customer/footer');
      }
    }
  }
  
  public function delete_keranjang($id){
    $where = array('id_keranjang' => $id);
    $this->rental_model->delete_data($where, 'keranjang');
    $this->session->set_flashdata('cartmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Data berhasil dihapus
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true">&times;</span>
    </button></div>');
    redirect('customer/keranjang');

  }

  public function batal_keranjang($id){
    $where = array('id_keranjang' => $id);

    $data = $this->rental_model->get_where($where, 'keranjang')->row();
    
    $where2 = array('id_konsol' => $data->id_konsol);
    $data2 = array('status' => '1');

    $this->rental_model->update_data('konsol', $data2, $where2);
    $this->rental_model->delete_data($where, 'keranjang');
    $this->session->set_flashdata('cartmsg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    keranjang berhasil dibatalkan
    <button type="button" class="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true">&times;</span>
    </button></div>');
    redirect('customer/keranjang');
  }

  public function _rules(){
		$this->form_validation->set_rules('lama', 'Lama Hari', 'required|greater_than[0]|numeric|is_natural_no_zero');
  }
}