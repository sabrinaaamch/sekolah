<?php
function currenturl($url, $echo)
{
  if (current_url() == base_url('admin/' . $url)) {
    echo $echo;
  }
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <?php $site = $this->db->get('site')->result(); ?>
  <a href="<?= base_url() ?>" class="brand-link text-center">
    <img src="<?= base_url('files/site/' . $site[0]->logo) ?>" alt="Logo" style="opacity: .8; width: 50px"><br>
    <span class="brand-text font-weight-light"><?= $site[0]->title ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php $userprofile = $this->db->get_where('user', ['level' => 'Admin'])->result(); ?>
        <img src="<?= base_url('files/userprofil/' . $userprofile[0]->image) ?>" style="background-color: white; border-radius: 50%">
      </div>
      <div class="info">
        <a href="<?= base_url('admin/myprofile/' . $this->session->userdata('id_user')) ?>" class="d-block">
          <?= $this->session->nama_lengkap; ?>
        </a>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- HOME -->
        <li class="nav-item">
          <a href="<?= base_url() ?>" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Beranda
            </p>
          </a>
        </li>

        <!-- USER MANAGEMENT -->
        <li class="nav-item has-treeview <?php currenturl('newuser', 'menu-open');
                                          currenturl('users', 'menu-open'); ?>">
          <a href="#" class="nav-link <?php currenturl('newuser', 'active');
                                      currenturl('users', 'active'); ?>">
            <i class="nav-icon fas fa-users"></i>
            <?php $query = "SELECT count(*) as total FROM user WHERE status=0";
            $row = $this->db->query($query)->result(); ?>
            <p>
              Manajemen Pengguna
            </p>
            <?php if ($row[0]->total == 0) {
            } else { ?>
              <span class="badge badge-primary">
                <?= $row[0]->total; ?>
              </span>
            <?php } ?>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php currenturl('newuser', 'active') ?>">
              <a href="<?= base_url('admin/newuser') ?>" class="nav-link <?php currenturl('newuser', 'active') ?>">
                <i class="nav-icon far fa-circle"></i>
                <p>
                  Pendaftar Baru &nbsp;&nbsp;&nbsp;
                  <?php if ($row[0]->total > 0) { ?>
                    <span class="badge badge-primary">
                      <?= $row[0]->total; ?>
                    </span>
                  <?php } ?>
                </p>
              </a>
            </li>
            <li class="nav-item <?php currenturl('users', 'active') ?>">
              <a href="<?= base_url('admin/users') ?>" class="nav-link <?php currenturl('users', 'active') ?>">
                <i class="nav-icon far fa-circle"></i>
                <p>
                  Kelola Data User
                </p>
              </a>
            </li>
          </ul>
        </li>

        <!-- LOANS MANAGEMENT -->
        <li class="nav-item has-treeview <?php currenturl('request', 'menu-open');
                                          currenturl('jadwal', 'menu-open'); ?>">
          <a href="#" class="nav-link <?php currenturl('request', 'active');
                                      currenturl('jadwal', 'active'); ?>">
            <i class="nav-icon fas fa-bookmark"></i>
            <?php
            $query2 = "SELECT count(*) as total FROM peminjaman WHERE status_peminjaman=0";
            $row2 = $this->db->query($query2)->result(); ?>
            <p>
              Kelola Peminjaman
            </p>
            <?php if ($row2[0]->total == 0) {
            } else { ?>
              <span class="badge badge-primary">
                <?= $row2[0]->total; ?>
              </span>
            <?php } ?>
          </a>
          <ul class="nav nav-treeview">
            <?php
            $query2 = "SELECT count(*) as total FROM peminjaman WHERE status_peminjaman=0";
            $row2 = $this->db->query($query2)->result(); ?>
            <li class="nav-item <?php currenturl('request', 'active'); ?>">
              <a href="<?= base_url('admin/request') ?>" class="nav-link <?php currenturl('request', 'active'); ?>">
                <i class="nav-icon far fa-circle"></i>
                <p>
                  Peminjaman &nbsp;&nbsp;&nbsp;
                  <?php if ($row2[0]->total > 0) { ?>
                    <span class="badge badge-primary">
                      <?= $row2[0]->total; ?>
                    </span>
                  <?php } ?>
                </p>
              </a>
            </li>
            <li class="nav-item <?php currenturl('jadwal', 'active') ?>">
              <a href="<?= base_url('admin/jadwal') ?>" class="nav-link <?php currenturl('jadwal', 'active') ?>">
                <i class="nav-icon far fa-circle"></i>
                <p>
                  Jadwal
                </p>
              </a>
            </li>
          </ul>
        </li>

        <!-- RUANGAN -->
        <li class="nav-item <?php currenturl('ruangan', 'active'); ?>">
          <a href="<?= base_url('admin/ruangan') ?>" class="nav-link <?php currenturl('ruangan', 'active'); ?>">
            <i class="nav-icon fas fa-hotel"></i>
            <p>
              Data Ruangan
            </p>
          </a>
        </li>

        <!-- SETTING -->
        <li class="nav-item has-treeview <?php currenturl('myprofile/' . $this->session->userdata('id_user'), 'menu-open'); ?>">
          <a href="#" class="nav-link <?php currenturl('myprofile/' . $this->session->userdata('id_user'), 'active'); ?>">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Pengaturan
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item <?php currenturl('myprofile/' . $this->session->userdata('id_user'), 'active'); ?>">
              <a href="<?= base_url('admin/myprofile/' . $this->session->userdata('id_user')) ?>" class="nav-link <?php currenturl('myprofile/' . $this->session->userdata('id_user'), 'active'); ?>">
                <i class="nav-icon far fa-circle"></i>
                <p>
                  Profil Saya
                </p>
              </a>
            </li>
            <li class="nav-item <?php currenturl('sitesetting', 'active'); ?>">
              <a href="<?= base_url('admin/sitesetting') ?>" class="nav-link <?php currenturl('sitesetting', 'active'); ?>">
                <i class="nav-icon far fa-circle"></i>
                <p>
                  Situs
                </p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>