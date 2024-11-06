<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="container">
                    <?= $this->session->flashdata('message') ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Data Ruangan</h3>
                                </div>
                                <div class="card-body">
                                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahruangan">Tambah Ruangan</button>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Ruangan</th>
                                                    <th>Nama Ruangan</th>
                                                    <th>Gambar</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($ruangan as $r) : ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $r->kode_ruangan ?></td>
                                                        <td><?= $r->nama_ruangan ?></td>
                                                        <td>
                                                            <?php if ($r->image == null) : ?>
                                                                <img src="<?= base_url('files/default/ruangan-default.png') ?>" width="100">
                                                            <?php else : ?>
                                                                <img src="<?= base_url('files/site/' . $r->image) ?>" width="100">
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#ubahruangan<?= $r->id_ruangan ?>" data-id_ruangan="<?= $r->id_ruangan ?>"><i class="fas fa-edit"></i></button>
                                                            <a href="<?= base_url('admin/hapusruangan/' . $r->id_ruangan) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></a>
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
                </div>
            </div>
        </div>
    </section>

    <!-- modal ubah ruangan -->
    <?php foreach ($ruangan as $r) : ?>
        <div class="modal fade" id="ubahruangan<?= $r->id_ruangan ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ubah Ruangan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="<?= base_url('admin/ubahruangan') ?>" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kode_ruangan">Kode Ruangan</label>
                                <input type="hidden" name="id_ruangan" value="<?= $r->id_ruangan ?>">
                                <input type="text" class="form-control" id="kode_ruangan" name="kode_ruangan" value="<?= $r->kode_ruangan ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_ruangan">Nama Ruangan</label>
                                <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan" value="<?= $r->nama_ruangan ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <input type="file" class="form-control" id="imageRuang" name="image">
                                <img src="<?= base_url('files/site/' . $r->image) ?>" width="100" class="mt-2">
                            </div>
                            <div class="form-group">
                                <span>Preview Gambar Update:</span>
                                <div id="imagePreview"></div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- modal tambah ruangan -->
    <div class="modal fade" id="tambahruangan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Ruangan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('admin/tambahruangan') ?>" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_ruangan">Kode Ruangan <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="kode_ruangan" name="kode_ruangan" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_ruangan">Nama Ruangan <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar <sup class="text-danger">*</sup></label>
                            <input type="file" class="form-control" id="imageRuang" name="image" required>
                            <sub class="font-italic"><sup class="text-danger">*</sup>Patikan ukuran gambar tidak lebih dari 10MB</sub>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>