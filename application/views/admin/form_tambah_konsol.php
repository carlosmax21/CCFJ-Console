<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Form Input Data Konsol</h1>
    </div>

    <div class="card">
      <div class="card-body">

        <form action="<?= base_url('admin/data_konsol/tambah_konsol_aksi') ?>" enctype="multipart/form-data" method="post">
          <div class="row">
            <div class="col-md-12">

              <div class="form-group">
                <label for="">Nama</label>
                <input type="text" name="nama" class="form-control">
                <?= form_error('nama', '<div class="text-small text-danger">', '</div>') ?>
              </div>

              <div class="form-group">
                <label for="">Harga Sewa perhari</label>
                <input type="number" name="harga" class="form-control">
                <?= form_error('harga', '<div class="text-small text-danger">', '</div>') ?>
              </div>

              <div class="form-group">
                <label for="">Stock</label>
                <input type="number" name="stock" class="form-control">
                <?= form_error('stock', '<div class="text-small text-danger">', '</div>') ?>
              </div>
              
              <div class="form-group">
                <label for="">Deskripsi</label>
                <input type="text" name="desc" class="form-control">
                <?= form_error('desc', '<div class="text-small text-danger">', '</div>') ?>
              </div>
              
              <div class="form-group">
                <label for="">Gambar</label>
                <input type="file" name="gambar" class="form-control">
              </div>

              <button type="submit" class="btn btn-primary mt-4">Simpan</button>
              <button type="reset" class="btn btn-success mt-4">Reset</button>
            </div>
          </div>
        </form>
      </div>
    </div>


  </section>
</div>