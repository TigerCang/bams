<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'form-budget']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="mUnique" name="mUnique" value="<?= $budget[0]->unique ?>" />
                <input type="hidden" id="mStart" name="mStart" value="<?= ($parent1[0]->source == 'income' ? '4,7' : '5,6,8') ?>" />
                <div class="row" id="qCost">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="mCost" name="mCost" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($cost1) : ?> <option value="<?= $cost1[0]->id ?>" selected data-subtext="<?= $cost1[0]->name ?>"><?= $cost1[0]->code ?></option><?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_mCost"></div>
                            <label for="mCost"><?= lang('app.cost') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row" id="qAccount">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="mAccount" name="mAccount" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($account1) : ?> <option value="<?= $account1[0]->id ?>" selected data-subtext="<?= $account1[0]->name ?>"><?= $account1[0]->code ?></option><?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_mAccount"></div>
                            <label for="mAccount"><?= lang('app.account number') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
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
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="mPrice" name="mPrice" placeholder="" value="<?= $budget[0]->price ?>" onchange="countMTotal()" />
                            <label for="mPrice"><?= lang('app.price') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control autonumber" data-a-sep="." data-a-dec="," id="mTotal" name="mTotal" value="<?= $budget[0]->total ?>" placeholder="" />
                            <label for="mTotal"><?= lang('app.total') ?></label>
                            <div id="error" class="invalid-feedback err_mTotal"></div>
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
                        <button type="button" class="<?= json('btn submit') ?> btn-submit"><?= json('submit') ?></button>
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

    $(document).ready(function() {
        // const isObject = document.getElementById('mObject').value === 'project';
        const isObject = '<?= $parent1[0]->object ?>' === 'project';
        $('#qCost').attr('hidden', !isObject);
        $('#qAccount').attr('hidden', isObject);

        // const getTujuan = $("#mtujuan").val();
        // const divBiaya2 = document.getElementById("zbiaya2");
        // const divAkun2 = document.getElementById("zakun2");
        // (getTujuan === 'proyek') ? (divBiaya2.removeAttribute("hidden"), divAkun2.setAttribute("hidden", true)) : (divBiaya2.setAttribute("hidden", true), divAkun2.removeAttribute("hidden"));

        // $('.btnok').click(function(e) {
        //     e.preventDefault();
        //     var form = $('.formanggaran')[0];
        //     var formData = new FormData(form);
        //     var url = '/anggaran/edititem';
        //     $.ajax({
        //         type: 'post',
        //         url: url,
        //         data: formData,
        //         enctype: "multipart/form-data",
        //         cache: false,
        //         processData: false,
        //         contentType: false,
        //         dataType: "json",
        //         beforeSend: function() {
        //             $('.btnok').attr('disable', 'disabled');
        //             $('.btnok').html('<i class="fa fa-spin fa-spinner"></i>');
        //         },
        //         complete: function() {
        //             $('.btnok').removeAttr('disable', 'disabled');
        //             $('.btnok').html('<?= lang('app.btnOK') ?>');
        //         },
        //         success: function(response) {
        //             if (response.error) {
        //                 if (response.error.mcatatan) {
        //                     $('#mcatatan').addClass('is-invalid');
        //                     $('.errmcatatan').html(response.error.mcatatan);
        //                 } else {
        //                     $('#mcatatan').removeClass('is-invalid');
        //                     $('.errmcatatan').html('');
        //                 }
        //             } else {
        //                 clearElements();
        //                 flashdata('success', response.sukses);
        //                 $('#modal-lampiran').modal('hide');
        //                 databudget();
        //             }

        //             function handleFieldError(field, error) {
        //                 if (error) {
        //                     $('#' + field).addClass('is-invalid');
        //                     $('.err' + field).html(error);
        //                 } else {
        //                     $('#' + field).removeClass('is-invalid');
        //                 }
        //             }

        //             function clearElements() {
        //                 $("#mbulan").val('');
        //                 $("#mjumlah").val('');
        //                 $("#mharga").val('');
        //                 $("#mtotal").val('');
        //                 $("#mcatatan").val('');
        //             }
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status + "\n" + xhr.responseText);
        //             alert(thrownError);
        //         }
        //     });
        // });
    });

    $('.modal').on('shown.bs.modal', function() {
        $('#mAccount').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "/load/account",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        start: $("#mStart").val(),
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

        $('#mCost').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "/load/cost",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        param: 'cost',
                        segment: '',
                        // start: $("#xType").val().substring(0, 2),
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
</script>