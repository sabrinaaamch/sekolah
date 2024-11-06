<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="<?= base_url('peminjam') ?>" class="navbar-brand">

        <?php $sitetitle = $this->db->get('site')->result(); ?>
        <?php if ($sitetitle[0]->logo) { ?>
          <img src="<?= base_url('files/site/' . $sitetitle[0]->logo) ?>" alt="logo" class="brand-image img-circle">
          <span class="brand-text font-weight-light"><?php $sitetitle = $this->db->get('site')->result();
                                                      echo $sitetitle[0]->title ?></span>
        <?php } else { ?>
          <span class="brand-text font-weight-light"><?php $sitetitle = $this->db->get('site')->result();
                                                      echo $sitetitle[0]->title ?></span>
        <?php } ?>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="<?= base_url('peminjam') ?>" class="nav-link">Beranda</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('peminjam/jadwal') ?>" class="nav-link">Jadwal</a>
          </li>
        </ul>
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
          <a href="#" data-toggle="modal" data-target="#logout" class="btn btn-danger btn-flat"><i class="fas fa-power-off"></i>&nbsp;&nbsp;Keluar</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Jadwal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Jadwal</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tabel Jadwal</h3>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body text-center">
                <div class="table-responsive">
                  <table id="tabel" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>User</th>
                        <th>Ruangan</th>
                        <th>Jam Mulai</th>
                        <th>Jam Berakhir</th>
                        <th>Tanggal</th>
                        <th>Keterangan Peminjaman</th>
                        <th>Role</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <?php $no = 1; ?>
                    <?php foreach ($jadwal as $q) : ?>
                      <?php if ($id_user == $q->id_user) { ?>
                        <tbody>
                          <tr class="font-weight-bold text-primary">
                            <td><?= $no++; ?></td>
                            <td><?= $q->nama_lengkap; ?></td>
                            <td><?= $q->nama_ruangan; ?></td>
                            <td><?= substr($q->jam_mulai, 0, 5); ?></td>
                            <td><?= substr($q->jam_berakhir, 0, 5); ?></td>
                            <td><?= longdate_indo($q->tanggal); ?></td>
                            <td><?= $q->keterangan; ?></td>
                            <td>
                            <?php if ($q->level == 'Admin') {
                                echo 'Admin';
                              } elseif ($q->level == 'Peminjam') {
                                echo 'Siswa';
                              } elseif ($q->level == 'Pengawas') {
                                echo 'Pengawas';
                              } ?>
                            </td>
                            <td>
                              <?php if ($q->status_jadwal == 0) {
                                echo '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                              } elseif ($q->status_jadwal == 1) {
                                echo '<span class="badge badge-info">Sedang digunakan..</span>';
                              } elseif ($q->status_jadwal == 2) {
                                echo '<span class="badge badge-success">Selesai</span>';
                              } elseif ($q->status_jadwal == 3) {
                                echo '<span class="badge badge-danger">Ditolak</span>';
                              } ?>
                            </td>
                          </tr>
                        </tbody>
                      <?php } else { ?>
                        <tbody>
                          <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $q->nama_lengkap; ?></td>
                            <td><?= $q->nama_ruangan; ?></td>
                            <td><?= substr($q->jam_mulai, 0, 5); ?></td>
                            <td><?= substr($q->jam_berakhir, 0, 5); ?></td>
                            <td><?= longdate_indo($q->tanggal); ?></td>
                            <td><?= $q->keterangan; ?></td>
                            <td>
                            <?php if ($q->level == 'Admin') {
                                echo 'Admin';
                              } elseif ($q->level == 'Peminjam') {
                                echo 'Siswa';
                              } elseif ($q->level == 'Pengawas') {
                                echo 'Pengawas';
                              } ?>
                            </td>
                            <td>
                              <?php if ($q->status_jadwal == 0) {
                                echo '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                              } elseif ($q->status_jadwal == 1) {
                                echo '<span class="badge badge-info">Sedang digunakan..</span>';
                              } elseif ($q->status_jadwal == 2) {
                                echo '<span class="badge badge-success">Selesai</span>';
                              } elseif ($q->status_jadwal == 3) {
                                echo '<span class="badge badge-danger">Ditolak</span>';
                              } ?>
                            </td>
                          </tr>
                        </tbody>
                      <?php } ?>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <span class="text-danger p-2 font-weight-bold text-uppercase">*Teks tebal & warna biru merupakan jadwal anda</span><br>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>