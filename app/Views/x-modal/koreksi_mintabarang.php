<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMinput') ?>">
                <h4 class="modal-title"><?= lang('app.mintabarang') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open_multipart('', ['class' => 'formbarang']) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <input type="hidden" class="form-control" id="mid" name="mid" value="<?= $po[0]->id ?>">
                            <input type="hidden" class="form-control" id="mjenis" name="mjenis" value="<?= $po[0]->jenis ?>">
                            <input type="hidden" class="form-control" id="midunik" name="midunik" value="<?= $induk[0]->idunik ?>">
                            <input type="hidden" class="form-control" id="mnodoc" name="mnodoc" value="<?= $induk[0]->nodoc ?>">
                            <div class="form-group row" id="zitem2">
                                <label for="mitem" class="col-sm-1 col-form-label"><?= lang('app.item') ?></label>
                                <div class="col-sm-11">
                                    <?= "<select id='mitem' class='js-example-data-ajax' name='mitem' onchange='loadsatuanm()'>";
                                    echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                                    if ($barang1) echo "<option value='{$barang1[0]->id}' selected>{$barang1[0]->kode} => {$barang1[0]->nama} ({$barang1[0]->partnumber})</option>";
                                    echo "</select>"; ?>
                                    <div id="error" class="invalid-feedback d-block errmitem"></div>
                                </div>
                            </div>
                            <div class="form-group row" id="zjasa2">
                                <label for="mjasa" class="col-sm-1 col-form-label"><?= lang('app.jasa') ?></label>
                                <div class="col-sm-11">
                                    <?= "<select id='mjasa' class='js-example-data-ajax' name='mjasa'>";
                                    echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                                    if ($jasa1) echo "<option value='{$jasa1[0]->id}' selected>{$jasa1[0]->noakun} => {$jasa1[0]->nama}</option>";
                                    echo "</select>"; ?>
                                    <div id="error" class="invalid-feedback d-block errmjasa"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mspesifikasi" class="col-sm-1 col-form-label"><?= lang('app.spesifikasi') ?></label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" rows="3" id="mspesifikasi" name="mspesifikasi"><?= $po[0]->spesifikasi ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mjumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" harusisi class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="mjumlah" name="mjumlah" value="<?= $po[0]->jumlah ?>" />
                                    <div class="invalid-feedback errmjumlah"></div>
                                </div>
                                <div class="col-sm-2">
                                    <?= "<select id='msatuan' class='js-example-basic-single' name='msatuan'>";
                                    echo "<option value=''>" . lang('app.pilih-') . "</option>";
                                    foreach ($satuan as $db) :
                                        echo "<option value='{$db->nama}'" . (($po[0]->satuan == $db->nama) ? 'selected' : '') . ">{$db->nama}</option>";
                                    endforeach;
                                    echo "</select>"; ?>
                                    <div id="error" class="invalid-feedback d-block errmsatuan"></div>
                                </div>
                                <div class="col-sm-1"></div>
                                <label for="mkonversi" class="col-sm-1 col-form-label"><?= lang('app.konversi') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" harusisi class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="mkonversi" name="mkonversi" value="<?= $po[0]->konversi ?>" />
                                    <div class="invalid-feedback errmkonversi"></div>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-1">
                                    <input type="text" readonly class="form-control" id="msatuan2" name="msatuan2" value="<?= ($po[0]->jenis == '1' ? $barang1[0]->satuan : '') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mcatatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                                <div class="col-sm-11">
                                    <textarea harusisi class="form-control" rows="3" id="mcatatan" name="mcatatan" placeholder="<?= lang('app.harusisi') ?>"><?= $po[0]->catatan ?></textarea>
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
    function loadsatuanm() {
        var getBarang = $("#mitem").val();
        $.ajax({
            type: "POST",
            url: "/mintabarang/satuan",
            data: {
                barang: getBarang,
            },
            dataType: "json",
            success: function(response) {
                if (response.barang.length !== 0) { // if (typeof response.barang !== 'undefined')
                    const isNonStok = response.barang[0].pilihan === 'nonstok';
                    $("#msatuan2").val(response.barang[0].satuan);
                    $("#msatuan").val(response.barang[0].satuan).trigger('change');
                    $("#mkonversi").val(isNonStok ? '1,0000' : '');
                    $("#mjumlah").val(isNonStok ? '1,0000' : '');
                    $("#mkonversi").prop('readonly', isNonStok); //bernilai true false
                    $("#mjumlah").prop('readonly', isNonStok);
                } else {
                    $("#mjumlah").val('');
                    $("#mkonversi").val('');
                    $("#msatuan2").val('');
                    $("#mkonversi").prop('readonly', false);
                    $("#mjumlah").prop('readonly', false);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        const getJenis = $("#mjenis").val();
        const divItem2 = document.getElementById("zitem2");
        const divJasa2 = document.getElementById("zjasa2");
        (getJenis === '1') ? (divItem2.removeAttribute("hidden"), divJasa2.setAttribute("hidden", true)) : (divItem2.setAttribute("hidden", true), divJasa2.removeAttribute("hidden"));

        $("#mitem").select2({
            dropdownParent: $("#modal-lampiran"),
            ajax: {
                url: "/mintabarang/item",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilihan: '',
                        sn: '0',
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

        $("#mjasa").select2({
            dropdownParent: $("#modal-lampiran"),
            ajax: {
                url: "/mintabarang/jasa",
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
            <?= lang("app.inputminimum") ?>,
        })

        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formbarang')[0];
            var formData = new FormData(form);
            var url = '/mintabarang/edititem';
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
                    $('#mitem, #mjasa, #mjumlah, #msatuan, #mcatatan').removeClass('is-invalid');
                    $('.errmitem, .errmjasa, .errmjumlah, .errmsatuan, .errmcatatan').html('');
                    if (response.error) { //dari msg save lampiran
                        handleFieldError('mitem', response.error.mitem);
                        handleFieldError('mjasa', response.error.mjasa);
                        handleFieldError('mjumlah', response.error.mjumlah);
                        handleFieldError('msatuan', response.error.msatuan);
                        handleFieldError('mcatatan', response.error.mcatatan);
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
                        $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("#mspesifikasi").val('');
                        $("#mjumlah").val('');
                        $("#msatuan").val('').trigger('change');
                        $("#mkonversi").val('');
                        $("#msatuan2").val('');
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