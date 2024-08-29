<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'formmain']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-4">

        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= ($anggaran[0]->idunik ?? '') ?>" />
                <input type="hidden" id="awal" name="awal" value="0">
                <input type="hidden" id="xpilih" name="xpilih" value="<?= ($anggaran[0]->pilih ?? '') ?>">
                <input type="hidden" id="xbeban" name="xbeban" value="<?= ($anggaran[0]->beban ?? '') ?>">
                <input type="hidden" id="xjenis" name="xjenis" value="<?= ($anggaran[0]->jenis ?? '') ?>">

                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="judul" name="judul" <?= (isset($anggaran[0]->kondisi[0]) && $anggaran[0]->kondisi[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($anggaran[0]->judul ?? '') ?>" />
                            <label for="judul"><?= lang('app.judul') ?></label>
                            <div id="error" class="invalid-feedback errjudul"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="pilih" name="pilih">
                                <?php foreach ($selpilih as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($anggaran[0]->pilih) && $anggaran[0]->pilih == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="pilih"><?= lang('app.pilih') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="beban" name="beban">
                                <?php foreach ($selbeban as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($anggaran[0]->beban) && $anggaran[0]->beban == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="beban"><?= lang('app.objek') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row" id="zjenis">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="jenis" name="jenis">
                                <?php foreach ($jenis as $db) : ?>
                                    <option value="<?= $db->kode ?>" <?= (isset($anggaran[0]->jenis) && $anggaran[0]->jenis == $db->kode ? 'selected' : '') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="jenis"><?= lang('app.jenis') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 ms-auto text-end">
                        <div class="btn-group" id="dropdown-icon">
                            <button type="button" class="<?= json('btn submit') ?> btnsubmit me-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= json('submit') ?></button>
                            <ul class="dropdown-menu">
                                <li><button type="button" name="action" value="save" class="dropdown-item d-flex align-items-center btnsave" <?= $button['save'] ?>><?= lang('app.btn save') ?></button></li>
                                <li><button type="button" name="action" value="confirm" class="dropdown-item d-flex align-items-center btnsave" <?= $button['conf'] ?>><?= lang('app.btn konf') ?></button></li>
                                <li><button type="button" name="action" value="hapus" class="dropdown-item d-flex align-items-center btnsave" <?= $button['del'] ?>><?= lang('app.btn hapus') ?></button></li>
                                <li><button type="button" name="action" value="aktif" class="dropdown-item d-flex align-items-center btnsave" <?= $button['aktif'] ?>><?= $btnaktif ?></button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card Footer -->
        </div> <!--/ Card awal -->
    </div> <!--/ Coloum kiri -->

    <div class="col-12 col-md-12 col-lg-8">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row" id="zbiaya">
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="biaya" name="biaya">
                            </select>
                            <div id="error" class="invalid-feedback errbiaya"></div>
                            <label for="biaya"><?= lang('app.item biaya') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row" id="zakun">
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="akun" name="akun">
                            </select>
                            <div id="error" class="invalid-feedback errakun"></div>
                            <label for="akun"><?= lang('app.noakun') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="bulan" name="bulan" placeholder="" onchange="hitungTotal()" />
                            <label for="bulan"><?= lang('app.bulan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" placeholder="" onchange="hitungTotal()" />
                            <label for="jumlah"><?= lang('app.jumlah') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="harga" name="harga" placeholder="" onchange="hitungTotal()" />
                            <label for="harga"><?= lang('app.harga') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-a-sep="." data-a-dec="," id="total" name="total" placeholder="" />
                            <label for="total"><?= lang('app.total') ?></label>
                            <div id="error" class="invalid-feedback errtotal"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""><?= ($alat[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($alat[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($alat[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($alat[0]->aktifby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <button type="button" class="<?= json('btn submit') ?> btntambah"><?= lang('app.btn add') ?></button>
                    </div>
                </div>
            </div> <!--/ Card Footer -->
        </div> <!--/ Card isian -->
    </div> <!--/ Coloum kanan -->
</div> <!--/ Row-->
<?= form_close() ?>

<div class="card-datatable table-responsive viewTabel"></div>

<script>
    $("#pilih, #beban, #jenis").change(function() {
        if (this.id === 'pilih') {
            $("#xpilih").val($(this).val());
            var pilihValue = $(this).val();
            document.getElementById('awal').value = (pilihValue === 'pendapatan') ? '4' : '6';
        } else if (this.id === 'beban') {
            $("#xbeban").val($("#beban").val());
            const isProyek = document.getElementById('xbeban').value === 'proyek';
            $('#zjenis, #zbiaya').attr('hidden', !isProyek);
            $('#zakun').attr('hidden', isProyek);
        } else if (this.id === 'jenis') {
            $("#xjenis").val($(this).val());
        }
    });

    function hitungTotal() {
        if (document.getElementById('bulan').value === '') document.getElementById('bulan').value = '0,00'
        if (document.getElementById('jumlah').value === '') document.getElementById('jumlah').value = '0,0000'
        if (document.getElementById('harga').value === '') document.getElementById('harga').value = '0,00'
        var bulan = formatAngka(document.getElementById('bulan').value, 'nol');
        var jumlah = formatAngka(document.getElementById('jumlah').value, 'nol');
        var harga = formatAngka(document.getElementById('harga').value, 'nol');
        var total = parseFloat(bulan) * parseFloat(jumlah) * parseFloat(harga);
        $('#total').val(formatAngka(total, 'rp'));
        // document.getElementById('total').value = formatAngka(total, 'rp');
    }

    function dataAnggaran() {
        var getIdu = $("#idunik").val();
        var getBeban = $("#xbeban").val();
        var getJudul = $("#judul").val();
        $.ajax({
            url: "<?= $link ?>/tabel",
            data: {
                idunik: getIdu,
                beban: getBeban,
                judul: getJudul,
            },
            dataType: "json",
            success: function(response) {
                $('.viewTabel').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        dataAnggaran();
        $("#pilih, #beban, #jenis").trigger("change")

        $('#akun').select2({
            ajax: {
                url: "<?= $link ?>/akun",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        awal: $("#awal").val(),
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= json('min input') ?>,
            <?= json('template 1') ?>,
            <?= json('template 2') ?>,
        });

        $('#biaya').select2({
            ajax: {
                url: "<?= $link ?>/biaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        param: 'biaya',
                        ruas: '',
                        awal: $('#xjenis').val().substring(0, 2),
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= json('min input') ?>,
            <?= json('template 1') ?>,
            <?= json('template 2') ?>,
        });
    });

    $('.btnlampir').click(function(e) {
        e.preventDefault();
        var getIdu = $("#idunik").val();
        $.ajax({
            url: "/lampiran/input",
            data: {
                idunik: getIdu,
                param: 'alat',
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

    $('.btntambah').click(function(e) {
        e.preventDefault();
        var form = $('.formmain')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
        var url = '<?= $link ?>/add';
        formData.append('postaction', getAction);
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btntambah').attr('disabled', 'disabled');
                $('.btntambah').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btntambah').removeAttr('disabled');
                $('.btntambah').each(function() {
                    $(this).html('<?= json('submit') ?>');
                });
            },
            success: function(response) {
                $('#akses, #judul, #biaya, #akun, #total').removeClass('is-invalid');
                $('.errakses, .errjudul, .errbiaya, .errakun, .errtotal').html('');
                if (response.error) {
                    handleFieldError('akses', response.error.akses);
                    handleFieldError('judul', response.error.judul);
                    handleFieldError('biaya', response.error.biaya);
                    handleFieldError('akun', response.error.akun);
                    handleFieldError('total', response.error.total);
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

    $('.btnsave').click(function(e) {
        e.preventDefault();
        var form = $('.formmain')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
        var url = '<?= $link ?>/save';
        formData.append('postaction', getAction);
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btnsubmit').attr('disabled', 'disabled');
                $('.btnsubmit').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btnsubmit').removeAttr('disabled');
                $('.btnsubmit').each(function() {
                    $(this).html('<?= json('submit') ?>');
                });
            },
            success: function(response) {
                $('#kode, #deskripsi, #biaya, #gambar').removeClass('is-invalid');
                $('.errkode, .errdeskripsi, .errbiaya, .errgambar').html('');
                if (response.error) {
                    handleFieldError('kode', response.error.kode);
                    handleFieldError('deskripsi', response.error.deskripsi);
                    handleFieldError('biaya', response.error.biaya);
                    handleFieldError('gambar', response.error.gambar);
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
</script>

<?= $this->endSection() ?>