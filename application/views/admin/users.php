<?php
$query = $this->db->query("SELECT * FROM user ORDER BY level='Admin' AND id_user DESC")->result();
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
	<div class="container">
		<div class="card">
			<div class="card-header text-center">
				<h2>Kelola Data User</h2>
			</div>
			<div class="card-body">
				<?= $this->session->flashdata('message'); ?>
				<div class="row">
					<div class="col-2">
						<button class="btn btn-primary" data-toggle="modal" data-target="#adduser"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah User</button>
					</div>
					<div class="col-12"><br></div>
				</div>
				<div class="table-responsive">
					<table id="tabel" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>No.</th>
								<th>Nama Lengkap</th>
								<th>Username</th>
								<th>NIP</th>
								<th>Level</th>
								<th class="col-xs-2">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1; ?>
							<?php foreach ($query as $u) : ?>
								<tr>
									<td><?= $no++; ?></td>
									<td><?= $u->nama_lengkap; ?></td>
									<td><?= $u->username; ?></td>
									<td><?= $u->nip; ?></td>
									<td><?= $u->level; ?></td>
									<td>
										<?php if ($u->id_user != $this->session->userdata('id_user')) : ?>
											<a href="javascript:void(0);" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edituser<?= $u->id_user; ?>"><i class="fa fa-edit"></i></a>
											<a href="<?= base_url('admin/deleteuser/' . $u->id_user) ?>" onclick="return confirm('Hapus User?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
										<?php else : ?>
											<a href="<?= base_url('admin/myprofile/' . $this->session->userdata('id_user')) ?>" class="btn btn-sm btn-primary"><i class="fa fa-user"></i></a>
										<?php endif; ?>
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