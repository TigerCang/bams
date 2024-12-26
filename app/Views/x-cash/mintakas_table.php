<table id="tabelAwal" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th width="5" hidden></th>
            <th><?= lang('app.tanggal') ?></th>
            <th><?= lang('app.peminta') ?></th>
            <th><?= lang('app.dokumen') ?></th>
            <th><?= lang('app.setuju') ?></th>
            <th class="text-center"><?= json('status') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($kas as $index => $row) :
            $label = labelBadge('biayakas', ($row->status[1])) ?>
            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                <td hidden><?= $index + 1 ?>.</td>
                <td><?= formattanggal($row->tgl_minta) ?></td>
                <td><?= $row->peminta ?></td>
                <td><?= $row->nodokumen ?></td>
                <td></td>
                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
                <td><a href="javascript:void(0);" class="btninput" data-idunik="<?= $row->idunik ?>"><?= json('btn iview') ?></a></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>