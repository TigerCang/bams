<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- Page-body start -->
<div class="page-body">
    <form action="/itmk/save/<?= $idunik ?>" id="myForm" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header <?= ($revisi == 'n') ? lang('app.bgInput') : lang('app.bgDetil') ?>">
                        <h5><?= lang('app.header') ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik ?>">
                        <input type="hidden" class="form-control" id="kui" name="kui" value="<?= $nodoc['0']->nama . '/' . $perusahaan1['0']->kui . $wilayah1['0']->kode . '/' . $divisi1['0']->kode . '/' ?>">
                        <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= $perusahaan1['0']->id ?>">
                        <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= $wilayah1['0']->id ?>">
                        <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= $divisi1['0']->id ?>">
                        <input type="hidden" class="form-control" id="idpegawai" name="idpegawai" value="<?= $pegawai1['0']->id ?>">
                        <input type="hidden" class="form-control" name="gambarlama" value="<?= (old('gambarlama') ?? (empty(!$minta) ? $minta['0']->lampiran : 'default.png')) ?>">
                        <input type="hidden" class="form-control" id="tglak" name="tglak">

                        <div class="form-group row">
                            <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                            <div class="col-sm-11">
                                <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                    <?= "<option value=''>" . lang('app.pilih-') . "</option>";
                                    foreach ($perusahaan as $db) :
                                        echo "<option value='{$db->id}' data-kui='{$db->kui}'" . ((old('perusahaan') == $db->id) || ($perusahaan1['0']->id == $db->id && empty(old('perusahaan'))) ? 'selected' : '') . ">{$db->kode} => {$db->nama}</option>";
                                    endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                            <div class="col-sm-4">
                                <select id="wilayah" class="js-example-basic-single" name="wilayah" disabled>
                                    <?= "<option value=''>" . lang('app.pilih-') . "</option>";
                                    foreach ($wilayah as $db) :
                                        echo "<option value='{$db->id}' data-kui='{$db->kode}'" . ((old('wilayah') == $db->id) || ($wilayah1['0']->id == $db->id && empty(old('wilayah'))) ? 'selected' : '') . ">{$db->nama}</option>";
                                    endforeach ?>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                            <div class="col-sm-4">
                                <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                    <?= "<option value=''>" . lang('app.pilih-') . "</option>";
                                    foreach ($divisi as $db) :
                                        echo "<option value='{$db->id}' data-kui='{$db->kode}'" . ((old('divisi') == $db->id) || ($divisi1['0']->id == $db->id && empty(old('divisi'))) ? 'selected' : '') . ">{$db->nama}</option>";
                                    endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= ($revisi == 'n' ? lang('app.bgInput') : lang('app.bgDetil')) ?>">
                        <h5><?= lang('app.dokumen') ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc') ?></label>
                            <div class="col-sm-4">
                                <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= (empty(!$minta) ? $minta['0']->nodoc : '') ?>">
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                            <div class="col-sm-2">
                                <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= (empty(!$minta) ? $minta['0']->tgl_minta : date('Y-m-d')) ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pegawai" class="col-sm-1 col-form-label"><?= lang('app.pegawai') ?></label>
                            <div class="col-sm-11">
                                <select id="pegawai" class="js-example-data-ajax" name="pegawai" <?= (empty(!$minta) ? 'disabled' : '') ?>>
                                    <option value=""><?= lang('app.pilihsr') ?></option>
                                    <?= "<option value='{$pegawai1['0']->id}' selected>{$pegawai1['0']->kode} => {$pegawai1['0']->nama} </option>" ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block"><?= validation_show_error('pegawai') ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lampiran" class="col-sm-1 col-form-label"><?= lang('app.berkas') ?></label>
                            <div class="col-sm-11">
                                <input type="file" class="form-control <?= (validation_show_error('lampiran') ? 'is-invalid' : '') ?>" id="lampiran" name="lampiran">
                                <div class="invalid-feedback"><?= validation_show_error('lampiran') ?></div>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= ($revisi == 'n' ? lang('app.bgInput') : lang('app.bgDetil')) ?>">
                        <h5><?= lang('app.inputdata') ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="kategori" class="col-sm-1 col-form-label"><?= lang('app.kategori') ?></label>
                            <div class="col-sm-11">
                                <select id="kategori" class="js-example-basic-single" name="kategori">
                                    <?= "<option value=''>" . lang('app.pilih-') . "</option>";
                                    foreach ($kategori as $db) :
                                        echo "<option value='{$db->id}' data-lama='{$db->nilai}'" . ((old('kategori') == $db->id) || (empty(!$minta) && $minta['0']->cuti_id == $db->id && empty(old('minta'))) ? 'selected' : '') . ">{$db->nama}</option>";
                                    endforeach ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block"><?= validation_show_error('kategori') ?></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggalaw" class="col-sm-1 col-form-label"><?= lang('app.dari') ?></label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="tanggalaw" name="tanggalaw" value="<?= (old('tanggalaw') ?? (empty(!$minta) ? $minta['0']->tgl_cuti1 : date('Y-m-d'))) ?>">
                            </div>
                            <div class="col-sm-2">
                                <input type="date" class="form-control <?= (validation_show_error('tglak') ? 'is-invalid' : '') ?>" id="tanggalak" name="tanggalak" value="<?= (old('tanggalak') ?? (empty(!$minta) ? $minta['0']->tgl_cuti2 : date('Y-m-d'))) ?>">
                                <div class="invalid-feedback"><?= validation_show_error('tglak') ?></div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="lama" class="col-sm-1 col-form-label"><?= lang('app.lamawaktu') ?></label>
                            <div class="col-sm-1">
                                <input type="number" readonly class="form-control" id="lama" name="lama" value="<?= (old('lama') ?? (empty(!$minta) ? $minta['0']->lama : '0')) ?>" autocomplete="off">
                            </div>
                            <label class="col-sm-1 col-form-label"><?= lang('app.hari') ?></label>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                            <div class="col-sm-11">
                                <textarea harusisi class="form-control <?= (validation_show_error('catatan') ? 'is-invalid' : '') ?>" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"><?= (old('catatan') ?? (empty(!$minta) ? $minta['0']->catatan : '')) ?></textarea>
                                <div class="invalid-feedback"><?= validation_show_error('catatan') ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div class="col-4"></div>
                            <div class="col-4 text-center">
                                <?= "<button type='button' class='btn " . lang('app.btnCetak') . "'>" . lang('app.btn_Cetak') . "</button>";
                                echo " <button type='submit' class='btn " . lang('app.btnSave') . "'>" . lang('app.btn_Save') . "</button>"; ?>
                            </div>
                            <div class="col-4"></div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div>
        </div>
    </form>
</div><!-- body end -->

<script>
    // onchange = "loadpegawai()"
    $("#pegawai").change(loadpegawai);

    var awal = "<?= $nodoc['0']->nama ?>";
    $("#perusahaan, #kategori").change(function() {
        if (this.id === 'perusahaan') {
            document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        } else if (this.id === 'kategori') {
            document.getElementById('lama').value = $("#kategori").find(':selected').data('lama');
        }
    });

    function loadpegawai() {
        var getPegawai = $("#pegawai").val();
        $.ajax({
            type: "POST",
            url: "/itmk/detilpegawai",
            data: {
                pegawai: getPegawai,
            },
            dataType: "json",
            success: function(response) {
                if (response.pegawai) {
                    var dataPegawai = response.pegawai['0'];
                    $("#idperusahaan").val(dataPegawai.perusahaan_id);
                    $("#idwilayah").val(dataPegawai.wilayah_id);
                    $("#iddivisi").val(dataPegawai.divisi_id);
                    $("#idpegawai").val(dataPegawai.id);
                    $("#wilayah").val(dataPegawai.wilayah_id).trigger("change");
                    $("#divisi").val(dataPegawai.divisi_id).trigger("change");
                    $("#perusahaan").val(dataPegawai.perusahaan_id).trigger("change");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        $("#pegawai").select2({
            ajax: {
                url: "/itmk/pegawai",
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
            <?= lang("app.inputminimum") ?>,
        })
    });
</script>

<?= $this->endSection() ?>