<div onload="flashdata()"></div>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- <php
$status = statuslabel('biayakas', $kas[0]->status);
$aksescek = ($tuser['acc_setuju'] == '0' ? (!preg_match("/,tritem,/i", $tuser['jenis_cek']) ? 'disabled' : '') : ($levpos == '0' ? 'disabled' : ($levpos != '0' && $levpos != $tuser['acc_setuju'] ? 'disabled' : '')));
$aksescek = ($aksescek == '' && ($kas[0]->status == '1' || $kas[0]->status == '2') ? '' : 'disabled'); ?> -->

<?php
$aksescek = "";
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
                    <input type="hidden" class="form-control" id="xlevel" name="xlevel" value="<?= $tuser['acc_setuju'] ?>">
                    <input type="hidden" class="form-control" id="iduser" name="iduser" value="<?= (($tuser['confpeg'] == '1' && $tuser['akpeg'] == '1') ? $tuser['id'] : '') ?>">
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= ($kas[0]->perusahaan_id == $db->id ? 'selected' : '') ?>><?= "{$db->kode} => {$db->nama}" ?></option>
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
                                    <option value="<?= $db->id ?>" <?= ($kas[0]->wilayah_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= ($kas[0]->divisi_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
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
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= $kas[0]->nodoc ?>">
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="revisi" class="col-sm-1 col-form-label"><?= lang('app.rev') ?></label>
                        <div class="col-sm-1">
                            <input type="text" readonly class="form-control" id="revisi" name="revisi" value="<?= $kas[0]->revisi ?>">
                        </div>
                        <label for="tanggal" class="col-sm-1 col-form-label">&emsp;&emsp;&emsp;<?= lang('app.tanggal') ?></label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= $kas[0]->tgl_minta ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="peminta" class="col-sm-1 col-form-label"><?= lang('app.peminta') ?></label>
                        <div class="col-sm-4">
                            <select id="peminta" class="js-example-data-ajax" name="peminta" disabled>
                                <option value=""><?= lang('app.pilihsr') ?></option>
                                <?php if ($user1) : ?> <option value="<?= $user1[0]->id ?>" selected><?= "{$user1[0]->kode} : {$user1[0]->namapeg}" ?></option><?php endif; ?>
                            </select>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="tujuan" class="col-sm-1 col-form-label"><?= lang('app.tujuan'); ?></label>
                        <div class="col-sm-2">
                            <select id="tujuan" class="js-example-basic-single" name="tujuan" disabled>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selbeban as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= ($kas[0]->tujuan == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="kodebeban" class="col-sm-1 col-form-label" id="labelbeban"><?= lang('app.tujuan') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodebeban" name="kodebeban" placeholder="<?= lang('app.harusisi'); ?>" value="<?= $beban1[0]->kode ?>">
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="namabeban" name="namabeban" value="<?= $beban1[0]->nama ?>">
                                <span class="input-group-addon">
                                    <i class="icofont icofont-link-alt" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penerima" class="col-sm-1 col-form-label"><?= lang('app.penerima'); ?></label>
                        <div class="col-sm-11">
                            <select id="penerima" class="js-example-data-ajax" name="penerima" disabled>
                                <option value=""><?= lang('app.pilihsr') ?></option>
                                <?php if ($penerima1) : ?> <option value="<?= $penerima1[0]->id ?>" selected><?= "{$penerima1[0]->kode} => {$penerima1[0]->nama}" ?></option><?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kbli" class="col-sm-1 col-form-label"><?= lang('app.kbli'); ?></label>
                        <div class="col-sm-11">
                            <select id="kbli" class="js-example-data-ajax" name="kbli">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                                <?php if ($kbli1) : ?> <option value="<?= $kbli1[0]->id ?>" selected><?= "{$kbli1[0]->kode} => {$kbli1[0]->nama}" ?></option><?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->
            <div class="dt-responsive table-responsive tabelkas"></div>

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.inputdata'); ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card <?= ($aksescek == 'disabled' ? 'klikini' : '') ?>"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="aksi" class="col-sm-1 col-form-label"><?= lang('app.setuju') ?></label>
                        <div class="col-sm-2">
                            <select id="aksi" class="js-example-basic-single" name="aksi">
                                <?php foreach ($selaksi as $db) : ?>
                                    <option value="<?= $db->nama ?>"><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"></textarea>
                            <div id="error" class="invalid-feedback errcatatan"></div>
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
                            <button type="submit" class="btn <?= lang('app.btncSave') ?> btnsave" <?= $aksescek ?>><?= lang('app.btnSave') ?></button>
                        </div>
                        <div class="col-4 text-right"></div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    function dataitemkas() {
        var getIDU = "<?= $idunik ?>";
        var getTujuan = $("#xtujuan").val();
        var basbprix = ($("#xtujuan").val() === 'proyek' ? '1000001b' : '1000001b');
        $.ajax({
            url: "/cekkas/tabkas",
            data: {
                idunik: getIDU,
                asal: 'cekkas',
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

    $(document).ready(function() {
        dataitemkas();

        $("#peminta").select2({
            ajax: {
                url: "/cekkas/peminta",
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
                url: "/cekkas/penerima",
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

        $("#kbli").select2({
            ajax: {
                url: "/cekkas/kbli",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilihan: 'kbli',
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

        $('.btnlog').click(function(e) {
            e.preventDefault();
            var getIDU = "<?= $idunik ?>";
            $.ajax({
                url: "/cekkas/logaksi",
                data: {
                    idunik: getIDU,
                    pilihan: 'cek',
                    asal: 'cekkas',
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
        })

        $('.btnsave').click(function(e) {
            e.preventDefault();
            var form = $('.formkas')[0];
            var formData = new FormData(form);
            var getAction = $(this).val();
            var url = '/cekkas/savedoc';
            formData.append('postaction', getAction);
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsave').attr('disabled', 'disabled');
                    $('.btnsave').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsave').removeAttr('disable', 'disabled');
                    $('.btnsave').html('<?= lang('app.btnSave') ?>');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.iduser) {
                            $('#akses').addClass('is-invalid');
                            $('.erriduser').html(response.error.iduser);
                        } else {
                            $('#akses').removeClass('is-invalid');
                            $('.erriduser').html('');
                        }
                        if (response.error.catatan) {
                            $('#catatan').addClass('is-invalid');
                            $('.errcatatan').html(response.error.catatan);
                        } else {
                            $('#catatan').removeClass('is-invalid');
                            $('.errcatatan').html('');
                        }
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
            return false;
        })
    });
</script>

<?= $this->endSection(); ?>