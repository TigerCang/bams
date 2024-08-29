<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formfile']) ?>
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= ($inventaris ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= ($inventaris ? lang('app.detildata') : lang('app.inputdata')) ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" name="idunik" value="<?= $idunik ?>">
                    <input type="hidden" class="form-control" id="niaktif" name="niaktif" value="<?= (($inventaris && $inventaris[0]->is_aktif == '0') ? '1' : '0') ?>">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= ($inventaris[0]->perusahaan_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= ($inventaris[0]->wilayah_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= ($inventaris[0]->divisi_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idcamp" name="idcamp" value="<?= ($inventaris[0]->cabang_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idcamplama" name="idcamplama" value="<?= ($inventaris[0]->cabang_id ?? '') ?>">
                    <input type="hidden" class="form-control " id="umur" name="umur" value="<?= ($inventaris[0]->umur ?? '0') ?>">
                    <input type="hidden" class="form-control " id="sisa" name="sisa" value="<?= ($inventaris[0]->sisa ?? '0') ?>">
                    <input type="hidden" class="form-control" name="gambarlama" value="<?= ($inventaris[0]->gambar ?? 'default.png') ?>">
                    <div class="form-group row">
                        <label for="kode" class="col-sm-1 col-form-label"><?= lang('app.kode') ?></label>
                        <div class="col-sm-4">
                            <input type="text" harusisi <?= (($inventaris && $inventaris[0]->is_confirm != '0') ? 'readonly' : '') ?> class="form-control text-uppercase inventaris" id="kode" name="kode" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($inventaris[0]->kode ?? '') ?>" data-mask="aaa-a-aaa-999.999">
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-1 col-form-label"><?= lang('app.deskripsi') ?></label>
                        <div class="col-sm-11">
                            <input type="text" harusisi class="form-control" id="nama" name="nama" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($inventaris[0]->nama ?? '') ?>">
                            <div id="error" class="invalid-feedback errnama"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" <?= (($inventaris && $inventaris[0]->is_confirm != '0') ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (($inventaris && $inventaris[0]->perusahaan_id == $db->id) ? 'selected' : '') . ($tuser['act_perusahaan'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['perusahaan']) ? '' : 'disabled') ?>><?= "{$db->kode} => {$db->nama}" ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errperusahaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" <?= ($inventaris && $inventaris[0]->is_confirm != '0' && $tuser['act_super'] == '0' ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (($inventaris && $inventaris[0]->wilayah_id == $db->id) ? 'selected' : '') . ($tuser['act_wilayah'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errwilayah"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" <?= (($inventaris && $inventaris[0]->is_confirm != '0') ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (($inventaris && $inventaris[0]->divisi_id == $db->id) ? 'selected' : '') . ($tuser['act_divisi'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errdivisi"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kodecamp" class="col-sm-1 col-form-label"><?= lang('app.cabang') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodecamp" name="kodecamp" value="<?= ($camp1[0]->kode ?? '') ?>">
                            <div id="error" class="invalid-feedback errkodecamp"></div>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" <?= ($inventaris && $inventaris[0]->is_confirm != '0' && $tuser['act_super'] == '0' ? 'readonly' : '') ?> class="form-control" id="namacamp" name="namacamp" value="<?= ($camp1[0]->nama ?? '') ?>">
                                <?php if ($inventaris && $inventaris[0]->is_confirm != '0' && $tuser['act_super'] == '0') : ?><span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                                <?php else : ?><span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="klikcamp()"></i></span><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <div class="row">
        <div class="col-sm-9">

            <div class="card">
                <div class="card-header <?= ($inventaris ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= lang('app.keuangan') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="kelakun" class="col-sm-2 col-form-label"><?= lang('app.kelakun') ?></label>
                        <div class="col-sm-10">
                            <select id="kelakun" class="js-example-basic-single" name="kelakun">
                                <option value="" data-umur="0" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($kelakun as $db) : ?>
                                    <option value="<?= $db->id ?>" data-umur="<?= formatkoma($db->nilai, 0) ?>" <?= (($inventaris && $inventaris[0]->kakun_id == $db->id) ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errkelakun"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kategori" class="col-sm-2 col-form-label"><?= lang('app.kategori') ?></label>
                        <div class="col-sm-10">
                            <select id="kategori" class="js-example-tokenizer" name="kategori">
                                <option value=""><?= lang('app.pilihcr') ?></option>
                                <?php foreach ($katinv as $db) : ?>
                                    <option value="<?= $db->kategori ?>" <?= (($inventaris && $inventaris[0]->kategori == $db->kategori) ? 'selected' : '') ?>><?= $db->kategori ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="faktur" class="col-sm-2 col-form-label"><?= lang('app.faktur') ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="faktur" name="faktur" value="<?= ($inventaris[0]->bukti ?? '') ?>">
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="tglbeli" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tglbeli" name="tglbeli" value="<?= ($inventaris[0]->tgl_beli ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nibeli" class="col-sm-2 col-form-label"><?= lang('app.akuisisi') ?></label>
                        <div class="col-sm-4">
                            <input type="text" harusisi class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nibeli" name="nibeli" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($inventaris[0]->ni_beli ?? '') ?>" onchange="hitungsusut()">
                            <div id="error" class="invalid-feedback errnibeli"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="niresidu" class="col-sm-1 col-form-label"><?= lang('app.residu') ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="niresidu" name="niresidu" value="<?= ($inventaris[0]->ni_residu ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="msusut" class="col-sm-2 col-form-label"><?= lang('app.sistemsusut') ?></label>
                        <div class="col-sm-10">
                            <select id="msusut" class="js-example-basic-single" name="msusut">
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selnama as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (($inventaris && $inventaris[0]->modsusut == $db->nama) ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errmsusut"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nisusut" class="col-sm-2 col-form-label"><?= lang('app.susut') ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nisusut" name="nisusut" value="<?= ($inventaris[0]->ni_susut ?? '') ?>">
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="umurdet" class="col-sm-2 col-form-label"><?= lang('app.umuraset') ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-right" readonly id="umurdet" name="umurdet" value="<?= ($inventaris ? "{$inventaris[0]->sisa} / {$inventaris[0]->umur}" : '') ?>">
                        </div>
                    </div>
                </div>
            </div> <!-- Akhir card -->

            <div class="card">
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="linkpo" class="col-sm-2 col-form-label"><?= lang('app.linkpo') ?></label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="linkpo" name="linkpo" value="">
                        </div>
                    </div>
                </div>
            </div> <!-- Akhir card -->

        </div>
        <div class="col-sm-3">

            <div class="card">
                <div class="card-header <?= ($inventaris ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= lang('app.gambar') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <img src="/assets/fileimg/inventaris/<?= ($inventaris[0]->gambar ?? 'default.png') ?>" class="img-thumbnail img-preview mx-auto my-auto d-block">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="gambar" name="gambar" onchange="previewImage()" />
                            <div id="error" class="invalid-feedback errgambar"></div>
                        </div>
                    </div>
                </div>
            </div> <!-- Akhir card -->

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= ($inventaris ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= lang('app.data+') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="lokasi" class="col-sm-1 col-form-label"><?= lang('app.lokasi') ?></label>
                        <div class="col-sm-11">
                            <select id="lokasi" class="js-example-tokenizer" name="lokasi">
                                <option value=""><?= lang('app.pilihcr') ?></option>
                                <?php foreach ($lokasiinv as $db) : ?>
                                    <option value="<?= $db->lokasi ?>" <?= (($inventaris && $inventaris[0]->lokasi == $db->lokasi) ? 'selected' : '') ?>><?= $db->lokasi ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pegawai" class="col-sm-1 col-form-label"><?= lang('app.pegawai') ?></label>
                        <div class="col-sm-11">
                            <select id="pegawai" class="js-example-data-ajax" name="pegawai">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                                <?php if ($pegawai1) : ?> <option value="<?= $pegawai1[0]->id ?>" selected><?= "{$pegawai1[0]->kode} => {$pegawai1[0]->nama}" ?></option><?php endif; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errpegawai"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"><?= ($inventaris[0]->catatan ?? '') ?></textarea>
                            <div id="error" class="invalid-feedback errcatatan"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div></div>
                        <div>
                            <button type="reset" class="btn <?= lang('app.btncReset') ?>" <?= $btnhid ?>><?= lang('app.btnReset') ?></button>
                            <button type="button" name="action" value="aktif" class="btn <?= $btnclas2 ?> btnsave" <?= $actaktif ?>><?= $btntext2 ?></button>
                            <button type="button" name="action" value="confirm" class="btn <?= lang('app.btncConfirm') ?> btnsave" <?= $btnsama . $actconf ?>><?= lang('app.btnConfirm') ?></button>
                            <button type="button" name="action" value="save" class="btn <?= $btnclas1 ?> btnsave" <?= $actcreate ?>><?= $btntext1 ?></button>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.upby") . ' : ' . ($inventaris[0]->upby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.confby") . ' : ' . ($inventaris[0]->coby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.acby") . ' : ' . ($inventaris[0]->akby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#perusahaan").on("change", () => $("#idperusahaan").val($("#perusahaan").val()));
    $("#wilayah").on("change", () => $("#idwilayah").val($("#wilayah").val()));
    $("#divisi").on("change", () => $("#iddivisi").val($("#divisi").val()));
    $("#kelakun").change(function() {
        $("#umur").val($(this).find(':selected').data('umur'));
        $("#umurdet").val($("#sisa").val() + " / " + $(this).find(':selected').data('umur'));
    });

    function klikcamp() {
        var getPerusahaan = $("#perusahaan").val();
        var getWilayah = $("#wilayah").val();
        var getDivisi = $("#divisi").val();
        var getNama = $("#namacamp").val();
        $.ajax({
            url: "/inventaris/basecamp",
            data: {
                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                divisi: getDivisi,
                isi: getNama,
                wenbrako: '10000000',
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
    }

    function hitungsusut() {
        var beli = formatAngka(document.getElementById('nibeli').value, 'nol');
        var umur = formatAngka(document.getElementById('umur').value, 'nol');
        var susut = parseFloat(beli) / parseFloat(umur);
        $('#nisusut').val(formatAngka(susut, 'rp'));
    }

    $(document).ready(function() {
        $("#pegawai").select2({
            ajax: {
                url: "/inventaris/pegawai",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '0001',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum") ?>,
        });

        $('.btnsave').click(function(e) {
            e.preventDefault();
            var form = $('.formfile')[0];
            var formData = new FormData(form);
            var getAction = $(this).val();
            var url = '/inventaris/save';
            formData.append('postaction', getAction);
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsave').attr('disabled', 'disabled');
                    $('.btnsave').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsave').removeAttr('disabled');
                    $('.btnsave').each(function() {
                        var value = $(this).val();
                        if (value === 'aktif') {
                            $(this).html('<?= $btntext2 ?>');
                        } else if (value === 'confirm') {
                            $(this).html('<?= lang("app.btnConfirm") ?>');
                        } else if (value === 'save') {
                            $(this).html('<?= $btntext1 ?>');
                        }
                        $(this).attr('name', 'action');
                    });
                },
                success: function(response) {
                    $('#kode, #nama, #perusahaan, #wilayah, #divisi, #kodecamp, #kelakun, #nibeli, #msusut, #catatan, #gambar').removeClass('is-invalid');
                    $('.errkode, .errnama, .errperusahaan, .errwilayah, .errdivisi, .errkodecamp, .errkelakun, .errnibeli, .errmsusut, .errcatatan, .errgambar').html('');
                    if (response.error) {
                        handleFieldError('kode', response.error.kode);
                        handleFieldError('nama', response.error.nama);
                        handleFieldError('perusahaan', response.error.perusahaan);
                        handleFieldError('wilayah', response.error.wilayah);
                        handleFieldError('divisi', response.error.divisi);
                        handleFieldError('kodecamp', response.error.kodecamp);
                        handleFieldError('kelakun', response.error.kelakun);
                        handleFieldError('nibeli', response.error.nibeli);
                        handleFieldError('msusut', response.error.msusut);
                        handleFieldError('catatan', response.error.catatan);
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
    });
</script>

<?= $this->endSection() ?>