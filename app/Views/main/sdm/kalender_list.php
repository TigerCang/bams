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
                            <th><?= lang('app.tanggal') ?></th>
                            <th><?= lang('app.deskripsi') ?></th>
                            <th class='text-center'><?= lang('app.saby') ?></th>
                            <th><?= lang('app.saby') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kalender as $index => $row) : ?>
                            <tr>
                                <td hidden><?= $index + 1 ?>.</td>
                                <td><?= $row->tanggal ?></td>
                                <td><?= $row->nama ?></td>
                                <td><?= $row->nama ?></td>
                                <td><?= $row->user ?></td>
                                <td><?php if ($tuser['act_button'][1] == '1') : ?>
                                        <a href="javascript:void(0);" class="btninput" data-idunik="<?= $row->idunik ?>"><?= json('btn iview') ?></a>
                                    <?php endif ?>
                                </td>
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