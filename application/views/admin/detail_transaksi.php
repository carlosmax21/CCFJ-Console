<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Detail Transaksi</h1>
    </div>

    <table class="table table-bordered table-striped">
      <tr>
        <th>No</th>
        <th>Nama Konsol</th>
        <th>Harga Sewa Per Hari</th>
      </tr>

      <?php 
      $no = 1;
      foreach($detail as $dt): ?>
      <tr>
      <tr>
          <td><?= $no++; ?></td>
          <td><?= $dt->nama; ?></td>
          <td>Rp.<?= number_format($dt->harga, 0, ',', '.'); ?>,-</td>
        </tr>
      </tr>

      <?php endforeach; ?>
    </table>
  </section>
</div>