<div onload="flashdata()"></div>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php
$actsave = '1';
$stat = ($anggaran[0]->status ?? '0');
$status = statuslabel('biayaang', $stat); ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formanggaran']) ?>
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
                <!--  -->
                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik ?>">
                    <input type="hidden" class="form-control" id="kui" name="kui">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= ($anggaran[0]->perusahaan_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= ($anggaran[0]->wilayah_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= ($anggaran[0]->divisi_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="xlevel" name="xlevel" value="<?= $tuser['acc_setuju'] ?>">
                    <input type="hidden" class="form-control" id="iduser" name="iduser" value="<?= (($tuser['confpeg'] == '1' && $tuser['akpeg'] == '1') ? $tuser['id'] : '') ?>">
                    <input type="hidden" class="form-control" id="idproyek" name="idproyek" value="<?= ($anggaran[0]->beban_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idruas" name="idruas" value="<?= ($anggaran[0]->ruas_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idtipe" name="idtipe" value="<?= ($proyek1[0]->tipe_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="noadd" name="noadd" value="<?= ($anggaran[0]->adendum ?? '1') ?>">
                    <input type="hidden" class="form-control" id="norev" name="norev" value="<?= ($anggaran[0]->revisi ?? '1') ?>">
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" <?= (($anggaran && $anggaran[0]->status != '0') ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kui ?>" <?= (($anggaran && $anggaran[0]->perusahaan_id == $db->id)  ? 'selected' : '') . ($tuser['act_perusahaan'] == '1' || preg_match("/,$db->id,/i", $tuser['perusahaan']) ? '' : 'disabled') ?>><?= $db->kode . ' => ' . $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errperusahaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" <?= (($anggaran && $anggaran[0]->status != '0') ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kode ?>" <?= (($anggaran && $anggaran[0]->wilayah_id == $db->id) ? 'selected' : '') . ($tuser['act_wilayah'] == '1' || preg_match("/,$db->id,/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errwilayah"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" <?= (($anggaran && $anggaran[0]->status != '0') ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kode ?>" <?= (($anggaran && $anggaran[0]->divisi_id == $db->id) ? 'selected' : '') . ($tuser['act_divisi'] == '1' || preg_match("/,$db->id,/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errdivisi"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.dokumen') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc') ?></label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= ($anggaran[0]->nodoc ?? '') ?>">
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="revisi" class="col-sm-1 col-form-label"><?= lang('app.rev') ?></label>
                        <div class="col-sm-1">
                            <input type="text" readonly class="form-control" id="revisi" name="revisi" value="<?= (($anggaran && $anggaran[0]->status != '0') ? $anggaran[0]->adendum . "." . $anggaran[0]->revisi : '') ?>">
                        </div>
                        <label for="status" class="col-sm-1 col-form-label">&emsp;&emsp;<?= lang('app.status') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="status" name="status" value="<?= $status['text'] ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="kodeproyek" class="col-sm-1 col-form-label"><?= lang('app.proyek') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodeproyek" name="kodeproyek" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($proyek1[0]->kode ?? '') ?>">
                            <div class="invalid-feedback errkodeproyek"></div>
                        </div>
                        <div class="col-sm-9 input-group">
                            <input type="text" <?= (($anggaran && $anggaran[0]->status != '0') ? 'readonly' : '') ?> class="form-control" id="namapaket" name="namapaket" value="<?= ($proyek1[0]->paket ?? '') ?>">
                            <span class="input-group-addon">
                                <i class="icofont <?= (($anggaran && $anggaran[0]->status != '0') ? 'icofont-link-alt' : 'icofont-search-alt-2') ?>" aria-hidden="true" <?= (($anggaran && $anggaran[0]->status != '0') ? '' : 'onclick="klikproyek()"') ?>></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ruas" class="col-sm-1 col-form-label"><?= lang('app.ruas') ?></label>
                        <div class="col-sm-11">
                            <select id="ruas" class="js-example-basic-single" name="ruas" <?= (($anggaran && $anggaran[0]->status != '0') ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php if ($ruas1) : ?> <option value="<?= $ruas1[0]->id ?>" selected><?= $ruas1[0]->kode . ' => ' . $ruas1[0]->nama ?></option><?php endif; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errruas"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="periode" class="col-sm-1 col-form-label"><?= lang('app.periode') ?></label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="tanggal1" name="tanggal1" value="<?= ($anggaran[0]->tanggal1 ?? date('Y-m-d')) ?>">
                        </div>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="tanggal2" name="tanggal2" value="<?= ($anggaran[0]->tanggal2 ?? date('Y-m-d')) ?>">
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="nibruto" class="col-sm-1 col-form-label"><?= lang('app.nibruto') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nibruto" name="nibruto" value="<?= ($proyek1[0]->ni_bruto ?? '') ?>" />
                        </div>
                        <label for="ninetto" class="col-sm-1 col-form-label">&emsp;&emsp;<?= lang('app.ninetto') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="ninetto" name="ninetto" value="<?= ($proyek1[0]->ni_netto ?? '') ?>" />
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.inputdata') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.itembiaya') ?></label>
                        <div class="col-sm-11">
                            <select id="biaya" class="js-example-data-ajax" name="biaya">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errbiaya"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" onchange="hitungtotal()" />
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="hgkontrak" class="col-sm-2 col-form-label text-right"><?= lang('app.hgkontrak') ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="hgkontrak" name="hgkontrak" onchange="hitungtotal()" />
                        </div>
                        <label for="hgkerja" class="col-sm-2 col-form-label text-right"><?= lang('app.hgkerja') ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="hgkerja" name="hgkerja" onchange="hitungtotal()" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kelin" class="col-sm-1 col-form-label"><?= lang('app.kelompok') ?></label>
                        <div class="col-sm-2">
                            <select id="kelin" class="js-example-basic-single" name="kelin">
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selnama as $db) : ?>
                                    <option value="<?= $db->nama ?>"><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errkelin"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="totalkontrak" class="col-sm-2 col-form-label text-right"><?= lang('app.totalkontrak') ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="totalkontrak" name="totalkontrak" placeholder="<?= lang('app.harusisi') ?>" />
                            <div class="invalid-feedback errtotalkontrak"></div>
                        </div>
                        <label for="totalkerja" class="col-sm-2 col-form-label text-right"><?= lang('app.totalkerja') ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="totalkerja" name="totalkerja" placeholder="<?= lang('app.harusisi') ?>" />
                            <div class="invalid-feedback errtotalkerja"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"></textarea>
                            <div class="invalid-feedback errcatatan"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="col-4">
                            <button type="button" class="btn <?= lang('app.btncLogaksi') ?> btnlog"><?= lang('app.btnLogaksi') ?></button>
                        </div>
                        <div class="col-4 text-center">
                            <div class="dropdown-primary dropdown">
                                <button type="button" name="action" value="cetak" class="btn <?= lang('app.btncCetak') ?>"><?= lang('app.btnCetak') ?></button>
                                <button type="button" class="btn <?= lang('app.btncSave') ?> dropdown-toggle <?= $actsave ?>" data-toggle="dropdown"><?= lang('app.btnSave') ?></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php $style = ((!$anggaran || $anggaran[0]->status == '0') ? "style='pointer-events: none; opacity: 0.5;'" : ''); ?>
                                    <a class="dropdown-item" onclick="savedoc()"><?= lang('app.simpandoc') ?></a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" <?= $style ?> onclick="bataldoc()"><?= lang('app.bataldoc') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" class="btn <?= lang('app.btncAdd') ?> btnadd" <?= $actsave ?>><?= lang('app.btnAdd') ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dt-responsive table-responsive tabelbiaya"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    var awal = "<?= $nodoc[0]->nama ?>";
    $("#ruas").on("change", () => $("#idruas").val($("#ruas").val()));
    $("#perusahaan, #divisi, #wilayah").change(function() {
        $("#idperusahaan").val($("#perusahaan").val());
        $("#iddivisi").val($("#divisi").val());
        $("#idwilayah").val($("#wilayah").val());
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + '/' + $("#wilayah").find(':selected').data('kui') + '.' + $("#divisi").find(':selected').data('kui') + '/';
    });

    function hitungtotal() {
        if (document.getElementById('jumlah').value === '') document.getElementById('jumlah').value = '0,0000'
        if (document.getElementById('hgkontrak').value === '') document.getElementById('hgkontrak').value = '0,00'
        if (document.getElementById('hgkerja').value === '') document.getElementById('hgkerja').value = '0,00'

        var jumlah = formatAngka(document.getElementById('jumlah').value, 'nol');
        var hgkontrak = formatAngka(document.getElementById('hgkontrak').value, 'nol');
        var hgkerja = formatAngka(document.getElementById('hgkerja').value, 'nol');
        var totalkontrak = parseFloat(jumlah) * parseFloat(hgkontrak);
        var totalkerja = parseFloat(jumlah) * parseFloat(hgkerja);
        $('#totalkontrak').val(formatAngka(totalkontrak, 'rp'));
        $('#totalkerja').val(formatAngka(totalkerja, 'rp'));
    }

    function dataitembiaya() {
        var getIDU = "<?= $idunik ?>";
        var getKategori = $("#idtipe").val();
        $.ajax({
            url: "/anggbiayal/tabbiaya",
            data: {
                idunik: getIDU,
                asal: 'biayal',
                katproyek: getKategori,
                bapmsacpkix: '1010111111a',
                menu: 'bl',
            },
            dataType: "json",
            success: function(response) {
                $('.tabelbiaya').html(response.data);
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
            url: "/anggbiayal/proyek",
            data: {
                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                divisi: getDivisi,
                isi: getNama,
                wenbrako: '10101000',
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

    function loadruas() {
        var getProyek = $("#idproyek").val();
        $.ajax({
            type: "POST",
            url: "/anggbiayal/ruas",
            data: {
                proyek: getProyek,
                pilih: 'ruas',
            },
            dataType: "json",
            success: function(response) {
                $("#ruas").html(response.ruas);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function savedoc() {
        var form = $('.formanggaran')[0];
        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: "/anggbiayal/savedoc",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                $('#akses, #perusahaan, #wilayah, #divisi, #kodeproyek, #ruas').removeClass('is-invalid');
                $('.errakses, .errperusahaan, .errwilayah, .errdivisi, .errkodeproyek, .errruas').html('');
                if (response.error) {
                    handleFieldError('akses', response.error.akses);
                    handleFieldError('perusahaan', response.error.perusahaan);
                    handleFieldError('wilayah', response.error.wilayah);
                    handleFieldError('divisi', response.error.divisi);
                    handleFieldError('kodeproyek', response.error.kodeproyek);
                    handleFieldError('ruas', response.error.ruas);
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
    }

    function bataldoc() {
        var getIDU = "<?= $idunik ?>";
        $.ajax({
            url: "/anggbiayal/modalbatal",
            data: {
                idunik: getIDU,
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

    // function bataldoc() {
    //     var getIDU = "<?= $idunik ?>";
    //     var getUser = $("#iduser").val();
    //     var getDokumen = $("#nodoc").val();
    //     $.ajax({
    //         type: "POST",
    //         url: "/anggbiayal/modalbatal",
    //         data: {
    //             idunik: getIDU,
    //             user: getUser,
    //             nodoc: getDokumen,
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.error) {
    //                 if (response.error.akses) {
    //                     $('#akses').addClass('is-invalid');
    //                     $('.errakses').html(response.error.akses);
    //                 } else {
    //                     $('#akses').removeClass('is-invalid');
    //                     $('.errakses').html('');
    //                 }
    //             } else {
    //                 window.location.href = response.redirect;
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText);
    //             alert(thrownError);
    //         }
    //     });
    // }

    $(document).ready(function() {
        $("#perusahaan").change();
        // loadruas();
        dataitembiaya();

        $("#biaya").select2({
            ajax: {
                url: "/anggbiayal/biaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    pilih = (document.getElementById("idruas").value === "" || document.getElementById("idtipe").value === "") ? "blank" : "biaya";
                    return {
                        searchTerm: params.term,
                        pilih: pilih,
                        ruas: $("#idruas").val(),
                        kategori: $("#idtipe").val(),
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
            var form = $('.formanggaran')[0];
            var formData = new FormData(form);
            var url = '/anggbiayal/additem';
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
                    $('.btnadd').html('<?= lang('app.btnAdd') ?>');
                },
                success: function(response) {
                    $('#akses, #perusahaan, #wilayah, #divisi, #kodeproyek, #ruas, #biaya, #totalkontrak, #totalkerja, #kelin, #catatan').removeClass('is-invalid');
                    $('.errakses, .errperusahaan, .errwilayah, .errdivisi, .errkodeproyek, .errruas, .errbiaya, .errtotalkontrak, .errtotalkerja, .errkelin, .errcatatan').html('');
                    if (response.error) {
                        handleFieldError('akses', response.error.akses);
                        handleFieldError('perusahaan', response.error.perusahaan);
                        handleFieldError('wilayah', response.error.wilayah);
                        handleFieldError('divisi', response.error.divisi);
                        handleFieldError('kodeproyek', response.error.kodeproyek);
                        handleFieldError('ruas', response.error.ruas);
                        handleFieldError('biaya', response.error.biaya);
                        handleFieldError('totalkontrak', response.error.totalkontrak);
                        handleFieldError('totalkerja', response.error.totalkerja);
                        handleFieldError('kelin', response.error.kelin);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        clearElements();
                        flashdata('success', response.sukses);
                        document.getElementById("status").value = response.stat;
                        dataitembiaya();
                    }

                    function handleFieldError(field, error) {
                        if (error) {
                            $('#' + field).addClass('is-invalid');
                            $('.err' + field).html(error);
                        } else {
                            $('#' + field).removeClass('is-invalid');
                        }
                    }

                    function clearElements() {
                        // $('#perusahaan, #wilayah, #divisi, #ruas').removeClass('is-invalid').attr('disabled', 'disabled');
                        // $('#namapaket').attr('readonly', 'readonly');
                        // $('.input-group-addon').html("<i class='icofont icofont-link-alt' aria-hidden='true'></i>");
                        $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("#jumlah, #hgkontrak, #hgkerja, #totalkontrak, #totalkerja, #catatan").val("");
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