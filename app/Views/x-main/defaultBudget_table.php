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
                <td class="text-end"><?= ($row->level == '4' ? formatComa($row->price) : '') ?></td>
                <td class="text-end"><?= formatComa($row->total) ?></td>
                <td><?= $row->notes ?></td>
                <td>
                    <?php if ($row->level == '4') : ?>
                        <div class="dropdown">
                            <a href="javascript:void(0);" data-bs-toggle="dropdown"><?= json('btn i-dropdown') ?></a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownLink">
                                <li><a href="javascript:void(0);" class="dropdown-item btn-edit" data-uniq="<?= $row->unique ?>"><?= lang('app.edit'); ?></a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item btn-delete" data-uniq="<?= $row->unique ?>"><?= lang('app.delete'); ?></a></li>
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
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var getUniq = $(this).data('uniq') || '';
        $.ajax({
            url: "<?= $link ?>/modal",
            data: {
                uniq: getUniq,
            },
            dataType: "json",
            success: function(response) {
                $('.modal-input').html(response.data).show();
                $('#modal-input').modal('show')
                $('#modal-input').on('shown.bs.modal', function() {
                    $('#account').select2({
                        ajax: {
                            url: "/load/account",
                            type: "POST",
                            dataType: "json",
                            delay: 250,
                            data: function(params) {
                                return {
                                    searchTerm: params.term,
                                    start: $("#start").val(),
                                };
                            },
                            processResults: function(response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true
                        },
                        <?= json('min input') ?>,
                        <?= json('template 1') ?>,
                        <?= json('template 2') ?>,
                    });

                    $('#cost').select2({
                        ajax: {
                            url: "/load/cost",
                            type: "POST",
                            dataType: "json",
                            delay: 250,
                            data: function(params) {
                                return {
                                    searchTerm: params.term,
                                    param: 'cost',
                                    segment: '',
                                    start: $("#xType").val().substring(0, 2),
                                };
                            },
                            processResults: function(response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true
                        },
                        <?= json('min input') ?>,
                        <?= json('template 1') ?>,
                        <?= json('template 2') ?>,
                    });
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })
</script>
<!-- <script>
    function hapus(id, kode) {
        var url = '/anggaran/delitem';
        Swal.fire({
            title: '<= lang('app.tanyadel'); ?>',
            text: "<= lang('app.infodel'); ?>",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<= lang('app.confirmdel'); ?>',
            cancelButtonText: '<= lang('app.batal'); ?>'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        id: id,
                        kode: kode,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) { //dari msg save lampiran
                            flashdata('success', response.sukses);
                            databudget();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText);
                        alert(thrownError);
                    }
                });
            }
        })
    }
</script> -->