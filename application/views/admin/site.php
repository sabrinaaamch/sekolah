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
                        <li class="breadcrumb-item"><a href="#"><?= $root; ?></a></li>
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
                <?php echo $this->session->flashdata('message') ?>
                <div class="callout callout-info">
                    <?php foreach ($site as $s) : ?>
                        <table class="table col-sm-6">
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;" rowspan="4"><img src="<?php echo base_url('files/site/' . $s->logo) ?>" width="100" class="image-responsive" alt="Logo"></td>
                                </tr>
                                <tr>
                                    <th>JUDUL</th>
                                    <td>:</td>
                                    <td><?php echo $s->title ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>LOGO</th>
                                    <td>:</td>
                                    <td><?php echo $s->logo ?> </td>
                                </tr>
                                <tr>
                                    <th>ICON</th>
                                    <td>:</td>
                                    <td><?php echo $s->icon ?></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <a href="javascript:;" data-toggle="modal" data-id_site="<?php echo $s->id_site ?>" data-target="#ubahsitus"><span class="btn btn-primary">Ubah</span></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ADMIN EDIT SITUS -->
<div class="modal fade" id="ubahsitus">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div id="ajaxubahsitus"></div>
            <form enctype="multipart/form-data" action="<?php echo base_url('admin/editsite') ?>" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Edit situs</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php foreach ($site as $s) : ?>
                        <input type="hidden" name="id_site" value="<?php echo $s->id_site ?>">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $s->title ?>">
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <br>
                            <center><img src="<?php echo base_url('files/site/' . $s->logo) ?>" width="50" id="imglogo"></center>
                            <label for="ubahlogo" class="badge badge-primary">Ubah</label>
                            <input type="file" id="ubahlogo" onchange="return ubahLogo()" name="logo" class="d-none">
                            <span class="text-danger" id="newlogoname"></span>
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <center><img src="<?php echo base_url('files/site/' . $s->icon) ?>" width="50"></center>
                            <label for="ubahicon" class="badge badge-primary">Ubah</label>
                            <input type="file" id="ubahicon" onchange="return ubahIcon()" name="icon" class="d-none">
                            <span class="text-danger" id="newiconname"></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="edit" class="btn btn-primary pinjam">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>