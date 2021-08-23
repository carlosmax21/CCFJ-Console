<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Form Update Data Konsol</h1>
    </div>

    <div class="card">
      <div class="card-body">

        <?php foreach($konsol as $ks): ?>

        <form action="<?= base_url('admin/data_konsol/update_konsol_aksi') ?>" enctype="multipart/form-data" method="post">
          <div class="row">

              <div class="form-group">
                <label for="">Nama</label>
                <input type="hidden" name="id_konsol" value="<?= $ks->id_konsol; ?>">
                <input type="text" name="nama" class="form-control" value="<?= $ks->nama ?>">
                <?= form_error('nama', '<div class="text-small text-danger">', '</div>') ?>
              </div>

              <div class="form-group">
                <label for="">Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= $ks->harga ?>">
                <?= form_error('harga', '<div class="text-small text-danger">', '</div>') ?>
              </div>

              <div class="form-group">
                <label for="">Stock</label>
                <input type="number" name="stock" class="form-control" value="<?= $ks->stock ?>">
                <?= form_error('stock', '<div class="text-small text-danger">', '</div>') ?>
              </div>
              
              <div class="form-group">
                <label for="">Deskripsi</label>
                <input type="text" name="desc" class="form-control" value="<?= $ks->descKonsol ?>">
                <?= form_error('desc', '<div class="text-small text-danger">', '</div>') ?>
              </div>
              
              <div class="form-group">
                <label for="">Gambar</label>
                <input type="file" name="gambar" class="form-control">
              </div>

              <div class="form-group">
                <label for="">Action</label>
                <div style="padding: 2px;">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <button type="reset" class="btn btn-success">Reset</button>
                </div>
              </div>
          </div>
        </form>

        <?php endforeach; ?>
      </div>
    </div>

  </section>
</div>