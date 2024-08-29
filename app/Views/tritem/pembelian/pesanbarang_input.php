<div onload="flashdata()"></div>

<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="page-body">
    <form action="/pesanbarang/save/<?= $idunik; ?>" id="myForm" method="POST">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-sm-12">
                <input type="hidden" class="form-control" id="akses" name="akses" value="">
                <div class="invalid-feedback alert background-danger" role="alert">
                    <?= $validation->geterror('akses'); ?>
                </div>

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
                        <?php if (empty($pesan)) {
                            $pil = old('pilihan');
                        } else {
                            $pil = $pesan['0']->pilihan;

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
                            }
                        } ?>

                        <input type="hidden" class="form-control" id="kui" name="kui" value="<?= old('kui'); ?>">
                        <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik; ?>">
                        <input type="hidden" class="form-control" id="mintaunik" name="mintaunik" value="<?= (!empty($pesan)) ? $pesan['0']->idunik : ''; ?>">
                        <input type="hidden" class="form-control" id="xpajak" name="xpajak" value="<?= (!empty($pesan)) ? $pesan['0']->stpajak : ''; ?>">
                        <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= (empty($pesan)) ? old('idperusahaan') : $pesan['0']->perusahaan_id; ?>">
                        <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= (empty($pesan)) ? old('idwilayah') : $pesan['0']->wilayah_id; ?>">
                        <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= (empty($pesan)) ? old('iddivisi') : $pesan['0']->divisi_id; ?>">
                        <input type="hidden" class="form-control" id="xpilihan" name="xpilihan" value="<?= (empty($pesan)) ? old('xpilihan') : $pesan['0']->pilihan; ?>">
                        <input type="hidden" class="form-control" id="idbeban" name="idbeban" value="<?= (empty($pesan)) ? old('idbeban') : $pesan['0']->cabang_id; ?>">
                        <input type="hidden" class="form-control" id="nisubtotal" name="nisubtotal" value="0" />
                        <input type="hidden" class="form-control" id="nippn" name="nippn" value="0" />
                        <input type="hidden" class="form-control" id="nitotal" name="nitotal" value="0" />

                        <div class="form-group row">
                            <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan'); ?></label>
                            <div class="col-sm-11">
                                <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($perusahaan as $db) : ?>
                                        <option value="<?= $db->id; ?>" data-kui="<?= $db->kui; ?>" <?= (empty(!$pesan)) ? (($pesan['0']->perusahaan_id == $db->id) ? 'selected' : '') : ''; ?>><?= $db->kode . '&emsp;=>&emsp;' . $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah'); ?></label>
                            <div class="col-sm-4">
                                <select id="wilayah" class="js-example-basic-single" name="wilayah" disabled>
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($wilayah as $db) : ?>
                                        <option value="<?= $db->id; ?>" data-kui="<?= $db->kui; ?>" <?= (empty(!$pesan)) ? (($pesan['0']->wilayah_id == $db->id) ? 'selected' : '') : ''; ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi'); ?></label>
                            <div class="col-sm-4">
                                <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($divisi as $db) : ?>
                                        <option value="<?= $db->id; ?>" data-kui="<?= $db->kui; ?>" <?= (empty(!$pesan)) ? (($pesan['0']->divisi_id == $db->id) ? 'selected' : '') : ''; ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
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
                                <select id="penerima" class="js-example-data-ajax" name="penerima">
                                    <option value=""><?= lang('app.pilihsr'); ?></option>
                                    <?php if (!empty($penerima1)) {
                                        echo "<option value='" . $penerima1['0']->id . "' selected='selected'>" . $penerima1['0']->kode . ' => ' . $penerima1['0']->nama . "</option>";
                                    } ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('penerima'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="docminta" class="col-sm-1 col-form-label"><?= lang('app.nodoc'); ?></label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control <?= ($validation->hasError('docminta')) ? 'is-invalid' : ''; ?>" id="docminta" name="docminta" value="<?= (empty(!$pesan)) ? $pesan['0']->nodoc : ''; ?>" autocomplete="off">
                                    <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="klikdokumen()"></i></span>
                                </div>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('docminta'); ?>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal'); ?></label>
                            <div class="col-sm-2">
                                <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= (empty(!$pesan)) ? $pesan['0']->tglpo : date('Y-m-d'); ?>">
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
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($selnama as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= ($pil == $db->nama) ? 'selected' : ''; ?>><?= lang('app.' . $db->nama); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="nopesan" class="col-sm-1 col-form-label"><?= lang('app.nopesan'); ?></label>
                            <div class="col-sm-4">
                                <input type="text" readonly class="form-control" id="nopesan" name="nopesan" value="<?= (empty(!$pesan)) ? $pesan['0']->nodocpesan : ''; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="beban" class="col-sm-1 col-form-label"><?= lang('app.cabang'); ?></label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" id="beban" name="beban" value="<?= (empty(!$pesan)) ? $beban : ''; ?>">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" id="namabeban" name="namabeban" value="<?= (empty(!$pesan)) ? $namabeban : ''; ?>" autocomplete="off">
                                    <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- Akhir card table-->
                <div class="dt-responsive table-responsive tabelbarang"></div>
                <div class="dt-responsive table-responsive tabelbiaya"></div>

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.biaya'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.biaya'); ?></label>
                            <div class="col-sm-11">
                                <select id="biaya" class="js-example-data-ajax" name="biaya">
                                    <option value=""><?= lang('app.pilihsr'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="item" class="col-sm-1 col-form-label"><?= lang('app.namabarang'); ?></label>
                            <div class="col-sm-5">
                                <select id="item" class="js-example-basic-single" name="item">
                                    <option value="" data-jenis="0"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($anak as $db) :
                                        if ($db->jenis == '1') { ?>
                                            <option value="<?= $db->id; ?>" data-jenis="1" data-jumlah="<?= $db->jl_beli; ?>" data-spesifikasi="<?= $db->spesifikasi; ?>"><?= $db->namabarang; ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $db->id; ?>" data-jenis="0" data-jumlah="<?= $db->jl_beli; ?>" data-spesifikasi="<?= $db->spesifikasi; ?>"><?= $db->namaakun; ?></option>
                                    <?php }
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="total" class="col-sm-1 col-form-label"><?= lang('app.total'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="total" name="total" value="<?= old('total'); ?>" placeholder="<?= lang('app.harusisi'); ?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="spesifikasi" class="col-sm-1 col-form-label"><?= lang('app.spesifikasi'); ?></label>
                            <div class="col-sm-5">
                                <input type="text" readonly class="form-control" id="spesifikasi" name="spesifikasi" value="" />
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan'); ?></label>
                            <div class="col-sm-11">
                                <textarea harusisi class="form-control" rows="3" id="catatan" name="mcatatan" placeholder="<?= lang('app.harusisi'); ?>"><?= old('catatan'); ?></textarea>
                                <div class="invalid-feedback errcatatan"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div></div>
                            <div>
                                <button type="button" class="btn <?= lang('app.btnOk'); ?> btnok" id="btnok"><?= lang('app.btn_Ok'); ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div></div>
                            <div>
                                <button type="button" class="btn <?= lang('app.btnCetak'); ?>"><?= lang('app.btn_Cetak'); ?></button>
                                <button type="submit" class="btn <?= lang('app.btnSave'); ?>" <?= (empty(!$pesan)) ? 'disabled' : ''; ?>><?= lang('app.btn_Save'); ?></button>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div>
        </div>
    </form>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    var awal = "<?= $nodoc['0']->nama ?>";
    $("#perusahaan").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        document.getElementById('idperusahaan').value = document.getElementById('perusahaan').value
    });
    $("#divisi").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        document.getElementById('iddivisi').value = document.getElementById('divisi').value
    });
    $("#wilayah").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        document.getElementById('idwilayah').value = document.getElementById('wilayah').value
    });
    $("#pilihan").change(function() {
        document.getElementById('xpilihan').value = document.getElementById('pilihan').value
    });

    $("#item").change(function() {
        document.getElementById('jumlah').value = '';
        document.getElementById('spesifikasi').value = '';
        var jumlah = $("#item").find(':selected').data('jumlah');

        document.getElementById('jumlah').value = formatRupiah(jumlah * 1);
        document.getElementById('spesifikasi').value = $("#item").find(':selected').data('spesifikasi');
    });

    function datamintabarang() {
        var getIDU = $("#mintaunik").val();
        var getpesanIDU = $("#idunik").val();
        var getpenerima = $("#penerima").val();
        var getnodoc = $("#docminta").val();
        var getpajak = $("#xpajak").val();
        $.ajax({
            url: "/pesanbarang/tabbarang",
            data: {
                idunik: getIDU,
                pesanidunik: getpesanIDU,
                penerima: getpenerima,
                nodoc: getnodoc,
                pajak: getpajak,
                meabpr: '000010',
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

    function databiaya() {
        var getIDU = "<?= $idunik; ?>";
        $.ajax({
            url: "/pesanbarang/tabbiaya",
            data: {
                idunik: getIDU,
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

    function klikdokumen() {
        var getdoc = $("#docminta").val();
        var getsuplier = $("#penerima").val();
        $.ajax({
            url: "/pesanbarang/dokumen",
            data: {
                dokumen: getdoc,
                penerima: getsuplier,
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

    $(document).ready(function() {
        datamintabarang();
        databiaya();

        $("#penerima").select2({
            ajax: {
                url: "/pesanbarang/penerima",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '010',
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

        $("#biaya").select2({
            ajax: {
                url: "/pesanbarang/biaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        awal: '6',
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

        $('#btnok').click(function() {
            var getIDU = "<?= $idunik; ?>";
            var getItem = $("#item").val();
            var getBiaya = $("#biaya").val();
            var getJumlah = $("#jumlah").val();
            var getTotal = $("#total").val();
            var getCatatan = $("#catatan").val();
            $.ajax({
                type: "POST",
                url: "/pesanbarang/addbiaya",
                data: {
                    idunik: getIDU,
                    item: getItem,
                    biaya: getBiaya,
                    jumlah: getJumlah,
                    total: getTotal,
                    catatan: getCatatan,
                },
                dataType: "json",
                beforeSend: function() {
                    $('.btnok').attr('disable', 'disabled');
                    $('.btnok').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnok').removeAttr('disable', 'disabled');
                    $('.btnok').html('<?= lang('app.btn_Ok'); ?>');
                },
                success: function(response) {
                    if (response.error) { //dari msg save lampiran
                        // if (response.error.catatan) {
                        //     $('#catatan').addClass('is-invalid');
                        //     $('.errcatatan').html(response.error.catatan);
                        // } else {
                        //     $('#catatan').removeClass('is-invalid');
                        //     $('.errcatatan').html('');
                        // }
                    } else {
                        // $('#akses').removeClass('is-invalid');
                        // $('.errakses').html('');

                        // flashdata(response.sukses, 'success', response.judul);
                        databiaya();
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