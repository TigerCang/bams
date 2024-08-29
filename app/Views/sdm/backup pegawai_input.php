<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="page-body">
    <form action="/pegawai/save/<?= $idunik; ?>" id="myForm" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header <?= (empty($pegawai)) ? lang('app.bgInput') : lang('app.bgDetil'); ?>">
                        <h5><?= (empty($pegawai)) ? lang('app.inputdata') : lang('app.detildata'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <input type="hidden" class="form-control" name="gambarlama" value="<?= (old('gambarlama')) ? old('gambarlama') : ((empty(!$pegawai)) ? $pegawai['0']->gambar : 'default.png'); ?>">
                        <input type="hidden" class="form-control" id="aktif" name="aktif" value="<?= (old('aktif')) ? old('aktif') : ((empty(!$pegawai)) ? $pegawai['0']->is_aktif : '1'); ?>">
                        <input type="hidden" class="form-control" id="jk" name="jk" value="<?= (old('jk')) ? old('jk') : ((empty(!$pegawai)) ? $pegawai['0']->jenkel : ''); ?>">
                        <input type="hidden" class="form-control" id="idcamp" name="idcamp" value="<?= (old('idcamp')) ? old('idcamp') : ((empty(!$pegawai)) ? $pegawai['0']->cabang_id : ''); ?>">
                        <input type="hidden" class="form-control" id="idjabatan" name="idjabatan" value="<?= (empty(!$pegawai)) ? $pegawai['0']->jabatan_id : ''; ?>">
                        <div class="form-group row">
                            <label for="kode" class="col-sm-1 col-form-label"><?= lang('app.kode'); ?></label>
                            <div class="col-sm-4">
                                <input type="text" harusisi <?= (empty(!$pegawai)) ? ((($pegawai['0']->is_confirm == '1')) ? 'readonly' : '') : ''; ?> class="form-control text-uppercase <?= ($validation->hasError('kode')) ? 'is-invalid' : ''; ?>" id="kode" name="kode" maxlength="16" placeholder="<?= lang('app.min16kar'); ?>" value="<?= (old('kode')) ? old('kode') : ((empty(!$pegawai)) ? $pegawai['0']->kode : ''); ?>" autocomplete="off" autofocus>
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('kode'); ?>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="nip" class="col-sm-2 col-form-label"><?= lang('app.nip+'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" harusisi <?= (empty(!$pegawai)) ? (($pegawai['0']->is_confirm == '1') ? 'readonly' : '') : ''; ?> class="form-control nip <?= ($validation->hasError('nip')) ? 'is-invalid' : ''; ?>" id="nip" name="nip" placeholder="<?= lang('app.harusisi'); ?>" value="<?= (old('nip')) ? old('nip') : ((empty(!$pegawai)) ? $pegawai['0']->nip : ''); ?>" data-mask="99.99.9999" autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('nip'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-1 col-form-label"><?= lang('app.nama'); ?></label>
                            <div class="col-sm-11">
                                <input type="text" harusisi class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" placeholder="<?= lang('app.harusisi'); ?>" value="<?= (old('nama')) ? old('nama') : ((empty(!$pegawai)) ? $pegawai['0']->nama : ''); ?>" autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('nama'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan'); ?></label>
                            <div class="col-sm-11">
                                <select id="perusahaan" class="js-example-basic-single" name="perusahaan">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($perusahaan as $db) : ?>
                                        <option value="<?= $db->id; ?>" <?= (old('perusahaan') == $db->id) ? 'selected' : ((empty(!$pegawai)) ? ((($pegawai['0']->perusahaan_id == $db->id) && (old('perusahaan') == '')) ? 'selected' : '') : ''); ?> <?= ($tuser['akses_perusahaan'] == '1') ? '' : ((preg_match("/,$db->id,/i", $tuser['perusahaan'])) ? '' : 'disabled'); ?>><?= $db->kode . '&emsp;=>&emsp;' . $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('perusahaan'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah'); ?></label>
                            <div class="col-sm-4">
                                <select id="wilayah" class="js-example-basic-single" name="wilayah">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($wilayah as $db) : ?>
                                        <option value="<?= $db->id; ?>" <?= (old('wilayah') == $db->id) ? 'selected' : ((empty(!$pegawai)) ? ((($pegawai['0']->wilayah_id == $db->id) && (old('wilayah') == '')) ? 'selected' : '') : ''); ?> <?= ($tuser['akses_wilayah'] == '1') ? '' : ((preg_match("/,$db->id,/i", $tuser['wilayah'])) ? '' : 'disabled'); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('wilayah'); ?>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi'); ?></label>
                            <div class="col-sm-4">
                                <select id="divisi" class="js-example-basic-single" name="divisi">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($divisi as $db) : ?>
                                        <option value="<?= $db->id; ?>" <?= (old('divisi') == $db->id) ? 'selected' : ((empty(!$pegawai)) ? ((($pegawai['0']->divisi_id == $db->id) && (old('divisi') == '')) ? 'selected' : '') : ''); ?> <?= ($tuser['akses_divisi'] == '1') ? '' : ((preg_match("/,$db->id,/i", $tuser['divisi'])) ? '' : 'disabled'); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('divisi'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kodecamp" class="col-sm-1 col-form-label"><?= lang('app.cabang'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" readonly class="form-control" id="kodecamp" name="kodecamp" value="<?= (old('kodecamp')) ? old('kodecamp') : ((empty(!$camp1)) ? $camp1['0']->kode : ''); ?>">
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="namacamp" name="namacamp" value="<?= (old('namacamp')) ? old('namacamp') : ((empty(!$camp1)) ? $camp1['0']->nama : ''); ?>" autocomplete="off">
                                    <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="klikcamp()"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t4lahir" class="col-sm-1 col-form-label"><?= lang('app.t4lahir'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="t4lahir" name="t4lahir" value="<?= (old('t4lahir')) ? old('t4lahir') : ((empty(!$pegawai)) ? $pegawai['0']->t4lahir : ''); ?>" autocomplete="off">
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="tgllahir" class="col-sm-1 col-form-label"><?= lang('app.tgllahir'); ?></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" id="tgllahir" name="tgllahir" value="<?= (old('tgllahir')) ? old('tgllahir') : ((empty(!$pegawai)) ? $pegawai['0']->tgl_lahir : ''); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenkel" class="col-sm-1 col-form-label"><?= lang('app.jenkel'); ?></label>
                            <div class="col-sm-3 form-radio">
                                <div class="radio radiofill radio-primary radio-inline">
                                    <label>
                                        <input type="radio" name="jenkel" value="pria" <?= (old('jenkel') == "pria") ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->jenkel == "pria") && (old('jenkel') == '') ? 'checked' : '') : ''); ?>>
                                        <i class="helper"></i><?= lang('app.pria'); ?>
                                    </label>
                                </div>
                                <div class="radio radiofill radio-primary radio-inline">
                                    <label>
                                        <input type="radio" name="jenkel" value="wanita" <?= (old('jenkel') == "wanita") ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->jenkel == "wanita") && (old('jenkel') == '') ? 'checked' : '') : ''); ?>>
                                        <i class="helper"></i><?= lang('app.wanita'); ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                            <label for="goldarah" class="col-sm-1 col-form-label"><?= lang('app.goldarah'); ?></label>
                            <div class="col-sm-3">
                                <select id="goldarah" class="js-example-basic-single" name="goldarah">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($selgd as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= (old('goldarah') == $db->nama) ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->goldarah == $db->nama) && (old('goldarah') == '') ? 'selected' : '') : ''); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-1 col-form-label"><?= lang('app.alamat'); ?></label>
                            <div class="col-sm-11">
                                <textarea class="form-control" rows="3" id="alamat" name="alamat"><?= (old('alamat')) ? old('alamat') : ((empty(!$pegawai)) ? $pegawai['0']->alamat : ''); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kontak" class="col-sm-1 col-form-label"><?= lang('app.kontak'); ?></label>
                            <div class="col-sm-11">
                                <textarea class="form-control" rows="3" id="kontak" name="kontak"><?= (old('kontak')) ? old('kontak') : ((empty(!$pegawai)) ? $pegawai['0']->kontak : ''); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gambar" class="col-sm-1 col-form-label"><?= lang('app.gambar'); ?></label>
                            <div class="col-sm-7">
                                <input type="file" class="form-control <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" onchange="previewImage()" />
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('gambar'); ?>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3">
                                <img src="/assets/fileimg/pegawai/<?= (empty(!$pegawai)) ? $pegawai['0']->gambar : 'default.png'; ?>" class="img-thumbnail img-preview mx-auto my-auto d-block">
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div>
        </div><!-- Akhir .row -->
        <div class="row">
            <div class="col-sm-6">

                <div class="card">
                    <div class="card-header <?= (empty($pegawai)) ? lang('app.bgInput') : lang('app.bgDetil'); ?>">
                        <h5><?= lang('app.sim'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="jsim" class="col-sm-3 col-form-label"><?= lang('app.golong'); ?></label>
                            <div class="col-sm-9">
                                <select id="jsim" class="js-example-basic-single" name="jsim">
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($selkelsim as $db1) :
                                        echo "<optgroup label='" . $db1->kelompok . "'>";
                                        foreach ($selsim as $db) :
                                            if ($db->kelompok == $db1->kelompok) { ?>
                                                <option value="<?= $db->nama; ?>" <?= (old('jsim') == $db->nama) ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->jns_sim == $db->nama) && (old('jsim') == '') ? 'selected' : '') : ''); ?>><?= $db->nama; ?></option>
                                    <?php }
                                        endforeach;
                                        echo "</optgroup>";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nosim" class="col-sm-3 col-form-label"><?= lang('app.nomor'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nosim" name="nosim" value="<?= (old('nosim')) ? old('nosim') : ((empty(!$pegawai)) ? $pegawai['0']->nosim : ''); ?>" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tglsim" class="col-sm-3 col-form-label"><?= lang('app.tanggal'); ?></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tglsim" name="tglsim" value="<?= (old('tglsim')) ? old('tglsim') : ((empty(!$pegawai)) ? $pegawai['0']->tgl_sim : ''); ?>">
                            </div>
                        </div>
                    </div>
                </div> <!-- Akhir .card -->

            </div> <!-- Akhir Kolom kiri -->
            <div class="col-sm-6">

                <div class="card">
                    <div class="card-header <?= (empty($pegawai)) ? lang('app.bgInput') : lang('app.bgDetil'); ?>">
                        <h5><?= lang('app.ijazah'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="ijazah" class="col-sm-3 col-form-label"><?= lang('app.ijazah'); ?></label>
                            <div class="col-sm-9">
                                <select id="ijazah" class="js-example-basic-single" name="ijazah">
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($selijasah as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= (old('ijazah') == $db->nama) ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->ijasah == $db->nama) && (old('ijazah') == '') ? 'selected' : '') : ''); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jurusan" class="col-sm-3 col-form-label"><?= lang('app.jurusan'); ?></label>
                            <div class="col-sm-9">
                                <select id="jurusan" class="js-example-tokenizer" name="jurusan">
                                    <option value=""><?= lang('app.pilihcr'); ?></option>
                                    <?php foreach ($jurusan as $db) : ?>
                                        <option value="<?= $db->jurusan; ?>" <?= (old('jurusan') == $db->jurusan) ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->jurusan == $db->jurusan) && (old('jurusan') == '') ? 'selected' : '') : ''); ?>><?= $db->jurusan; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="statusijazah" class="col-sm-3 col-form-label"><?= lang('app.status'); ?></label>
                            <div class="col-sm-9">
                                <select id="statusijazah" class="js-example-basic-single" name="statusijazah">
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($selstatijasah as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= (old('statusijazah') == $db->nama) ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->st_ijasah == $db->nama) && (old('statusijazah') == '') ? 'selected' : '') : ''); ?>><?= lang('app.' . $db->nama); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tglijazah" class="col-sm-3 col-form-label"><?= lang('app.tanggal'); ?></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tglijazah" name="tglijazah" value="<?= (old('tglijazah')) ? old('tglijazah') : ((empty(!$pegawai)) ? $pegawai['0']->tgl_ijasah : ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- Akhir Kolom kanan -->
        </div> <!-- Akhir .row -->
        <div class="row">
            <div class="col-sm-6">

                <div class="card">
                    <div class="card-header <?= (empty($pegawai)) ? lang('app.bgInput') : lang('app.bgDetil'); ?>">
                        <h5><?= lang('app.mulai'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="statuspeg" class="col-sm-3 col-form-label"><?= lang('app.status'); ?></label>
                            <div class="col-sm-9">
                                <select id="statuspeg" class="js-example-basic-single" name="statuspeg">
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($selstatpegawai as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= (old('statuspeg') == $db->nama) ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->st_pegawai == $db->nama) && (old('statuspeg') == '') ? 'selected' : '') : ''); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgljoin" class="col-sm-3 col-form-label"><?= lang('app.tglgabung'); ?></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tgljoin" name="tgljoin" value="<?= (old('tgljoin')) ? old('tgljoin') : ((empty(!$pegawai)) ? $pegawai['0']->tgl_join : ''); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tglawal" class="col-sm-3 col-form-label"><?= lang('app.awalkontrak'); ?></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tglawal" name="tglawal" value="<?= (old('tglawal')) ? old('tglawal') : ((empty(!$pegawai)) ? $pegawai['0']->tgl_kontrakawal : ''); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tglakhir" class="col-sm-3 col-form-label"><?= lang('app.akhirkontrak'); ?></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tglakhir" name="tglakhir" value="<?= (old('tglakhir')) ? old('tglakhir') : ((empty(!$pegawai)) ? $pegawai['0']->tgl_kontrakakhir : ''); ?>">
                            </div>
                        </div>
                    </div>
                </div> <!-- Akhir .card -->

            </div> <!-- Akhir Kolom kiri -->
            <div class="col-sm-6">

                <div class="card">
                    <div class="card-header <?= (empty($pegawai)) ? lang('app.bgInput') : lang('app.bgDetil'); ?>">
                        <h5><?= lang('app.akhir'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="modkeluar" class="col-sm-3 col-form-label"><?= lang('app.pilihan'); ?></label>
                            <div class="col-sm-9">
                                <select id="modkeluar" class="js-example-basic-single" name="modkeluar">
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($selmodkeluar as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= (old('modkeluar') == $db->nama) ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->mode_keluar == $db->nama) && (old('modkeluar') == '') ? 'selected' : '') : ''); ?>><?= lang('app.' . $db->nama); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tglkeluar" class="col-sm-3 col-form-label"><?= lang('app.tanggal'); ?></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tglkeluar" name="tglkeluar" value="<?= (old('tglkeluar')) ? old('tglkeluar') : ((empty(!$pegawai)) ? $pegawai['0']->tgl_keluar : ''); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alasan" class="col-sm-3 col-form-label"><?= lang('app.alasan'); ?></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" id="alasan" name="alasan"><?= (old('alasan')) ? old('alasan') : ((empty(!$pegawai)) ? $pegawai['0']->alasan_keluar : ''); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div><!-- Akhir Kolom kanan -->
        </div>
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header <?= (empty($pegawai)) ? lang('app.bgInput') : lang('app.bgDetil'); ?>">
                        <h5><?= lang('app.data+'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="kelakun" class="col-sm-1 col-form-label"><?= lang('app.kelakun'); ?></label>
                            <div class="col-sm-4">
                                <select id="kelakun" class="js-example-basic-single" name="kelakun">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($kelakun as $db) : ?>
                                        <option value="<?= $db->id; ?>" <?= (old('kelakun') == $db->id) ? 'selected' : ((empty(!$pegawai)) ? ((($pegawai['0']->kakun_id == $db->id) && (old('kelakun') == '')) ? 'selected' : '') : ''); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('kelakun'); ?>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="statusptkp" class="col-sm-1 col-form-label"><?= lang('app.ptkp'); ?></label>
                            <div class="col-sm-4">
                                <select id="statusptkp" class="js-example-basic-single" name="statusptkp">
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($selkelptkp as $db1) :
                                        echo "<optgroup label='" . $db1->kelompok . "'>";
                                        foreach ($selptkp as $db) :
                                            if ($db->kelompok == $db1->kelompok) { ?>
                                                <option value="<?= $db->nama; ?>" <?= (old('statusptkp') == $db->nama) ? 'selected' : ((empty(!$pegawai)) ? (($pegawai['0']->st_ptkp == $db->nama) && (old('statusptkp') == '') ? 'selected' : '') : ''); ?>><?= $db->nama; ?></option>
                                    <?php }
                                        endforeach;
                                        echo "</optgroup>";
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="golongan" class="col-sm-1 col-form-label"><?= lang('app.golpeg'); ?></label>
                            <div class="col-sm-4">
                                <select id="golongan" class="js-example-basic-single" name="golongan">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($golongan as $db) : ?>
                                        <option value="<?= $db->id; ?>" <?= (old('golongan') == $db->id) ? 'selected' : ((empty(!$pegawai)) ? ((($pegawai['0']->golongan_id == $db->id) && (old('golongan') == '')) ? 'selected' : '') : ''); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('golongan'); ?>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="jabatan" class="col-sm-1 col-form-label"><?= lang('app.jabatan'); ?></label>
                            <div class="col-sm-4">
                                <select id="jabatan" <?= (empty(!$pegawai)) ? (($pegawai['0']->is_confirm == '1') ? 'disabled' : '') : ''; ?> class="js-example-basic-single" name="jabatan">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($jabatan as $db) : ?>
                                        <option value="<?= $db->id; ?>" <?= (old('jabatan') == $db->id) ? 'selected' : ((empty(!$pegawai)) ? ((($pegawai['0']->jabatan_id == $db->id) && (old('jabatan') == '')) ? 'selected' : '') : ''); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('jabatan'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="surel" class="col-sm-1 col-form-label"><?= lang('app.surel'); ?></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="surel" name="surel" value="<?= (old('surel')) ? old('surel') : ((empty(!$pegawai)) ? $pegawai['0']->email : ''); ?>" autocomplete="off">
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="userid" class="col-sm-1 col-form-label"><?= lang('app.username'); ?></label>
                            <div class="col-sm-4">
                                <select id="userid" class="js-example-data-ajax <?= ($validation->hasError('userid')) ? 'is-invalid' : ''; ?>" name="userid">
                                    <option value="" selected="true"><?= lang('app.pilihsr'); ?></option>
                                    <?php if (empty(!$user1)) {
                                        echo "<option value='" . $user1['0']->id . "' selected='selected'>" . $user1['0']->kode . "</option>";
                                    } ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('userid'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="atasan" class="col-sm-1 col-form-label"><?= lang('app.atasan'); ?></label>
                            <div class="col-sm-11">
                                <select id="atasan" class="js-example-data-ajax" name="atasan">
                                    <option value="" selected="selected"><?= lang('app.pilihsr'); ?></option>
                                    <?php if (empty(!$pegawai1)) {
                                        echo "<option value='" . $pegawai1['0']->id . "' selected='selected'>" . $pegawai1['0']->kode . ' => ' . $pegawai1['0']->nip . ' => ' . $pegawai1['0']->nama . "</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="asuransi" class="col-sm-1 col-form-label"><?= lang('app.asuransi'); ?></label>
                            <div class="col-sm-11">
                                <textarea class="form-control" rows="3" id="asuransi" name="asuransi"><?= (old('asuransi')) ? old('asuransi') : ((empty(!$pegawai)) ? $pegawai['0']->asuransi : ''); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan'); ?></label>
                            <div class="col-sm-11">
                                <textarea harusisi class="form-control <?= ($validation->hasError('catatan')) ? 'is-invalid' : ''; ?>" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi'); ?>"><?= (old('catatan')) ? old('catatan') : ((empty(!$pegawai)) ? $pegawai['0']->catatan : ''); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('catatan'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" <?= (empty($pegawai)) ? 'hidden' : ''; ?>>
                            <label for="status" class="col-sm-1 col-form-label"><?= lang('app.status'); ?></label>
                            <div class="col-sm-5 d-inline">
                                <input class="switch bs-switch" data="aktif" type="checkbox" <?= (old('aktif') || old('aktif') == '0') ? ((old('aktif') == '1') ? 'checked' : '') : ((empty(!$pegawai)) ? (($pegawai['0']->is_aktif == '1') ? 'checked' : '') : 'checked'); ?> data-on-text="<?= lang('app.aktif'); ?>" data-off-text="<?= lang('app.noaktif'); ?>" data-on-color="success" data-off-color="danger">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                <button <?= (empty($pegawai)) ? 'hidden' : ''; ?> type="button" class="btn <?= lang('app.btnLampir'); ?> <?= ($tuser['act_edit'] == '0') ? 'disabled' : ''; ?> tambahlampiran"><?= lang('app.btn_Lampir'); ?></button>
                            </div>
                            <div>
                                <button <?= (empty(!$pegawai)) ? 'hidden' : ''; ?> type="reset" class="btn <?= lang('app.btnReset'); ?>"><?= lang('app.btn_Reset'); ?></button>
                                <a href="/pegawai/confirm/<?= $idunik; ?>" <?= (empty(!$pegawai)) ? '' : 'hidden'; ?> class="btn <?= lang('app.btnConfirm'); ?> <?= ($tuser['act_confirm'] == '0') ? 'disabled' : ''; ?> <?= (empty(!$pegawai)) ? (($pegawai['0']->is_confirm == '1') ? 'disabled' : '') : 'disabled'; ?> "><?= lang('app.btn_Confirm'); ?></a>
                                <button <?= (empty(!$pegawai)) ? '' : 'hidden'; ?> type="button" class="btn <?= lang('app.btnDelete'); ?>" <?= ($tuser['act_delete'] == '0') ? 'disabled' : ''; ?> data-toggle="modal" data-target="#modal-delete"><?= lang('app.btn_Delete'); ?></button>
                                <button type="submit" class="btn <?= (empty($pegawai)) ? lang('app.btnSave') : lang('app.btnUpdate'); ?>" <?= (empty(!$pegawai)) ? (($tuser['act_edit'] == '0') ? 'disabled' : '') : (($tuser['act_create'] == '0') ? 'disabled' : ''); ?>><?= (empty($pegawai)) ? lang('app.btn_Save') : lang('app.btn_Update'); ?></button>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div>
        </div>
    </form>
    <div class="row" <?= (empty($pegawai)) ? 'hidden' : ''; ?>>
        <div class="col-sm-12">
            <div class="dt-responsive table-responsive tabellampiran"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>
<div class="modalbeban" style="display: none;"></div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMdel'); ?>">
                <h4 class="modal-title"><?= lang('app.titlekonfdelete'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?= lang('app.tanyadel'); ?>&hellip; ?</p>
                <p><?= lang('app.infodel'); ?></p>
            </div>
            <div class="modal-footer">
                <form action="/pegawai/delete/<?= $idunik; ?>" method="POST" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn <?= lang('app.btnDelete'); ?>" data-toggle="modal" data-target="#modal-delete" name="delete"><?= lang('app.btn_Confya'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function klikcamp() {
        var getnama = $("#namacamp").val();
        $.ajax({
            url: "/pegawai/basecamp",
            type: "GET",
            data: {
                isi: getnama,
                perusahaan: '',
                wilayah: '',
                divisi: '',
                beban: '0',
            },
            dataType: "json",
            success: function(response) {
                $('.modalbeban').html(response.data).show();
                $('#modal-beban').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function datalampiran() {
        var getIDU = "<?= $idunik; ?>";
        $.ajax({
            url: "/pegawai/tablampir",
            data: {
                idunik: getIDU,
                xpilih: 'pegawai',
            },
            dataType: "json",
            success: function(response) {
                $('.tabellampiran').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        datalampiran();
        $('.tambahlampiran').click(function(e) {
            e.preventDefault();
            var getIDU = "<?= $idunik; ?>";
            $.ajax({
                url: "/pegawai/addlampir",
                data: {
                    idunik: getIDU,
                    xpilih: 'pegawai',
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

        $('input[type="radio"]').click(function() {
            var inputValue = $(this).attr("value");
            document.getElementById('jk').value = inputValue;
        });

        $("#atasan").select2({
            ajax: {
                url: "/pegawai/pegawai",
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
            <?= lang("app.inputminimum"); ?>,
        });

        $("#userid").select2({
            ajax: {
                url: "/pegawai/user",
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
            <?= lang("app.inputminimum"); ?>,
        });
    });
</script>

<?= $this->endSection(); ?>