<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="page-body">
    <div class="row">
        <div class="col-lg-12">

            <div class="cover-profile">
                <div class="profile-bg-img">
                    <img class="profile-bg-img img-fluid" src="<?= base_url('assets') ?>/images/bg-img1.jpg" alt="bg-img">
                    <div class="card-block user-info">
                        <div class="col-md-12">
                            <div class="media-left">
                                <a href="#" class="profile-image">
                                    <img class="user-img img-radius" src="<?= base_url('assets/fileimg/pegawai') ?>/<?= session()->avatar ?>" width="100" height="100" alt="user-img">
                                </a>
                            </div>
                            <div class="media-body row">
                                <div class="col-lg-12">
                                    <div class="user-title">
                                        <h2><?= $biodata[0]->nama ?></h2>
                                        <span class="text-white"><?= $biodata[0]->jabatan ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="tab-header card">
                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#personal" role="tab"><?= lang('app.infopribadi') ?></a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#hakakses" role="tab"><?= lang('app.hakakses') ?></a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#gaji" role="tab"><?= lang('app.gaji') ?></a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#ulasan" role="tab"><?= lang('app.ulasan') ?></a>
                        <div class="slide"></div>
                    </li>
                </ul>
            </div>
            <!--  -->
            <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h7 class="card-header-text fontprofil">Biodata</h7>
                        </div>
                        <!--  -->
                        <div class="card-block">
                            <div class="view-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row" width="150"><?= lang('app.kode') ?></th>
                                                                    <td width="20">:</td>
                                                                    <td><?= $biodata[0]->kode ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.nip') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->nip ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.nama') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->nama ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.jenkel') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= lang('app.' . $biodata[0]->jenkel) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.lahir') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= ($biodata[0]->t4lahir . ", " . formattanggal($biodata[0]->tgl_lahir)) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.goldarah') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->goldarah ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.surel') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->email ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row" width="150"><?= lang('app.perusahaan') ?></th>
                                                                    <td width="20">:</td>
                                                                    <td><?= $biodata[0]->perusahaan ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.wilayah') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->wilayah ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.divisi') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->divisi ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.cabang') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->cabang ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.lokasi') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->lokasi ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.jabatan') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->jabatan ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.golongan') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->golongan ?></td>
                                                                </tr>
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
                    </div> <!-- end card -->

                    <div class="card">
                        <!-- <div class="card-header">
                            <h7 class="card-header-text fontprofil">&nbsp;</h7>
                        </div> -->
                        <!--  -->
                        <div class="card-block">
                            <div class="view-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row" width="150"><?= lang('app.sim') ?></th>
                                                                    <td width="20">:</td>
                                                                    <td><?= $biodata[0]->jns_sim ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.nomor') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->nosim ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.tanggalhabis') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= formattanggal($biodata[0]->tgl_sim) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"></th>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.ijazah') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->ijasah ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.jurusan') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->jurusan ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.status') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= lang('app.' . $biodata[0]->st_ijasah) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.tanggal') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= formattanggal($biodata[0]->tgl_ijasah) ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row" width="150"><?= lang('app.status') ?></th>
                                                                    <td width="20">:</td>
                                                                    <td><?= $biodata[0]->st_pegawai ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.tglgabung') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= formattanggal($biodata[0]->tgl_join) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.awalkontrak') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= formattanggal($biodata[0]->tgl_kontrakawal) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.akhirkontrak') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= formattanggal($biodata[0]->tgl_kontrakakhir) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"></th>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr></tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.ptkp') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->st_ptkp ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><?= lang('app.atasan') ?></th>
                                                                    <td>:</td>
                                                                    <td><?= $biodata[0]->atasan ?></td>
                                                                </tr>
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
                    </div><!-- end card -->

                    <div class="card">
                        <!-- <div class="card-header">
                            <h7 class="card-header-text fontprofil">&nbsp;</h7>
                        </div> -->
                        <!--  -->
                        <div class="card-block">
                            <div class="view-info">
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label font-weight-bold"><?= lang('app.alamat') ?></label>
                                    <label class="col-sm-11 col-form-label"><?= $biodata[0]->alamat ?></label>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label font-weight-bold"><?= lang('app.kontak') ?></label>
                                    <label class="col-sm-11 col-form-label"><?= $biodata[0]->kontak ?></label>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label font-weight-bold"><?= lang('app.asuransi') ?></label>
                                    <label class="col-sm-11 col-form-label"><?= $biodata[0]->asuransi ?></label>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-sm-1 col-form-label font-weight-bold"><?= lang('app.catatan') ?></label>
                                    <label class="col-sm-11 col-form-label"><?= $biodata[0]->catatan ?></label>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card -->
                </div> <!-- end tab personal -->

                <div class="tab-pane" id="hakakses" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">User Services</h5>
                        </div>

                        <div class="card-block">
                        </div>
                    </div><!-- end card -->
                </div><!-- end tab hak akses -->

                <div class="tab-pane" id="hakakses" role="tabpanel">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">User Services22</h5>
                        </div>

                        <div class="card-block">
                        </div>
                    </div><!-- end card -->

                </div><!-- end tab hak akses -->

                <div class="tab-pane" id="hakakses" role="tabpanel">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">User Services</h5>
                        </div>

                        <div class="card-block">
                        </div>
                    </div><!-- end card -->

                </div><!-- end tab hak akses -->
            </div>

        </div>
    </div>
</div><!-- body end -->

<?= $this->endSection() ?>
<!-- <script>
    $('.closeX').on('click', function() {
        $(this).closest('.card').fadeOut();
    })
</script> -->