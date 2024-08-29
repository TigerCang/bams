<div onload="flashdata()"></div>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formbarang']) ?>
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
                <!--  -->
                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" id="idunik" name="idunik">
                    <input type="hidden" class="form-control" id="awal" name="awal" value="<?= $nodoc[0]->nama ?>">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi">
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='perusahaan' class='js-example-basic-single' name='perusahaan' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($perusahaan as $db) :
                                echo "<option value='{$db->id}' data-kui='{$db->kui}'>{$db->kode} => {$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='wilayah' class='js-example-basic-single' name='wilayah' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($wilayah as $db) :
                                echo "<option value='{$db->id}'>{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='divisi' class='js-example-basic-single' name='divisi' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($divisi as $db) :
                                echo "<option value='{$db->id}'>{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
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
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc">
                        </div>
                        <div class="col-sm-4"></div>
                        <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pegawai" class="col-sm-1 col-form-label"><?= lang('app.pegawai') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='pegawai' class='js-example-data-ajax' name='pegawai'>";
                            echo "<option value='' selected>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errpegawai"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

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
                        <label for="barang" class="col-sm-1 col-form-label"><?= lang('app.item') ?></label>
                        <div class="col-sm-10">
                            <?= "<select id='barang' class='js-example-data-ajax' name='barang'>";
                            echo "<option value='' selected>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                            <div class="invalid-feedback d-block errbarang"></div>
                        </div>
                        <div class="col-sm-1 text-right">
                            <button type="button" class="btn <?= lang('app.btncNew') ?> inputatk"><?= lang('app.btnNew') ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                        <div class="col-sm-2">
                            <input type="text" harusisi class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" value="<?= old('jumlah') ?>" />
                            <div class="invalid-feedback errjumlah"></div>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="satuan" name="satuan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"><?= old('catatan') ?></textarea>
                            <div class="invalid-feedback errcatatan"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="col-4">
                            <button type="button" class="btn <?= lang('app.btncLogaksi') ?> btnlog"><?= lang('app.btnLogaksi') ?>
                        </div>
                        <div class="col-4 text-center"></div>
                        <div class="col-4 text-right">
                            <?= "<button type='submit' class='btn " . lang('app.btncAdd') . " btnadd'>" . lang('app.btnAdd') . "</button>"; ?>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dt-responsive table-responsive tabelbarang"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#pegawai").change(loadperusahaan);

    function loadperusahaan() {
        var getTanggal = $("#tanggal").val();
        var getPegawai = $("#pegawai").val();
        $.ajax({
            type: "POST",
            url: "/ambilbarang/perusahaan",
            data: {
                tanggal: getTanggal,
                pegawai: getPegawai,
            },
            dataType: "json",
            success: function(response) {
                if (Object.keys(response.pegawai).length !== 0) {
                    $("#idperusahaan").val(response.pegawai['0'].perusahaan_id);
                    $("#idwilayah").val(response.pegawai['0'].wilayah_id);
                    $("#iddivisi").val(response.pegawai['0'].divisi_id);
                    $("#perusahaan").val(response.pegawai['0'].perusahaan_id).change();
                    $("#wilayah").val(response.pegawai['0'].wilayah_id).change();
                    $("#divisi").val(response.pegawai['0'].divisi_id).change();
                    $("#idunik").val(response.idunik).change();
                    $("#nodoc").val(response.nodoc).change();
                } else {
                    $("#idperusahaan").val('');
                    $("#idwilayah").val('');
                    $("#iddivisi").val('');
                    $("#perusahaan").val('').change();
                    $("#wilayah").val('').change();
                    $("#divisi").val('').change();
                    $("#idunik").val('').change();
                    $("#nodoc").val('').change();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function dataitembarang() {
        var getTanggal = $("#tanggal").val();
        $.ajax({
            url: "/ambilbarang/tabbarang",
            data: {
                tanggal: getTanggal,
                asal: 'ambil',
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

    $(document).ready(function() {
        dataitembarang();

        $("#pegawai").select2({
            ajax: {
                url: "/ambilbarang/pegawai",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '0001',
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

        $("#barang").select2({
            ajax: {
                url: "/ambilbarang/atk",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                    };
                },
                processResults: function(response) {
                    var results = response.map(function(item) {
                        return {
                            id: item.id,
                            text: item.text,
                            dataSatuan: item['data-satuan']
                        };
                    });
                    return {
                        results: results
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum") ?>,
        })

        $("#barang").on("change", function() {
            var selectedOption = $(this).select2("data")[0];
            $('#satuan').val(selectedOption.dataSatuan);
        });

        $('.btnadd').click(function(e) {
            e.preventDefault();
            var form = $('.formbarang')[0];
            var formData = new FormData(form);
            var url = '/ambilbarang/additem';
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
                    $('#pegawai, #barang, #jumlah, #catatan').removeClass('is-invalid');
                    $('.errpegawai, .errbarang, .errjumlah, .errcatatan').html('');
                    if (response.error) {
                        handleFieldError('pegawai', response.error.pegawai);
                        handleFieldError('barang', response.error.barang);
                        handleFieldError('jumlah', response.error.jumlah);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        clearElements();
                        flashdata('success', response.sukses);
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
                        $("select[name='pegawai']").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("#idperusahaan").val("");
                        $("#idwilayah").val("");
                        $("#iddivisi").val("");
                        $("#perusahaan").val("").trigger('change');
                        $("#wilayah").val("").trigger('change');
                        $("#divisi").val("").trigger('change');
                        $("#pegawai").val("").trigger('change');
                        $("#jumlah").val("");
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

        $('.inputatk').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "/ambilbarang/modalinput",
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

        $('.btnlog').click(function(e) {
            e.preventDefault();
            // var getIDU = "<= $idunik ?>";
            $.ajax({
                url: "/ambilbarang/logaksi",
                data: {
                    // idunik: getIDU,
                    pilihan: 'cek',
                    asal: 'cekbarang',
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
    });
</script>

<?= $this->endSection() ?>