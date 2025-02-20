<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'formmain']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= $idunik ?>" />
                <input type="hidden" id="xkui" name="xkui">
                <input type="hidden" id="xbeban" name="xbeban">

                <div class="row g-2">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="perusahaan" name="perusahaan">
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->inisial ?>" <?= (isset($kas[0]->perusahaan_id) && $kas[0]->perusahaan_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][0] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['perusahaan']) ? '' : 'disabled') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="perusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="wilayah" name="wilayah">
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->nama2 ?>" <?= (isset($kas[0]->wilayah_id) && $kas[0]->wilayah_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][1] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="wilayah"><?= lang('app.wilayah') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="divisi" name="divisi">
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->nama2 ?>" <?= (isset($kas[0]->divisi_id) && $kas[0]->divisi_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][2] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="divisi"><?= lang('app.divisi') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card perusahaan-->
    </div> <!--/ Coloum kiri -->

    <div class="col-12 col-md-12 col-lg-8">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="dokumen" name="dokumen" placeholder="" value="<?= ($kas[0]->nodokumen ?? '') ?>" />
                            <label for="dokumen"><?= lang('app.dokumen') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="revisi" name="revisi" placeholder="" value="<?= ($kas[0]->revisi ?? '') ?>" />
                            <label for="revisi"><?= lang('app.revisi') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" readonly class="form-control" id="tglminta" name="tglminta" value="<?= ($kas[0]->tgl_minta ?? date('Y-m-d')) ?>" />
                            <label for="tglminta"><?= lang('app.tanggal') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-8 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="peminta" name="peminta" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($user1) : ?> <option value="<?= $user1[0]->kode ?>" selected data-subtext="<?= $user1[0]->namapegawai ?>"><?= $user1[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="peminta"><?= lang('app.peminta') ?></label>
                            <div id="error" class="invalid-feedback errpeminta"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="beban" name="beban" data-placeholder="">
                                <?php foreach ($selbeban as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($kas[0]->beban) && $kas[0]->beban == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="beban"><?= lang('app.objek') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-4 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="kodebeban" name="kodebeban" placeholder="<?= lang('app.harus') ?>" value="" />
                            <label for="kodebeban"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkodebeban"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-9 d-flex justify-content-between align-items-center mb-4">
                        <div class="form-floating form-floating-outline w-100 me-2">
                            <input type="text" class="form-control" id="namabeban" name="namabeban" placeholder="" value="" />
                            <label for="namabeban"><?= lang('app.deskripsi') ?></label>
                        </div>
                        <div>
                            <button type="button" class="<?= json('btn pilih') ?> btnpilih"><?= json('btn ipilih') ?></button>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-8 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="penerima" name="penerima" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($penerima1) : ?> <option value="<?= $penerima1[0]->id ?>" selected data-subtext="<?= $penerima1[0]->nama ?>"><?= $penerima1[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="penerima"><?= lang('app.penerima') ?></label>
                            <div id="error" class="invalid-feedback errpenerima"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-4">
                        <input type="file" class="form-control" id="lampiran" name="lampiran" />
                        <div id="error" class="invalid-feedback errlampiran"></div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card dokumen -->
    </div> <!--/ Coloum kiri -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="akun" name="akun" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($akun1) : ?> <option value="<?= $akun1[0]->id ?>" selected data-subtext="<?= $akun1[0]->nama ?>"><?= $akun1[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="akun"><?= lang('app.noakun') ?></label>
                            <div id="error" class="invalid-feedback errakun"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" placeholder="" value="<?= $kasanak[0]->jumlah ?? '0' ?>" />
                            <label for="jumlah"><?= lang('app.jumlah') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="harga" name="harga" placeholder="" value="<?= $kasanak[0]->harga ?? '0' ?>" />
                            <label for="harga"><?= lang('app.harga') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="total" name="total" value="<?= $kasanak[0]->debit ?? '0' ?>" placeholder="" />
                            <label for="total"><?= lang('app.total') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""><?= ($kasanak[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-6 mb-4">
                    </div>
                    <div class="col-6 ms-auto text-end">
                        <div class="btn-group" id="dropdown-icon">
                            <button type="button" class="<?= json('btn submit') ?> btnsubmit dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= json('submit') ?></button>
                            <ul class="dropdown-menu">
                                <li><button type="button" name="action" value="save" class="dropdown-item d-flex align-items-center btnsave"><?= lang('app.btn save') ?></button></li>
                                <li><button type="button" name="action" value="batal" class="dropdown-item d-flex align-items-center btnsave"><?= lang('app.btn batal') ?></button></li>
                                <li><button type="button" name="action" value="confirm" class="dropdown-item d-flex align-items-center btnsave"><?= lang('app.btn konf') ?></button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card Footer -->
        </div> <!--/ Card akhir -->

    </div> <!--/ Col-->
</div> <!--/ Row-->
<?= form_close() ?>

<div class="modalpilih" style="display: none;"></div>

<script>
    $("#jumlah, #harga").change(hitungTotal);
    $("#perusahaan, #divisi, #wilayah").change(function() {
        var awal = "<?= $dokumen[0]->nama ?? '' ?>";
        document.getElementById('xkui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + '/' + $("#wilayah").find(':selected').data('kui') + '.' + $("#divisi").find(':selected').data('kui') + '/';
    });

    function hitungTotal() {
        if (document.getElementById('jumlah').value === '') document.getElementById('jumlah').value = '0,0000'
        if (document.getElementById('harga').value === '') document.getElementById('harga').value = '0,00'
        var jumlah = formatAngka(document.getElementById('jumlah').value, 'nol');
        var harga = formatAngka(document.getElementById('harga').value, 'nol');
        var total = parseFloat(jumlah) * parseFloat(harga);
        $('#total').val(formatAngka(total, 'rp'));
    }

    $(document).on('click', '.btnpilih', function(e) {
        e.preventDefault();
        var getPerusahaan = $("#perusahaan").val();
        var getWilayah = $("#wilayah").val();
        var getDivisi = $("#divisi").val();
        var getBeban = $("#beban").val();
        var getIsi = $("#namabeban").val();
        $.ajax({
            url: "<?= $link ?>/klikbeban",
            data: {
                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                divisi: getDivisi,
                beban: getBeban,
                isi: getIsi,
            },
            dataType: "json",
            success: function(response) {
                $('.modalpilih').html(response.data).show();
                $('#modal-pilih').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    $(document).ready(function() {
        $("#perusahaan").trigger("change")

        $('#peminta').select2({
            ajax: {
                url: "<?= $link ?>/peminta",
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
            <?= json('min input') ?>,
        });

        $('#penerima').select2({
            ajax: {
                url: "<?= $link ?>/penerima",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '00110',
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
        });

        $('#akun').select2({
            ajax: {
                url: "<?= $link ?>/akun",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        awal: '1',
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
        });
    });

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
                $('#peminta, #kodebeban, #penerima, #lampiran, #akun').removeClass('is-invalid');
                $('.errpeminta .errkodebeban, .errpenerima, .errlampiran, .errakun').html('');
                if (response.error) {
                    handleFieldError('peminta', response.error.peminta);
                    handleFieldError('kodebeban', response.error.kodebeban);
                    handleFieldError('penerima', response.error.penerima);
                    handleFieldError('lampiran', response.error.lampiran);
                    handleFieldError('akun', response.error.akun);
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