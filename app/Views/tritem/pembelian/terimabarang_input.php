<div onload="flashdata()"></div>

<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formmasuk']) ?>
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgInput'); ?>">
                    <h5><?= lang('app.header'); ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <?php
                    switch ($pesan['0']->pilihan) {
                        case 'proyek':
                            $beban = $proyek1['0']->kode;
                            $namabeban = $proyek1['0']->paket;
                            break;
                        case 'camp':
                            $beban = $camp1['0']->kode;
                            $namabeban = $camp1['0']->nama;
                            break;
                        case 'alat':
                            $beban = $alat1['0']->kode;
                            $namabeban = $alat1['0']->nama;
                            break;
                        case 'tanah':
                            $beban = $tanah1['0']->kode;
                            $namabeban = $tanah1['0']->nama;
                            break;
                        default:
                            $beban = '';
                            $namabeban = '';
                            break;
                    } ?>

                    <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik; ?>">
                    <input type="hidden" class="form-control" id="mintaunik" name="mintaunik" value="<?= (!empty($pesan)) ? $pesan['0']->idunik : ''; ?>">
                    <input type="hidden" class="form-control" id="xpajak" name="xpajak" value="<?= (!empty($pesan)) ? $pesan['0']->stpajak : ''; ?>">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= (empty($pesan)) ? old('idperusahaan') : $pesan['0']->perusahaan_id; ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= (empty($pesan)) ? old('idwilayah') : $pesan['0']->wilayah_id; ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= (empty($pesan)) ? old('iddivisi') : $pesan['0']->divisi_id; ?>">
                    <input type="hidden" class="form-control" id="xpilihan" name="xpilihan" value="<?= (empty($pesan)) ? old('xpilihan') : $pesan['0']->pilihan; ?>">
                    <input type="hidden" class="form-control" id="idbeban" name="idbeban" value="<?= (empty($pesan)) ? old('idbeban') : $pesan['0']->cabang_id; ?>">
                    <input type="text" class="form-control" id="satuan1" name="satuan1" value="">
                    <input type="text" class="form-control" id="satuan2" name="satuan2" value="">
                    <input type="text" class="form-control" id="jenis" name="jenis" value="">
                    <input type="text" class="form-control" id="hasil" name="hasil" value="">

                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan'); ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                <option><?= $pesan['0']->perusahaan . '&emsp;=>&emsp;' . $pesan['0']->namaperusahaan; ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah'); ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" disabled>
                                <option><?= $pesan['0']->wilayah; ?></option>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi'); ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                <option><?= $pesan['0']->divisi; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput'); ?>">
                    <h5><?= lang('app.dokumen'); ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="penerima" class="col-sm-1 col-form-label"><?= lang('app.suplier'); ?></label>
                        <div class="col-sm-11">
                            <select id="penerima" class="js-example-basic-single" name="penerima" disabled>
                                <option value="<?= $penerima1['0']->id; ?>"><?= $penerima1['0']->kode . ' => ' . $penerima1['0']->nama ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="docminta" class="col-sm-1 col-form-label"><?= lang('app.nodoc'); ?></label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="docminta" name="docminta" value="<?= $pesan['0']->nodoc; ?>" autocomplete="off">
                                <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal'); ?></label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= $pesan['0']->tglpo; ?>">
                        </div>
                        <label for="norev" class="col-sm-1 col-form-label text-right"><?= lang('app.norev'); ?></label>
                        <div class="col-sm-1">
                            <input type="text" readonly class="form-control" id="norev" name="norev" value="0">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan'); ?></label>
                        <div class="col-sm-4">
                            <select id="pilihan" class="js-example-basic-single" name="pilihan" disabled>
                                <option><?= ($pesan['0']->pilihan == '') ? lang('app.pilih-') : lang('app.' . $pesan['0']->pilihan); ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="nopesan" class="col-sm-1 col-form-label"><?= lang('app.nopesan'); ?></label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" id="nopesan" name="nopesan" value="<?= $pesan['0']->nodocpesan; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="beban" class="col-sm-1 col-form-label"><?= lang('app.cabang'); ?></label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="beban" name="beban" value="<?= $beban; ?>">
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="namabeban" name="namabeban" value="<?= $namabeban; ?>" autocomplete="off">
                                <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- Akhir card table-->
            <div class="dt-responsive table-responsive tabelbarang"></div>

            <div class="card">
                <div class="card-header <?= lang('app.bgInput'); ?>">
                    <h5><?= lang('app.inputdata'); ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="item" class="col-sm-1 col-form-label"><?= lang('app.namabarang'); ?></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <select id="item" class="js-example-basic-single" name="item">
                                    <option value="" data-jenis="0"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($anak as $db) :
                                        if ($db->jenis == '1') { ?>
                                            <option value="<?= $db->id; ?>" data-spesifikasi="<?= $db->spesifikasi; ?>" data-jenis="1" data-jumlah="<?= $db->jl_beli; ?>" data-satuan="<?= $db->satuan; ?>" data-satuandetil="<?= $db->satuandetil; ?>" data-konversi="<?= $db->konversi; ?>"><?= $db->namabarang; ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $db->id; ?>" data-spesifikasi="<?= $db->spesifikasi; ?>" data-jenis="0" data-jumlah="<?= $db->jl_beli; ?>" data-satuan="" data-satuandetil="" " data-konversi=" 1"><?= $db->namaakun; ?></option>
                                    <?php }
                                    endforeach; ?>
                                </select>
                                <span class="input-group-addon"><i class="fa fa-file-text-o" aria-hidden="true" onclick="klikitem()"></i></span>
                            </div>
                            <div id="error" class="invalid-feedback d-block erritem"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="tglmasuk" class="col-sm-1 col-form-label"><?= lang('app.tanggal'); ?></label>
                        <div class="col-sm-3">
                            <input type="datetime-local" class="form-control" id="tglmasuk" name="tglmasuk" value="<?= date('Y-m-d H:i'); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="spesifikasi" class="col-sm-1 col-form-label"><?= lang('app.spesifikasi'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" readonly class="form-control" id="spesifikasi" name="spesifikasi" value="" />
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="tiket" class="col-sm-1 col-form-label"><?= lang('app.tiket'); ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="tiket" name="tiket" value="<?= old('tiket'); ?>" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nopol" class="col-sm-1 col-form-label"><?= lang('app.nopol'); ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control text-uppercase" id="nopol" name="nopol" value="<?= old('nopol'); ?>" autocomplete="off" />
                        </div>
                        <div class="col-sm-4"></div>
                        <label for="supir" class="col-sm-1 col-form-label"><?= lang('app.supir'); ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="supir" name="supir" value="<?= old('supir'); ?>" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah'); ?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" value="" placeholder="<?= lang('app.harusisi'); ?>" />
                        </div>
                        <div class="col-sm-4"></div>
                        <label for="konversi" class="col-sm-1 col-form-label"><?= lang('app.konversi'); ?></label>
                        <div class="col-sm-1">
                            <input type="text" readonly class="form-control" id="konversi" name="konversi" value="" />
                        </div>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="hjumlah" name="hjumlah" value="" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gudang" class="col-sm-1 col-form-label"><?= lang('app.gudang'); ?></label>
                        <div class="col-sm-5">
                            <select id="gudang" class="js-example-basic-single" name="gudang">
                                <option value=""><?= lang('app.pilih-'); ?></option>
                                <?php foreach ($gudang as $db) : ?>
                                    <option value="<?= $db->id; ?>"><?= $db->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div></div>
                        <div>
                            <button type="submit" class="btn <?= lang('app.btnSave'); ?> btnok"><?= lang('app.btn_Save'); ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->
            <div class="dt-responsive table-responsive tabelpomasuk"></div>

        </div>
    </div>
    <?= form_close() ?>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#item").change(function() {
        document.getElementById('jumlah').value = '';
        document.getElementById('spesifikasi').value = '';
        document.getElementById('konversi').value = '';
        document.getElementById('satuan1').value = '';
        document.getElementById('satuan2').value = '';
        document.getElementById('jenis').value = $("#item").find(':selected').data('jenis');

        var jumlah = $("#item").find(':selected').data('jumlah');
        var konversi = $("#item").find(':selected').data('konversi');
        document.getElementById('jumlah').value = formatRupiah(jumlah * 1);
        document.getElementById('konversi').value = formatRupiah(konversi * 1);
        document.getElementById('spesifikasi').value = $("#item").find(':selected').data('spesifikasi');
        document.getElementById('satuan1').value = $("#item").find(':selected').data('satuan');
        document.getElementById('satuan2').value = $("#item").find(':selected').data('satuandetil');

        if ($("#item").find(':selected').data('satuan') != $("#item").find(':selected').data('satuandetil')) {
            var total = parseFloat(jumlah) * parseFloat(konversi);
            document.getElementById('hjumlah').value = formatRupiah(total) + ' ' + $("#item").find(':selected').data('satuandetil');;
            document.getElementById('hasil').value = formatRupiah(total * 1);
        } else {
            document.getElementById('hjumlah').value = formatRupiah(jumlah * 1) + ' ' + $("#item").find(':selected').data('satuandetil');
            document.getElementById('hasil').value = formatRupiah(jumlah * 1);
        }
    });

    function klikitem() {
        var getitem = $("#item").val();
        var getjenis = $("#jenis").val();
        if (getjenis == '1') { // jika ada isi
            $.ajax({
                url: "/cekada/showitem",
                data: {
                    item: getitem,
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
    }

    function datamintabarang() {
        var getIDU = $("#mintaunik").val();
        var getpesanIDU = $("#idunik").val();
        var getpenerima = $("#penerima").val();
        var getnodoc = $("#docminta").val();
        var getpajak = $("#xpajak").val();
        $.ajax({
            url: "/terimabarang/tabbarang",
            data: {
                idunik: getIDU,
                pesanidunik: getpesanIDU,
                penerima: getpenerima,
                nodoc: getnodoc,
                pajak: getpajak,
                meabpr: '000001',
            },
            dataType: "json",
            success: function(response) {
                $('.tabelbarang').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function datapomasuk() {
        var getIDU = "<?= $idunik; ?>";
        $.ajax({
            url: "/terimabarang/tabmasuk",
            data: {
                idunik: getIDU,
            },
            dataType: "json",
            success: function(response) {
                $('.tabelpomasuk').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        datamintabarang();
        datapomasuk();

        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formmasuk')[0];
            var formData = new FormData(form);
            var url = '/terimabarang/save';
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnok').attr('disable', 'disabled');
                    $('.btnok').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnok').removeAttr('disable', 'disabled');
                    $('.btnok').html('<?= lang('app.btn_Save'); ?>');
                },
                success: function(response) {
                    if (response.error) { //dari msg save lampiran
                        // if (response.error.akses) {
                        //     $('#akses').addClass('is-invalid');
                        //     $('.errakses').html(response.error.akses);
                        // } else {
                        //     $('#akses').removeClass('is-invalid');
                        //     $('.errakses').html('');
                        // }
                    } else {
                        // $('#catatan').removeClass('is-invalid');
                        // $('.errcatatan').html('');
                        flashdata(response.sukses, 'success', response.judul);
                        datamintabarang();
                        datapomasuk();
                        document.getElementById("spesifikasi").value = "";
                        document.getElementById("jumlah").value = "";
                        return false;
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