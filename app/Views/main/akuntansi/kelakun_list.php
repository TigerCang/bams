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
                            <th <?= $khid ?>><?= lang('app.kategori') ?></th>
                            <th><?= lang('app.kelompok') ?></th>
                            <th><?= lang('app.deskripsi') ?></th>
                            <th <?= $phid ?>><?= lang('app.perusahaan') ?></th>
                            <th <?= $nhid ?>><?= lang('app.nilai') ?></th>
                            <th class="text-center"><?= json('status') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kelakun as $index => $row) :
                            $label = labelBadge('main', ($row->kondisi)) ?>
                            <tr <?= ($row->xlog == '' ? 'class="fw-bold"' : '') ?>>
                                <td hidden><?= $index + 1 ?>.</td>
                                <td <?= $khid ?>><?= lang('app.' . $row->param) ?></td>
                                <td><?= lang('app.' . $row->sub_param) ?></td>
                                <td><?= $row->nama ?></td>
                                <td <?= $phid ?>><span><?= $row->perusahaan ?></span>
                                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->divisi ?></small>
                                </td>
                                <td <?= $nhid ?>><?= $row->nilai ?></td>
                                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
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
        var getIdu = $(this).data('idunik') || '';
        $.ajax({
            url: "<?= $link ?>/input",
            data: {
                datakey: getIdu,
            },
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