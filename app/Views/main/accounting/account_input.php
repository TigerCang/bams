<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'form-main']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($account[0]->unique ?? '') ?>" />
                <input type="hidden" id="xCategory" name="xCategory" value="<?= ($account[0]->category ?? '1-asset') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-5 col-md-5 col-lg-5 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($account[0]->adaptation[0]) && $account[0]->adaptation[0] == '1') ? 'readonly' : '' ?> class="form-control accountNumber" id="code" name="code" placeholder="" value="<?= (empty($account) ? '' : substr($account[0]->code, -7)) ?>" data-mask="999.9999" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="accountNumber" name="accountNumber" placeholder="" value="<?= ($account[0]->code ?? '') ?>" />
                            <label for="accountNumber"><?= lang('app.account number') ?></label>
                        </div>
                    </div>
                    <div class="col-2 col-md-2 col-lg-1 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="level" name="level" value="<?= ($account[0]->level ?? '') ?>" />
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" <?= ((isset($account[0]->adaptation[0]) && $account[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="" value="<?= ($account[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="category" name="category" <?= (isset($account[0]->adaptation[0]) && $account[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selectCategory as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($account[0]->category) && $account[0]->category == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="category"><?= lang('app.category') ?></label>
                        </div>
                    </div>
                    <div class="col-3">
                        <input type="checkbox" id="position" name="position" data-toggle="toggle" data-width="100%" <?= (isset($account[0]->position) && $account[0]->position == 'credit' ? '' : 'checked') ?> />
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($account[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($account[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($account[0]->activeBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <div class="btn-group" id="dropdown-icon">
                            <button type="button" class="<?= json('btn submit') ?> btn-submit dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= json('submit') ?></button>
                            <ul class="dropdown-menu">
                                <li><button type="button" name="action" value="save" class="dropdown-item d-flex align-items-center btn-save" <?= $button['save'] ?>><?= lang('app.btn save') ?></button></li>
                                <li><button type="button" name="action" value="confirm" class="dropdown-item d-flex align-items-center btn-save" <?= $button['confirm'] ?>><?= lang('app.btn confirm') ?></button></li>
                                <li><button type="button" name="action" value="delete" class="dropdown-item d-flex align-items-center btn-save" <?= $button['delete'] ?>><?= lang('app.btn delete') ?></button></li>
                                <li><button type="button" name="action" value="active" class="dropdown-item d-flex align-items-center btn-save" <?= $button['active'] ?>><?= $btn_active ?></button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Footer -->
            <?= form_close() ?>

        </div> <!--/ Modal Content -->
    </div> <!--/ Modal Dialog -->
</div> <!--/ Modal fade -->

<script src="<?= base_url('libraries') ?>/cang/form-masking/form-mask.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
<script>
    $("#code").on("change", () => $("#accountNumber").val($("#category").val().charAt(0) + $("#code").val()));
    $('#modal-input').on('shown.bs.modal', function() {
        $('#position').bootstrapToggle({
            onlabel: '<?= lang('app.debit') ?>',
            offlabel: '<?= lang('app.credit') ?>',
            onstyle: 'success',
            offstyle: 'info'
        });
    });

    $('#category').change(function() {
        $("#code").change();
        $('#xCategory').val($(this).val());
        var number = $(this).val().charAt(0); // get one number from category
        if (number == '1' || number == '3' || number == '5' || number == '6' || number == '8') {
            $('#position').bootstrapToggle('on'); // checkbox on
        } else {
            $('#position').bootstrapToggle('off');
        }
    });

    $('.btn-save').click(function(e) {
        e.preventDefault();
        var getAction = $(this).val();
        if (getAction === 'delete') {
            askConfirmation("<?= lang('app.sure') ?>", "<?= lang('app.confirm delete') ?>").then((result) => {
                if (result.isConfirmed) {
                    submitForm(getAction);
                } else {
                    return;
                }
            });
        } else {
            submitForm(getAction);
        }
    })

    function submitForm(getAction) {
        var form = $('.form-main')[0];
        var formData = new FormData(form);
        var url = '<?= $link ?>/save';
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
                $('#askDelete, #code, #description').removeClass('is-invalid');
                $('.err_askDelete, .err_code, .err_description').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('code', response.error.code);
                    handleFieldError('description', response.error.description);
                } else {
                    window.location.href = response.redirect;
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
    }
</script>