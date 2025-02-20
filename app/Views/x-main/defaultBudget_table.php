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
                                <li><a href="javascript:void(0);" class="dropdown-item btn-edit" data-uniq="<?= $row->unique ?>"><?= lang('app.btn edit'); ?></a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item btn-delete" data-uniq="<?= $row->unique ?>"><?= lang('app.btn delete'); ?></a></li>
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
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var getUniq = $(this).data('uniq');
        askConfirmation("<?= lang('app.sure') ?>", "<?= lang('app.confirm delete') ?>").then((result) => {
            if (result.isConfirmed) {
                submitItem(getUniq);
            } else {
                return;
            }
        });
    });

    function submitItem(getUniq) {
        $.ajax({
            type: 'POST',
            url: "<?= $link ?>/deleteItem",
            data: {
                unique: getUniq,
            },
            success: function(response) {
                if (response.message) {
                    tableBudget();
                    var alertHtml = `<div class="alert alert-success alert-dismissible fade show" role="alert">${response.message}</div>`;
                    $('#alertContainer4').html(alertHtml);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
        return false;
    }
</script>