<div style="height: 150px;"></div>
<div class="container">
  <div class="card mx-auto">
    <div class="card-header">
      Data Transaksi Anda
    </div>
    <span class="mt-2 p-2"><?= $this->session->flashdata('transactionmsg'); ?></span>
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <tr>
          <th>No</th>
          <th>Harga Total</th>
          <th>Alamat Tujuan</th>
          <th>Lama Rental</th>
          <th>Status</th>
          <th>Action</th>
        </tr>

        <?php
        $no = 1;
        foreach($transaksi as $tr): ?>
        <tr>
          <td><?= $no++; ?></td>
          <td>Rp.<?= number_format($tr->totalHarga, 0, ',', '.'); ?>,-</td>
          <td><?= $tr->alamat ?></td>
          <td><?= $tr->lamaHari?></td>
          <td><?= $tr->keterangan; ?></td>
          <td>
          <div>
            <a href="<?= base_url('customer/transaksi/view_detail/').$tr->id_transaksi; ?>" class="btn btn-sm btn-info mr-2"><i class="fas fa-eye"></i></a>
            <?php
              if($tr->keterangan == "Sedang Dikirim"){ ?>
                <a href="<?= base_url('customer/transaksi/delete/').$tr->id_transaksi; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
              <?php }
            ?>
            <?php
              if($tr->keterangan == "Sudah Dikirim"){ ?>
                <a href="<?= base_url('customer/transaksi/confirm_rental/').$tr->id_transaksi; ?>" class="btn btn-sm btn-info mr-2">konfirmasi</a>
              <?php }
            ?>
          </div>
        </td>
        </tr>

        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>

<div style="height: 180px;"></div>