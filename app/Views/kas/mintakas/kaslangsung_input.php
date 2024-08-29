<div onload="flashdata()"></div>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php
$actconf = 'disabled hidden';
$beda = '';
if ($kas && $kas[0]->user_id != $tuser['id']) $beda = 'disabled'; //jika beda matikan tombol save
$stat = ($kas[0]->status ?? '0');
$status = statuslabel('barangpo', $stat);
if ($kas && $kas[0]->status == 'c') { //jika blm diacc
    if ($kas[0]->is_sama == '0' && $kas[0]->peminta_id == $tuser['id']) $actconf = '';
}
$actsave = (preg_match("/$stat/i", '013c') ? '' : 'disabled');
$klik = (preg_match("/$stat/i", '013c') ? '' : 'klikini');
if ($klik == '') $klik = ($beda == '' ? '' : 'klikini');
?>

<?php
$actsave = '1';
$stat = ($kas[0]->status ?? '0');
$status = statuslabel('biayakas', $stat);
?>

<div class="page-body">
    <?= form_open('', ['class' => 'formkas']) ?>
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-sm-12">
            <input type="hidden" class="form-control" id="akses" name="akses" value="">
            <div class="invalid-feedback errakses alert background-danger" role="alert"></div>

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.header'); ?></h5>
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
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= ($kas[0]->perusahaan_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= ($kas[0]->wilayah_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= ($kas[0]->divisi_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idpenerima" name="idpenerima" value="<?= ($kas[0]->penerima_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="xlevel" name="xlevel" value="<?= $tuser['acc_setuju'] ?>">
                    <input type="hidden" class="form-control" id="iduser" name="iduser" value="<?= (($tuser['confpeg'] == '1' && $tuser['akpeg'] == '1') ? $tuser['id'] : '') ?>">
                    <input type="hidden" class="form-control" id="idpeminta" name="idpeminta">
                    <input type="hidden" class="form-control" id="xtujuan" name="xtujuan" value="<?= ($kas[0]->tujuan ?? '') ?>">
                    <input type="hidden" class="form-control" id="idbeban" name="idbeban" value="<?= ($kas[0]->beban_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="iditem" name="iditem">
                    <input type="hidden" class="form-control" id="idakun" name="idakun">
                    <input type="hidden" class="form-control" id="idtipe" name="idtipe" value="<?= ($kas && $kas[0]->tujuan == 'proyek' ? $beban1[0]->tipe_id : '') ?>">
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" <?= ($kas ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kui ?>" <?= (($kas && $kas[0]->perusahaan_id == $db->id) ? 'selected' : '') . ($tuser['act_perusahaan'] == '1' || preg_match("/,$db->id,/i", $tuser['perusahaan']) ? '' : 'disabled') ?>><?= $db->kode . ' => ' . $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errperusahaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" <?= ($kas ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kode ?>" <?= (($kas && $kas[0]->wilayah_id == $db->id) ? 'selected' : '') . ($tuser['act_wilayah'] == '1' || preg_match("/,$db->id,/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errwilayah"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" <?= ($kas ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kode ?>" <?= (($kas && $kas[0]->divisi_id == $db->id) ? 'selected' : '') . ($tuser['act_divisi'] == '1' || preg_match("/,$db->id,/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errdivisi"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.dokumen'); ?></h5>
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
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= ($kas[0]->nodoc ?? '') ?>">
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="revisi" class="col-sm-1 col-form-label"><?= lang('app.rev') ?></label>
                        <div class="col-sm-1">
                            <input type="text" readonly class="form-control" id="revisi" name="revisi" value="<?= ($kas[0]->revisi ?? '0') ?>">
                        </div>
                        <label for="tanggal" class="col-sm-1 col-form-label">&emsp;&emsp;&emsp;<?= lang('app.tanggal') ?></label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= ($kas[0]->tgl_minta ?? date('Y-m-d')) ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="peminta" class="col-sm-1 col-form-label"><?= lang('app.peminta') ?></label>
                        <div class="col-sm-4">
                            <select id="peminta" class="js-example-data-ajax" name="peminta" <?= ($kas && $kas[0]->status != '0' ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilihsr') ?></option>
                                <?php if ($user1) : ?> <option value="<?= $user1[0]->id ?>" selected><?= $user1[0]->kode . ' : ' . $user1[0]->namapeg ?></option><?php endif; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errpeminta"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="tujuan" class="col-sm-1 col-form-label"><?= lang('app.tujuan'); ?></label>
                        <div class="col-sm-2">
                            <select id="tujuan" class="js-example-basic-single" name="tujuan" <?= ($kas ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selbeban as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (($kas && $kas[0]->tujuan == $db->nama) ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="kodebeban" class="col-sm-1 col-form-label" id="labelbeban"><?= lang('app.tujuan') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodebeban" name="kodebeban" placeholder="<?= lang('app.harusisi'); ?>" value="<?= ($beban1[0]->kode ?? '') ?>">
                            <div id="error" class="invalid-feedback d-block errkodebeban"></div>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" <?= ($kas ? 'readonly' : '') ?> class="form-control" id="namabeban" name="namabeban" value="<?= ($beban1[0]->nama ?? '') ?>">
                                <span class="input-group-addon">
                                    <i class="icofont <?= ($kas ? 'icofont-link-alt' : 'icofont-search-alt-2') ?>" aria-hidden="true" <?= ($kas ? '' : 'onclick="klikbeban()"') ?>></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penerima" class="col-sm-1 col-form-label"><?= lang('app.penerima'); ?></label>
                        <div class="col-sm-11">
                            <select id="penerima" class="js-example-data-ajax" name="penerima">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                                <?php if ($penerima1) : ?> <option value="<?= $penerima1[0]->id ?>" selected><?= $penerima1[0]->kode . ' => ' . $penerima1[0]->nama ?></option><?php endif; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errpenerima"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.inputdata'); ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card <?= $klik ?>"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row" id="zruas">
                        <label for="ruas" class="col-sm-1 col-form-label"><?= lang('app.ruas'); ?></label>
                        <div class="col-sm-11">
                            <select id="ruas" class="js-example-basic-single" name="ruas">
                                <option value=""><?= lang('app.pilih-') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="zbiaya">
                        <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.item'); ?></label>
                        <div class="col-sm-11">
                            <select id="biaya" class="js-example-basic-single" name="biaya">
                                <option value=""><?= lang('app.pilih-') ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errbiaya"></div>
                        </div>
                    </div>
                    <div class="form-group row" id="zsd">
                        <label for="sumberdaya" class="col-sm-1 col-form-label"><?= lang('app.sumberdaya'); ?></label>
                        <div class="col-sm-11">
                            <select id="sumberdaya" class="js-example-data-ajax" name="sumberdaya">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errsumberdaya"></div>
                        </div>
                    </div>
                    <div class="form-group row" id="zakun">
                        <label for="akun" class="col-sm-1 col-form-label"><?= lang('app.noakun'); ?></label>
                        <div class="col-sm-11">
                            <select id="akun" class="js-example-basic-single" name="akun">
                                <option value=""><?= lang('app.pilih-') ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errakun"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah'); ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" onchange="hitungtotal()" />
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="harga" class="col-sm-1 col-form-label text-right"><?= lang('app.harga'); ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="harga" name="harga" onchange="hitungtotal()" />
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="total" class="col-sm-1 col-form-label text-right"><?= lang('app.total'); ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="total" name="total" placeholder="<?= lang('app.harusisi'); ?>" />
                            <div id="error" class="invalid-feedback d-block errtotal"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan'); ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi'); ?>"></textarea>
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
                                <button type="button" name="action" value="cetak" class="btn <?= lang('app.btncCetak') ?> btnconf"><?= lang('app.btnCetak') ?></button>
                                <button type="button" name="action" value="confirm" class="btn <?= lang('app.btncConfirm') ?> btnconf" <?= $actconf ?>><?= lang('app.btnConfirm') ?></button>
                                <button type="button" class="btn <?= lang('app.btncSave') ?> dropdown-toggle <?= $actsave ?>" data-toggle="dropdown"><?= lang('app.btnSave') ?></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php $style = ($beda == 'disabled' ? "style='pointer-events: none; opacity: 0.5;'" : ''); ?>
                                    <a class="dropdown-item" <?= $style ?> onclick="savedoc()"><?= lang('app.simpandoc') ?></a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" onclick="bataldoc()"><?= lang('app.bataldoc') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" <?= $beda ?> class="btn <?= lang('app.btncAdd') ?> btnadd" <?= $actsave ?>><?= lang('app.btnAdd') ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dt-responsive table-responsive tabelkas"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    var awal = "<?= $nodoc[0]->nama ?>";
    $("#perusahaan, #divisi, #wilayah").change(function() {
        $("#idperusahaan").val($("#perusahaan").val());
        $("#iddivisi").val($("#divisi").val());
        $("#idwilayah").val($("#wilayah").val());
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + '/' + $("#wilayah").find(':selected').data('kui') + '.' + $("#divisi").find(':selected').data('kui') + '/';
    });

    $("#peminta, #penerima, #tujuan, #ruas, #biaya, #sumberdaya, #akun").change(function() {
        if (this.id === 'peminta') {
            $("#idpeminta").val($("#peminta").val());
        } else if (this.id === 'penerima') {
            $("#idpenerima").val($("#penerima").val());
        } else if (this.id === 'tujuan') {
            const showElements = ['#zruas', '#zbiaya', '#zsd'];
            const hideElements = ['#zruas', '#zbiaya', '#zsd'];
            var translations = {
                null: "<?= lang('app.tujuan') ?>",
                proyek: "<?= lang('app.proyek') ?>",
                camp: "<?= lang('app.camp') ?>",
                alat: "<?= lang('app.alat') ?>",
                tool: "<?= lang('app.tool') ?>",
                tanah: "<?= lang('app.tanah') ?>",
            };
            $("#idbeban, #kodebeban, #namabeban, #iditem, #idakun").val("");
            $("select[name='sumberdaya']").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
            $("select[name='ruas'], select[name='biaya'], select[name='akun']").empty().append(`<option value=""><?= lang('app.pilih-') ?></option>`);
            $("#labelbeban").text(translations[$(this).val()]);
            $('#xtujuan').val($(this).val());
            if ($(this).val() === 'proyek') {
                showElements.forEach(id => $(id).removeAttr('hidden'));
                $('#zakun').attr('hidden', 'hidden');
            } else {
                hideElements.forEach(id => $(id).attr('hidden', 'hidden'));
                $('#zakun').removeAttr('hidden');
            }
        } else if (this.id === 'ruas') {
            loadanggaran();
            $("#iditem, #idakun").val("");
            $("select[name='sumberdaya']").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
        } else if (this.id === 'biaya') {
            $('#iditem').val($('#biaya :selected').data('idbiaya'));
            if ($('#xtujuan').val() === 'proyek' && $('#ruas').val() === '') $('#idakun').val($('#biaya :selected').data('akunbiaya'));
        } else if (this.id === 'sumberdaya') {
            // console.log($('#sumberdaya').find(':selected'));
            // console.log($('#sumberdaya').val());
            // console.log($("#sumberdaya :selected").text());
        } else if (this.id === 'akun') {
            $('#idakun').val($('#akun :selected').data('akunbiaya'));
        }
    });

    function setawal() {
        const showElements = ['#zruas', '#zbiaya', '#zsd'];
        const hideElements = ['#zruas', '#zbiaya', '#zsd'];
        var translations = {
            null: "<?= lang('app.tujuan') ?>",
            proyek: "<?= lang('app.proyek') ?>",
            camp: "<?= lang('app.camp') ?>",
            alat: "<?= lang('app.alat') ?>",
            tool: "<?= lang('app.tool') ?>",
            tanah: "<?= lang('app.tanah') ?>",
        };
        if ($("#tujuan").val() === 'proyek') {
            showElements.forEach(id => $(id).removeAttr('hidden'));
            $('#zakun').attr('hidden', 'hidden');
        } else {
            hideElements.forEach(id => $(id).attr('hidden', 'hidden'));
            $('#zakun').removeAttr('hidden');
        }
        $("#labelbeban").text(translations[$("#tujuan").val()]);
    }

    //hitungtotal
    function hitungtotal() {
        if (document.getElementById('jumlah').value === '') document.getElementById('jumlah').value = '0,0000'
        if (document.getElementById('harga').value === '') document.getElementById('harga').value = '0,00'
        var jumlah = formatAngka(document.getElementById('jumlah').value, 'nol');
        var harga = formatAngka(document.getElementById('harga').value, 'nol');
        var total = parseFloat(jumlah) * parseFloat(harga);
        $('#total').val(formatAngka(total, 'rp'));
    }

    function dataitemkas() {
        var getIDU = "<?= $idunik ?>";
        var getTujuan = $("#xtujuan").val();
        var basbprix = ($("#xtujuan").val() === 'proyek' ? '1000001a' : '0100001a');
        $.ajax({
            url: "/<?= $menu; ?>/tabkas",
            data: {
                idunik: getIDU,
                asal: '<?= $menu; ?>',
                tujuan: getTujuan,
                basbprix: basbprix,
            },
            dataType: "json",
            success: function(response) {
                $('.tabelkas').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikbeban() {
        var getPerusahaan = $("#perusahaan").val();
        var getWilayah = $("#wilayah").val();
        var getDivisi = $("#divisi").val();
        var getNama = $("#namabeban").val();
        var getTujuan = $("#tujuan").val();
        $.ajax({
            url: "/<?= $menu; ?>/beban",
            data: {
                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                divisi: getDivisi,
                isi: getNama,
                tujuan: getTujuan,
                wenbrako: '10011100',
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
        var getProyek = $("#idbeban").val();
        $.ajax({
            type: "POST",
            url: "/<?= $menu; ?>/ruas",
            data: {
                proyek: getProyek,
                pilih: 'ruas',
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#ruas").html(response.ruas);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function loadanggaran() {
        var getTujuan = $("#xtujuan").val();
        var getRuas = $("#ruas").val();
        var getBeban = $("#idbeban").val();
        var getTipe = $("#idtipe").val();
        var getTanggal = $("#tanggal").val();
        $.ajax({
            type: "POST",
            url: "/<?= $menu; ?>/anggaran",
            data: {
                tujuan: getTujuan,
                ruas: getRuas,
                beban: getBeban,
                tipe: getTipe,
                tanggal: getTanggal,
            },
            dataType: "json",
            success: function(response) {
                (response.tujuan === 'proyek') ? $("#biaya").html(response.anggaran): $("#akun").html(response.anggaran);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        setawal();
        dataitemkas();
        loadruas();
        loadanggaran();
        $("#peminta").change();
        // $("#peminta, #tujuan").trigger('change');

        $("#peminta").select2({
            ajax: {
                url: "/<?= $menu; ?>/peminta",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pegawai: '1',
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

        $("#penerima").select2({
            ajax: {
                url: "/<?= $menu; ?>/penerima",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '1111',
                        osm: '',
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
        })

        $("#sumberdaya").select2({
            ajax: {
                url: "/<?= $menu; ?>/sumberdaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: 'sumberdaya',
                        ruas: $("#ruas").val(),
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

        $('.btnadd').click(function(e) {
            e.preventDefault();
            var form = $('.formkas')[0];
            var formData = new FormData(form);
            var url = '/<?= $menu ?>/additem';
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
                    $('#akses, #perusahaan, #wilayah, #divisi, #peminta, #kodebeban, #penerima, #biaya, #sumberdaya, #akun, #total, #catatan').removeClass('is-invalid');
                    $('.errakses, .errperusahaan, .errwilayah, .errdivisi, .errpeminta, .errkodebeban, .errpenerima, .errbiaya, .errsumberdaya, .errakun, .errtotal, .errcatatan').html('');
                    if (response.error) {
                        handleFieldError('akses', response.error.akses);
                        handleFieldError('perusahaan', response.error.perusahaan);
                        handleFieldError('wilayah', response.error.wilayah);
                        handleFieldError('divisi', response.error.divisi);
                        handleFieldError('peminta', response.error.peminta);
                        handleFieldError('kodebeban', response.error.kodebeban);
                        handleFieldError('penerima', response.error.penerima);
                        handleFieldError('biaya', response.error.biaya);
                        handleFieldError('sumberdaya', response.error.sumberdaya);
                        handleFieldError('akun', response.error.akun);
                        handleFieldError('total', response.error.total);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        clearElements();
                        flashdata('success', response.sukses);
                        document.getElementById("nodoc").value = response.nodoc;
                        // document.getElementById("status").value = response.stat;
                        dataitemkas();
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
                        $("#perusahaan, #wilayah, #divisi, #tujuan").removeClass('is-invalid').attr('disabled', 'disabled');
                        $("#namabeban").attr('readonly', 'readonly');
                        $(".input-group-addon").html("<i class='icofont icofont-link-alt' aria-hidden='true'></i>");
                        $("select[name='biaya']").val('').trigger('change');
                        $("select[name='sumberdaya']").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("select[name='akun']").append(`<option value=""><?= lang('app.pilih-') ?></option>`);
                        $("#jumlah #harga, #total, #catatan").val("");
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

<?= $this->endSection(); ?>