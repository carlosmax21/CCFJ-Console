<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Form Update Customer</h1>
    </div>

    <?php foreach($user as $cs): ?>
    <form action="<?= base_url('admin/data_customer/update_customer_aksi') ?>" method="post">
      <div class="form-group"> 
        <label for="">Nama</label>
        <input type="hidden" name="id_user" value="<?= $cs->id_user; ?>">
        <input type="text" name="nama" class="form-control" value="<?= $cs->nama; ?>">
        <?= form_error('nama', '<div class="text-small text-danger">', '</div>') ?>
      </div>
      <div class="form-group"> 
        <label for="">email</label>
        <input type="text" name="email" class="form-control" value="<?= $cs->email; ?>">
        <?= form_error('email', '<div class="text-small text-danger">', '</div>') ?>
      </div>
      <div class="form-group"> 
        <label for="">Alamat</label>
        <input type="text" name="alamat" class="form-control" value="<?= $cs->alamat; ?>">
        <?= form_error('alamat', '<div class="text-small text-danger">', '</div>') ?>
      </div>
      <div class="form-group"> 
        <label for="">No. Telepon</label>
        <input type="text" name="no_telepon" class="form-control" value="<?= $cs->no_telepon; ?>">
        <?= form_error('no_telepon', '<div class="text-small text-danger">', '</div>') ?>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <button type="reset" class="btn btn-warning">Reset</button>

    </form>
    <?php endforeach; ?>

  </section>
</div>