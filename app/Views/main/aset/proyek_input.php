<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'formmain']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">

        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= ($proyek[0]->idunik ?? '') ?>" />

                <div class="row g-2">
                    <div class="col-9 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="kode" name="kode" <?= (isset($proyek[0]->kondisi[0]) && $proyek[0]->kondisi[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.harus') ?>" maxlength="10" value="<?= ($proyek[0]->kode ?? '') ?>" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                    <div class="col-0 col-md-4 col-lg-4"></div>
                    <div class="col-3 col-md-2 col-lg-2 mb-4">
                        <input type="checkbox" id="pajak" name="pajak" data-toggle="toggle" data-width="100%" <?= (isset($proyek[0]->is_pajak) && $proyek[0]->is_pajak == '1' ? 'checked' : '') ?> data-onlabel="<?= lang('app.pajak') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="success">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" <?= ((isset($proyek[0]->kondisi[0]) && $proyek[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($proyek[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.nama proyek') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="paket" name="paket" <?= ((isset($proyek[0]->kondisi[0]) && $proyek[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($proyek[0]->paket ?? '') ?>" />
                            <label for="paket"><?= lang('app.nama paket') ?></label>
                            <div id="error" class="invalid-feedback errpaket"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="atasnama" name="atasnama" placeholder="" value="<?= ($proyek[0]->atasnama ?? '') ?>" />
                            <label for="atasnama"><?= lang('app.atas nama') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="" value="<?= ($proyek[0]->lokasi ?? '') ?>" />
                            <label for="lokasi"><?= lang('app.lokasi') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="pemilik" name="pemilik" placeholder="" value="<?= ($proyek[0]->pemilik ?? '') ?>" />
                            <label for="pemilik"><?= lang('app.pemilik') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="lingkup" name="lingkup" placeholder="" value="<?= ($proyek[0]->lingkup ?? '') ?>" />
                            <label for="lingkup"><?= lang('app.lingkup') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="propinsi" name="propinsi" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>" onchange="loadKabupaten()">
                                <option value="" <?= (isset($proyek[0]->propinsi) && $proyek[0]->propinsi == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($propinsi as $db) : ?>
                                    <option value="<?= $db->propinsi ?>" <?= (isset($proyek[0]->propinsi) && $proyek[0]->propinsi == $db->propinsi ? 'selected' : '') ?>><?= $db->propinsi ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="propinsi"><?= lang('app.propinsi') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="kabupaten" name="kabupaten" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($proyek[0]->kabupaten) && $proyek[0]->kabupaten == '' ? 'selected' : '') ?>></option>
                            </select>
                            <label for="kabupaten"><?= lang('app.kabupaten') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="carabayar" name="carabayar" placeholder="" value="<?= ($proyek[0]->nama ?? '') ?>" />
                            <label for="carabayar"><?= lang('app.cara bayar') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kategori" name="kategori">
                                <?php foreach ($kategori as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($biaya[0]->kate_id) && $biaya[0]->kate_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kategori"><?= lang('app.kategori') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card awal -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglkontrak" name="tglkontrak" value="<?= ($proyek[0]->tgl_kontrak ?? '') ?>" />
                            <label for="tglkontrak"><?= lang('app.tanggal kontrak') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglpho" name="tglpho" value="<?= ($proyek[0]->tgl_pho ?? '') ?>" />
                            <label for="tglpho">PHO</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglfho" name="tglfho" value="<?= ($proyek[0]->tgl_fho ?? '') ?>" />
                            <label for="tglfho">FHO</label>
                        </div>
                    </div>
                    <div class="col-3 col-md-2 col-lg-2 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="periode1" name="periode1" placeholder="" value="<?= ($proyek[0]->periode1 ?? '0') ?>" min="2025" max="2100" />
                            <label for="periode1"><?= lang('app.periode') ?></label>
                        </div>
                    </div>
                    <div class="col-3 col-md-2 col-lg-2 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="periode2" name="periode2" placeholder="" value="<?= ($proyek[0]->periode2 ?? '0') ?>" min="2025" max="2100" />
                            <label for="periode2"><?= lang('app.periode') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="kbli" name="kbli" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <?php foreach ($kbli as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($proyek[0]->kbli_id) && $proyek[0]->kbli_id == $db->id ? 'selected' : '') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="kbli"><?= lang('app.kbli') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="keuangan" name="keuangan" placeholder=""><?= ($proyek[0]->keuangan ?? '') ?></textarea>
                            <label for="keuangan"><?= lang('app.keuangan') ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/ Card tanggal -->
    </div><!--/ Coloum kiri -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="perusahaan" name="perusahaan" <?= (isset($proyek[0]->kondisi[0]) && $proyek[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($proyek[0]->perusahaan_id) && $proyek[0]->perusahaan_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][0] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['perusahaan']) ? '' : 'disabled') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="perusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="wilayah" name="wilayah" <?= ((isset($proyek[0]->kondisi[0]) && $proyek[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'disabled') : '') ?>>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($proyek[0]->wilayah_id) && $proyek[0]->wilayah_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][1] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="wilayah"><?= lang('app.wilayah') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="divisi" name="divisi" <?= (isset($proyek[0]->kondisi[0]) && $proyek[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($proyek[0]->divisi_id) && $proyek[0]->divisi_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][2] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
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
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nikontrak" name="nikontrak" placeholder="" value="<?= ($proyek[0]->ni_kontrak ?? '') ?>" onchange="hitungppn()" />
                            <label for="nikontrak"><?= lang('app.nikontrak') ?></label>
                            <div id="error" class="invalid-feedback errnikontrak"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nitbhkur" name="nitbhkur" placeholder="" value="<?= ($proyek[0]->ni_tambah ?? '') ?>" onchange="hitungppn()" />
                            <label for="nitbhkur"><?= lang('app.nilai+-') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nilain" name="nilain" placeholder="" value="<?= ($proyek[0]->ni_lain ?? '') ?>" onchange="hitungppn()" />
                            <label for="nilain"><?= lang('app.lain+-') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nibruto" name="nibruto" placeholder="" value="<?= ($proyek[0]->ni_bruto ?? '') ?>" />
                            <label for="nibruto"><?= lang('app.nibruto') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-4 col-md-2 col-lg-4 mb-4">
                        <div class="form-group row">
                            <div class="form-floating form-floating-outline">
                                <input type="number" step="0.01" class="form-control" id="ppnps" name="ppnps" placeholder="" value="<?= ($proyek[0]->ppn ?? '0') ?>" min="0" max="100" onchange="hitungppn()" />
                                <label for="ppnps"><?= lang('app.ppn') ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 col-md-4 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nippn" name="nippn" placeholder="" value="<?= ($proyek[0]->ni_ppn ?? '') ?>" onchange="hitungppn2()" />
                            <label for="nippn"><?= lang('app.nippn') ?></label>
                        </div>
                    </div>
                    <div class="col-4 col-md-2 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="number" step="0.01" class="form-control" id="pphps" name="pphps" placeholder="" value="<?= ($proyek[0]->pph ?? '0') ?>" min="0" max="100" onchange="hitungppn()" />
                            <label for="pphps"><?= lang('app.pph') ?></label>
                        </div>
                    </div>
                    <div class="col-8 col-md-4 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nipph" name="nipph" placeholder="" value="<?= ($proyek[0]->ni_pph ?? '') ?>" onchange="hitungppn2()" />
                            <label for="nipph"><?= lang('app.nipph') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-0 col-md-6 col-lg-0"></div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="ninetto" name="ninetto" placeholder="" value="<?= ($proyek[0]->ni_netto ?? '') ?>" />
                            <label for="ninetto"><?= lang('app.ninetto') ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Akhir card -->

    </div> <!--/ Coloum kanan -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="konsultan" name="konsultan" placeholder=""><?= ($proyek[0]->konsultan ?? '') ?></textarea>
                            <label for="konsultan"><?= lang('app.konsultan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="asuransi" name="asuransi" placeholder=""><?= ($proyek[0]->asuransi ?? '') ?></textarea>
                            <label for="asuransi"><?= lang('app.asuransi') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="pelaksanaan" name="pelaksanaan" placeholder=""><?= ($proyek[0]->pelaksanaan ?? '') ?></textarea>
                            <label for="pelaksanaan"><?= lang('app.pelaksanaan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""><?= ($proyek[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($proyek[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($proyek[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($proyek[0]->aktifby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <?php if ($proyek) : ?>
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

<div class="row" <?= ($proyek ? '' : 'hidden') ?>>
    <div class="col-sm-12">
        <div class="card-datatable table-responsive viewTabel"></div>
    </div>
</div>

<div class="modallampiran" style="display: none;"></div>

<script>
    function hitungppn() {
        document.getElementById('nikontrak').value = document.getElementById('nikontrak').value || '0,00';
        document.getElementById('ppnps').value = document.getElementById('ppnps').value || '0,00';
        document.getElementById('pphps').value = document.getElementById('pphps').value || '0,00';
        document.getElementById('nitbhkur').value = document.getElementById('nitbhkur').value || '0,00';
        document.getElementById('nilain').value = document.getElementById('nilain').value || '0,00';

        var kontrak = formatAngka(document.getElementById('nikontrak').value, 'nol');
        var persenppn = formatAngka(document.getElementById('ppnps').value, 'nol');
        var persenpph = formatAngka(document.getElementById('pphps').value, 'nol');
        var tbhkur = formatAngka(document.getElementById('nitbhkur').value, 'nol');
        var lain = formatAngka(document.getElementById('nilain').value, 'nol');
        var bruto = parseFloat(kontrak) + parseFloat(tbhkur) + parseFloat(lain);
        var ppn = (parseFloat(bruto) * parseFloat(persenppn)) / (100 + parseFloat(persenppn));
        var netto = parseFloat(bruto) - parseFloat(ppn)
        var pph = parseFloat(persenpph) / 100 * parseFloat(netto)

        $('#nibruto').val(formatAngka(bruto, 'rp'));
        $('#nippn').val(formatAngka(ppn, 'rp'));
        $('#ninetto').val(formatAngka(netto, 'rp'));
        $('#nipph').val(formatAngka(pph, 'rp'));
    }

    function hitungppn2() {
        document.getElementById('nippn').value = document.getElementById('nippn').value || '0,00';
        document.getElementById('nipph').value = document.getElementById('nipph').value || '0,00';
        var bruto = formatAngka(document.getElementById('nibruto').value, 'nol');
        var ppn = formatAngka(document.getElementById('nippn').value, 'nol');
        var netto = parseFloat(bruto) - parseFloat(ppn)
        $('#ninetto').val(formatAngka(netto, 'rp'));
    }

    function dataLampiran() {
        var getIdu = $("#idunik").val();
        $.ajax({
            url: "/lampiran/tabel",
            data: {
                idunik: getIdu,
                param: 'proyek',
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

    function loadKabupaten() {
        var getPropinsi = $("#propinsi").val();
        var getKabupaten = "<?= $proyek[0]->kabupaten ?? '' ?>";
        $.ajax({
            type: "POST",
            url: "/proyek/kabupaten",
            data: {
                propinsi: getPropinsi,
                kabupaten: getKabupaten
            },
            dataType: "json",
            success: function(response) {
                if (response.kabupaten) {
                    $("#kabupaten").html(response.kabupaten);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        dataLampiran();
        loadKabupaten();
    });

    $('.btnlampir').click(function(e) {
        e.preventDefault();
        var getIdu = $("#idunik").val();
        $.ajax({
            url: "/lampiran/input",
            data: {
                idunik: getIdu,
                param: 'proyek',
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
                $('#kode, #deskripsi, #paket, #nikontrak').removeClass('is-invalid');
                $('.errkode, .errdeskripsi, .errpaket, .errnikontrak').html('');
                if (response.error) {
                    handleFieldError('kode', response.error.kode);
                    handleFieldError('deskripsi', response.error.deskripsi);
                    handleFieldError('paket', response.error.paket);
                    handleFieldError('nikontrak', response.error.nikontrak);
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