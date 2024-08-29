<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-header pb-0">
                <h5 class="card-title">Filter</h5>
                <input type="hidden" id="idunik" name="idunik" value="<?= $idunik ?>" />
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="sperusahaan" name="sperusahaan">
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('flash-perus') == $db->id ? 'selected' : '') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="sperusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="sdivisi" name="sdivisi">
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('flash-divisi') == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="sdivisi"><?= lang('app.divisi') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="stanggal" name="stanggal" value=<?= date('Y-m-d') ?> />
                            <label for="stanggal"><?= lang('app.tanggal') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row" <?= $cari1 ?>>
                    <div class="col-12 col-md-4 col-lg-4 d-flex justify-content-between align-items-center mb-4">
                        <div class="form-floating form-floating-outline w-100 me-4">
                            <select class="select2-non form-select" id="sstatus" name="sstatus" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="0"><?= lang('app.baru') ?></option>
                                <option value="c"><?= lang('app.belum acc') ?></option>
                                <option value="1"><?= lang('app.tunda') ?></option>
                                <option value="2"><?= lang('app.proses') ?></option>
                                <option value="3"><?= lang('app.revisi') ?></option>
                                <option value="4"><?= lang('app.tolak') ?></option>
                                <option value="5"><?= lang('app.batal') ?></option>
                                <option value="7"><?= lang('app.minta ok') ?></option>
                            </select>
                            <label for="sstatus"><?= lang('app.status') ?></label>
                        </div>
                        <div>
                            <button type="button" class="<?= json('btn cari') ?> btncari"><?= lang('app.btn cari') ?></button>
                        </div>
                    </div>
                </div>
                <div class="row" <?= $cari2 ?>>
                    <div class="col-12 col-md-2 col-lg-2 d-flex justify-content-between align-items-center mb-4">
                        <div class="me-4">
                            <input type="checkbox" id="sacc" name="sacc" data-toggle="toggle" data-onlabel="<?= lang('app.setuju') ?>" data-offlabel="<?= lang('app.no') ?>" data-onstyle="primary">
                        </div>
                        <div>
                            <button type="button" class="<?= json('btn cari') ?> btncari"><?= lang('app.btn cari') ?></button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center row <?= (session()->getFlashdata('pesan') ? 'py-3' : 'py-0') ?> gap-3 gap-md-0">
                    <div <?= $cari1 ?>>
                        <button type="button" class="<?= json('btn create') ?> btninput" <?= ($tuser['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn create') ?></button>
                    </div>
                </div>
                <?php if (session()->getFlashdata('pesan')) :
                    echo json('alert sukses-1') . session()->getFlashdata('pesan') . json('alert sukses-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive viewTabel"></div>
        </div><!--/ Card -->

    </div><!--/ Col -->
</div><!--/ Row -->

<script>
    $(document).ready(function() {
        $('.btncari').trigger('click');
    });

    $(document).ready(function() {
        $(document).on('click', '.btninput', function(e) {
            e.preventDefault();
            var getIdu = $(this).data('idunik') || "<?= $idunik ?>";
            var url = '<?= $link ?>/input?datakey=' + getIdu;
            window.location.href = url;
        })
    });

    $(document).on('click', '.btncari', function(e) {
        e.preventDefault();
        var getParam = "<?= $param ?>";
        var getPerusahaan = $("#sperusahaan").val();
        var getDivisi = $("#sdivisi").val();
        var getTanggal = $("#stanggal").val();
        var getStatus = $("#sstatus").val();
        var getAcc = $("#sacc").val();
        $.ajax({
            url: "<?= $link ?>/cari",
            type: "POST",
            data: {
                param: getParam,
                perusahaan: getPerusahaan,
                divisi: getDivisi,
                tanggal: getTanggal,
                status: getStatus,
                acc: getAcc,
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
    })
</script>

<?= $this->endSection() ?>