<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Form Update Customer</h1>
    </div>

    <?php foreach($transaksi as $tr): ?>
    <form action="<?= base_url('admin/transaksi/update_transaksi_aksi') ?>" method="post">
      <div class="form-group"> 
        <label for="">ID Transaksi</label>
        <input type="text" name="id_transaksi" class="form-control" value="<?= $tr->id_transaksi; ?>" readonly>
      </div>

      <div class="form-group"> 
        <label for="">Alamat Tujuan</label>
        <input type="text" name="alamat" class="form-control" value="<?= $tr->alamat; ?>">
      </div>

      <div class="form-group"> 
        <label for="">Lama Rental</label>
        <input type="hidden" name="totalHarga" class="form-control" value="<?= $tr->totalHarga; ?>">
        <input type="hidden" name="lamaHariOld" class="form-control" value="<?= $tr->lamaHari; ?>">
        <input type="number" name="lamaHariNew" class="form-control" value="<?= $tr->lamaHari; ?>">
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <button type="reset" class="btn btn-warning">Reset</button>

    </form>
    <?php endforeach; ?>

  </section>
</div>