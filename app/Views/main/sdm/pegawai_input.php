<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'formmain']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">

        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= ($pegawai[0]->idunik ?? '') ?>" />
                <input type="hidden" name="namagambar" value="<?= ($pegawai[0]->gambar ?? 'default.png') ?>">

                <div class="row g-2">
                    <div class="col-12 col-md-7 col-lg-7 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="kode" name="kode" <?= (isset($pegawai[0]->kondisi[0]) && $pegawai[0]->kondisi[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.harus') ?>" maxlength="16" value="<?= ($pegawai[0]->kode ?? '') ?>" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control nip" id="nip" name="nip" <?= ((isset($pegawai[0]->kondisi[0]) && $pegawai[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($pegawai[0]->nip ?? '') ?>" data-mask="99.99.9999" />
                            <label for="nip"><?= lang('app.nip+') ?></label>
                            <div id="error" class="invalid-feedback errnip"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" <?= ((isset($pegawai[0]->kondisi[0]) && $pegawai[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($pegawai[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-8 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="t4lahir" name="t4lahir" placeholder="" value="<?= ($pegawai[0]->t4lahir ?? '') ?>" />
                            <label for="t4lahir"><?= lang('app.t4lahir') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tgllahir" name="tgllahir" value="<?= ($pegawai[0]->tgl_lahir ?? '') ?>" />
                            <label for="tgllahir"><?= lang('app.tanggal lahir') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="surel" name="surel" placeholder="" value="<?= ($pegawai[0]->email ?? '') ?>" />
                            <label for="surel"><?= lang('app.surel') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kelamin" name="kelamin">
                                <option value="pria" <?= (isset($pegawai[0]->kelamin) && $pegawai[0]->kelamin == 'pria' ? 'selected' : '') ?>><?= lang('app.pria') ?></option>
                                <option value="wanita" <?= (isset($pegawai[0]->kelamin) && $pegawai[0]->kelamin == 'wanita' ? 'selected' : '') ?>><?= lang('app.wanita') ?></option>
                            </select>
                            <label for="kelamin"><?= lang('app.jenis kelamin') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="darah" name="darah" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($pegawai[0]->darah) && $pegawai[0]->darah == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($seldarah as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($pegawai[0]->darah) && $pegawai[0]->darah == $db->nama ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="darah"><?= lang('app.golongan darah') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="alamat" name="alamat" placeholder=""><?= ($pegawai[0]->alamat ?? '') ?></textarea>
                            <label for="alamat"><?= lang('app.alamat') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="kontak" name="kontak" placeholder=""><?= ($pegawai[0]->kontak ?? '') ?></textarea>
                            <label for="kontak"><?= lang('app.kontak') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="cabang" name="cabang" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($cabang1) : ?> <option value="<?= $cabang1[0]->id ?>" selected data-subtext="<?= $cabang1[0]->nama ?>"><?= $cabang1[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="cabang"><?= lang('app.cabang') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-8 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="" value="<?= ($pegawai[0]->lokasi ?? '') ?>" />
                            <label for="lokasi"><?= lang('app.lokasi') ?></label>
                        </div>
                    </div>
                    <div class="col-3 col-md-4 col-lg-4 mb-4">
                        <input type="checkbox" id="osm" name="osm" data-toggle="toggle" data-width="100%" <?= (isset($pegawai[0]->is_alias) && $pegawai[0]->is_alias[4] == '1' ? 'checked' : '') ?> data-onlabel="<?= lang('app.osm') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="primary">
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card awal -->
    </div> <!--/ Coloum kiri -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <img class="img-fluid img-preview" src="/assets/gambar/pegawai/<?= ($pegawai ? $pegawai[0]->gambar : 'default.png') ?>">
                    </div>
                    <div class="col-12 mb-2">
                        <input type="file" class="form-control" id="gambar" name="gambar" onchange="previewImage()" />
                        <div id="error" class="invalid-feedback errgambar"></div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card gambar -->
    </div> <!--/ Coloum kanan -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12 col-md-12 col-lg-4">

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="jenissim" name="jenissim" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($pegawai[0]->jenis_sim) && $pegawai[0]->jenis_sim == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selkelsim as $db1) : ?>
                                    <optgroup label="<?= $db1->kelompok ?>">
                                        <?php foreach ($selsim as $db) : ?>
                                            <?php if ($db->kelompok == $db1->kelompok) : ?> <option value="<?= $db->nama ?>" <?= (isset($pegawai[0]->jenis_sim) && $pegawai[0]->jenis_sim == $db->nama ? 'selected' : '') ?>><?= $db->nama ?></option><?php endif ?>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <label for="jenissim"><?= lang('app.sim') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglsim" name="tglsim" value="<?= ($pegawai[0]->tgl_sim ?? '') ?>" />
                            <label for="tglsim"><?= lang('app.tanggal habis') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="nosim" name="nosim" placeholder="" value="<?= ($pegawai[0]->nosim ?? '') ?>" />
                            <label for="nosim"><?= lang('app.nosim') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card identity -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="statpegawai" name="statpegawai" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($pegawai[0]->st_pegawai) && $pegawai[0]->st_pegawai == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selstatpegawai as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($pegawai[0]->st_pegawai) && $pegawai[0]->st_pegawai == $db->nama ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="statpegawai"><?= lang('app.status') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglgabung" name="tglgabung" value="<?= ($pegawai[0]->tgl_join ?? '') ?>" />
                            <label for="tglgabung"><?= lang('app.tanggal gabung') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglkontrakaw" name="tglkontrakaw" value="<?= ($pegawai[0]->tgl_kontrakaw ?? '') ?>" />
                            <label for="tglkontrakaw"><?= lang('app.awal kontrak') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglkontrakak" name="tglkontrakak" value="<?= ($pegawai[0]->tgl_kontrakak ?? '') ?>" />
                            <label for="tglkontrakak"><?= lang('app.akhir kontrak') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card kontrak -->
    </div> <!--/ Coloum kiri -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="ijasah" name="ijasah" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($pegawai[0]->ijasah) && $pegawai[0]->ijasah == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selijasah as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($pegawai[0]->ijasah) && $pegawai[0]->ijasah == $db->nama ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="ijasah"><?= lang('app.ijasah') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="jurusan" name="jurusan" data-allow-clear="true" data-placeholder="<?= lang('app.pilihcr') ?>">
                                <option value="" <?= (isset($pegawai[0]->jurusan) && $pegawai[0]->jurusan == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($seljurusan as $db) : ?>
                                    <option value="<?= $db->jurusan ?>" <?= (isset($pegawai[0]->jurusan) && $pegawai[0]->jurusan == $db->jurusan ? 'selected' : '') ?>><?= $db->jurusan ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="jurusan"><?= lang('app.jurusan') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="statijasah" name="statijasah" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($pegawai[0]->st_ijasah) && $pegawai[0]->st_ijasah == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selstatijasah as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($pegawai[0]->st_ijasah) && $pegawai[0]->st_ijasah == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="statijasah"><?= lang('app.status') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglijasah" name="tglijasah" value="<?= ($pegawai[0]->tgl_ijasah ?? '') ?>" />
                            <label for="tglijasah"><?= lang('app.tanggal') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card sertifikat -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="keluar" name="keluar" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($pegawai[0]->pilih_keluar) && $pegawai[0]->pilih_keluar == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selkeluar as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($pegawai[0]->pilih_keluar) && $pegawai[0]->pilih_keluar == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="keluar"><?= lang('app.keluar perusahaan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglkeluar" name="tglkeluar" value="<?= ($pegawai[0]->tgl_keluar ?? '') ?>" />
                            <label for="tglkeluar"><?= lang('app.tanggal') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="alasankeluar" name="alasankeluar" placeholder=""><?= ($pegawai[0]->alasan_keluar ?? '') ?></textarea>
                            <label for="alasankeluar"><?= lang('app.alasan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card out company -->
    </div> <!--/ Coloum tengah -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="perusahaan" name="perusahaan" <?= (isset($pegawai[0]->kondisi[0]) && $pegawai[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($pegawai[0]->perusahaan_id) && $pegawai[0]->perusahaan_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][0] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['perusahaan']) ? '' : 'disabled') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="perusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="wilayah" name="wilayah" <?= ((isset($pegawai[0]->kondisi[0]) && $pegawai[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'disabled') : '') ?>>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($pegawai[0]->wilayah_id) && $pegawai[0]->wilayah_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][1] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="wilayah"><?= lang('app.wilayah') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="divisi" name="divisi" <?= (isset($pegawai[0]->kondisi[0]) && $pegawai[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($pegawai[0]->divisi_id) && $pegawai[0]->divisi_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][2] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="divisi"><?= lang('app.divisi') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card perusahaan-->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="usernama" name="usernama">
                                <?php if ($user1) : ?> <option value="<?= $user1[0]->id ?>" selected data-subtext=" "><?= $user1[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="usernama"><?= lang('app.usernama') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="atasan" name="atasan">
                                <?php if ($atasan1) : ?> <option value="<?= $atasan1[0]->id ?>" selected data-subtext="<?= $atasan1[0]->nama ?>"><?= $atasan1[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="atasan"><?= lang('app.atasan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card user-->
    </div> <!--/ Coloum kanan -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kelakun" name="kelakun">
                                <?php foreach ($kelakun as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($pegawai[0]->kakun_pegawai) && $pegawai[0]->kakun_pegawai == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kelakun"><?= lang('app.kelompok akun') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="ptkp" name="ptkp" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($pegawai[0]->ptkp) && $pegawai[0]->ptkp == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selkelptkp as $db1) : ?>
                                    <optgroup label="<?= $db1->kelompok ?>">
                                        <?php foreach ($selptkp as $db) : ?>
                                            <?php if ($db->kelompok == $db1->kelompok) : ?> <option value="<?= $db->nama ?>" <?= (($pegawai && $pegawai[0]->st_ptkp == $db->nama) ? 'selected' : '') ?>><?= $db->nama ?></option><?php endif; ?>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                            <label for="ptkp">PTKP</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="jabatan" name="jabatan" <?= (isset($pegawai[0]->kondisi[0]) && $pegawai[0]->kondisi[0] == '1' ? ($tuser['act_akses'][8] == '1' ? '' : 'disabled') : '') ?>>
                                <?php foreach ($jabatan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($pegawai[0]->jabatan_id) && $pegawai[0]->jabatan_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="jabatan"><?= lang('app.jabatan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="golongan" name="golongan">
                                <?php foreach ($golongan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($pegawai[0]->golongan_id) && $pegawai[0]->golongan_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="golongan"><?= lang('app.golongan') ?></label>
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="asuransi" name="asuransi" placeholder=""><?= ($pegawai[0]->asuransi ?? '') ?></textarea>
                            <label for="asuransi"><?= lang('app.asuransi') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""><?= ($pegawai[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($pegawai[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($pegawai[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($pegawai[0]->aktifby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <?php if ($pegawai) : ?>
                            <button type="button" class="<?= json('btn lampir') ?> btnlampir"><?= json('btn ilampir') ?></button>
                        <?php endif ?>
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
            </div> <!--/ Card Footer -->
        </div> <!--/ Card akhir -->

    </div>
</div> <!--/ Row-->
<?= form_close() ?>

<div class="row" <?= ($pegawai ? '' : 'hidden') ?>>
    <div class="col-12">
        <div class="card-datatable table-responsive viewTabel"></div>
    </div>
</div>

<div class="modallampiran" style="display: none;"></div>

<script>
    function dataLampiran() {
        var getIdu = $("#idunik").val();
        $.ajax({
            url: "/lampiran/tabel",
            data: {
                idunik: getIdu,
                param: 'pegawai',
            },
            dataType: "json",
            success: function(response) {
                $('.viewTabel').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        dataLampiran();

        $('#cabang').select2({
            ajax: {
                url: "<?= $link ?>/cabang",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
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
            <?= json('template 1') ?>,
            <?= json('template 2') ?>,
        });

        $('#usernama').select2({
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

        $('#atasan').select2({
            ajax: {
                url: "<?= $link ?>/atasan",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '00010',
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
            <?= json('template 1') ?>,
            <?= json('template 2') ?>,
        });
    });

    $('.btnlampir').click(function(e) {
        e.preventDefault();
        var getIdu = $("#idunik").val();
        $.ajax({
            url: "/lampiran/input",
            data: {
                idunik: getIdu,
                param: 'pegawai',
            },
            dataType: "json",
            success: function(response) {
                $('.modallampiran').html(response.data).show();
                $('#modal-lampiran').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    $('.btnsave').click(function(e) {
        e.preventDefault();
        var form = $('.formmain')[0];
        var formData = new FormData(form);
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
                $('#kode, #nip, #deskripsi, #gambar').removeClass('is-invalid');
                $('.errkode, .errnip, .errdeskripsi, .errgambar').html('');
                if (response.error) {
                    handleFieldError('kode', response.error.kode);
                    handleFieldError('nip', response.error.nip);
                    handleFieldError('deskripsi', response.error.deskripsi);
                    handleFieldError('gambar', response.error.gambar);
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