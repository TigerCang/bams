<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMlampir') ?>">
                <h4 class="modal-title"><?= lang('app.titletrip') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open_multipart('', ['class' => 'formtrip']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <div class="form-group row">
                                <label for="trip1" class="col-sm-3 col-form-label"><?= lang('app.trip') ?></label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="trip1" name="trip1" min="1" max="10" autocomplete="off" />
                                    <div class="invalid-feedback errtrip1"></div>
                                </div>
                                <div class="col-sm-1 text-center">/</div>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="trip2" name="trip2" min="1" max="10" autocomplete="off">
                                    <div class="invalid-feedback errtrip2"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="persen" class="col-sm-3 col-form-label"><?= lang('app.persen') ?></label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control text-right" id="persen" name="persen" min="1" max="200" autocomplete="off">
                                    <div class="invalid-feedback errpersen"></div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <?= "<button type='submit' class='btn " . lang('app.btnOk') . " btnok'>" . lang('app.btn_Ok') . "</button>"; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnok').click(function(e) {
            var trip1Value = parseInt($('#trip1').val());
            var trip2Value = parseInt($('#trip2').val());

            if (trip1Value < 1 || trip1Value > 10 || trip2Value < 1 || trip2Value > 10) {
                e.preventDefault(); // Mencegah pengiriman formulir jika nilai di luar rentang
                alert("Trip value must be between 1 and 10");
                return; // Menghentikan eksekusi fungsi
            }

            e.preventDefault();
            var form = $('.formtrip')[0];
            var formData = new FormData(form);
            var url = '/persentrip/savedata';
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                enctype: "multipart/form-data",
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnok').attr('disable', 'disabled');
                    $('.btnok').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnok').removeAttr('disable', 'disabled');
                    $('.btnok').html('<?= lang('app.btn_Ok') ?>');
                },
                success: function(response) {
                    $('#trip1, #trip2, #persen').removeClass('is-invalid');
                    $('.errtrip1, .errtrip2, .errpersen').html('');

                    if (response.error) {
                        handleFieldError('trip1', response.error.trip1);
                        handleFieldError('trip2', response.error.trip2);
                        handleFieldError('persen', response.error.persen);
                    } else {
                        clearFieldsAndDisableElements();
                        clearFieldValues();
                        flashdata('success', response.sukses);
                        $('#modal-lampiran').modal('hide');
                        caridata();
                    }

                    function handleFieldError(field, error) {
                        if (error) {
                            $('#' + field).addClass('is-invalid');
                            $('.err' + field).html(error);
                        } else {
                            $('#' + field).removeClass('is-invalid');
                        }
                    }

                    function clearFieldsAndDisableElements() {
                        $('#trip1, #trip2, #persen').removeClass('is-invalid');
                    }

                    function clearFieldValues() {
                        document.getElementById("trip1").value = "";
                        document.getElementById("trip2").value = "";
                        document.getElementById("persen").value = "";
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        });
    });
</script>