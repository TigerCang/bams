<div onload="flashdata()"></div>

<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMlampir'); ?>">
                <h4 class="modal-title"><?= lang('app.editdata'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open_multipart('', ['class' => 'formlampiran']) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <input type="text" class="form-control" id="xjenis2" name="xjenis2" value="<?= (old('xjenis2')) ? old('xjenis2') : $po['0']->jenis; ?>">
                            <input type="text" class="form-control" id="mid" name="mid" value="<?= $po['0']->id; ?>">

                            <div class="form-group row">
                                <label for="jenisdata2" class="col-sm-1 col-form-label"><?= lang('app.jenis'); ?></label>
                                <div class="col-sm-5 d-inline">
                                    <input class="switch bs-switch" data="xjenis2" type="checkbox" <?= (old('xjenis2')) ? ((old('xjenis2') == '1') ? 'checked' : '') : (($po['0']->jenis == '1') ? 'checked' : ''); ?> data-on-text="<?= lang('app.namabarang'); ?>" data-off-text="<?= lang('app.jasa'); ?>" data-on-color="primary" data-off-color="success">
                                </div>
                            </div>
                            <div class="form-group row" id="zitem2">
                                <label for="item2" class="col-sm-1 col-form-label"><?= lang('app.namabarang'); ?></label>
                                <div class="col-sm-11">
                                    <select id="item2" class="js-example-data-ajax" name="item2" onchange="loadsatuan()">
                                        <option value=""><?= lang('app.pilihsr'); ?></option>
                                        <?php if ($po['0']->jenis == '1') {
                                            echo "<option value='" . $po['0']->barang_id . "' selected='selected'>" . $barang1['0']->kode . ' => ' . $barang1['0']->nama . " (" . $barang1['0']->partnumber . ")" . "</option>";
                                        } ?>
                                    </select>
                                    <div id="error" class="invalid-feedback d-block erritem2"></div>
                                </div>
                            </div>
                            <div class="form-group row" id="zbiaya2">
                                <label for="biaya2" class="col-sm-1 col-form-label"><?= lang('app.jasa'); ?></label>
                                <div class="col-sm-11">
                                    <select id="biaya2" class="js-example-data-ajax" name="biaya2">
                                        <option value=""><?= lang('app.pilihsr'); ?></option>
                                        <?php if ($po['0']->jenis == '0') {
                                            echo "<option value='" . $po['0']->barang_id . "' selected='selected'>" . $akun1['0']->noakun . ' => ' . $akun1['0']->nama . "</option>";
                                        } ?>
                                    </select>
                                    <div id="error" class="invalid-feedback d-block errbiaya2"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="spesifikasi2" class="col-sm-1 col-form-label"><?= lang('app.spesifikasi'); ?></label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" rows="3" id="spesifikasi2" name="spesifikasi2"><?= (old('spesifikasi')) ? old('spesifikasi') : $po['0']->spesifikasi; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jumlah2" class="col-sm-1 col-form-label"><?= lang('app.jumlah'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" harusisi class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="jumlah2" name="jumlah2" placeholder="<?= lang('app.harusisi'); ?>" value="<?= (old('jumlah')) ? old('jumlah') : $po['0']->jumlah; ?>" autocomplete="off" />
                                    <div class="invalid-feedback errjumlah2"></div>
                                </div>
                                <div class="col-sm-3"></div>
                                <label for="satuan2" class="col-sm-1 col-form-label"><?= lang('app.satuan'); ?></label>
                                <div class="col-sm-4">
                                    <select id="satuan2" class="js-example-basic-single select2-container--modal" name="satuan2">
                                        <option value=""><?= lang('app.pilih-'); ?></option>

                                    </select>
                                    <div id="error" class="invalid-feedback d-block errsatuan2"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="catatan2" class="col-sm-1 col-form-label"><?= lang('app.catatan'); ?></label>
                                <div class="col-sm-11">
                                    <textarea harusisi class="form-control" rows="3" id="catatan2" name="catatan2" placeholder="<?= lang('app.harusisi'); ?>"><?= (old('catatan')) ? old('catatan') : $po['0']->catatan; ?></textarea>
                                    <div class="invalid-feedback errcatatan2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn <?= lang('app.btnOk'); ?> btnok" name="attach"><?= lang('app.btn_Ok'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>

<script>
    var switch2 = 'input[type="checkbox"].bs-switch';
    const divItem2 = document.getElementById("zitem2");
    const divBiaya2 = document.getElementById("zbiaya2");
    divItem2.removeAttribute("hidden", true);
    divBiaya2.setAttribute("hidden", true);

    $(switch2).bootstrapSwitch(); // Convert all checkboxes with className `bs-switch` to switches.
    $(switch2).on('switchChange.bootstrapSwitch', function(event, state) {
        if (state == true) {
            divItem2.removeAttribute("hidden", true);
            divBiaya2.setAttribute("hidden", true);
        } else {
            divItem2.setAttribute("hidden", true);
            divBiaya2.removeAttribute("hidden", true);
        }
    });

    function loadsatuan() {
        var getBarang = $("#item2").val();
        $.ajax({
            type: "POST",
            url: "/mintabarang/satuan",
            data: {
                barang: getBarang,
            },
            dataType: "json",
            success: function(response) {
                if (response.satuan) {
                    $("#satuan2").html(response.satuan);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        <?php if ($po['0']->jenis == '1') { ?>
            loadsatuan()
        <?php } ?>

        $("#item2").select2({
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
            <?= lang("app.inputminimum"); ?>,
        })

        $("#biaya2").select2({
            dropdownParent: $("#modal-lampiran"),
            ajax: {
                url: "/mintabarang/biaya",
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
    });
</script>

<script type="text/javascript" src="<?= base_url('libraries'); ?>/assets/pages/form-masking/form-mask.js"></script>
<script type="text/javascript" src="<?= base_url('libraries'); ?>/bower_components/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?= base_url('libraries'); ?>/assets/pages/advance-elements/select2-custom.js"></script>
<script type="text/javascript" src="<?= base_url('libraries'); ?>/bower_components/extra/js/modal.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('libraries'); ?>/bower_components/extra/css/modal.css">