<div class="modal fade" id="modal-beban" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMlampir'); ?>">
                <h4 class="modal-title"><?= lang('app.titlepilihsuplier1'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="examplenon" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="10">#</th>
                                <th scope="col"><?= lang('app.kode'); ?></th>
                                <th scope="col"><?= lang('app.deskripsi'); ?></th>
                                <th scope="col"><?= lang('app.rating'); ?></th>
                                <th scope="col"><?= lang('app.harga'); ?></th>
                                <th scope="col"><?= lang('app.catatan'); ?></th>
                                <th scope="col" width="10"><?= lang('app.aksi'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>
                            <?php foreach ($suplier as $row) : ?>
                                <tr>
                                    <td><?= $nomor++; ?>.</td>
                                    <td><?= $row->suplier; ?></td>
                                    <td><?= $row->nama; ?></td>
                                    <td><?php
                                        for ($i = 0; $i < $row->rating; $i++) {
                                            echo "<i class=\"fa fa-star\" style=\"color:#01a9ac\"></i> ";
                                        } ?>
                                    </td>

                                    <td align="right"><?= formatrp($row->harga); ?></td>
                                    <td><?= $row->keterangan; ?></td>

                                    <td><button type="button" class="btn <?= lang('app.btnSelect2'); ?> btnselect" data-id="<?= $row->id; ?>" data-idminta="<?= $row->id_minta; ?>" data-suplier="<?= $row->suplier; ?>">
                                            <?= lang('app.btn_select2'); ?></button>
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

        // panggil button select diklik
        $('.btnselect').click(function(e) {
            e.preventDefault();
            var getid = $(this).data('id'); //ambil nilai dari table
            var getidminta = $(this).data('idminta'); //ambil nilai dari table
            var getsuplier = $(this).data('suplier'); //ambil nilai dari table

            $.ajax({
                url: "/bandingharga/hasilpilih",
                data: {
                    id: getid,
                    idminta: getidminta,
                    suplier: getsuplier,
                },
                dataType: "json",
                success: function(response) {
                    flashdata(response.sukses, 'success', response.judul);
                    $('#modal-beban').modal('hide');
                    datatawarbarang();

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        })

    });
</script>