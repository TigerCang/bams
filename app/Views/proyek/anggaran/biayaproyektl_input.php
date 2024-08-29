<div onload="flashdata()"></div>

<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php
$stat = "1" ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formbudget']) ?>
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-sm-12">
            <input type="hidden" class="form-control" id="akses" name="akses" value="">
            <div class="invalid-feedback errakses alert background-danger" role="alert"></div>

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.header') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik ?>">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= (empty($anggaran) ? old('idperusahaan') : $anggaran['0']->perusahaan_id) ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= (empty($anggaran) ? old('idwilayah') : $anggaran['0']->wilayah_id) ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= (empty($anggaran) ? old('iddivisi') : $anggaran['0']->divisi_id) ?>">
                    <input type="hidden" class="form-control" id="idproyek" name="idproyek" value="<?= (empty($anggaran) ? old('idproyek') : $anggaran['0']->tujuan_id) ?>">
                    <input type="hidden" class="form-control" id="noadd" name="noadd" value="<?= ($anggaran ? $anggaran['0']->noadendum : '1') ?>">
                    <input type="hidden" class="form-control" id="norev" name="norev" value="<?= ($anggaran ? $anggaran['0']->norevisi : '1') ?>">
                    <input type="hidden" class="form-control" id="pilihan" name="pilihan" value="pengeluaran">
                    <input type="hidden" class="form-control" id="tujuan" name="tujuan" value="proyek">
                    <input type="hidden" class="form-control" id="kodedoc" name="kodedoc" value="<?= $kodedoc['0']->nama ?>">

                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='perusahaan' class='js-example-basic-single' name='perusahaan'" . ($anggaran ? 'disabled' : '') . ">";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($perusahaan as $db) :
                                echo "<option value='{$db->id}' data-kui='{$db->kui}'" . ((old('perusahaan') == $db->id) || ($anggaran && $proyek1['0']->perusahaan_id == $db->id && empty(old('perusahaan')))  ? 'selected' : '') . " " . ($tuser['akses_perusahaan'] == '1' || preg_match("/,$db->id,/i", $tuser['perusahaan']) ? '' : 'disabled') . ">{$db->kode} => {$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errperusahaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='wilayah' class='js-example-basic-single' name='wilayah'" . ($anggaran ? 'disabled' : '') . ">";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($wilayah as $db) :
                                echo "<option value='{$db->id}' data-kui='{$db->kode}'" . ((old('wilayah') == $db->id) || ($anggaran && $proyek1['0']->wilayah_id == $db->id && empty(old('wilayah'))) ? 'selected' : '') . " " . ($tuser['akses_wilayah'] == '1' || preg_match("/,$db->id,/i", $tuser['wilayah']) ? '' : 'disabled') . ">{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errwilayah"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='divisi' class='js-example-basic-single' name='divisi'" . ($anggaran ? 'disabled' : '') . ">";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($divisi as $db) :
                                echo "<option value='{$db->id}' data-kui='{$db->kode}'" . ((old('divisi') == $db->id) || ($anggaran && $proyek1['0']->divisi_id == $db->id && empty(old('divisi'))) ? 'selected' : '') . " " . ($tuser['akses_divisi'] == '1' || preg_match("/,$db->id,/i", $tuser['divisi']) ? '' : 'disabled') . ">{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errdivisi"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.proyek') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="kodeproyek" class="col-sm-1 col-form-label"><?= lang('app.proyek') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodeproyek" name="kodeproyek" placeholder="<?= lang('app.harusisi') ?>" value="<?= (old('kodeproyek') ?? ($anggaran ? $proyek1['0']->kode : '')) ?>">
                            <div class="invalid-feedback errkodeproyek"></div>
                        </div>
                        <div class="col-sm-9 input-group">
                            <input type="text" <?= ($anggaran ? 'readonly' : '') ?> class="form-control" id="namapaket" name="namapaket" value="<?= (empty($anggaran) ? old('namapaket') : $proyek1['0']->paket) ?>">
                            <?= ($anggaran ? "<span class='input-group-addon'><i class='icofont icofont-link-alt' aria-hidden='true'></i></span>" : "<span class='input-group-addon'><i class='icofont icofont-search-alt-2' aria-hidden='true' onclick='klikproyek()'></i></span>") ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomoradd" class="col-sm-1 col-form-label"><?= lang('app.noadd') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="nomoradd" name="nomoradd" value="<?= ($anggaran && $anggaran['0']->st_confirm != '0' ? $anggaran['0']->noadendum . "." . $anggaran['0']->norevisi : '') ?>">
                        </div>
                        <div class="col-sm-3"></div>
                        <label for="nibruto" class="col-sm-1 col-form-label"><?= lang('app.nibruto') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nibruto" name="nibruto" value="<?= (empty($anggaran) ? old('nibruto') : $proyek1['0']->ni_bruto) ?>" />
                        </div>
                        <label for="ninetto" class="col-sm-1 col-form-label">&emsp;<?= lang('app.ninetto') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="ninetto" name="ninetto" value="<?= (empty($anggaran) ? old('ninetto') : $proyek1['0']->ni_netto) ?>" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc') ?></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= ($anggaran ? $anggaran['0']->nodoc : '') ?>">
                        </div>
                        <div class="col-sm-2 text-center"></div>
                        <label for="periode" class="col-sm-1 col-form-label"><?= lang('app.periode') ?></label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="tanggal1" name="tanggal1" value="<?= ($anggaran) ? $anggaran['0']->tanggal1 : date('Y-m-d') ?>">
                        </div>
                        <div class="col-sm-1 text-center"></div>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="tanggal2" name="tanggal2" value="<?= ($anggaran) ? $anggaran['0']->tanggal2 : date('Y-m-d') ?>">
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput') ?>">
                        <h5><?= lang('app.inputdata') ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.itembiaya') ?></label>
                            <div class="col-sm-11">
                                <?= "<select id='biaya' class='js-example-data-ajax' name='biaya'>";
                                echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                                echo "</select>"; ?>
                                <div id="error" class="invalid-feedback d-block errbiaya"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bulan" class="col-sm-1 col-form-label"><?= ucfirst(lang('app.bulan')) ?></label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="1" data-a-sep="." data-a-dec="," id="bulan" name="bulan" value="<?= old('bulan') ?>" onchange="hitungtotal()" />
                            </div>
                            <label for="jumlah" class="col-sm-1 col-form-label">&emsp;<?= lang('app.jumlah') ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" value="<?= old('jumlah') ?>" onchange="hitungtotal()" />
                            </div>
                            <label for="harga" class="col-sm-1 col-form-label">&emsp;<?= lang('app.harga') ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="harga" name="harga" value="<?= old('harga') ?>" onchange="hitungtotal()" />
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="total" class="col-sm-1 col-form-label">&emsp;<?= lang('app.total') ?></label>
                            <div class="col-sm-2">
                                <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="total" name="total" placeholder="<?= lang('app.harusisi') ?>" value="<?= old('total') ?>" />
                                <div class="invalid-feedback errtotal"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                            <div class="col-sm-11">
                                <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"><?= old('catatan') ?></textarea>
                                <div class="invalid-feedback errcatatan"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div class="col-4">
                                <?= "<button type='submit' class='btn " . lang('app.btnLoad') . " btnload'>" . lang('app.btn_Loadbudget') . "</button>"; ?>
                            </div>
                            <div class="col-4 text-center">
                                <div class="dropdown-primary dropdown">
                                    <?= "<button type='button' class='btn " . lang('app.btnCetak') . "'>" . lang('app.btn_Cetak') . "</button>";
                                    echo " <button type='button' class='btn " . lang('app.btnSave') . " dropdown-toggle " . (preg_match("/$stat/i", '013') ? '' : 'disabled') . "' " . (($anggaran && $anggaran['0']->st_confirm == '4') ? 'disabled' : '') . " data-toggle='dropdown'>" . lang('app.btn_Save') . "</button>";
                                    echo "<div class='dropdown-menu dropdown-menu-right'>";
                                    echo "<a class='dropdown-item' onclick='savedoc()'>" . lang('app.simpanangg') . "</a>";
                                    echo "<div role='separator' class='dropdown-divider'></div>";
                                    echo "<a class='dropdown-item' onclick='canceldoc()'>" . lang('app.batalangg') . "</a>";
                                    echo "</div>"; ?>
                                </div>
                            </div>
                            <div class="col-4 text-right">
                                <?= "<button type='submit' class='btn " . lang('app.btnAdd') . " btnadd'" . (preg_match("/$stat/i", '013') ? '' : 'disabled') . ">" . lang('app.btn_Add') . "</button>"; ?>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div>
        </div>
    </div>
    <?= form_close() ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dt-responsive table-responsive tabelbudget"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#perusahaan").on("change", () => $("#idperusahaan").val($("#perusahaan").val()));
    $("#wilayah").on("change", () => $("#idwilayah").val($("#wilayah").val()));
    $("#divisi").on("change", () => $("#iddivisi").val($("#divisi").val()));

    function hitungtotal() {
        if (document.getElementById('bulan').value === '') document.getElementById('bulan').value = '0'
        if (document.getElementById('jumlah').value === '') document.getElementById('jumlah').value = '0,0000'
        if (document.getElementById('harga').value === '') document.getElementById('harga').value = '0,00'

        var bulan = formatAngka(document.getElementById('bulan').value, 'nol');
        var jumlah = formatAngka(document.getElementById('jumlah').value, 'nol');
        var harga = formatAngka(document.getElementById('harga').value, 'nol');
        var total = parseFloat(bulan) * parseFloat(jumlah) * parseFloat(harga);
        $('#total').val(formatAngka(total, 'rp'));
    }

    function databudgetitem() {
        var getIDU = "<?= $idunik ?>";
        var getAsal = "<?= $asal ?>";
        $.ajax({
            url: "/anggproyekbtl/tabbudget",
            data: {
                idunik: getIDU,
                katproyek: '0',
                asal: getAsal,
                aksi: '1',
            },
            dataType: "json",
            success: function(response) {
                $('.tabelbudget').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikproyek() {
        var getPerusahaan = $("#perusahaan").val();
        var getWilayah = $("#wilayah").val();
        var getDivisi = $("#divisi").val();
        var getNama = $("#namapaket").val();
        $.ajax({
            url: "/anggproyekbtl/proyek",
            data: {
                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                divisi: getDivisi,
                isi: getNama,
                werbipakxo: '2000100000',
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

    function savedoc() {
        var getIDU = "<?= $idunik ?>";
        var getDoc = $("#nodoc").val();
        var getTgl1 = $("#tanggal1").val();
        var getTgl2 = $("#tanggal2").val();
        var getKodedoc = $("#kodedoc").val();
        var getAwal = $("#kodedoc").val() + '/' + $("#perusahaan").find(':selected').data('kui') + '/' + $("#wilayah").find(':selected').data('kui') + '.' + $("#divisi").find(':selected').data('kui') + '/';
        $.ajax({
            type: 'post',
            url: "/anggproyekbtl/savedoc",
            data: {
                idunik: getIDU,
                nodoc: getDoc,
                tanggal1: getTgl1,
                tanggal2: getTgl2,
                kodedoc: getKodedoc,
                awal: getAwal,
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    if (response.error.akses) {
                        $('#akses').addClass('is-invalid');
                        $('.errakses').html(response.error.akses);
                    } else {
                        $('#akses').removeClass('is-invalid');
                        $('.errakses').html('');
                    }
                } else {
                    window.location.href = '/anggproyekbtl';
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $('.btnload').click(function(e) {
        e.preventDefault();
        var form = $('.formbudget')[0];
        var formData = new FormData(form);
        var url = '/anggproyekbtl/loadbudget';
        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btnload').attr('disable', 'disabled');
                $('.btnload').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btnload').removeAttr('disable', 'disabled');
                $('.btnload').html('<?= lang('app.btn_Loadbudget'); ?>');
            },
            success: function(response) {
                $('#perusahaan, #wilayah, #divisi, #kodeproyek').removeClass('is-invalid');
                $('.errperusahaan, .errwilayah, .errdivisi, .errkodeproyek').html('');

                if (response.error) {
                    handleFieldError('perusahaan', response.error.perusahaan);
                    handleFieldError('wilayah', response.error.wilayah);
                    handleFieldError('divisi', response.error.divisi);
                    handleFieldError('kodeproyek', response.error.kodeproyek);
                } else {
                    if (response.ada) {
                        flashdata('info', response.ada);
                    } else {
                        flashdata('success', response.sukses);
                        databudgetitem();
                    }
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

    $(document).ready(function() {
        databudgetitem();

        $("#biaya").select2({
            ajax: {
                url: "/anggproyekbtl/biaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: 'biaya',
                        ruas: '',
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

        $('.btnadd').click(function(e) {
            e.preventDefault();
            var form = $('.formbudget')[0];
            var formData = new FormData(form);
            var url = '/anggproyekbtl/addbudget';
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnadd').attr('disable', 'disabled');
                    $('.btnadd').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnadd').removeAttr('disable');
                    $('.btnadd').html('<?= lang('app.btn_Add') ?>');
                },
                success: function(response) {
                    $('#akses, #perusahaan, #wilayah, #divisi, #kodeproyek, #biaya, #total, #catatan').removeClass('is-invalid');
                    $('.errakses, .errperusahaan, .errwilayah, .errdivisi, .errkodeproyek, .errbiaya, .errtotal, .errcatatan').html('');

                    if (response.error) {
                        handleFieldError('akses', response.error.akses);
                        handleFieldError('perusahaan', response.error.perusahaan);
                        handleFieldError('wilayah', response.error.wilayah);
                        handleFieldError('divisi', response.error.divisi);
                        handleFieldError('kodeproyek', response.error.kodeproyek);
                        handleFieldError('biaya', response.error.biaya);
                        handleFieldError('total', response.error.total);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        clearFieldsAndDisableElements();
                        flashdata('success', response.sukses);
                        databudgetitem();
                        $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        clearFieldValues();
                    }

                    function handleFieldError(field, error) {
                        if (error) {
                            $('#' + field).addClass('is-invalid');
                            $('.err' + field).html(error);
                        } else {
                            $('#' + field).removeClass('is-invalid');
                        }
                    }

                    function clearFieldsAndDisableElements() {
                        $('#perusahaan, #wilayah, #divisi').removeClass('is-invalid').attr('disabled', 'disabled');
                        $('#namapaket').attr('readonly', 'readonly');
                    }

                    function clearFieldValues() {
                        $("#bulan").val("");
                        $("#jumlah").val("");
                        $("#harga").val("");
                        $("#total").val("");
                        $("#catatan").val("");
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