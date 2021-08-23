<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Customer</h1>
    </div>
    
    <a href="<?= base_url('admin/data_customer/tambah_customer'); ?>" class="btn btn-primary mb-3">Tambah Customer</a>
    <?= $this->session->flashdata('custmsg'); ?>
    
    <table class="table table-hover table-striped table-bordered">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>No. Telepon</th>
        <th>Password</th>
        <th>Action</th>
      </tr>

      <?php 
      $no = 1;
      foreach($user as $us): ?>
      <tr>
        <td><?= $no++; ?>.</td>
        <td><?= $us->nama; ?></td>
        <td><?= $us->email; ?></td>
        <td><?= $us->alamat; ?></td>
        <td><?= $us->no_telepon; ?></td>
        <td><?= $us->password; ?></td>
        <td>
          <div class="row">
            <a href="<?= base_url('admin/data_customer/update_customer/').$us->id_user; ?>" class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>
            <a href="<?= base_url('admin/data_customer/delete_customer/').$us->id_user; ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
    


  </section>
</div>