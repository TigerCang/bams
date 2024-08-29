<?php
$chid = ($cpl[0] == '0' ? 'hidden' : '');
$phid = ($cpl[1] == '0' ? 'hidden' : '');
$lhid = ($cpl[2] == '0' ? 'hidden' : ''); ?>
<table id="tabelAwal" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th width="5" hidden></th>
            <th <?= $chid ?>><?= lang('app.cabang') ?></th>
            <th><?= lang('app.kode') ?></th>
            <th><?= lang('app.deskripsi') ?></th>
            <th <?= $phid ?>><?= lang('app.perusahaan') ?></th>
            <th <?= $lhid ?> class="text-center">Km</th>
            <th class="text-center"><?= json('status') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ruas as $index => $row) :
            $label = labelBadge('main', ($row->kondisi)) ?>
            <tr <?= ($row->xlog == '' ? 'class="fw-bold"' : '') ?>>
                <td hidden><?= $index + 1 ?>.</td>
                <td <?= $chid ?>><?= $row->kodecabang ?></td>
                <td><?= $row->kode ?></td>
                <td><?= $row->nama ?></td>
                <td <?= $phid ?>><span><?= $row->perusahaan ?></span>
                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->wilayah ?></small>
                </td>
                <td <?= $lhid ?> class="text-center"><?= formatkoma($row->jarak, '0') ?></td>
                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
                <td><?php if ($tuser['act_button'][1] == '1') : ?>
                        <a href="javascript:void(0);" class="btninput" data-idunik="<?= $row->idunik ?>"><?= json('btn iview') ?></a>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>