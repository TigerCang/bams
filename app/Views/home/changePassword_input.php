<?= form_open('', ['class' => 'form-password']) ?>
<?= csrf_field() ?>

<div>
    <div class="form-floating form-floating-outline mb-4">
        <input type="text" readonly class="form-control" id="usernameOC" name="usernameOC" placeholder="" value="<?= decrypt(session()->username) ?>" />
        <label for="usernameOC"><?= lang('app.username') ?></label>
    </div>
    <div class="form-floating form-floating-outline mb-4">
        <input type="password" class="form-control" id="oldPasswordOC" name="oldPasswordOC" placeholder="<?= lang('app.required') ?>" />
        <img src="<?= base_url('assets') ?>/image/eye-hide.png" class="toggle-password">
        <label for="oldPasswordOC"><?= lang('app.old password') ?></label>
        <div id="error" class="invalid-feedback err_oldPasswordOC"></div>
    </div>
    <div class="form-floating form-floating-outline mb-4">
        <input type="password" class="form-control" id="newPasswordOC" name="newPasswordOC" placeholder="<?= lang('app.required') ?>" />
        <img src="<?= base_url('assets') ?>/image/eye-hide.png" class="toggle-password">
        <label for="newPasswordOC"><?= lang('app.new password') ?></label>
        <div id="error" class="invalid-feedback err_newPasswordOC"></div>
    </div>
    <div class="form-floating form-floating-outline mb-6">
        <input type="password" class="form-control" id="confirmationOC" name="confirmationOC" placeholder="<?= lang('app.required') ?>" />
        <img src="<?= base_url('assets') ?>/image/eye-hide.png" class="toggle-password">
        <label for="confirmationOC"><?= lang('app.confirmation') ?></label>
    </div>

    <button type="button" class="<?= json('btn submit') ?> btn-submit"><?= json('submit') ?></button>
    <?= form_close() ?>
</div>

<script>
    $('.btn-submit').click(function(e) {
        e.preventDefault();
        var form = $('.form-password')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
        var url = '/changepassword';
        formData.append('postAction', getAction);
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btn-submit').attr('disabled', 'disabled');
                $('.btn-submit').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btn-submit').removeAttr('disabled');
                $('.btn-submit').each(function() {
                    $(this).html('<?= json('submit') ?>');
                });
            },
            success: function(response) {
                $('#oldPasswordOC, #newPasswordOC').removeClass('is-invalid');
                $('.err_oldPasswordOC, .err_newPasswordOC').html('');
                $('.offcanvas-body .alert').remove();
                if (response.error) {
                    handleFieldError('oldPasswordOC', response.error.oldPasswordOC);
                    handleFieldError('newPasswordOC', response.error.newPasswordOC);
                } else {
                    $('.offcanvas-body').prepend(`<div class="alert alert-success" role="alert">
                        ${response.success}</div>`);
                    // window.location.href = response.redirect;
                }

                function handleFieldError(field, error) {
                    if (error) {
                        $('#' + field).addClass('is-invalid');
                        $('.err_' + field).html(error);
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