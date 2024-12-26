<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMinput') ?>">
                <h4 class="modal-title"><?= lang('app.tawarharga') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open_multipart('', ['class' => 'formbarang']) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <input type="hidden" class="form-control" id="mid" name="mid" value="<?= $tawar[0]->id ?>">
                            <input type="hidden" class="form-control" id="mjenis" name="mjenis" value="<?= $po[0]->jenis ?>">
                            <input type="hidden" class="form-control" id="mbarang" name="mbarang" value="<?= ($po[0]->jenis == '1' ? $barang1[0]->nama : $jasa1[0]->nama) ?>">
                            <input type="hidden" class="form-control" id="midunik" name="midunik" value="<?= $induk[0]->idunik ?>">
                            <input type="hidden" class="form-control" id="mnodoc" name="mnodoc" value="<?= $induk[0]->nodoc ?>">
                            <div class="form-group row" id="zitem2">
                                <label for="mitem" class="col-sm-1 col-form-label"><?= lang('app.item') ?></label>
                                <div class="col-sm-11">
                                    <?= "<select id='mitem' class='js-example-basic-single' name='mitem' disabled>";
                                    if ($barang1) echo "<option value='{$barang1['0']->id}' selected>{$barang1['0']->kode} => {$barang1['0']->nama} ({$barang1['0']->partnumber})</option>";
                                    echo "</select>"; ?>
                                </div>
                            </div>
                            <div class="form-group row" id="zjasa2">
                                <label for="mjasa" class="col-sm-1 col-form-label"><?= lang('app.jasa') ?></label>
                                <div class="col-sm-11">
                                    <?= "<select id='mjasa' class='js-example-basic-single' name='mjasa' disabled>";
                                    if ($jasa1) echo "<option value='{$jasa1['0']->id}' selected>{$jasa1['0']->noakun} => {$jasa1['0']->nama}</option>";
                                    echo "</select>"; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mspesifikasi" class="col-sm-1 col-form-label"><?= lang('app.spesifikasi') ?></label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" readonly rows="3" id="mspesifikasi" name="mspesifikasi"><?= $po['0']->spesifikasi ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mjumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="mjumlah" name="mjumlah" value="<?= $po['0']->jumlah - $po['0']->ada ?>" />
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" readonly class="form-control" id="msatuan" name="msatuan" value="<?= $po['0']->satuan ?>">
                                </div>
                                <div class="col-sm-1"></div>
                                <label for="mpesan" class="col-sm-1 col-form-label"><?= lang('app.pesan') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="mpesan" name="mpesan" value="" />
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="msuplier" class="col-sm-1 col-form-label"><?= lang('app.suplier') ?></label>
                                <div class="col-sm-11">
                                    <?= "<select id='msuplier' class='js-example-data-ajax' name='msuplier'>";
                                    echo "<option value='' selected>" . lang('app.pilihsr') . "</option>";
                                    if ($suplier1) echo "<option value='{$suplier1[0]->id}' selected>{$suplier1[0]->kode} => {$suplier1[0]->nama}</option>";
                                    echo "</select>"; ?>
                                    <div class="invalid-feedback d-block errmsuplier"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mjltawar" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="mjltawar" name="mjltawar" value="<?= $tawar['0']->jumlah ?>" onchange="hitungtotal()" />
                                    <div class="invalid-feedback errmjltawar"></div>
                                </div>
                                <label for="mharga" class="col-sm-1 col-form-label text-right"><?= lang('app.harga') ?>&emsp;</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="mharga" name="mharga" value="<?= $tawar['0']->harga ?>" onchange="hitungtotal()" />
                                </div>
                                <label for="mdiskon" class="col-sm-1 col-form-label text-right"><?= lang('app.diskon') ?>&emsp;</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="mdiskon" name="mdiskon" value="<?= $tawar['0']->diskon ?>" onchange="hitungtotal()" />
                                </div>
                                <label for="mtotal" class="col-sm-1 col-form-label text-right"><?= lang('app.total') ?>&emsp;</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-right autonumber" readonly data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="mtotal" name="mtotal" value="<?= $tawar['0']->total ?>" />
                                    <div class="invalid-feedback errmtotal"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mpajak" class="col-sm-1 col-form-label"><?= lang('app.pajak') ?></label>
                                <div class="col-sm-1">
                                    <input type="checkbox" id="mpajak" name="mpajak" data-toggle="toggle" <?= (($tawar[0]->st_pajak == '1') ? 'checked' : '') ?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mcatatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" rows="3" id="mcatatan" name="mcatatan" placeholder="<?= lang('app.harusisi') ?>"><?= $tawar['0']->catatan ?></textarea>
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
    function hitungtotal() {
        if (document.getElementById('mjltawar').value === '') document.getElementById('mjltawar').value = '0,0000'
        if (document.getElementById('mharga').value === '') document.getElementById('mharga').value = '0,00'
        if (document.getElementById('mdiskon').value === '') document.getElementById('mdiskon').value = '0,00'
        var jumlah = formatAngka(document.getElementById('mjltawar').value, 'nol');
        var harga = formatAngka(document.getElementById('mharga').value, 'nol');
        var diskon = formatAngka(document.getElementById('mdiskon').value, 'nol');
        var total = parseFloat(jumlah) * (parseFloat(harga) - parseFloat(diskon));
        document.getElementById('mtotal').value = formatAngka(total, 'rp');
    }

    $(document).ready(function() {
        const getJenis = $("#mjenis").val();
        const divItem2 = document.getElementById("zitem2");
        const divJasa2 = document.getElementById("zjasa2");
        (getJenis === '1') ? (divItem2.removeAttribute("hidden"), divJasa2.setAttribute("hidden", true)) : (divItem2.setAttribute("hidden", true), divJasa2.removeAttribute("hidden"));

        $('#modal-lampiran').on('shown.bs.modal', function() {
            $('#mpajak').bootstrapToggle({
                on: '<?= lang('app.ya') ?>',
                off: '<?= lang('app.no') ?>',
                onstyle: 'success',
                offstyle: 'light'
            });
        });

        $("#msuplier").select2({
            dropdownParent: $("#modal-lampiran"),
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

        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formbarang')[0];
            var formData = new FormData(form);
            var url = '/tawarharga/edititem';
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
                    $('#msuplier, #mjltawar #mtotal, #mcatatan').removeClass('is-invalid');
                    $('.errmsuplier, .errmjltawar, .errmtotal, .errmcatatan').html('');
                    if (response.error) {
                        handleFieldError('msuplier', response.error.msuplier);
                        handleFieldError('mjltawar', response.error.mjltawar);
                        handleFieldError('mtotal', response.error.mtotal);
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
                        $("select[name='msuplier']").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("#mjltawar").val("");
                        $("#mtotal").val("");
                        $("#mcatatan").val("");
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