<table id="tableInit" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th width="150"><?= lang('app.code') ?></th>
            <th><?= lang('app.description') ?></th>
            <th width="100"><?= lang('app.unit') ?></th>
            <th width="150" <?= $pHid ?>><?= lang('app.price') ?></th>
            <th width="100" <?= $sHid ?> class="text-center"><?= lang('app.use serial') ?></th>
            <th width="100" class="text-center"><?= json('status') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($item as $index => $row) :
            $label = labelBadge('main', ($row->adaptation)) ?>
            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                <td><?= $index + 1 ?>.</td>
                <td><span><?= $row->code ?></span>
                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->part_number ?></small>
                </td>
                <td><?= $row->name ?></td>
                <td><?= $row->unit ?></td>
                <td <?= $pHid ?>><?= formatComa($row->price, '2') ?></td>
                <td <?= $sHid ?> class="text-center"><?= ($row->mode[0] == '1' ? '<i class="fa-regular fa-square-check"></i>' : '') ?></td>
                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
                <td><?php if (thisUser()['act_button'][1] == '1') : ?>
                        <a href="javascript:void(0);" class="btn-input" data-unique="<?= $row->unique ?>"><?= json('btn i-view') ?></a>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>