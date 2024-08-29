<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMinput') ?>">
                <h4 class="modal-title"><?= lang('app.config') ?></h4>
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
                            <input type="hidden" class="form-control" id="xparam" name="xparam" value="<?= $konfigurasi[0]->parameter ?>">
                            <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $konfigurasi[0]->idunik ?>">
                            <div class="form-group row">
                                <label for="parameter" class="col-sm-2 col-form-label"><?= lang('app.param') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" id="parameter" name="parameter" value="<?= lang('app.' . $konfigurasi[0]->parameter) ?>">
                                </div>
                            </div>
                            <div class="form-group row" <?= ($konfigurasi[0]->mode == 'A' ? '' : 'hidden') ?>>
                                <label for="level" class="col-sm-2 col-form-label"><?= lang('app.nilai') ?></label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="level" name="level" placeholder="1 - 20" value="<?= ($konfigurasi[0]->mode == 'A' ? $konfigurasi[0]->nilai : '1') ?>" min="1" max="20">
                                    <div class="invalid-feedback errlevel"></div>
                                </div>
                            </div>
                            <div class="form-group row" <?= ($konfigurasi[0]->mode == 'B' ? '' : 'hidden') ?>>
                                <label for="nama" class="col-sm-2 col-form-label"><?= lang('app.nilai') ?></label>
                                <div class="col-sm-4">
                                    <input type="nama" class="form-control" id="nama" name="nama" value="<?= $konfigurasi[0]->nilai ?>">
                                    <div class="invalid-feedback errnama"></div>
                                </div>
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
        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formfile')[0];
            var formData = new FormData(form);
            var url = '/konfigurasi/okdata';
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
                        if (response.error.level) {
                            $('#level').addClass('is-invalid');
                            $('.errlevel').html(response.error.level);
                        } else {
                            $('#level').removeClass('is-invalid');
                            $('.errlevel').html('');
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
                        caridata();
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