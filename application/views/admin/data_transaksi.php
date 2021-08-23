<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Transaksi</h1>
    </div>

    <table class="table table-bordered table-striped">
      <tr>
        <th>No</th>
        <th>Nama Perental</th>
        <th>Alamat</th>
        <th>Lama Rental</th>
        <th>Total Harga</th>
        <th>Status</th>
        <th>Action</th>
      </tr>

      <?php 
      $no = 1;
      foreach($transaksi as $tr): ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $tr->nama; ?></td>
        <td><?= $tr->alamat; ?></td>
        <td><?= $tr->lamaHari?> hari</td>
        <td>
          Rp.<?= number_format($tr->totalHarga, 0, ',', '.'); ?>,-
        </td>
        <td><?= $tr->keterangan;?></td>
        <td>
          <div class="row">
            <a href="<?= base_url('admin/transaksi/detail_transaksi/').$tr->id_transaksi; ?>" class="btn btn-sm btn-primary mr-2"><i class="fas fa-eye"></i></a>
            <?php
              if($tr->keterangan == "Sedang Dikirim"){ ?>
                <a href="<?= base_url('admin/transaksi/update_transaksi/').$tr->id_transaksi; ?>" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>
                <a href="<?= base_url('admin/transaksi/konfirmasi_transaksi/').$tr->id_transaksi; ?>" class="btn btn-sm btn-primary mr-2"><i class="fas fa-check"></i></a>
                <a href="<?= base_url('admin/transaksi/delete_transaksi/').$tr->id_transaksi; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
              <?php }
              else if($tr->keterangan == "Siap di Pick-up"){ ?>
                <a href="<?= base_url('admin/transaksi/transaksi_selesai/').$tr->id_transaksi; ?>" class="btn btn-sm btn-primary mr-2">Selesai</a>
            <?php }?>
          </div>
        </td>
      </tr>

      <?php endforeach; ?>
    </table>
  </section>
</div>