<div onload="flashdata()"></div>

<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Page-body start -->
<div class="page-body">
    <?= form_open('', ['class' => 'formminta']) ?>
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
                    <?php $stat = (empty($induk)) ? '1' : $induk['0']->status;
                    $mintapilih = (empty($induk)) ? old('pilihan') : $induk['0']->pilihan;
                    $beban = ($mintapilih == 'proyek') ? $proyek1['0']->kode : (($mintapilih == 'camp') ? $camp1['0']->kode : (($mintapilih == 'alat') ? $alat1['0']->kode : (($mintapilih == 'tanah') ? $tanah1['0']->kode : '')));
                    $namabeban = ($mintapilih == 'proyek') ? $proyek1['0']->paket : (($mintapilih == 'camp') ? $camp1['0']->nama : (($mintapilih == 'alat') ? $alat1['0']->nama : (($mintapilih == 'tanah') ? $tanah1['0']->nama : ''))); ?>

                    <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik; ?>">
                    <input type="hidden" class="form-control" id="iduser" name="iduser" value="<?= $tuser['id'] ?>">
                    <input type="hidden" class="form-control" id="kui" name="kui" value="<?= old('kui'); ?>">
                    <input type="hidden" class="form-control" id="xlevel" name="xlevel" value="<?= $tuser['lev_setuju']; ?>">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= (empty($minta)) ? old('idperusahaan') : $minta['0']->perusahaan_id; ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= (empty($minta)) ? old('idwilayah') : $minta['0']->wilayah_id; ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= (empty($minta)) ? old('iddivisi') : $minta['0']->divisi_id; ?>">
                    <input type="hidden" class="form-control" id="xpilihan" name="xpilihan" value="<?= (empty($minta)) ? old('xpilihan') : $minta['0']->pilihan; ?>">
                    <input type="hidden" class="form-control" id="vtotal" name="vtotal" value="<?= old('vtotal'); ?>" />

                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan'); ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                <option><?= $perusahaan1['0']->kode . '&emsp;=>&emsp;' . $perusahaan1['0']->nama; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah'); ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" disabled>
                                <option><?= $wilayah1['0']->nama; ?></option>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi'); ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                <option><?= $divisi1['0']->nama; ?></option>
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
                        <label for="userid" class="col-sm-1 col-form-label"><?= lang('app.peminta'); ?></label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="userid" name="userid" value="<?= $induk['0']->peminta; ?>">
                                <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal'); ?></label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= $induk['0']->tgl_minta; ?>">
                        </div>
                        <label for="norev" class="col-sm-1 col-form-label text-right"><?= lang('app.norev'); ?></label>
                        <div class="col-sm-1">
                            <input type="text" readonly class="form-control" id="norev" name="norev" value="<?= $induk['0']->norevisi; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan'); ?></label>
                        <div class="col-sm-4">
                            <select id="pilihan" class="js-example-basic-single" name="pilihan" disabled>
                                <option><?= lang('app.' . $induk['0']->pilihan); ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc'); ?></label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= $induk['0']->nodoc; ?>">
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
                                <input type="text" readonly class="form-control" id="namabeban" name="namabeban" value="<?= $namabeban; ?>">
                                <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penerima" class="col-sm-1 col-form-label"><?= lang('app.penerima'); ?></label>
                        <div class="col-sm-9">
                            <select id="penerima" class="js-example-basic-single" name="penerima" disabled>
                                <option><?= $penerima1['0']->kode . ' => ' . $penerima1['0']->nama; ?></option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select id="alias" class="js-example-basic-single" name="alias" disabled>
                                <option><?= lang('app.' . $induk['0']->alias); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" <?= ($induk['0']->lampiran == '') ? 'hidden' : ''; ?>>
                        <div class="col-sm-10"></div>
                        <div class="col-sm-2 text-right">
                            <button type="button" class="btn <?= lang('app.btnFile'); ?> tampilpdf"><?= lang('app.btn_File'); ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

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
                        <label for="noakun" class="col-sm-1 col-form-label"><?= lang('app.pajak'); ?></label>
                        <div class="col-sm-6">
                            <select id="noakun" class="js-example-basic-single" name="noakun">
                                <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                <?php foreach ($kelakun as $db) :
                                    echo "<option value='{$db->akun1_id}'" . ((old('kelakun') == $db->akun1_id) ? 'selected' : '') . ">{$db->nama}</option>";
                                endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errnoakun"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="nopajak" class="col-sm-1 col-form-label text-right"><?= lang('app.nopajak'); ?>&emsp;</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="nopajak" name="nopajak">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah'); ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" value="<?= old('jumlah'); ?>" autocomplete="off" onchange="hitungtotal()" />
                        </div>
                        <label for="harga" class="col-sm-1 col-form-label text-right"><?= lang('app.harga'); ?>&emsp;</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="harga" name="harga" value="<?= old('harga'); ?>" autocomplete="off" onchange="hitungtotal()" />
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="total" class="col-sm-1 col-form-label text-right"><?= lang('app.total'); ?>&emsp;</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="total" name="total" placeholder="<?= lang('app.harusisi'); ?>" value="<?= old('total'); ?>" autocomplete="off" />
                            <div class="invalid-feedback errvtotal"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan'); ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi'); ?>"><?= old('catatan'); ?></textarea>
                            <div class="invalid-feedback errcatatan"></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="col-4"></div>
                        <div class="col-4 text-center">
                            <button type="submit" class="btn <?= lang('app.btnSave'); ?> btnsave" <?= (preg_match("/$stat/i", '2')) ? '' : 'disabled'; ?>><?= lang('app.btn_Save'); ?></button>
                        </div>
                        <div class="col-4 text-right">
                            <div class="dropdown-primary dropdown">
                                <button type="button" class="btn <?= lang('app.btnAdd'); ?> dropdown-toggle <?= (preg_match("/$stat/i", '2')) ? '' : 'disabled'; ?>" data-toggle="dropdown"><?= lang('app.btn_Add'); ?></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" onclick="tambahdata('debit')"><?= lang('app.debit'); ?></a>
                                    <a class="dropdown-item" onclick="tambahdata('kredit')"><?= lang('app.kredit'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

        </div>
    </div>
    <?= form_close() ?>
    <div class="dt-responsive table-responsive tabelkas"></div>
</div><!-- body end -->

<script>
    //hitungtotal
    function hitungtotal() {
        if (document.getElementById('jumlah').value === '') document.getElementById('jumlah').value = '0,00'
        if (document.getElementById('harga').value === '') document.getElementById('harga').value = '0,00'

        var jumlah = formatKosong(document.getElementById('jumlah').value);
        var harga = formatKosong(document.getElementById('harga').value);
        var total = parseFloat(jumlah) * parseFloat(harga);
        document.getElementById('total').value = formatRupiah(total);
        document.getElementById('vtotal').value = total;
    }

    function datamintakas() {
        var getIDU = $("#idunik").val();
        var getPilih = $("#pilihan").val();
        $.ajax({
            url: "/<?= $menu; ?>/tabkas",
            data: {
                idunik: getIDU,
                asal: '<?= $menu; ?>',
                pilih: getPilih,
                paksbex: '1110001', //biayaproyek akun kbli supir barang edit tax
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

    function tambahdata(posisidk) {
        var form = $('.formminta')[0];
        var formData = new FormData(form);
        var url = '/<?= $menu; ?>/addkas';
        formData.append('posisidk', posisidk); // Add posisidk to formData

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    var errorFields = ['akses', 'perusahaan', 'wilayah', 'divisi', 'userid', 'pilihan', 'beban', 'penerima', 'biaya', 'sumberdaya', 'noakun', 'nokbli', 'catatan'];
                    errorFields.forEach(function(field) {
                        if (response.error[field]) {
                            $('#' + field).addClass('is-invalid');
                            $('.err' + field).html(response.error[field]);
                        } else {
                            $('#' + field).removeClass('is-invalid');
                            $('.err' + field).html('');
                        }
                    });

                    if (response.error.vtotal) {
                        $('#total').addClass('is-invalid');
                        $('.errvtotal').html(response.error.vtotal);
                    } else {
                        $('#total').removeClass('is-invalid');
                        $('.errvtotal').html('');
                    }
                } else {
                    $('#total').removeClass('is-invalid');
                    $('.errvtotal').html('');
                    $('#catatan').removeClass('is-invalid');
                    $('.errcatatan').html('');

                    document.getElementById("nopajak").value = "";
                    document.getElementById("jumlah").value = "";
                    document.getElementById("harga").value = "";
                    document.getElementById("total").value = "";
                    document.getElementById("vtotal").value = "";
                    $("#catatan").val('');

                    flashdata('success', response.sukses);
                    datamintakas();
                    return false;
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $('.btnsave').click(function(e) {
        e.preventDefault();
        var form = $('.formminta')[0];
        var formData = new FormData(form);
        var url = '/<?= $menu; ?>/savedoc';
        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.sukses) { //dari msg add
                    flashdata('success', response.sukses);
                    window.location.href = "/pajakkas";
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
        datamintakas();
    });
</script>

<?= $this->endSection(); ?>