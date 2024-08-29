<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'formmain']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= $idunik ?>" />

                <div class="row g-2">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="perusahaan" name="perusahaan" disabled>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->inisial ?>" <?= (isset($kas[0]->perusahaan_id) && $kas[0]->perusahaan_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][0] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['perusahaan']) ? '' : 'disabled') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="perusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="wilayah" name="wilayah" disabled>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->nama2 ?>" <?= (isset($kas[0]->wilayah_id) && $kas[0]->wilayah_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][1] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="wilayah"><?= lang('app.wilayah') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="divisi" name="divisi" disabled>
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
                            <input type="text" readonly class="form-control" id="dokumen" name="dokumen" placeholder="" value="<?= $kas[0]->nodokumen ?>" />
                            <label for="dokumen"><?= lang('app.dokumen') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="revisi" name="revisi" placeholder="" value="<?= $kas[0]->revisi ?>" />
                            <label for="revisi"><?= lang('app.revisi') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" readonly class="form-control" id="tglminta" name="tglminta" value="<?= $kas[0]->tgl_minta ?>" />
                            <label for="tglminta"><?= lang('app.tanggal') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="peminta" name="peminta" disabled>
                                <option value="<?= $user1[0]->kode ?>" selected data-subtext="<?= $user1[0]->namapegawai ?>"><?= $user1[0]->kode ?></option>
                            </select>
                            <label for="peminta"><?= lang('app.peminta') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="penerima" name="penerima" disabled>
                                <option value="<?= $penerima1[0]->id ?>" selected data-subtext="<?= $penerima1[0]->nama ?>"><?= $penerima1[0]->kode ?></option>
                            </select>
                            <label for="penerima"><?= lang('app.penerima') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-4 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="kodebeban" name="kodebeban" placeholder="" value="" />
                            <label for="kodebeban"><?= lang('app.kode') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-9 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="namabeban" name="namabeban" placeholder="" value="" />
                            <label for="namabeban"><?= lang('app.deskripsi') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card dokumen -->
    </div> <!--/ Coloum kanan -->
</div> <!--/ Row-->

<div class="card-datatable table-responsive viewTabel"></div>

<div class="row">
    <div class="col-12 col-md-12 col-lg-6">
        <div class="card mb-6">
            <div class="card-body">
                <ul class="timeline card-timeline mb-0">
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-primary"></span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-3">
                                <h6 class="mb-0">User 325454</h6>
                                <small class="text-muted">waktu</small>
                            </div>
                            <p class="mb-2">catatan catatan catatan catatan catatan
                                catatan catatan catatan catatan catatan catatan catatan catatan catatan catatan
                                catatan catatan catatan catatan catatan catatan catatan catatan catatan catatan
                            </p>
                            <!-- <div class="d-flex align-items-center mb-1">
                                <div class="badge bg-warning rounded-3">warning</div>
                            </div> -->
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-primary"></span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-3">
                                <h6 class="mb-0">User</h6>
                                <small class="text-muted">waktu</small>
                            </div>
                            <p class="mb-2">catatan</p>
                            <div class="d-flex align-items-center mb-1">
                                <div class="badge bg-warning rounded-3">warning</div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div> <!--/ Card body  -->
        </div> <!--/ Card timeline -->
    </div> <!--/ Coloum kiri -->

    <div class="col-12 col-md-12 col-lg-6">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="aksi" name="aksi" data-placeholder="">
                                <?php foreach ($selaksi as $db) : ?>
                                    <option value="<?= $db->nama ?>"><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="aksi"><?= lang('app.aksi') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3 mb-4">
                        <input type="checkbox" id="jabatan" name="jabatan" data-toggle="toggle" data-width="100%" data-onlabel="<?= lang('app.jabatan') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="warning">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""></textarea>
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
                        <button type="button" class="<?= json('btn submit') ?> btnsubmit"><?= json('submit') ?></button>
                    </div>
                </div>
            </div> <!--/ Card Footer -->
        </div> <!--/ Card persetujuan -->
    </div> <!--/ Coloum kanan -->
</div> <!--/ Row-->
<?= form_close() ?>

<script>
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