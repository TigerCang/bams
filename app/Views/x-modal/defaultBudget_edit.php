<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'form-modal']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="mUnique" name="mUnique" value="<?= $budget[0]->unique ?>" />
                <div class="row g-2">
                    <div class="col-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="objectCode" name="objectCode" value="<?= ($parent1[0]->object == 'project' ? $cost1[0]->code : $account1[0]->code) ?>" />
                            <label for="objectCode"><?= lang('app.code') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-9 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="objectName" name="objectName" value="<?= ($parent1[0]->object == 'project' ? $cost1[0]->name : $account1[0]->name) ?>" />
                            <label for="objectName"><?= lang('app.description') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="0" data-a-sep="." data-a-dec="," id="mMonth" name="mMonth" placeholder="" value="<?= $budget[0]->month ?>" onchange="countMTotal()" />
                            <label for="mMonth"><?= lang('app.month') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="mQuantity" name="mQuantity" placeholder="" value="<?= $budget[0]->quantity ?>" onchange="countMTotal()" />
                            <label for="mQuantity"><?= lang('app.quantity') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="mPrice" name="mPrice" placeholder="" value="<?= ($from == 'default' ? $budget[0]->price : $budget[0]->price_contract) ?>" onchange="countMTotal()" />
                            <label for="mPrice"><?= lang('app.price') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-a-sep="." data-a-dec="," id="mTotal" name="mTotal" value="<?= ($from == 'default' ? $budget[0]->total : $budget[0]->total_contract) ?>" placeholder="" />
                            <label for="mTotal"><?= lang('app.total') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="mNotes" name="mNotes" placeholder=""><?= $budget[0]->notes ?></textarea>
                            <label for="mNotes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-6"></div>
                    <div class="col-6 ms-auto text-end">
                        <button type="button" class="<?= json('btn submit') ?> btn-mEdit"><?= lang('app.btn edit') ?></button>
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
    function countMTotal() {
        document.getElementById('mMonth').value = document.getElementById('mMonth').value || '0,00';
        document.getElementById('mQuantity').value = document.getElementById('mQuantity').value || '0,0000';
        document.getElementById('mPrice').value = document.getElementById('mPrice').value || '0,00';

        var mMonth = formatAmount(document.getElementById('mMonth').value, 'nol');
        var mQuantity = formatAmount(document.getElementById('mQuantity').value, 'nol');
        var mPrice = formatAmount(document.getElementById('mPrice').value, 'nol');
        var mTotal = parseFloat(mMonth) * parseFloat(mQuantity) * parseFloat(mPrice);
        $('#mTotal').val(formatAmount(mTotal, 'rp'));
    }

    $('.btn-mEdit').click(function(e) {
        e.preventDefault();
        var form = $('.form-modal')[0];
        var formData = new FormData(form);
        var url = '<?= $link ?>/editItem';
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btn-mEdit').attr('disabled', 'disabled');
                $('.btn-mEdit').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btn-mEdit').removeAttr('disabled');
                $('.btn-mEdit').html("<?= lang('app.btn edit') ?>");
            },
            success: function(response) {
                if (response.message) {
                    tableBudget();
                    var alertHtml = `<div class="alert alert-success alert-dismissible fade show" role="alert">${response.message}</div>`;
                    $('#alertContainer4').html(alertHtml);
                    $('#modal-input').modal('hide');
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