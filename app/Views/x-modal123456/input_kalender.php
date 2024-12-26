<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMinput') ?>">
                <h4 class="modal-title"><?= lang('app.kalender') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open_multipart('', ['class' => 'formfile']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <div class="form-group row">
                                <label for="tanggalaw" class="col-sm-3 col-form-label"><?= lang('app.dari') ?></label>
                                <div class="col-sm-4">
                                    <input type="date" harusisi class="form-control" id="tanggalaw" name="tanggalaw" value="<?= old('tanggalaw') ?>">
                                    <div class="invalid-feedback errtanggalaw"></div>
                                </div>
                                <label for="tanggalak" class="col-sm-1 col-form-label text-center"><?= lang('app.sampai') ?></label>
                                <div class="col-sm-4">
                                    <input type="date" harusisi class="form-control" id="tanggalak" name="tanggalak" value="<?= old('tanggalak') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label"><?= lang('app.deskripsi') ?></label>
                                <div class="col-sm-9">
                                    <input type="text" harusisi class="form-control" id="nama" name="nama" value="<?= old('nama') ?>">
                                    <div class="invalid-feedback errnama"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="potcuti" class="col-sm-3 col-form-label"><?= lang('app.potongcuti') ?></label>
                                <div class="col-sm-1"><input type="checkbox" id="potcuti" name="potcuti" data-toggle="toggle"></div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="modal-footer"><?= "<button type='submit' class='btn " . lang('app.btncOK') . " btnok'>" . lang('app.btnOK') . "</button>"; ?></div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#modal-lampiran').on('shown.bs.modal', function() {
            // Inisialisasi elemen checkbox toggle
            $('#potcuti').bootstrapToggle({
                on: '<?= lang('app.ya') ?>',
                off: '<?= lang('app.no') ?>',
                onstyle: 'success',
                offstyle: 'light'
            });
        });

        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formfile')[0];
            var formData = new FormData(form);
            var url = '/kalender/save';
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
                    $('.btnok').html('<?= lang('app.btnOK') ?>');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.tanggalaw) {
                            $('#tanggalaw').addClass('is-invalid');
                            $('.errtanggalaw').html(response.error.tanggalaw);
                        } else {
                            $('#tanggalaw').removeClass('is-invalid');
                            $('.errtanggalaw').html('');
                        }
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errnama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errnama').html('');
                        }
                    } else {
                        flashdata("success", response.sukses);
                        $('#modal-lampiran').modal('hide');
                        datakalender();
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