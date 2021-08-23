<div style="height: 150px;"></div>
<div class="container">
  <div class="card mx-auto">
    <div class="card-header">
      Detail Keranjang
    </div>
    <span class="mt-2 p-2"><?= $this->session->flashdata('pesan'); ?></span>
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <tr>
          <th>No</th>
          <th>Nama Konsol</th>
          <th>Harga Sewa per hari</th>
        </tr>

        <?php
        $no = 1;
        
        foreach($detail as $dt): ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $dt->nama; ?></td>
          <td>Rp.<?= number_format($dt->harga, 0, ',', '.'); ?>,-</td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php
      echo anchor('customer/transaksi', '<button class="btn btn-danger">Back</button>');
      ?>
    </div>
  </div>
</div>