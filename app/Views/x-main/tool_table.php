<?php [$cHid, $oHid, $nHid] = array_map(function ($hid) {
    return $hid == '1' ? '' : 'hidden';
}, str_split($con)) ?>

<table id="tableInit" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th width="150" <?= $oHid ?>><?= lang('app.code') ?></th>
            <th width="100" <?= $nHid ?>><?= lang('app.number') ?></th>
            <th><?= lang('app.description') ?></th>
            <th width="200"><?= lang('app.category') ?></th>
            <th width="200" <?= $cHid ?>><?= lang('app.company') ?></th>
            <th width="200" <?= $cHid ?>><?= lang('app.division') ?></th>
            <th width="100" class="text-center"><?= json('status') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tool as $index => $row) :
            $label = labelBadge('main', ($row->adaptation)) ?>
            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                <td><?= $index + 1 ?>.</td>
                <td <?= $oHid ?>><span><?= $row->code ?></span>
                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->code2 ?></small>
                </td>
                <td <?= $nHid ?>><?= $row->code2 ?></td>
                <td><?= $row->name ?></td>
                <td><?= $row->category ?></td>
                <td <?= $cHid ?>><?= $row->company ?></td>
                <td <?= $cHid ?>><span><?= $row->division ?></span>
                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->region ?></small>
                </td>
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