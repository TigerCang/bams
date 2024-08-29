<div onload="flashdata()"></div>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php $status = statuslabel('barangpo', $barang[0]->status); ?>
<div class="page-body">
    <?= form_open('', ['class' => 'formbarang']) ?>
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
                    <input type="hidden" class="form-control" id="xlevel" name="xlevel" value="<?= $tuser['acc_setuju'] ?>">
                    <input type="hidden" class="form-control" id="iduser" name="iduser" value="<?= (($tuser['confpeg'] == '1' && $tuser['akpeg'] == '1') ? $tuser['id'] : '') ?>">
                    <input type="hidden" class="form-control" id="jenis" name="jenis">
                    <input type="hidden" class="form-control" id="nama" name="nama">
                    <input type="hidden" class="form-control" id="jumlah" name="jumlah">
                    <input type="hidden" class="form-control" id="jlpesan" name="jlpesan">
                    <input type="hidden" class="form-control" id="barangjasa" name="barangjasa">
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= ($barang[0]->perusahaan_id == $db->id ? 'selected' : '') ?>><?= $db->kode . ' => ' . $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" disabled>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= ($barang[0]->wilayah_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= ($barang[0]->divisi_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
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
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= $barang[0]->nodoc ?>">
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="revisi" class="col-sm-1 col-form-label"><?= lang('app.rev') ?></label>
                        <div class="col-sm-1">
                            <input type="text" readonly class="form-control" id="revisi" name="revisi" value="<?= $barang[0]->revisi ?>">
                        </div>
                        <label for="tanggal" class="col-sm-1 col-form-label">&emsp;&emsp;&emsp;<?= lang('app.tanggal') ?>&emsp;</label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= $barang[0]->tanggal ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="peminta" class="col-sm-1 col-form-label"><?= lang('app.peminta') ?></label>
                        <div class="col-sm-4">
                            <select id="peminta" class="js-example-basic-single" name="peminta" <?= ($barang ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php if ($user1) : ?> <option value="<?= $user1[0]->id ?>" selected><?= $user1[0]->kode . ' : ' . $user1[0]->namapeg ?></option><?php endif; ?>
                            </select>
                        </div>
                        <div class="col-sm-4"></div>
                        <label for="status" class="col-sm-1 col-form-label">&emsp;&emsp;&emsp;<?= lang('app.status') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="status" name="status" value="<?= $status['text'] ?>">
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

            <div class="dt-responsive table-responsive tabelbarang"></div>

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
                        <label for="item" class="col-sm-1 col-form-label"><?= lang('app.item') ?></label>
                        <div class="col-sm-11">
                            <div class="input-group">
                                <select id="item" class="js-example-basic-single" name="item">
                                    <option value=""><?= lang('app.pilih-') ?></option>
                                    <?php foreach ($anak as $db) : ?>
                                        <?= $deskripsi = ($db->jenis == '1' ? $db->namaitem : $db->namaakun); ?>
                                        <option value="<?= $db->id ?>" data-nama="<?= $deskripsi ?>" data-jumlah="<?= ubahSeparator($db->jumlah - $db->ada, 'titik') ?>" data-jenis="<?= $db->jenis ?>" data-barang="<?= $db->item_id ?>"><?= $deskripsi . ' ; ' . $db->spesifikasi ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="input-group-addon"><i class="icofont icofont-file-document" aria-hidden="true" onclick="klikbarang()"></i></span>
                            </div>
                            <div id="error" class="invalid-feedback d-block erritem"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="suplier" class="col-sm-1 col-form-label"><?= lang('app.suplier') ?></label>
                        <div class="col-sm-11">
                            <div class="input-group">
                                <select id="suplier" class="js-example-data-ajax" name="suplier">
                                    <option value="" selected><?= lang('app.pilihsr') ?></option>
                                </select>
                                <span class="input-group-addon"><i class="icofont icofont-file-document" aria-hidden="true" onclick="kliksuplier()"></i></span>
                            </div>
                            <div class="invalid-feedback d-block errsuplier"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jltawar" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jltawar" name="jltawar" onchange="hitungtotal()" />
                            <div class="invalid-feedback d-block errjltawar"></div>
                        </div>
                        <label for="harga" class="col-sm-1 col-form-label text-right"><?= lang('app.harga') ?>&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="harga" name="harga" onchange="hitungtotal()" />
                        </div>
                        <label for="diskon" class="col-sm-1 col-form-label text-right"><?= lang('app.diskon') ?>&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="diskon" name="diskon" onchange="hitungtotal()" />
                        </div>
                        <label for="total" class="col-sm-1 col-form-label text-right"><?= lang('app.total') ?>&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" readonly data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="total" name="total" />
                            <div class="invalid-feedback errtotal"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pajak" class="col-sm-1 col-form-label"><?= lang('app.pajak') ?></label>
                        <div class="col-sm-1"><input type="checkbox" id="pajak" name="pajak" data-toggle="toggle" data-on="<?= lang('app.ya') ?>" data-off="<?= lang('app.no') ?>" data-onstyle="success" data-offstyle="light"></div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"></textarea>
                            <div class="invalid-feedback errcatatan"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="col-4"></div>
                        <div class="col-4 text-center">
                            <button type="button" class="btn <?= lang('app.btncSave') ?> btnsave"><?= lang('app.btnSave') ?></button>
                        </div>
                        <div class="col-4 text-right">
                            <button type="submit" class="btn <?= lang('app.btncAdd') ?> btnadd"><?= lang('app.btnAdd') ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

            <div class="dt-responsive table-responsive tabelharga"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#item").change(function() {
        $("#nama").val($("#item").find(':selected').data('nama'));
        $("#jenis").val($("#item").find(':selected').data('jenis'));
        $("#jumlah").val($("#item").find(':selected').data('jumlah'));
        $("#barangjasa").val($("#item").find(':selected').data('barang'));
        datahargasuplier();
    });

    function hitungtotal() {
        if (document.getElementById('jltawar').value === '') document.getElementById('jltawar').value = '0,0000'
        if (document.getElementById('harga').value === '') document.getElementById('harga').value = '0,00'
        if (document.getElementById('diskon').value === '') document.getElementById('diskon').value = '0,00'
        var jumlah = formatAngka(document.getElementById('jltawar').value, 'nol');
        var harga = formatAngka(document.getElementById('harga').value, 'nol');
        var diskon = formatAngka(document.getElementById('diskon').value, 'nol');
        var total = parseFloat(jumlah) * (parseFloat(harga) - parseFloat(diskon));
        document.getElementById('total').value = formatAngka(total, 'rp');
    }

    function dataitembarang() {
        var getIDU = "<?= $idunik ?>";
        var getUser = $("#iduser").val();
        $.ajax({
            url: "/tawarharga/tabbarang",
            data: {
                idunik: getIDU,
                jaboskix: '0011111a',
                asal: 'minta',
                user: getUser,
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

    function datahargasuplier() {
        var getIDU = "<?= $idunik ?>";
        var getItem = $("#item").val();
        $.ajax({
            url: "/tawarharga/tabharga",
            data: {
                idunik: getIDU,
                bsomshdtpspix: '101001111111a',
                asal: 'tawar',
                item: getItem,
            },
            dataType: "json",
            success: function(response) {
                $('.tabelharga').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikbarang() {
        var getItem = $("#barangjasa").val();
        var getJenis = $("#jenis").val();
        $.ajax({
            url: "/tawarharga/mbarang",
            data: {
                isi: getItem,
                jenis: getJenis
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

    function kliksuplier() {
        var getSuplier = $("#suplier").val();
        $.ajax({
            url: "/tawarharga/msuplier",
            data: {
                isi: getSuplier,
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
        dataitembarang();

        $("#suplier").select2({
            ajax: {
                url: "/tawarharga/suplier",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '0100',
                        osm: '0',
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
            var form = $('.formbarang')[0];
            var formData = new FormData(form);
            var url = '/tawarharga/additem';
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
                    $('.btnadd').removeAttr('disable', 'disabled');
                    $('.btnadd').html('<?= lang('app.btnAdd') ?>');
                },
                success: function(response) {
                    $('#akses, #item, #jltawar, #suplier, #total, #catatan').removeClass('is-invalid');
                    $('.errakses, .erritem, .errjltawar, .errsuplier, .errtotal, .errcatatan').html('');
                    if (response.error) {
                        handleFieldError('akses', response.error.akses);
                        handleFieldError('item', response.error.item);
                        handleFieldError('jltawar', response.error.jltawar);
                        handleFieldError('suplier', response.error.suplier);
                        handleFieldError('total', response.error.total);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        clearElements();
                        flashdata('success', response.sukses);
                        // document.getElementById("status").value = response.stat;
                        datahargasuplier();
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
                        $("#item").val("").change();
                        $("select[name='suplier']").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("#jltawar").val("");
                        $("#harga").val("");
                        $("#diskon").val("");
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