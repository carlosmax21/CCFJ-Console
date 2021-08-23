<div style="height: 40px;"></div>

<section class="blog-posts grid-system">
  <div class="container">
    <?= $this->session->flashdata('konsoldatamsg'); ?>
    <div class="all-blog-posts">
      <div class="row">

        <?php foreach($konsol as $ks): ?>
        <div class="col-md-4 col-sm-6">
          <div class="blog-post">
            <div class="blog-thumb">
              <img src="<?= base_url('assets/upload/') . $ks->gambar ?>" alt="">
            </div>
            <div class="down-content">
              <a><h4><?= $ks->nama; ?></h4></a>
              <span>Rp. <?= number_format($ks->harga,0,',','.'); ?>,-</span> <strong>per hari</strong>

              <div class="row">
                
              </div>

              <div class="post-options">
                <div class="row">
                  <div class="col-lg-12">
                    <ul class="post-tags">
                      <li><i class="fa fa-bullseye"></i></li>
                      <?php 
                      if($ks->stock >= 1){ ?>
                        <a href="<?= base_url('customer/keranjang/tambah_keranjang/'.$ks->id_konsol) ?>"> Tambah ke Keranjang</a></li>
                      <?php }
                      else{ ?>
                        <a href="#" style="color: black;"> Tidak Tersedia</a></li>
                      <?php } ?>
                      
                      <li><a href="<?= base_url('customer/data_konsol/detail_konsol/'.$ks->id_konsol) ?>"> | Detail</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>
</section>

<div style="height: 180px;"></div>