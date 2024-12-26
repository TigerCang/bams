<div onload="flashdata()"></div>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php
// $actsave = (preg_match("/$stat/i", '013c') ? '' : 'disabled');
$actsave = '1';
$stat = ($anggaran[0]->status ?? '0');
$status = statuslabel('biayaang', $stat);
?>
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
                    <input type="hidden" class="form-control" id="xpilih" name="xpilih" value="<?= ($anggaran[0]->pilihan ?? '') ?>">
                    <input type="hidden" class="form-control" id="xtujuan" name="xtujuan" value="<?= ($anggaran[0]->tujuan ?? '') ?>">
                    <input type="hidden" class="form-control" id="xjenis" name="xjenis" value="<?= ($anggaran[0]->jenis ?? '') ?>">
                    <input type="hidden" class="form-control" id="idbeban" name="idbeban" value="<?= ($anggaran[0]->beban_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="noadd" name="noadd" value="<?= ($anggaran[0]->adendum ?? '1') ?>">
                    <input type="hidden" class="form-control" id="norev" name="norev" value="<?= ($anggaran[0]->revisi ?? '1') ?>">
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" <?= ($anggaran ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kui ?>" <?= (($anggaran && $anggaran[0]->perusahaan_id == $db->id) ? 'selected' : '') . ($tuser['act_perusahaan'] == '1' || preg_match("/,$db->id,/i", $tuser['perusahaan']) ? '' : 'disabled') ?>><?= $db->kode . ' => ' . $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errperusahaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" <?= ($anggaran ? 'disabled' : '') ?>>
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
                            <select id="divisi" class="js-example-basic-single" name="divisi" <?= ($anggaran ? 'disabled' : '') ?>>
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
                            <input type="text" readonly class="form-control" id="revisi" name="revisi" value="<?= ($anggaran ? $anggaran[0]->adendum . "." . $anggaran[0]->revisi : '') ?>">
                        </div>
                        <label for="status" class="col-sm-1 col-form-label">&emsp;&emsp;<?= lang('app.status') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="status" name="status" value="<?= $status['text'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pilih" class="col-sm-1 col-form-label"><?= lang('app.pilihan') ?></label>
                        <div class="col-sm-4">
                            <select id="pilih" class="js-example-basic-single" name="pilih" <?= ($anggaran ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selnama as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (($anggaran && $anggaran[0]->pilihan == $db->nama) ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errpilih"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="tujuan" class="col-sm-1 col-form-label"><?= lang('app.tujuan') ?></label>
                        <div class="col-sm-4">
                            <select id="tujuan" class="js-example-basic-single" name="tujuan" <?= ($anggaran ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selbeban as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (($anggaran && $anggaran[0]->tujuan == $db->nama) ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="zjenis">
                        <div class="col-sm-7"></div>
                        <label for="jenis" class="col-sm-1 col-form-label"><?= lang('app.jenis') ?></label>
                        <div class="col-sm-4">
                            <select id="jenis" class="js-example-basic-single" name="jenis" <?= ($anggaran ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($kategori as $db) : ?>
                                    <option value="<?= $db->kode ?>" <?= (($anggaran && $anggaran[0]->jenis == $db->kode) ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="kodebeban" class="col-sm-1 col-form-label" id="labelbeban"><?= lang('app.camp') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodebeban" name="kodebeban" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($beban1[0]->kode ?? '') ?>">
                            <div class="invalid-feedback errkodebeban"></div>
                        </div>
                        <div class="col-sm-9 input-group">
                            <input type="text" <?= ($anggaran ? 'readonly' : '') ?> class="form-control" id="namabeban" name="namabeban" value="<?= ($beban1[0]->nama ?? '') ?>">
                            <span class="input-group-addon">
                                <i class="icofont <?= ($anggaran ? 'icofont-link-alt' : 'icofont-search-alt-2') ?>" aria-hidden="true" <?= ($anggaran ? '' : 'onclick="klikbeban()"') ?>></i>
                            </span>
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
                    <div class="form-group row" id="zbiaya">
                        <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.itembiaya') ?></label>
                        <div class="col-sm-11">
                            <select id="biaya" class="js-example-data-ajax" name="biaya">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errbiaya"></div>
                        </div>
                    </div>
                    <div class="form-group row" id="zakun">
                        <label for="akun" class="col-sm-1 col-form-label"><?= lang('app.noakun') ?></label>
                        <div class="col-sm-11">
                            <select id="akun" class="js-example-data-ajax" name="akun">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errakun"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bulan" class="col-sm-1 col-form-label"><?= ucfirst(lang('app.bulan')) ?></label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="bulan" name="bulan" onchange="hitungtotal()" />
                        </div>
                        <label for="jumlah" class="col-sm-1 col-form-label text-right"><?= lang('app.jumlah') ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" onchange="hitungtotal()" />
                        </div>
                        <label for="harga" class="col-sm-1 col-form-label text-right"><?= lang('app.harga') ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="harga" name="harga" onchange="hitungtotal()" />
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="total" class="col-sm-1 col-form-label text-right"><?= lang('app.total') ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="total" name="total" />
                            <div class="invalid-feedback errtotal"></div>
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
                            <button type="button" class="btn <?= lang('app.btncLoadbudget') ?> btnload"><?= lang('app.btnLoadbudget') ?></button>
                        </div>
                        <div class="col-4 text-center">
                            <div class="dropdown-primary dropdown">
                                <button type="button" name="action" value="cetak" class="btn <?= lang('app.btncCetak') ?>"><?= lang('app.btnCetak') ?></button>
                                <button type="button" class="btn <?= lang('app.btncSave') ?> dropdown-toggle <?= $actsave ?>" data-toggle="dropdown"><?= lang('app.btnSave') ?></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" onclick="savedoc()"><?= lang('app.simpandoc') ?></a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" onclick="bataldoc()"><?= lang('app.bataldoc') ?></a>
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
    $("#perusahaan, #divisi, #wilayah").change(function() {
        $("#idperusahaan").val($("#perusahaan").val());
        $("#iddivisi").val($("#divisi").val());
        $("#idwilayah").val($("#wilayah").val());
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + '/' + $("#wilayah").find(':selected').data('kui') + '.' + $("#divisi").find(':selected').data('kui') + '/';
    });

    $("#pilih, #tujuan, #jenis").change(function() {
        if (this.id === 'pilih') {
            $('#xpilih').val($(this).val());
            $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
        } else if (this.id === 'tujuan') {
            var translations = {
                null: "<?= lang('app.tujuan') ?>",
                proyek: "<?= lang('app.proyek') ?>",
                camp: "<?= lang('app.camp') ?>",
                alat: "<?= lang('app.alat') ?>",
                tool: "<?= lang('app.tool') ?>",
                tanah: "<?= lang('app.tanah') ?>",
            };
            $("#idbeban, #kodebeban, #namabeban").val("");
            $('#zjenis, #zbiaya, #zakun').attr('hidden', 'hidden');
            ($(this).val() === 'proyek') ? $('#zbiaya, #zjenis').removeAttr('hidden'): $('#zakun').removeAttr('hidden');
            $("#labelbeban").text(translations[$(this).val()]);
            $('#xtujuan').val($(this).val());
            $('#jenis').val('').change()
        } else if (this.id === 'jenis') {
            $('#xjenis').val($(this).val());
        }
    });

    function setawal() {
        var translations = {
            null: "<?= lang('app.tujuan') ?>",
            proyek: "<?= lang('app.proyek') ?>",
            camp: "<?= lang('app.camp') ?>",
            alat: "<?= lang('app.alat') ?>",
            tool: "<?= lang('app.tool') ?>",
            tanah: "<?= lang('app.tanah') ?>",
        };
        $('#zjenis, #zbiaya, #zakun').attr('hidden', 'hidden');
        ($("#tujuan").val() === 'proyek') ? $('#zbiaya, #zjenis').removeAttr('hidden'): $('#zakun').removeAttr('hidden');
        $("#labelbeban").text(translations[$("#tujuan").val()]);
    }

    function hitungtotal() {
        if (document.getElementById('bulan').value === '') document.getElementById('bulan').value = '0,00'
        if (document.getElementById('jumlah').value === '') document.getElementById('jumlah').value = '0,0000'
        if (document.getElementById('harga').value === '') document.getElementById('harga').value = '0,00'

        var bulan = formatAngka(document.getElementById('bulan').value, 'nol');
        var jumlah = formatAngka(document.getElementById('jumlah').value, 'nol');
        var harga = formatAngka(document.getElementById('harga').value, 'nol');
        var total = parseFloat(bulan) * parseFloat(jumlah) * parseFloat(harga);
        $('#total').val(formatAngka(total, 'rp'));
    }

    function dataitembiaya() {
        var getIDU = "<?= $idunik ?>";
        var getTujuan = $("#xtujuan").val();
        var bapmsacpkix = ($("#xtujuan").val() === 'proyek' ? '1001010001a' : '0101010001a');
        $.ajax({
            url: "/anggobjek/tabbiaya",
            data: {
                idunik: getIDU,
                kategori: '',
                tujuan: getTujuan,
                bapmsacpkix: bapmsacpkix,
                menu: 'btl',
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

    function klikbeban() {
        var getPerusahaan = $("#perusahaan").val();
        var getWilayah = $("#wilayah").val();
        var getDivisi = $("#divisi").val();
        var getNama = $("#namabeban").val();
        var getTujuan = $("#xtujuan").val();
        $.ajax({
            url: "/anggobjek/beban",
            data: {
                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                divisi: getDivisi,
                isi: getNama,
                tujuan: getTujuan,
                wenbrako: '10010000',
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

        var getPerusahaan = $("#perusahaan").val();
        var getWilayah = $("#wilayah").val();
        var getDivisi = $("#divisi").val();
        var getBeban = $("#idbeban").val();
        var getNoadd = $("#noadd").val();
        var getNorev = $("#norev").val();
        var getPilih = $("#pilih").val();
        var getTujuan = $("#tujuan").val();
        $.ajax({
            type: 'post',
            url: "/anggobjek/savedoc",
            data: {
                idunik: getIDU,
                nodoc: getDoc,
                tanggal1: getTgl1,
                tanggal2: getTgl2,
                kodedoc: getKodedoc,
                awal: getAwal,

                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                divisi: getDivisi,
                beban: getBeban,
                noadd: getNoadd,
                norev: getNorev,
                pilih: getPilih,
                tujuan: getTujuan,
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
                    // $('#perusahaan').toggleClass('is-invalid', true);
                    // $('.errperusahaan').html(response.error.perusahaan);
                } else {
                    window.location.href = '/anggobjek';
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        setawal();
        dataitembiaya();
        // $("#pilih, #tujuan, #jenis").trigger('change');

        $("#biaya").select2({
            ajax: {
                url: "/anggobjek/biaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: 'biaya',
                        ruas: '',
                        awal: $('#xjenis').val().substring(0, 2),
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

        $("#akun").select2({
            ajax: {
                url: "/anggobjek/akun",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        awal: ($("#pilih").val() === 'pendapatan') ? '4' : ($("#pilih").val() === 'pengeluaran') ? '6' : '-',
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

        $('.btnadd').click(function(e) {
            e.preventDefault();
            var form = $('.formanggaran')[0];
            var formData = new FormData(form);
            var url = '/anggobjek/additem';
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
                    $('#akses, #perusahaan, #wilayah, #divisi, #pilih, #kodebeban, #biaya, #akun, #total, #catatan').removeClass('is-invalid');
                    $('.errakses, .errperusahaan, .errwilayah, .errdivisi, .errpilih, .errkodebeban, .errbiaya, .errakun, .errtotal, .errcatatan').html('');
                    if (response.error) {
                        handleFieldError('akses', response.error.akses);
                        handleFieldError('perusahaan', response.error.perusahaan);
                        handleFieldError('wilayah', response.error.wilayah);
                        handleFieldError('divisi', response.error.divisi);
                        handleFieldError('pilih', response.error.pilih);
                        handleFieldError('kodebeban', response.error.kodebeban);
                        handleFieldError('biaya', response.error.biaya);
                        handleFieldError('akun', response.error.akun);
                        handleFieldError('total', response.error.total);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        clearElements();
                        flashdata('success', response.sukses);
                        document.getElementById("nodoc").value = response.nodoc;
                        document.getElementById("revisi").value = response.revisi;
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
                        $('#perusahaan, #wilayah, #divisi, #pilih, #tujuan, #jenis').removeClass('is-invalid').attr('disabled', 'disabled');
                        $('#namabeban').attr('readonly', 'readonly');
                        $('.input-group-addon').html("<i class='icofont icofont-link-alt' aria-hidden='true'></i>");
                        $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("#bulan, #jumlah, #harga, #total, #catatan").val("");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
            return false;
        })

        $('.btnload').click(function(e) {
            e.preventDefault();
            var form = $('.formanggaran')[0];
            var formData = new FormData(form);
            var url = '/anggobjek/loadbudget';
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
                    $('#perusahaan, #wilayah, #divisi, #kodebeban, #pilih').removeClass('is-invalid');
                    $('.errperusahaan, .errwilayah, .errdivisi, .errkodebeban, .errpilih').html('');

                    if (response.error) {
                        handleFieldError('perusahaan', response.error.perusahaan);
                        handleFieldError('wilayah', response.error.wilayah);
                        handleFieldError('divisi', response.error.divisi);
                        handleFieldError('kodebeban', response.error.kodebeban);
                        handleFieldError('pilih', response.error.pilih);
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
    });
</script>

<?= $this->endSection() ?>