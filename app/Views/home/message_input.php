<?= form_open('', ['class' => 'form-password']) ?>
<?= csrf_field() ?>

<div>

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
                    handleFieldError('confirmationOC', response.error.confirmationOC);
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