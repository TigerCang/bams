<?php [$phid, $chid, $khid, $nhid] = array_map(function ($hid) {
    return $hid == '1' ? '' : 'hidden';
}, str_split($pckn)) ?>

<table id="tabelAwal" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th width="5" hidden></th>
            <th <?= $chid ?>><?= lang('app.kode') ?></th>
            <th <?= $nhid ?>><?= lang('app.nomor') ?></th>
            <th><?= lang('app.deskripsi') ?></th>
            <th <?= $khid ?>><?= lang('app.kategori') ?></th>
            <th <?= $phid ?>><?= lang('app.perusahaan') ?></th>
            <th <?= $phid ?>><?= lang('app.divisi') ?></th>
            <th class="text-center"><?= json('status') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alat as $index => $row) :
            $label = labelBadge('main', ($row->kondisi)) ?>
            <tr <?= ($row->xlog == '' ? 'class="fw-bold"' : '') ?>>
                <td hidden><?= $index + 1 ?>.</td>
                <td <?= $chid ?>><span><?= $row->kode ?></span>
                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->nomor ?></small>
                </td>
                <td <?= $nhid ?>><?= $row->nomor ?></td>
                <td><?= $row->nama ?></td>
                <td <?= $khid ?>><?= $row->kategori ?></td>
                <td <?= $phid ?>><?= $row->perusahaan ?></td>
                <td <?= $phid ?>><span><?= $row->divisi ?></span>
                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->wilayah ?></small>
                </td>
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