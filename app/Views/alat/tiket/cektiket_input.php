<div onload="flashdata()"></div>

<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php $stat = "1" ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formtiket']) ?>
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-sm-12">
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
                    <input type="text" class="form-control" id="nomortiket" name="nomortiket">

                    <div class="form-group row">
                        <label for="notiket" class="col-sm-1 col-form-label"><?= lang('app.notiket') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='notiket' class='js-example-data-ajax' name='notiket'>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errnotiket"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='perusahaan' class='js-example-basic-single' name='perusahaan' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='wilayah' class='js-example-basic-single' name='wilayah' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='divisi' class='js-example-basic-single' name='divisi' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kodecamp" class="col-sm-1 col-form-label"><?= lang('app.camp') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodecamp" name="kodecamp">
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="namacamp" name="namacamp">
                                <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.pelanggan') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="kodepelanggan" class="col-sm-1 col-form-label"><?= lang('app.pelanggan') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodepelanggan" name="kodepelanggan">
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="namapelanggan" name="namapelanggan">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kodeproyek" class="col-sm-1 col-form-label"><?= lang('app.proyek') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodeproyek" name="kodeproyek">
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="namaproyek" name="namaproyek">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ruas" class="col-sm-1 col-form-label"><?= lang('app.ruas') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='ruas' class='js-example-basic-single' name='ruas' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jarak" class="col-sm-1 col-form-label"><?= lang('app.jarak') ?></label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jarak" name="jarak" />
                                <div class="input-group-append">
                                    <span class="input-group-text"><label class="col-form-label">&ensp;Km</label></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.itembiaya') ?></label>
                        <div class="col-sm-7">
                            <?= "<select id='biaya' class='js-example-basic-single' name='biaya' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.detildata') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                        <div class="col-sm-2">
                            <input type="datetime-local" readonly class="form-control" id="tanggal" name="tanggal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="barang" class="col-sm-1 col-form-label"><?= lang('app.bahan') ?></label>
                        <div class="col-sm-6">
                            <?= "<select id='barang' class='js-example-basic-single' name='barang' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="0" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" />
                        </div>
                    </div>
                    <div class="form-group row mt-2 mb-2" style="border: 1px solid black;"></div>
                    <div class="form-group row">
                        <label for="alat" class="col-sm-1 col-form-label"><?= lang('app.alat') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='alat' class='js-example-basic-single' name='alat' disabled>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="supir" class="col-sm-1 col-form-label"><?= lang('app.supir') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='supir' class='js-example-basic-single' name='supir' disabled>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea class="form-control" readonly rows="3" id="catatan" name="catatan"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="col-4"></div>
                        <div class="col-4 text-center"></div>
                        <div class="col-4 text-right">
                            <?= "<button type='submit' class='btn " . lang('app.btnSave') . " btnsave'" . (preg_match("/$stat/i", '013') ? '' : 'disabled') . ">" . lang('app.btn_Save') . "</button>"; ?>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

        </div>
    </div>
    <?= form_close() ?>
</div><!-- body end -->

<script>
    $("#notiket").change(kliktiket);

    function kliktiket() {
        var gettiket = $("#notiket").val();
        $.ajax({
            type: "POST",
            url: "/cektiket/datatiket",
            data: {
                tiket: gettiket,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    // $("#idtiket").val(response.sukses.tiket['0'].id);
                    $("#perusahaan").html(response.sukses.perusahaan);
                    $("#wilayah").html(response.sukses.wilayah);
                    $("#divisi").html(response.sukses.divisi);
                    $("#ruas").html(response.sukses.ruas);
                    $("#biaya").html(response.sukses.biaya);
                    $("#barang").html(response.sukses.barang);
                    // $("#bentuk").html(response.sukses.bentuk);
                    // $("#kategori").html(response.sukses.kategori);
                    $("#alat").html(response.sukses.alat);
                    $("#supir").html(response.sukses.supir);

                    if (typeof response.sukses.tiket !== 'undefined') {
                        $("#nomortiket").val(response.sukses.tiket['0'].notiket);
                        $("#kodecamp").val(response.sukses.cabang['0'].kode);
                        $("#namacamp").val(response.sukses.cabang['0'].nama);
                        $("#kodepelanggan").val(response.sukses.penerima['0'].kode);
                        $("#namapelanggan").val(response.sukses.penerima['0'].nama);
                        $("#kodeproyek").val(response.sukses.proyek['0'].kode);
                        $("#namaproyek").val(response.sukses.proyek['0'].paket);
                        $("#jarak").val(response.sukses.subruas['0'].jarak);
                        $("#tanggal").val(response.sukses.tiket['0'].tanggal);
                        var formatJl = new Intl.NumberFormat('id-ID').format(response.sukses.tiket['0'].jumlah); // var formatJumlah = Number(jumlah).toLocaleString();
                        $("#jumlah").val(formatJl);
                        $("#catatan").val(response.sukses.tiket['0'].catatan);
                    } else {
                        $("#nomortiket").val('');
                        $("#kodecamp").val('');
                        $("#namacamp").val('');
                        $("#kodepelanggan").val('');
                        $("#namapelanggan").val('');
                        $("#kodeproyek").val('');
                        $("#namaproyek").val('');
                        $("#jarak").val('');
                        $("#jumlah").val('');
                        $("#catatan").val('');
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        $("#notiket").select2({
            ajax: {
                url: "/cektiket/notiket",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
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

        $('.btnsave').click(function(e) {
            e.preventDefault();
            var form = $('.formtiket')[0];
            var formData = new FormData(form);
            var url = '/cektiket/save';
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
                    $('.btnsave').removeAttr('disabled');
                    $('.btnsave').html('<?= lang('app.btn_Save') ?>');
                },
                success: function(response) {
                    $('#notiket').removeClass('is-invalid');
                    $('.errnotiket').html('');

                    if (response.error) {
                        handleFieldError('notiket', response.error.notiket);
                    } else {
                        flashdata('success', response.sukses);
                        $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $(".js-example-basic-single").empty().append(`<option value=""><?= lang('app.pilih-') ?></option>`);
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

                    function clearFieldValues() {
                        $("#nomortiket").val('');
                        $("#kodecamp").val('');
                        $("#namacamp").val('');
                        $("#kodepelanggan").val('');
                        $("#namapelanggan").val('');
                        $("#kodeproyek").val('');
                        $("#namaproyek").val('');
                        $("#jarak").val('');
                        $("#jumlah").val('');
                        $("#catatan").val('');
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