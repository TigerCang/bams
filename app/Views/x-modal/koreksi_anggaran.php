<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMinput') ?>">
                <h4 class="modal-title"><?= lang('app.anggaran') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open_multipart('', ['class' => 'formanggaran']) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <input type="hidden" class="form-control" id="mid" name="mid" value="<?= $anggaran[0]->id ?>">
                            <input type="hidden" class="form-control" id="midunik" name="midunik" value="<?= $anggaran[0]->idunik ?>">
                            <input type="hidden" class="form-control" id="mtujuan" name="mtujuan" value="<?= $anggaran[0]->tujuan ?>">
                            <input type="hidden" class="form-control" id="mitem" name="mitem" value="<?= ($anggaran[0]->biaya_id == '0' ? $anggaran[0]->akun_id : $anggaran[0]->biaya_id) ?>">
                            <div class="form-group row" id="zbiaya2">
                                <label for="mbiaya" class="col-sm-1 col-form-label"><?= lang('app.itembiaya') ?></label>
                                <div class="col-sm-11">
                                    <?= "<select id='mbiaya' class='js-example-basic-single' name='mbiaya' disabled>";
                                    echo "<option value=''>" . lang('app.pilih-') . "</option>";
                                    if ($biaya1) echo "<option value='{$biaya1[0]->id}' selected>{$biaya1[0]->kode} => {$biaya1[0]->nama}</option>";
                                    echo "</select>"; ?>
                                </div>
                            </div>
                            <div class="form-group row" id="zakun2">
                                <label for="makun" class="col-sm-1 col-form-label"><?= lang('app.noakun') ?></label>
                                <div class="col-sm-11">
                                    <?= "<select id='makun' class='js-example-basic-single' name='makun' disabled>";
                                    echo "<option value=''>" . lang('app.pilih-') . "</option>";
                                    if ($akun1) echo "<option value='{$akun1[0]->id}' selected>{$akun1[0]->noakun} => {$akun1[0]->nama}</option>";
                                    echo "</select>"; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mbulan" class="col-sm-1 col-form-label"><?= ucfirst(lang('app.bulan')) ?></label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="mbulan" name="mbulan" value="<?= $anggaran[0]->bulan ?>" onchange="hitungmtotal()" />
                                </div>
                                <label for="mjumlah" class="col-sm-1 col-form-label">&emsp;<?= lang('app.jumlah') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="mjumlah" name="mjumlah" value="<?= $anggaran[0]->jumlah ?>" onchange="hitungmtotal()" />
                                </div>
                                <label for="mharga" class="col-sm-1 col-form-label">&emsp;<?= lang('app.harga') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="mharga" name="mharga" value="<?= $anggaran[0]->harga ?>" onchange="hitungmtotal()" />
                                </div>
                                <div class="col-sm-1"></div>
                                <label for="mtotal" class="col-sm-1 col-form-label">&emsp;<?= lang('app.total') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="mtotal" name="mtotal" value="<?= $anggaran[0]->total ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mcatatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                                <div class="col-sm-11">
                                    <textarea harusisi class="form-control" rows="3" id="mcatatan" name="mcatatan" placeholder="<?= lang('app.harusisi') ?>"><?= $anggaran[0]->catatan ?></textarea>
                                    <div class="invalid-feedback errmcatatan"></div>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="modal-footer"><?= "<button type='submit' class='btn " . lang('app.btncOK') . " btnok'>" . lang('app.btnOK') . "</button>"; ?></div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/extra/css/modal.css">
<script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/form-masking/form-mask.js"></script>
<script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/advance-elements/select2-custom.js"></script>
<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/select2/js/select2.full.min.js"></script>
<script>
    function hitungmtotal() {
        if (document.getElementById('mbulan').value === '') document.getElementById('mbulan').value = '0,00'
        if (document.getElementById('mjumlah').value === '') document.getElemesntById('mjumlah').value = '0,0000'
        if (document.getElementById('mharga').value === '') document.getElementById('mharga').value = '0,00'
        var bulan = formatAngka(document.getElementById('mbulan').value, 'nol');
        var jumlah = formatAngka(document.getElementById('mjumlah').value, 'nol');
        var harga = formatAngka(document.getElementById('mharga').value, 'nol');
        var total = parseFloat(bulan) * parseFloat(jumlah) * parseFloat(harga);
        document.getElementById('mtotal').value = formatAngka(total, 'rp');
    }

    $(document).ready(function() {
        const getTujuan = $("#mtujuan").val();
        const divBiaya2 = document.getElementById("zbiaya2");
        const divAkun2 = document.getElementById("zakun2");
        (getTujuan === 'proyek') ? (divBiaya2.removeAttribute("hidden"), divAkun2.setAttribute("hidden", true)) : (divBiaya2.setAttribute("hidden", true), divAkun2.removeAttribute("hidden"));

        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formanggaran')[0];
            var formData = new FormData(form);
            var url = '/anggaran/edititem';
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
                    $('.btnok').attr('disable', 'disabled');
                    $('.btnok').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnok').removeAttr('disable', 'disabled');
                    $('.btnok').html('<?= lang('app.btnOK') ?>');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.mcatatan) {
                            $('#mcatatan').addClass('is-invalid');
                            $('.errmcatatan').html(response.error.mcatatan);
                        } else {
                            $('#mcatatan').removeClass('is-invalid');
                            $('.errmcatatan').html('');
                        }
                    } else {
                        clearElements();
                        flashdata('success', response.sukses);
                        $('#modal-lampiran').modal('hide');
                        databudget();
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
                        $("#mbulan").val('');
                        $("#mjumlah").val('');
                        $("#mharga").val('');
                        $("#mtotal").val('');
                        $("#mcatatan").val('');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        });
    });
</script>