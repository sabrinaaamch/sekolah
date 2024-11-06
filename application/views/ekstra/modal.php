<!-- MODAL PUBLIK -->
<!-- ADMIN EDIT PROFIL ADMIN -->
<div class="modal fade" id="editprofiladmin">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="ajaxeditprofil"></div>
            <form action="<?php echo base_url('admin/editprofil') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Edit profil Admin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $profil = $this->m_siplabs->get_data('user', 'where level="Admin"')->row(); ?>
                    <div class="row">
                        <div class="col-md">
                            <input type="hidden" name="id_user" value="<?= $profil->id_user ?>">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" value="<?= $profil->username ?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" value="<?= $profil->nama_lengkap ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Bio</label>
                                <textarea name="bio" class="form-control"><?= $profil->bio ?></textarea>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label>NIP/NIS</label>
                                <input type="text" onkeypress="return isNumberKey(event)" name="nip" value="<?= $profil->nip ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nomor WA Aktif</label>
                                <div class="input-group">
                                    <span class="text-bold">+62</span>&nbsp;&nbsp;<input type="text" onkeypress="return isNumberKey(event)" name="no_telp" value="<?= $profil->no_telp ?>" class="form-control">
                                </div>
                                <small class="text-danger">Nomor dimulai dari angka 8, peminjam akan langsung mengirimkan pesan ke nomor ini</small>
                            </div>
                            <div class="form-group">
                                <label>Pilih Gambar</label>
                                <input type="file" id="imageinput" onchange="return filename()" name="image" class="form-control image">
                                <span class="text-danger" id="imagename"></span>
                                <img src="<?php echo base_url('files/userprofil/' . $profil->image) ?>" width="100">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="edit" class="btn btn-primary pinjam">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="gantipassword">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="<?php echo base_url('admin/aksigantipass') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Ubah password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_user" name="id_user" value="<?php echo $this->session->userdata('id_user') ?>">
                    <div class="form-group">
                        <label for="">Password lama</label>
                        <div class="input-group">
                            <input type="password" id="password_lama" name="password_lama" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Password baru</label>
                        <div class="input-group">
                            <input type="password" id="password_baru" name="password_baru" class="form-control" required>
                        </div>
                        <span class="text-danger" id="password_baru_message"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Konfirmasi password baru</label>
                        <div class="input-group">
                            <input type="password" id="password_baru2" name="password_baru2" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btnubahpassword" name="ubah" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL MENDAFTAR -->
<div class="modal fade" id="mendaftar">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="<?php echo base_url('auth/mendaftar') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Akun baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" style="display: none" role="alert" id="alertdaftar"></div>
                    <span id="alertusername"></span>
                    <div class="input-group mb-3">
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" id="usernamedaftar" name="username" class="form-control usernamedaftar" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password2" id="password2" class="form-control" placeholder="Konfirmasi Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" id="nip" name="nip" class="form-control" onkeypress="return isNumberKey(event)" onkeyup="return ceknip()" placeholder="NIP/NIS">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-sort-numeric-up-alt"></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="daftar" name="daftar" class="btn btn-primary btn-block btn-flat">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH USER -->
<div class="modal fade" id="adduser">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" action="<?= base_url('admin/adduser') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah User baru</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Lengkap<sup class="text-danger">*</sup></label>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <label>Username<sup class="text-danger">*</sup></label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                            <sub class="text-danger">Username hanya bisa dibuat sekali, dan tidak bisa diganti.</sub>
                        </div>
                        <div class="form-group">
                            <label>Password<sup class="text-danger">*</sup></label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password2" id="password2" class="form-control" placeholder="Konfirmasi Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" class="form-control" placeholder="Bio"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_telp">Nomor WA Aktif</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+62</div>
                                </div>
                                <input type="number" name="no_telp" onkeypress="return isNumberKey(event)" class="form-control" id="no_telp" placeholder="878228828282">
                            </div>
                            <small class="text-danger">Nomor dimulai dari angka 8, peminjam akan langsung mengirimkan pesan ke nomor ini</small>
                        </div>
                        <div class="form-group">
                            <label>NIP/NIS<sup class="text-danger">*</sup></label>
                            <input type="text" name="nip" class="form-control" placeholder="NIP/NIS" required>
                        </div>
                        <div class="form-group">
                            <label>Level<sup class="text-danger">*</sup></label>
                            <select name="level" class="form-control" required>
                                <option value="Admin">Admin</option>
                                <option value="Peminjam">Siswa</option>
                                <option value="Guru">Guru</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="tambah" class="btn btn-primary pinjam">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT USER -->
<?php
$users = $this->m_siplabs->get_data('user')->result();
foreach ($users as $u) : ?>
    <div class="modal fade" id="edituser<?= $u->id_user; ?>">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form role="form" action="<?= base_url('admin/edituser') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User <?= $u->nama_lengkap; ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_user" value="<?= $u->id_user ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Lengkap<sup class="text-danger">*</sup></label>
                                <input type="text" name="nama_lengkap" class="form-control" value="<?= $u->nama_lengkap; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Username<sup class="text-danger">*</sup></label>
                                <input type="text" name="username" class="form-control" value="<?= $u->username; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <sub class="text-danger">Biarkan kosong jika tidak ingin diganti!</sub>
                            </div>
                            <div class="form-group">
                                <label>Bio</label>
                                <textarea name="bio" class="form-control"><?= $u->bio; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>NIP/NIS<sup class="text-danger">*</sup></label>
                                <input type="text" name="nip" class="form-control" value="<?= $u->nip; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Level<sup class="text-danger">*</sup></label>
                                <select name="level" class="form-control" required>
                                    <option value="Admin" <?php if ($u->level == 'Admin') {
                                                                echo 'selected';
                                                            } ?>>Admin</option>
                                    <option value="Peminjam" <?php if ($u->level == 'Peminjam') {
                                                                    echo 'selected';
                                                                } ?>>Siswa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="edit" class="btn btn-primary pinjam">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- MODAL PINJAM -->
<div class="modal fade" id="pinjam">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" action="<?= base_url('peminjam/pinjam') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Pinjam ruangan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" id="pinjam_id_user" name="id_user" value="<?php if (isset($user)) {
                                                                                            echo $user;
                                                                                        } ?>">
                        <div class="form-group">
                            <label>Username<sup class="text-danger">*</sup></label>
                            <input type="text" id="pinjam_username" name="username" readonly class="form-control" value="<?php if (isset($username)) {
                                                                                                                                echo $username;
                                                                                                                            } ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Ruangan<sup class="text-danger">*</sup></label>
                            <select id="id_ruangan" name="id_ruangan" class="form-control" required>
                                <?php
                                $ruangan2 = $this->m_siplabs->get_datawithadd('ruangan', 'where status_ruangan="Nganggur"')->result();
                                foreach ($ruangan2 as $r2) : ?>
                                    <option value="<?php echo $r2->id_ruangan ?>"><?php echo $r2->kode_ruangan ?> - <?php echo $r2->nama_ruangan ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jam Mulai<sup class="text-danger">*</sup></label>
                            <input type="time" id="pinjam_jam_mulai" name="jam_mulai" class="form-control verifydate" value="<?php echo date('H:i'); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jam Selesai<sup class="text-danger">*</sup></label>
                            <input type="time" id="pinjam_jam_selesai" name="jam_berakhir" class="form-control verifydate" value="<?php $time = new DateTime(date('H:i'));
                                                                                                                                    $time->modify('+1 hours');
                                                                                                                                    echo $time->format('H:i'); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal<sup class="text-danger">*</sup></label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control verifydate" value="<?php echo date('Y-m-d', time()); ?>" required>
                            <span id="alerttanggal" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Keterangan Peminjaman<sup class="text-danger">*</sup></label>
                            <select name="keterangan" id="keterangan" class="form-control" required>
                                <option value="Praktek" id="praktek">Praktek</option>
                                <option value="Rapat" id="rapat">Rapat</option>
                                <option value="Pelatihan/Workshop" id="pelatihan">Pelatihan / Workshop</option>
                                <option value="Ulangan/Ujian" id="ujian">Ulangan / Ujian</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="tambah" class="btn btn-primary pinjam">Pinjam</button>
                </div>
            </form>
        </div>
        <!-- modal pinjam ruangan -->
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- MODAL LOGOUT -->
<div class="modal fade" id="logout">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lanjutkan?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Pilih 'logout' untuk keluar dari sistem</h5>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url('auth/logout') ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>