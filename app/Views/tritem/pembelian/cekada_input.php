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
                    <input type="hidden" class="form-control" id="iduser" name="iduser" value="<?= (($tuser['confpeg'] == '1' && $tuser['akpeg'] == '1') ? $tuser['id'] : '') ?>">
                    <input type="hidden" class="form-control" id="jenis" name="jenis">
                    <input type="hidden" class="form-control" id="nama" name="nama">
                    <input type="hidden" readonly class="form-control" id="jumlah" name="jumlah">
                    <input type="hidden" readonly class="form-control" id="satuan" name="satuan">
                    <input type="hidden" class="form-control" id="barangjasa" name="barangjasa">
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                <option value="" selected><?= lang('app.pilih-') ?></option>
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
                                <option value="" selected><?= lang('app.pilih-') ?></option>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= ($barang[0]->wilayah_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                <option value="" selected><?= lang('app.pilih-') ?></option>
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
                        <label for="tanggal" class="col-sm-1 col-form-label">&emsp;&emsp;&emsp;<?= lang('app.tanggal') ?></label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= $barang[0]->tanggal ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="peminta" class="col-sm-1 col-form-label"><?= lang('app.peminta') ?></label>
                        <div class="col-sm-4">
                            <select id="peminta" class="js-example-basic-single" name="peminta" <?= ($barang ? 'disabled' : '') ?>>
                                <option value="" selected><?= lang('app.pilih-') ?></option>
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
                                        <option value="<?= $db->id ?>" data-nama="<?= $deskripsi ?>" data-jumlah="<?= ubahSeparator($db->jumlah, 'titik') ?>" data-ada="<?= ubahSeparator($db->ada, 'titik') ?>" data-satuan="<?= $db->satuan ?>" data-konversi="<?= ubahSeparator($db->konversi, 'titik') ?>" data-satuan2="<?= $db->satuandetil ?>" data-jenis="<?= $db->jenis ?>" data-barang="<?= $db->item_id ?>"><?= $deskripsi . ' ; ' . $db->spesifikasi ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="input-group-addon"><i class="icofont icofont-files" aria-hidden="true" onclick="klikbarang()"></i></span>
                            </div>
                            <div id="error" class="invalid-feedback d-block erritem"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mada" class="col-sm-1 col-form-label"><?= lang('app.ada') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="mada" name="mada" placeholder="<?= lang('app.harusisi') ?>" />
                            <div class="invalid-feedback errmada"></div>
                        </div>
                        <div class="col-sm-3"></div>
                        <label for="konversi" class="col-sm-1 col-form-label"><?= lang('app.konversi') ?></label>
                        <div class="col-sm-2">
                            <input type="text" harusisi class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="konversi" name="konversi" />
                            <div class="invalid-feedback errkonversi"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="satuan2" name="satuan2">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="col-4"></div>
                        <div class="col-4 text-center">
                            <button type="submit" class="btn <?= lang('app.btncSave') ?> btnsave"><?= lang('app.btnSave') ?></button>
                        </div>
                        <div class="col-4 text-right">
                            <button type="submit" class="btn <?= lang('app.btncAdd') ?> btnadd"><?= lang('app.btnAdd') ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#item").change(function() {
        $("#nama").val($("#item").find(':selected').data('nama'));
        $("#jenis").val($("#item").find(':selected').data('jenis'));
        $("#jumlah").val($("#item").find(':selected').data('jumlah'));
        $("#satuan").val($("#item").find(':selected').data('satuan'));
        $("#konversi").val($("#item").find(':selected').data('konversi'));
        $("#satuan2").val($("#item").find(':selected').data('satuan2'));
        $("#mada").val($("#item").find(':selected').data('ada'));
        $("#barangjasa").val($("#item").find(':selected').data('barang'));
    });

    function dataitembarang() {
        var getIDU = "<?= $idunik ?>";
        var getUser = $("#iduser").val();
        $.ajax({
            url: "/cekada/tabbarang",
            data: {
                idunik: getIDU,
                jaboskix: '1100110a',
                asal: 'cekada',
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

    function klikbarang() {
        var getItem = $("#barangjasa").val();
        var getJenis = $("#jenis").val();
        $.ajax({
            url: "/cekada/mbarang",
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

    $(document).ready(function() {
        dataitembarang();

        $('.btnadd').click(function(e) {
            e.preventDefault();
            var form = $('.formbarang')[0];
            var formData = new FormData(form);
            var url = '/cekada/additem';
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                enctype: "multipart/form-data",
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
                    $('#mada, #konversi').removeClass('is-invalid');
                    $('.errmada, .errkonversi').html('');
                    if (response.error) { //dari msg save lampiran
                        handleFieldError('mada', response.error.mada);
                        handleFieldError('konversi', response.error.konversi);
                    } else {
                        clearElements();
                        flashdata('success', response.sukses);
                        $('#modal-lampiran').modal('hide');
                        dataitembarang();
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
                        $("#jumlah").val("");
                        $("#satuan").val("");
                        $("#konversi").val("");
                        $("#satuan2").val("");
                        $("#mada").val("");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        });

        $('.btnsave').click(function(e) {
            e.preventDefault();
            var getIDU = "<?= $idunik ?>";
            var getUser = $("#iduser").val();
            var getDokumen = $("#nodoc").val();
            $.ajax({
                url: "/cekada/savedoc",
                type: "POST",
                data: {
                    idunik: getIDU,
                    user: getUser,
                    nodoc: getDokumen,
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
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        })
    });
</script>

<?= $this->endSection() ?>