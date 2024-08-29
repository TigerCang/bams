<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">

    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center row <?= (session()->getFlashdata('pesan') ? 'py-3' : 'py-0') ?> gap-3 gap-md-0">
                    <div>
                        <button type="button" class="<?= json('btn create') ?> btninput" <?= ($tuser['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn create') ?></button>
                    </div>
                </div>
                <?php if (session()->getFlashdata('pesan')) :
                    echo json('alert sukses-1') . session()->getFlashdata('pesan') . json('alert sukses-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive">
                <table id="tabelAwal" class="table table-striped table-hover nowrap">
                    <thead>
                        <tr class="bghead">
                            <th width="5" hidden></th>
                            <th><?= lang('app.peminta') ?></th>
                            <th><?= lang('app.token') ?></th>
                            <th><?= lang('app.saby') ?></th>
                            <th class="text-center"><?= json('status') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($token as $index => $row) :
                            $label = labelBadge('token', ($row->is_use)) ?>
                            <tr <?= ($row->is_use == '0' ? 'class="fw-bold"' : '') ?>>
                                <td hidden><?= $index + 1 ?>.</td>
                                <td><?= $row->peminta ?></td>
                                <td><?= $row->token ?></td>
                                <td><?= $row->user ?></td>
                                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div><!--/ Card Datatable -->
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->
<div class="modalinput" style="display: none;"></div>

<script>
    $(document).on('click', '.btninput', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= $link ?>/input",
            dataType: "json",
            success: function(response) {
                $('.modalinput').html(response.data).show();
                $('#modal-input').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })
</script>

<?= $this->endSection() ?>