<div class="container">
  <div style="height: 150px;"></div>
  <div class="card">
    <card class="card-header">
      Konfimasi tambah keranjang konsol
    </card> 
    <div class="card-body">
      <?php foreach($detail as $dt): ?>
      <form action="<?= base_url('customer/keranjang/tambah_keranjang_aksi') ?>" method="post">
        <div class="form-group">
          <div class="form-group">
            <label for="">Nama konsol</label>
            <input type="text" name="nama" class="form-control" value="<?= $dt->nama; ?> " readonly>
          </div>
          <label for="">Harga per hari</label>
          <input type="hidden" name="id_konsol" value="<?= $dt->id_konsol; ?>">
          <input type="text" name="harga" class="form-control" value="<?= $dt->harga?>" readonly>
        </div>
        <div>
        <button type="submit" class="btn btn-primary">Tambah Keranjang</button>
        <a class="btn btn-danger" href="<?= base_url('customer/data_konsol/'); ?>">Back</a>
      </form>
      <div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<div style="height: 180px;"></div>