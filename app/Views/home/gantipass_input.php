<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?= (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : ''); ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formmfile']) ?>
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.gantisandi') ?></h5>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $tuser['idunik'] ?>">
                    <div class="form-group row">
                        <label for="kode" class="col-sm-1 col-form-label"><?= lang('app.username') ?></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" readonly id="username" name="username" value="<?= session()->username ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="passlama" class="col-sm-1 col-form-label"><?= lang('app.passlama') ?></label>
                        <div class="col-sm-11">
                            <input type="password" oninput="this.value = this.value;" class="form-control no-copy-paste form-password" id="passlama" name="passlama" placeholder="<?= lang('app.harusisi') ?>" value="<?= old('passlama') ?>">
                            <div id="error" class="invalid-feedback errpasslama"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="passbaru" class="col-sm-1 col-form-label"><?= lang('app.passbaru') ?></label>
                        <div class="col-sm-11">
                            <input type="password" class="form-control no-copy-paste form-password" id="passbaru" name="passbaru" placeholder="<?= lang('app.harusisi') ?>" value="<?= old('passbaru') ?>">
                            <div id="error" class="invalid-feedback errpassbaru"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="konfirmasi" class="col-sm-1 col-form-label"><?= lang('app.konfirmasi') ?></label>
                        <div class="col-sm-11">
                            <input type="password" class="form-control no-copy-paste form-password" id="konfirmasi" name="konfirmasi" placeholder="<?= lang('app.harusisi') ?>" value="<?= old('konfirmasi') ?>">
                            <div id="error" class="invalid-feedback errkonfirmasi"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="checkbox" id="showhide" class="ShowPassword" value="">
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                <span class="text-inverse"><?= lang('app.log_tampilpass') ?></span>
                            </label>
                        </div>
                        <div>
                            <?= "<button type='reset' class='btn " . lang('app.btncReset') . "'>" . lang('app.btnReset') . "</button>
                                <button type='submit' class='btn " . lang('app.btncSave') . " btnsave'>" . lang('app.btnSave') . "</button>"; ?>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
</div><!-- body end -->

<script>
    $(document).ready(function() {
        $('.btnsave').click(function(e) {
            e.preventDefault();
            var form = $('.formmfile')[0];
            var formData = new FormData(form);
            var url = '/savepass';
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
                    $('.btnsave').html('<?= lang('app.btnSave') ?>');
                },
                success: function(response) {
                    $('#passlama, #passbaru, #konfirmasi').removeClass('is-invalid');
                    $('.errpasslama, .errpassbaru, .errkonfirmasi, .errdivisi').html('');
                    if (response.error) {
                        handleFieldError('passlama', response.error.passlama);
                        handleFieldError('passbaru', response.error.passbaru);
                        handleFieldError('konfirmasi', response.error.konfirmasi);
                    } else {
                        window.location.href = '/sandi';
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
    });
</script>

<?= $this->endSection() ?>