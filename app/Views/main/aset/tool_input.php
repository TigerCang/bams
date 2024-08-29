<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'formmain']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">

        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= ($tool[0]->idunik ?? '') ?>" />
                <input type="hidden" name="namagambar" value="<?= ($tool[0]->gambar ?? 'default.png') ?>">

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="kode" name="kode" <?= (isset($tool[0]->kondisi[0]) && $tool[0]->kondisi[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.harus') ?>" maxlength="10" value="<?= ($tool[0]->kode ?? '') ?>" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" <?= ((isset($tool[0]->kondisi[0]) && $tool[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($tool[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="kategori" name="kategori" data-allow-clear="true" data-placeholder="<?= lang('app.pilihcr') ?>">
                                <option value="" <?= (isset($tool[0]->kategori) && $tool[0]->kategori == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selkategori as $db) : ?>
                                    <option value="<?= $db->kategori ?>" <?= (isset($tool[0]->kategori) && $tool[0]->kategori == $db->kategori ? 'selected' : '') ?>><?= $db->kategori ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kategori"><?= lang('app.kategori') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="jenis" name="jenis" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($tool[0]->jenis) && $tool[0]->jenis == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($seljenis as $db) : ?>
                                    <option value="<?= $db->jenis ?>" <?= (isset($tool[0]->jenis) && $tool[0]->jenis == $db->jenis ? 'selected' : '') ?>><?= $db->jenis ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="jenis"><?= lang('app.jenis') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="merk" name="merk" placeholder="" value="<?= ($tool[0]->merk ?? '') ?>" />
                            <label for="merk"><?= lang('app.merk') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="fakturlink" name="fakturlink" placeholder="" value="<?= ($tool[0]->nolink ?? '') ?>" />
                            <label for="fakturlink"><?= lang('app.faktur link') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card awal -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-8 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="faktur" name="faktur" placeholder="" value="<?= ($tool[0]->bukti ?? '') ?>" />
                            <label for="faktur"><?= lang('app.faktur') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="tglbeli" name="tglbeli" value="<?= ($tool[0]->tgl_beli ?? '') ?>" />
                            <label for="tglbeli"><?= lang('app.tanggal') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="nibeli" name="nibeli" placeholder="" value="<?= ($tool[0]->ni_beli ?? '') ?>" />
                            <label for="nibeli"><?= lang('app.nibeli') ?></label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="nisewa" name="nisewa" placeholder="" value="<?= ($tool[0]->ni_sewa ?? '') ?>" />
                            <label for="nisewa"><?= lang('app.nisewa') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="kbli" name="kbli" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($tool[0]->kbli_id) && $tool[0]->kbli_id == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($kbli as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($tool[0]->kbli_id) && $tool[0]->kbli_id == $db->id ? 'selected' : '') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kbli"><?= lang('app.kbli') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="biaya" name="biaya" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($biaya1) : ?> <option value="<?= $biaya1[0]->id ?>" selected data-subtext="<?= $biaya1[0]->nama ?>"><?= $biaya1[0]->kode ?></option><?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback errbiaya"></div>
                            <label for="biaya"><?= lang('app.sumber daya') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""><?= ($tool[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card keuangan -->
    </div> <!--/ Coloum kiri -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <img class="img-fluid img-preview" src="/assets/gambar/tool/<?= ($tool ? $tool[0]->gambar : 'default.png') ?>">
                    </div>
                    <div class="col-12 mb-2">
                        <input type="file" class="form-control" id="gambar" name="gambar" onchange="previewImage()" />
                        <div id="error" class="invalid-feedback errgambar"></div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card gambar -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="perusahaan" name="perusahaan" <?= (isset($tool[0]->kondisi[0]) && $tool[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($tool[0]->perusahaan_id) && $tool[0]->perusahaan_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][0] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['perusahaan']) ? '' : 'disabled') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="perusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="wilayah" name="wilayah" <?= ((isset($tool[0]->kondisi[0]) && $tool[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'disabled') : '') ?>>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($tool[0]->wilayah_id) && $tool[0]->wilayah_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][1] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="wilayah"><?= lang('app.wilayah') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="divisi" name="divisi" <?= (isset($tool[0]->kondisi[0]) && $tool[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($tool[0]->divisi_id) && $tool[0]->divisi_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][2] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="divisi"><?= lang('app.divisi') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card perusahaan-->
    </div> <!--/ Coloum kanan -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($tool[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($tool[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($tool[0]->aktifby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <?php if ($tool) : ?>
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

<div class="row" <?= ($tool ? '' : 'hidden') ?>>
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
                param: 'tool',
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

        $('#biaya').select2({
            ajax: {
                url: "<?= $link ?>/biaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        param: 'biayasd',
                        ruas: '0000',
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
                param: 'tool',
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
                $('#kode, #deskripsi, #biaya, #gambar').removeClass('is-invalid');
                $('.errkode, .errdeskripsi, .errbiaya, .errgambar').html('');
                if (response.error) {
                    handleFieldError('kode', response.error.kode);
                    handleFieldError('deskripsi', response.error.deskripsi);
                    handleFieldError('biaya', response.error.biaya);
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