<div class="container">
  <div style="height: 150px;"></div>

  <div class="card">
    <div class="card-body">
      <?php foreach($detail as $dt): ?>
      <div class="row">
        <div class="col-md-6">
          <img width="500px;" src="<?= base_url('assets/upload/').$dt->gambar; ?>" alt="">
        </div>
        <div class="col-md-6">
          <table class="table">
            <tr>
              <th>Nama</th>
              <td><?= $dt->nama; ?></td>
            </tr>
            <tr>
              <th>Harga</th>
              <td>Rp.<?= number_format($dt->harga, 0, ',', '.'); ?>,-</td>
            </tr>
            <tr>
              <th>Stock</th>
              <td><?= $dt->stock; ?></td>
            </tr>
            <tr>
              <th>Status</th>
              <td>
                <?php if($dt->stock >= 1){
                  echo "Tersedia";
                }
                else{
                  echo "Tidak tersedia / sedang dirental";
                } ?>
              </td>
            </tr>
            <tr>
              <th>Deskripsi</th>
              <td><?= $dt->descKonsol; ?></td>
            </tr>
            <tr>
            <td></td>
              <td>
              <?php
                if($dt->stock == 0){ 
                  echo anchor('customer/data_konsol/', '<button class="btn btn-danger">Telah Dirental</button>');
                }
                else{
                  echo anchor('customer/keranjang/tambah_keranjang/'. $dt->id_konsol, '<button class="btn btn-success">Tambah ke Keranjang</button>');
                  echo anchor('customer/data_konsol/', ' <button class="btn btn-danger">Back</button>');
                }
                ?>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>


<div style="height: 180px;"></div>


    