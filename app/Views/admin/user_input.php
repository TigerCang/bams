<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'formmain']) ?>
<?= csrf_field() ?>
<div class="row">
    <!-- username dan limit -->
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= $user[0]->idunik ?>" />

                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="usernama" name="usernama" value="<?= ($user[0]->kode) ?>" />
                            <label for="usernama"><?= lang('app.usernama') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="peminta" name="peminta" value="<?= ($token[0]->peminta ?? '') ?>" />
                            <label for="peminta"><?= lang('app.peminta') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="role" name="role" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($user[0]->role_id) && $user[0]->role_id == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($role as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= ($user && $user[0]->role_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="role"><?= lang('app.role') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="atasan" name="atasan" <?= ($link == '/nuser' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <?php if ($useratas) : ?><option value="<?= $useratas[0]->kode ?>" selected><?= "{$useratas[0]->kode}" ?></option><?php endif ?>
                            </select>
                            <label for="atasan"><?= lang('app.atasan') ?></label>
                            <div id="error" class="invalid-feedback erratasan"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="setuju" name="setuju">
                                <?php for ($i = 0; $i <= $tlevel; $i++) : ?>
                                    <?php $deskripsi = ($i == '1' ? ' (' . lang('app.tinggi') . ')' : ($i == $tlevel ? ' (' . lang('app.rendah') . ')' : '')) ?>
                                    <option value="<?= $i ?>" <?= ($user[0]->act_setuju == $i ? 'selected' : '') . ($i == '0' ? '' : ($link == '/nuser' ? ($useratas[0]->act_setuju == '0' ? 'disabled' : ($useratas[0]->act_setuju <= $i ?  '' : 'disabled')) : '')) ?> data-subtext="Level <?= $i . $deskripsi ?>"><?= $i ?></option>
                                <?php endfor ?>
                                <option disabled data-subtext="">-------------------------------------------</option>
                                <option value="101" <?= ($user[0]->act_setuju == '101' ? 'selected' : '') . ($link == '/nuser' ? ($useratas[0]->act_setuju != '101' ? 'disabled' : '') : '') ?> data-subtext=""><?= lang('app.keuangan') ?></option>
                                <option value="102" <?= ($user[0]->act_setuju == '102' ? 'selected' : '') . ($link == '/nuser' ? ($useratas[0]->act_setuju != '102' ? 'disabled' : '') : '') ?> data-subtext=""><?= lang('app.pemeriksa') ?></option>
                            </select>
                            <label for="setuju"><?= lang('app.setuju') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="batas" name="batas" placeholder="<?= lang('app.batas') ?>" value="<?= $user[0]->act_limit ?>" />
                            <label for="batas"><?= lang('app.batas') ?></label>
                            <div id="error" class="invalid-feedback errbatas"></div>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card awal -->

        <!-- checkbox semua atau pilih -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="perusahaan" name="perusahaan" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[0] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[0] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.perusahaan') ?>" data-offlabel="<?= lang('app.pilih') ?>" data-onstyle="primary" data-offstyle="warning">
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="wilayah" name="wilayah" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[1] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[1] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.wilayah') ?>" data-offlabel="<?= lang('app.pilih') ?>" data-onstyle="primary" data-offstyle="warning">
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="divisi" name="divisi" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[2] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[2] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.divisi') ?>" data-offlabel="<?= lang('app.pilih') ?>" data-onstyle="primary" data-offstyle="warning">
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="jabatan" name="jabatan" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[3] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[3] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.jabatan') ?>" data-offlabel="<?= lang('app.pilih') ?>" data-onstyle="primary" data-offstyle="warning">
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="proyek" name="proyek" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[4] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[4] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.proyek') ?>" data-offlabel="<?= lang('app.pilih') ?>" data-onstyle="primary" data-offstyle="warning">
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="cabang" name="cabang" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[5] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[5] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.cabang') ?>" data-offlabel="<?= lang('app.pilih') ?>" data-onstyle="primary" data-offstyle="warning">
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="alat" name="alat" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[6] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[6] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.alat') ?>" data-offlabel="<?= lang('app.pilih') ?>" data-onstyle="primary" data-offstyle="warning">
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="tanah" name="tanah" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[7] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[7] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.tanah bangunan') ?>" data-offlabel="<?= lang('app.pilih') ?>" data-onstyle="primary" data-offstyle="warning">
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card -->
    </div> <!--/ Coloum kanan -->

    <!-- aksi button untuk menu utama -->
    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-header">
                <h6 class="card-title mb-0"><?= lang('app.aksi') ?></h6>
            </div>

            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-6 mb-2">
                        <input type="checkbox" id="buat" name="buat" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[0] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_button[0] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn buat') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="primary">
                    </div>
                    <div class="col-6 col-md-4 col-lg-6 mb-2">
                        <input type="checkbox" id="baca" name="baca" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[1] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_button[1] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn baca') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="info">
                    </div>
                    <div class="col-6 col-md-4 col-lg-6 mb-2">
                        <input type="checkbox" id="ubah" name="ubah" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[2] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_button[2] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn ubah') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="warning">
                    </div>
                    <div class="col-6 col-md-4 col-lg-6">
                        <input type="checkbox" id="hapus" name="hapus" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[3] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_button[3] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn hapus') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="danger">
                    </div>
                    <div class="col-6 col-md-4 col-lg-6">
                        <input type="checkbox" id="konf" name="konf" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[4] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_button[4] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn konf') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="success">
                    </div>
                    <div class="col-6 col-md-4 col-lg-6">
                        <input type="checkbox" id="aktif" name="aktif" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[5] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_button[5] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn aktif') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="dark">
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card aksi -->

        <!-- tambahan -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-12 mb-4">
                        <input type="checkbox" id="super" name="super" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[8] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[8] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.super+') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="danger">
                    </div>
                    <div class="col-6 col-md-4 col-lg-12 mb-4">
                        <input type="checkbox" id="saring" name="saring" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_akses[9] == '1' ? 'checked' : '') . ($link == '/nuser' && $useratas[0]->act_akses[9] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.saring+') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="danger">
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card -->
    </div> <!--/ Column -->
</div> <!--/ Row-->

<div class="row">

    <!-- tab untuk selection -->
    <div class="col-12">
        <div class="card">
            <div class="card-header p-2">
                <div class="nav-align-top">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-perusahaan" aria-controls="navs-top-perusahaan" aria-selected="true"><?= lang('app.perusahaan') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-wilayah" aria-controls="navs-top-wilayah" aria-selected="false"><?= lang('app.wilayah') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-divisi" aria-controls="navs-top-divisi" aria-selected="false"><?= lang('app.divisi') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-jabatan" aria-controls="navs-top-jabatan" aria-selected="false"><?= lang('app.jabatan') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-proyek" aria-controls="navs-top-proyek" aria-selected="true"><?= lang('app.proyek') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-cabang" aria-controls="navs-top-cabang" aria-selected="false"><?= lang('app.cabang') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-alat" aria-controls="navs-top-alat" aria-selected="false"><?= lang('app.alat') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-tanah" aria-controls="navs-top-tanah" aria-selected="false"><?= lang('app.tanah bangunan') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-kasbank" aria-controls="navs-top-kasbank" aria-selected="false"><?= lang('app.kas bank') ?></button></li>
                    </ul>
                </div>
            </div> <!-- judul header tab -->

            <div class="card-body mb-6">
                <div class="tab-content p-2">
                    <div class="tab-pane fade show active" id="navs-top-perusahaan" role="tabpanel">
                        <div class="row w-100">
                            <?php $perus = (explode(",", trim($user[0]->perusahaan, ',')))  ?>
                            <ul class="list-group">
                                <?php foreach ($perusahaan as $index => $db) :
                                    $kondisi = '';
                                    $ncek = '0';
                                    foreach ($perus as $field) {
                                        list($nid, $nstatus) = explode(":", $field);
                                        if ($nid == $db->id) {
                                            $kondisi = 'checked';
                                            $ncek = $nstatus;
                                            break;
                                        }
                                    } ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="checkbox" id="perusbox_<?= $db->id ?>" name="daftarperusahaan[]" value="<?= $db->id ?>" <?= $kondisi ?> />
                                            <label class="form-check-label" for="perusbox_<?= $db->id ?>"><?= "{$db->kode} &emsp; {$db->nama}" ?></label>
                                        </div>
                                        <div class="newsize">
                                            <input type="checkbox" data-toggle="toggle" id="perus_<?= $db->id ?>" name="perus_<?= $db->id ?>" <?= ($ncek == '1' ? 'checked' : '') ?> data-onlabel="<?= lang('app.semua akses') ?>" data-offlabel="<?= lang('app.baca') ?>" data-onstyle="success" data-offstyle="info">
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-wilayah" role="tabpanel">
                        <div class="row w-100">
                            <?php $wil = (explode(",", trim($user[0]->wilayah, ',')))  ?>
                            <ul class="list-group">
                                <?php foreach ($wilayah as $index => $db) :
                                    $kondisi = '';
                                    $ncek = '0';
                                    foreach ($wil as $field) {
                                        list($nid, $nstatus) = explode(":", $field);
                                        if ($nid == $db->id) {
                                            $kondisi = 'checked';
                                            $ncek = $nstatus;
                                            break;
                                        }
                                    } ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="checkbox" id="wilbox_<?= $db->id ?>" name="daftarwilayah[]" value="<?= $db->id ?>" <?= $kondisi ?> />
                                            <label class="form-check-label" for="wilbox_<?= $db->id ?>"><?= "{$db->nama}" ?></label>
                                        </div>
                                        <div class="newsize">
                                            <input type="checkbox" data-toggle="toggle" id="wil_<?= $db->id ?>" name="wil_<?= $db->id ?>" <?= ($ncek == '1' ? 'checked' : '') ?> data-onlabel="<?= lang('app.semua akses') ?>" data-offlabel="<?= lang('app.baca') ?>" data-onstyle="success" data-offstyle="info">
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-divisi" role="tabpanel">
                        <div class="row w-100">
                            <?php $div = (explode(",", trim($user[0]->divisi, ',')))  ?>
                            <ul class="list-group">
                                <?php foreach ($divisi as $index => $db) :
                                    $kondisi = '';
                                    $ncek = '0';
                                    foreach ($div as $field) {
                                        list($nid, $nstatus) = explode(":", $field);
                                        if ($nid == $db->id) {
                                            $kondisi = 'checked';
                                            $ncek = $nstatus;
                                            break;
                                        }
                                    } ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="checkbox" id="divbox_<?= $db->id ?>" name="daftardivisi[]" value="<?= $db->id ?>" <?= $kondisi ?> />
                                            <label class="form-check-label" for="divbox_<?= $db->id ?>"><?= "{$db->nama}" ?></label>
                                        </div>
                                        <div class="newsize">
                                            <input type="checkbox" data-toggle="toggle" id="div_<?= $db->id ?>" name="div_<?= $db->id ?>" <?= ($ncek == '1' ? 'checked' : '') ?> data-onlabel="<?= lang('app.semua akses') ?>" data-offlabel="<?= lang('app.baca') ?>" data-onstyle="success" data-offstyle="info">
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-jabatan" role="tabpanel">
                        <div class="row w-100">
                            <?php $jabat = (explode(",", $user[0]->jabatan)) ?>
                            <select id="custom-headers" class="searchable" multiple="multiple" name="daftarjabatan[]">
                                <?php foreach ($jabatan as $db) : $kondisi = '';
                                    foreach ($jabat as $field) if ($field == $db->id) $kondisi = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($kondisi . ($link == '/nuser' ? ($useratas[0]->act_akses[3] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $useratas[0]->jabatan) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->nama}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-proyek" role="tabpanel">
                        <div class="row w-100">
                            <?php $proy = (explode(",", $user[0]->proyek)) ?>
                            <select id="custom-headers" class="searchable" multiple="multiple" name="daftarproyek[]">
                                <?php foreach ($proyek as $db) : $kondisi = '';
                                    foreach ($proy as $field) if ($field == $db->id) $kondisi = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($kondisi . ($link == '/nuser' ? ($useratas[0]->act_akses[4] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $useratas[0]->proyek) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->kode} &emsp; {$db->paket}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-cabang" role="tabpanel">
                        <div class="row w-100">
                            <?php $cab = (explode(",", $user[0]->cabang)) ?>
                            <select id="custom-headers" class="searchable" multiple="multiple" name="daftarcabang[]">
                                <?php foreach ($cabang as $db) : $kondisi = '';
                                    foreach ($cab as $field) if ($field == $db->id) $kondisi = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($kondisi . ($link == '/nuser' ? ($useratas[0]->act_akses[5] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $useratas[0]->cabang) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->kode} &emsp; {$db->nama}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-alat" role="tabpanel">
                        <div class="row w-100">
                            <?php $alt = (explode(",", $user[0]->alat)) ?>
                            <select id="custom-headers" class="searchable" multiple="multiple" name="daftaralat[]">
                                <?php foreach ($alat as $db) : $kondisi = '';
                                    foreach ($alt as $field) if ($field == $db->id) $kondisi = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($kondisi . ($link == '/nuser' ? ($useratas[0]->act_akses[6] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $useratas[0]->alat) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->kode} &emsp; {$db->nama}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-tanah" role="tabpanel">
                        <div class="row w-100">
                            <?php $tan = (explode(",", $user[0]->tanah)) ?>
                            <select id="custom-headers" class="searchable" multiple="multiple" name="daftartanah[]">
                                <?php foreach ($tanah as $db) : $kondisi = '';
                                    foreach ($tan as $field) if ($field == $db->id) $kondisi = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($kondisi . ($link == '/nuser' ? ($useratas[0]->act_akses[7] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $useratas[0]->tanah) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->kode} &emsp; {$db->nama}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-kasbank" role="tabpanel">
                        <div class="row w-100">
                            <?php $kas = (explode(",", $user[0]->kasbank)) ?>
                            <select id="custom-headers" class="searchable" multiple="multiple" name="daftarkasbank[]">
                                <?php foreach ($kasbank as $db) : $kondisi = '';
                                    foreach ($alt as $field) if ($field == $db->id) $kondisi = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($kondisi . ($link == '/nuser' ? ($useratas[0]->act_akses[8] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $useratas[0]->kasbank) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->nama}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div> <!--/ Tab content  -->
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($user[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($user[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($user[0]->aktifby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <div class="btn-group" id="dropdown-icon">
                            <button type="button" class="<?= json('btn submit') ?> btnsubmit dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= json('submit') ?></button>
                            <ul class="dropdown-menu">
                                <li><button type="button" name="action" value="save" class="dropdown-item d-flex align-items-center btnsave" <?= $button['save'] ?>><?= lang('app.btn save') ?></button></li>
                                <li><button type="button" name="action" value="confirm" class="dropdown-item d-flex align-items-center btnsave" <?= $button['conf'] ?>><?= lang('app.btn konf') ?></button></li>
                                <li><button type="button" name="action" value="hapus" class="dropdown-item d-flex align-items-center btnsave" <?= $button['del'] ?>><?= lang('app.btn hapus') ?></button></li>
                                <li><button type="button" name="action" value="aktif" class="dropdown-item d-flex align-items-center btnsave" <?= $button['aktif'] ?>><?= $btnaktif ?></button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card footer  -->
        </div> <!--/ Card -->
    </div> <!--/ Column -->
</div> <!--/ Row-->
<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('#atasan').select2({
            ajax: {
                url: "<?= $link ?>/usernama",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pegawai: '',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= json('min input') ?>,
        });
    });

    $('.btnsave').click(function(e) {
        e.preventDefault();
        var form = $('.formmain')[0];
        var formData = new FormData(form);
        var resultPerusahaan = [];
        var resultWilayah = [];
        var resultDivisi = [];

        formData.getAll('daftarperusahaan[]').forEach(function(value) {
            var perusID = 'perus_' + value;
            var perusCheck = formData.has(perusID) ? 1 : 0;
            resultPerusahaan.push(value + ':' + perusCheck);
        });
        formData.getAll('daftarwilayah[]').forEach(function(value) {
            var wilID = 'wil_' + value;
            var wilCheck = formData.has(wilID) ? 1 : 0;
            resultWilayah.push(value + ':' + wilCheck);
        });
        formData.getAll('daftardivisi[]').forEach(function(value) {
            var divID = 'div_' + value;
            var divCheck = formData.has(divID) ? 1 : 0;
            resultDivisi.push(value + ':' + divCheck);
        });

        var aksesPerusahaan = resultPerusahaan.join(',');
        var aksesWilayah = resultWilayah.join(',');
        var aksesDivisi = resultDivisi.join(',');
        formData.append('aksesPerusahaan', aksesPerusahaan);
        formData.append('aksesWilayah', aksesWilayah);
        formData.append('aksesDivisi', aksesDivisi);
        var getAction = $(this).val();
        var url = '<?= $link ?>/save';
        formData.append('postaction', getAction);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btnsubmit').attr('disabled', 'disabled');
                $('.btnsubmit').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btnsubmit').removeAttr('disabled');
                $('.btnsubmit').each(function() {
                    $(this).html('<?= json('submit') ?>');
                });
            },
            success: function(response) {
                $('#atasan, #batas').removeClass('is-invalid');
                $('.erratasan, .errbatas').html('');
                if (response.error) {
                    handleFieldError('atasan', response.error.atasan);
                    handleFieldError('batas', response.error.batas);
                } else {
                    window.location.href = response.redirect;
                }

                function handleFieldError(field, error) {
                    if (error) {
                        $('#' + field).addClass('is-invalid');
                        $('.err' + field).html(error);
                    } else {
                        $('#' + field).removeClass('is-invalid');
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
        return false;
    })
</script>

<?= $this->endSection() ?>