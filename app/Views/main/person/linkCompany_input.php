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
                <input type="hidden" id="unique" name="unique" value="<?= ($company[0]->unique ?? '') ?>" />
                <div class="row g-2">
                    <div class="col-12 col-md-7 col-lg-7 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="code" name="code" placeholder="<?= lang('app.required') ?>" value="<?= ($company[0]->code ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control text-uppercase" id="initial" name="initial" <?= ((isset($company[0]->adaptation[0]) && $company[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> maxlength="3" placeholder="<?= lang('app.required') ?>" value="<?= ($company[0]->initial ?? '') ?>" />
                            <label for="initial"><?= lang('app.initial') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="description" name="description" placeholder="<?= lang('app.required') ?>" value="<?= ($company[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="person" name="person" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($person1) : ?><option value="<?= $person1[0]->code ?>" selected data-subtext="<?= $person1[0]->name ?>"><?= $person1[0]->code ?></option><?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_person"></div>
                            <label for="person"><?= lang('app.person') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-6">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($company[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-6 ms-auto text-end">
                        <button type="button" class="<?= json('btn submit') ?> btn-submit"><?= json('submit') ?></button>
                    </div>
                </div>
            </div> <!--/ Modal Footer -->
            <?= form_close() ?>

        </div> <!--/ Modal Content -->
    </div> <!--/ Modal Dialog -->
</div> <!--/ Modal fade -->

<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
<script>
    $('.modal').on('shown.bs.modal', function() {
        $('#person').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "/load/person",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        choose: '11110',
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

    $('.btn-submit').click(function(e) {
        e.preventDefault();
        var form = $('.form-main')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
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
                $('#person').removeClass('is-invalid');
                $('.err_person').html('');
                if (response.error) {
                    handleFieldError('person', response.error.person);
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
    })
</script>