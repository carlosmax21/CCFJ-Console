<div style="height: 150px;"></div>
<div class="container">
  <div class="card mx-auto">
    <div class="card-header">
    <i class="fas fa-shopping-cart"></i>
      Keranjang belanja
    </div>
    <span class="mt-2 p-2"><?= $this->session->flashdata('cartmsg'); ?></span>
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <tr>
          <th>No</th>
          <th>Nama Konsol</th>
          <th>Harga Sewa per hari</th>
          <th>Hapus</th>
        </tr>

        <?php
        $grand_total= 0;
        $no = 1;
        foreach($keranjang as $kr): ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $kr->nama; ?></td>
          <td>Rp.<?= number_format($kr->harga, 0, ',', '.'); ?>,-</td>
          <td><a href="<?= base_url('customer/keranjang/delete_keranjang/').$kr->id_keranjang; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
        </tr>
        <tr>
            <?php $grand_total = $grand_total + $kr->harga; ?>
        <tr>

        <?php endforeach; ?>
        <tr>
            <td colspan="4"><b>Harga Order Total : Rp.<?php echo number_format($grand_total, 0, ',', '.');  ?></td>
        </tr>
        <tr>
          <form action="<?= base_url('customer/keranjang/checkout_keranjang') ?>" method="post">
          <td colspan="3">
            <label>Lama Hari:</label> <input type="number" name="lama">
            <?= form_error('lama', '<div class="text-small text-danger">', '</div>') ?> 
          </td>
            <input type="hidden" name="harga" value="<?= $grand_total; ?>">
          <td><button type="submit" class="btn btn-primary">Check-out</button>
          <a class="btn btn-danger" href="<?= base_url('customer/dashboard/'); ?>">Back</a>
          </td>
          </form>
        </tr>
      </table>
    </div>
  </div>
</div>

<div style="height: 180px;"></div>
