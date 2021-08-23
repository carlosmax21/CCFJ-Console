<div class="container">
  <div style="height: 150px;"></div>
  <div class="card">
    <card class="card-header">
      Form Rental konsol
    </card> 
    <div class="card-body">
   
      <form action="<?= base_url('customer/transaksi/checkout_aksi') ?>" method="post">
      <span class="mt-2 p-2"><?= $this->session->flashdata('pesan'); ?></span>
        <div class="form-group">
          <label for="">Total Biaya</label>
          <input type="hidden" name="lamaHari" value="<?= $lamaHari ?>"> 
          <input type="text" name="harga" class="form-control" value="<?= $total?>" readonly>
        </div>
        <div class="form-group">
          <label for="">Alamat Pengiriman</label>
          <input type="text" name="alamat" class="form-control" value="<?= $alamat?>">
        </div>
        <button type="submit" class="btn btn-primary">Rental</button>
      </form>
    
    </div>
  </div>
</div>

<div style="height: 180px;"></div>