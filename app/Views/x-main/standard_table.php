<table id="tableInit" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th width="200"><?= lang('app.category') ?></th>
            <th width="150"><?= lang('app.code') ?></th>
            <th><?= lang('app.description') ?></th>
            <th width="100" class="text-center"><?= json('status') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($standard as $index => $row) :
            $label = labelBadge('main', ($row->adaptation)) ?>
            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                <td><?= $index + 1 ?>.</td>
                <td><?= lang('app.' . $row->param) ?></td>
                <td><?= $row->code ?></td>
                <td><?= $row->name ?></td>
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