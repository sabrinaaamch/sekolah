<?php
$jadwal = $this->db->query("SELECT * FROM jadwal INNER JOIN peminjaman on jadwal.id_peminjaman=peminjaman.id_peminjaman INNER JOIN user on peminjaman.id_user=user.id_user INNER JOIN ruangan on peminjaman.id_ruangan = ruangan.id_ruangan ORDER BY peminjaman.tanggal ASC")->result();

$cek_tanggal = $this->db->query("SELECT * FROM peminjaman WHERE tanggal < CURRENT_DATE() OR (tanggal = CURRENT_DATE() AND jam_berakhir < CURRENT_TIME()) AND status_peminjaman = 1 AND id_user = $user")->result();
foreach ($cek_tanggal as $row) {
    $this->db->update('peminjaman', ['status_peminjaman' => 2], ['id_peminjaman' => $row->id_peminjaman]);
}
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?= $root; ?></a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header text-center">
                <h2>Kelola Jadwal</h2>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('message'); ?>
                <div class="table-responsive">
                    <table id="tabel" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama User</th>
                                <th>Ruangan</th>
                                <th>Jam Mulai</th>
                                <th>Jam Berakhir</th>
                                <th>Tanggal</th>
                                <th>Keterangan Peminjaman</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyjadwal">
                            <?php $no = 1; ?>
                            <?php foreach ($jadwal as $j) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $j->nama_lengkap; ?></td>
                                    <td><?= $j->nama_ruangan; ?></td>
                                    <td><?= substr($j->jam_mulai, 0, 5); ?></td>
                                    <td><?= substr($j->jam_berakhir, 0, 5); ?></td>
                                    <td><?= longdate_indo($j->tanggal); ?></td>
                                    <td><?= $j->keterangan; ?></td>
                                    <td>
                                        <?php if ($j->status_jadwal == 0) {
                                            echo '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                                        } elseif ($j->status_jadwal == 1) {
                                            echo '<span class="badge badge-info">Sedang digunakan..</span>';
                                        } elseif ($j->status_jadwal == 2) {
                                            echo '<span class="badge badge-success">Selesai</span>';
                                        } elseif ($j->status_jadwal == 3) {
                                            echo '<span class="badge badge-danger">Ditolak</span>';
                                        } ?>
                                    </td>
                                    <td>
                                        <?php if ($j->status_jadwal == 0) { ?>
                                            <a href="<?= base_url('admin/accjadwal/' . $j->id_jadwal); ?>" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin menerima peminjaman ini?')"><i class="fas fa-check"></i></a>
                                            <a href="<?= base_url('admin/tolak/' . $j->id_jadwal); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menolak peminjaman ini?')"><i class="fas fa-times"></i></a>
                                        <?php } ?>
                                        <a href="<?= base_url('admin/hapusjadwal/' . $j->id_jadwal); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jadwal ini?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>