<div class="modal fade" id="modal-beban" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMlampir'); ?>">
                <h4 class="modal-title"><?= lang('app.titlepilihsuplier'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="examplenon" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="bghead">
                                <th scope="col" width="10">#</th>
                                <th scope="col"><?= lang('app.kode'); ?></th>
                                <th scope="col"><?= lang('app.deskripsi'); ?></th>
                                <th scope="col"><?= lang('app.rating'); ?></th>
                                <th scope="col" width="10"><?= lang('app.aksi'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>
                            <tr>
                                <td><?= $nomor++; ?>.</td>
                                <td></td>
                                <td></td>
                                <td> </td>
                                <td><button type="button" id="selectsuplier" class="btn <?= lang('app.btnSelect'); ?>" data-kode="" data-nama=""><?= lang('app.btn_Select'); ?></button></td>
                            </tr>
                            <?php foreach ($suplier as $row) : ?>
                                <tr>
                                    <td><?= $nomor++; ?>.</td>
                                    <td><?= $row->kode; ?></td>
                                    <td><?= $row->nama; ?></td>
                                    <td><?php
                                        for ($i = 0; $i < $row->rating; $i++) {
                                            echo "<i class=\"fa fa-star\" style=\"color:#01a9ac\"></i> ";
                                        } ?>
                                    </td>
                                    <td><button type="button" id="selectsuplier" class="btn <?= lang('app.btnSelect'); ?>" data-kode="<?= $row->kode; ?>" data-nama="<?= $row->nama; ?>">
                                            <?= lang('app.btn_Select'); ?></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#examplenon').DataTable({
            "searching": true,
            "ordering": true,
            "autoWidth": false,
        });

        $(document).on('click', '#selectsuplier', function() {
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');
            $('#suplier').val(kode);
            $('#namasuplier').val(nama);
            $('#modal-beban').modal('hide');
        })
    });
</script>