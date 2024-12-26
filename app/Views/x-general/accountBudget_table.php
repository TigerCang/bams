<table id="tableData" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th width="180"><?= ($object == 'project' ? lang('app.cost') : lang('app.account number')) ?></th>
            <th><?= lang('app.description') ?></th>
            <th width="100" class="text-center"><?= lang('app.month') ?></th>
            <th width="100" class="text-end"><?= lang('app.quantity') ?></th>
            <th width="150" class="text-end"><?= lang('app.price') ?></th>
            <th width="150" class="text-end"><?= lang('app.total') ?></th>
            <th><?= lang('app.notes') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($budget as $index => $row) :
            $label = labelBadge('colorTR', ($row->level)) ?>
            <tr class="<?= $label['class'] ?>">
                <td><?= $index + 1 ?>.</td>
                <td><?= str_repeat("&emsp;", $row->level - 1) . $row->code ?></td>
                <td><?= $row->description ?></td>
                <td class="text-center"><?= ($row->level == '4' ? formatComa($row->month, '0') : '') ?></td>
                <td class="text-end"><?= ($row->level == '4' ? formatComa($row->quantity, '4') : '') ?></td>
                <td class="text-end"><?= ($row->level == '4' ? formatComa($row->price_contract) : '') ?></td>
                <td class="text-end"><?= formatComa($row->total_contract) ?></td>
                <td><?= $row->notes ?></td>
                <td>
                    <?php if ($row->level == '4') : ?>
                        <div class="dropdown">
                            <a href="javascript:void(0);" data-bs-toggle="dropdown"><?= json('btn i-dropdown') ?></a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownLink">
                                <li><a href="javascript:void(0);" class="dropdown-item btn-edit" data-unique="<?= $row->unique ?>"><?= lang('app.edit'); ?></a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item btn-delete" data-unique="<?= $row->unique ?>"><?= lang('app.delete'); ?></a></li>
                            </ul>
                        </div>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/extra.js"></script>
<script>
    // $('.ubahdata').click(function(e) {
    //     e.preventDefault();
    //     var getID = $(this).data('id');
    //     $.ajax({
    //         url: "/mintabarang/modalkoreksi",
    //         data: {
    //             id: getID,
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             $('.modallampiran').html(response.data).show();
    //             $('#modal-lampiran').modal('show')
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText);
    //             alert(thrownError);
    //         }
    //     });
    // })

    // function hapus(id, deskripsi) {
    //     var url = '/mintabarang/delitem';
    //     Swal.fire({
    //         title: '<?= lang('app.tanyadel') ?>',
    //         text: "<?= lang('app.infodel') ?>",
    //         icon: 'question',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: '<?= lang('app.confirmdel') ?>',
    //         cancelButtonText: '<?= lang('app.batal') ?>'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 type: 'post',
    //                 url: url,
    //                 data: {
    //                     id: id,
    //                     barang: deskripsi,
    //                 },
    //                 dataType: "json",
    //                 success: function(response) {
    //                     if (response.sukses) { //dari msg save lampiran
    //                         flashdata('success', response.sukses);
    //                         dataitembarang();
    //                     }
    //                 },
    //                 error: function(xhr, ajaxOptions, thrownError) {
    //                     alert(xhr.status + "\n" + xhr.responseText);
    //                     alert(thrownError);
    //                 }
    //             });
    //         }
    //     })
    // }
</script>