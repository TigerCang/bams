<?php [$bHid, $cHid, $dHid] = array_map(function ($hid) {
    return $hid == '1' ? '' : 'hidden';
}, str_split($bcd)) ?>

<table id="tableInit" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th width="150" <?= $bHid ?>><?= lang('app.branch') ?></th>
            <th width="150"><?= lang('app.code') ?></th>
            <th><?= lang('app.description') ?></th>
            <th width="200" <?= $cHid ?>><?= lang('app.company') ?></th>
            <th width="100" <?= $dHid ?> class="text-center">Km</th>
            <th width="100" class="text-center"><?= json('status') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($distance as $index => $row) :
            $label = labelBadge('main', ($row->adaptation)) ?>
            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                <td><?= $index + 1 ?>.</td>
                <td <?= $bHid ?>><?= $row->codeBranch ?></td>
                <td><?= $row->code ?></td>
                <td><?= $row->name ?></td>
                <td <?= $cHid ?>><span><?= $row->company ?></span>
                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->region ?></small>
                </td>
                <td <?= $dHid ?> class="text-center"><?= formatComa($row->distance, '0') ?></td>
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