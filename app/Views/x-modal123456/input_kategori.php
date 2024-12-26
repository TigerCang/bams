<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title judul-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'formmodal']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="midunik" name="midunik" />

                <div class="row g-2">
                    <div class="col-12 col-md-12 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="mparam" name="mparam" placeholder="" value="<?= $param ?>" />
                            <label for="param"><?= lang('app.param') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="mdeskripsi" name="mdeskripsi" placeholder="<?= lang('app.harus') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errmdeskripsi"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row w-100">
                        <div class="col-12 ms-auto text-end">
                            <div class="btn-group" id="dropdown-icon">
                                <button type="button" class="<?= json('btn submit') ?> btnsubmit dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= json('submit') ?></button>
                                <ul class="dropdown-menu">
                                    <li><button type="button" name="action" value="save" class="dropdown-item d-flex align-items-center btnsave" <?= $button['save'] ?>><?= lang('app.btn save') ?></button></li>
                                    <li><button type="button" name="action" value="hapus" class="dropdown-item d-flex align-items-center btnsave" <?= $button['del'] ?>><?= lang('app.btn hapus') ?></button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!--/ Modal Footer -->

                <div class="card-datatable table-responsive">
                    <table id="tabelmodal" class="table table-striped table-hover nowrap">
                        <thead>
                            <tr class="bghead">
                                <th><?= lang('app.deskripsi') ?></th>
                                <th><?= lang('app.saby') ?></th>
                                <th width="5" data-orderable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($berkas as $row) : ?>
                                <tr>
                                    <td><?= $row->nama ?></td>
                                    <td><?= $row->saveby ?></td>
                                    <td><?php if ($tuser['act_button'][2] == '1') : ?>
                                            <a href="javascript:void(0);" class="btnubah" data-idunik="<?= $row->idunik ?>" data-deskripsi="<?= $row->nama ?>"><?= json('btn iubah'); ?></a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div> <!--/ Card table -->
            </div> <!--/ Modal Body -->
            <?= form_close() ?>

        </div> <!--/ Modal Content -->
    </div> <!--/ Modal Dialog -->
</div> <!--/ Modal fade -->

<script src="<?= base_url('libraries') ?>/cang/js/modal.js"></script>
<script>
    $(document).ready(function() {
        $('.btnsave').click(function(e) {
            e.preventDefault();
            var form = $('.formmodal')[0];
            var formData = new FormData(form);
            var getAction = $(this).val();
            var url = '<?= $link ?>/savekategori';
            formData.append('postaction', getAction);
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsubmit').attr('disabled', 'disabled');
                    $('.btnsubmit').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
                },
                complete: function() {
                    $('.btnsubmit').removeAttr('disabled');
                    $('.btnsubmit').each(function() {
                        $(this).html('<?= json('submit') ?>');
                    });
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.mdeskripsi) {
                            $('#mdeskripsi').addClass('is-invalid');
                            $('.errmdeskripsi').html(response.error.mdeskripsi);
                        } else {
                            $('#mdeskripsi').removeClass('is-invalid');
                            $('.errmdeskripsi').html('');
                        }
                        // if (response.error.deskripsi2) {
                        //     $('#deskripsi2').addClass('is-invalid');
                        //     $('.errdeskripsi2').html(response.error.deskripsi2);
                        // } else {
                        //     $('#deskripsi2').removeClass('is-invalid');
                        //     $('.errdeskripsi2').html('');
                        // }
                    } else {
                        $('#modal-input').modal('hide'); // Tutup modal
                        loadOption(); // Panggil fungsi loadOption
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
            return false;
        })

        $('.btnubah').click(function(e) {
            e.preventDefault();
            var idunik = $(this).data('idunik');
            var deskripsi = $(this).data('deskripsi');

            $('#midunik').val(idunik);
            $('#mdeskripsi').val(deskripsi);
        });
    });
</script>