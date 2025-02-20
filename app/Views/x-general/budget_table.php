<table id="tableInit" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th width="150"><?= lang('app.code') ?></th>
            <th width="4000"><?= lang('app.segment') ?></th>
            <th><?= lang('app.document number') ?></th>
            <th><?= lang('app.revision') ?></th>
            <th width="200" class="text-end"><?= lang('app.total') ?></th>
            <th><?= lang('app.date') ?></th>
            <th width="100" class="text-center"><?= json('status') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($budget as $index => $row) :
            $label = labelBadge('cash', ($row->status)) ?>
            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                <td><?= $index + 1 ?>.</td>
                <td><?= $row->object ?></td>
                <td><?= $row->segment ?></td>
                <td><?= $row->document_number ?></td>
                <td><?= $row->revision ?></td>
                <td><?= $row->allTotal ?></td>
                <td><?= $row->date_start ?></td>
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