<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <?php if (session()->getFlashdata('pesan')) :
                    echo json('alert sukses-1') . session()->getFlashdata('pesan') . json('alert sukses-2');
                endif ?>
            </div> <!--/ Card Header -->

            <div class="card-datatable table-responsive">
                <table id="tabelAwal" class="table table-striped table-hover nowrap">
                    <thead>
                        <tr class="bghead">
                            <th width="5">#</th>
                            <th><?= lang('app.param') ?></th>
                            <th class="text-center"><?= lang('app.nilai') ?></th>
                            <th><?= lang('app.saby') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfigurasi as $index => $row) : ?>
                            <tr>
                                <td><?= $index + 1 ?>.</td>
                                <td><?= lang('app.' . $row['param']) ?></td>
                                <td class="text-center"><?= $row['nilai'] ?></td>
                                <td><?= $row['user'] ?></td>
                                <td><?php if ($tuser['act_button'][2] == '1') : ?>
                                        <a href="javascript:void(0);" class="btninput" data-idunik="<?= $row['idunik'] ?>" data-param="<?= $row['param'] ?>"><?= json('btn iubah') ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div> <!--/ Card Datatable -->
        </div> <!--/ Card -->
    </div> <!--/ Col -->
</div> <!--/ Row -->
<div class="modalinput" style="display: none;"></div>

<script>
    $('.btninput').click(function(e) {
        e.preventDefault();
        var getIdu = $(this).data('idunik');
        var getParam = $(this).data('param');
        $.ajax({
            url: "<?= $link ?>/input",
            data: {
                datakey: getIdu,
                param: getParam,
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