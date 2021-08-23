<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Detail Konsol</h1>
    </div>
  </section>

  <?php foreach($detail as $dt): ?>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-5">
            <img width="110%;" src="<?= base_url('assets/upload/'). $dt->gambar; ?>" alt="">
          </div>
          <div class="col-md-7">
            <table class="table">
              <tr>
                <td>Nama</td>
                <td><?= $dt->nama; ?></td>
              </tr>
              <tr>
                <td>Harga Sewa</td>
                <td>Rp. <?= number_format($dt->harga, 0, ',', '.'); ?>,-</td>
              </tr>
              <tr>
                <td>Stock</td>
                <td><?= $dt->stock ?></td>
              </tr>
              <tr>
                <td>Status</td>
                <td>
                  <?php
                  if($dt->stock == 0){ ?>
                    <span class="badge badge-danger">Tidak Tersedia</span>                 
                  <?php }
                  else{ ?>
                    <span class="badge badge-primary">Tersedia</span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                <td>Deskripsi</td>
                <td><?= $dt->descKonsol ?></td>
              </tr>
            </table>

            <a href="<?= base_url('admin/data_konsol'); ?>" class="btn btn-sm btn-danger ml-4">Kembali</a>
            <a href="<?= base_url('admin/data_konsol/update_konsol/').$dt->id_konsol; ?>" class="btn btn-sm btn-primary">Update</a>
          </div>
        </div>
      </div>
    </div>

  <?php endforeach; ?>
</div>