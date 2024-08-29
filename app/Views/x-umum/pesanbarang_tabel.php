<div onload="flashdata()"></div>
<?php ($pesan == '1') ? $hid = 'hidden' : $hid = ''; ?>

<table id="berkas" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col" width="100"><?= lang('app.tanggal'); ?></th>
            <th scope="col" <?= $hid; ?>><?= lang('app.peminta'); ?></th>
            <th scope="col"><?= lang('app.nodoc'); ?></th>
            <th scope="col"><?= lang('app.suplier'); ?></th>
            <th scope="col"><?= lang('app.pilihan'); ?></th>
            <th scope="col"><?= lang('app.perusahaan'); ?></th>
            <th scope="col"><?= lang('app.wilayah'); ?></th>
            <th scope="col"><?= lang('app.divisi'); ?></th>
            <th scope="col" width="10" class="text-center"><?= lang('app.level'); ?></th>
            <th scope="col" width="10"><?= lang('app.status'); ?></th>
            <th scope="col" width="10"><?= lang('app.aksi'); ?></th>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($po as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>" . formattgl($row->tgl_po) . "</td>";
            echo "<td $hid>$row->peminta</td>";
            echo "<td>$row->nodoc</td>";
            echo "<td>$row->suplier</td>";
            echo "<td>" . (($row->pilihan == '') ? '' : lang('app.' . $row->pilihan)) . "</td>";
            echo "<td>$row->perusahaan</td>";
            echo "<td>$row->wilayah</td>";
            echo "<td>$row->divisi</td>";
            echo "<td class='text-center'>$row->level_aw</td>";

            switch ($row->status) {
                case '0':
                    echo "<td class='text-center'><label class='label label-inverse'>" . lang('app.draft') . "</label></td>";
                    break;
                case '1':
                    echo "<td class='text-center'><label class='label label-biru'>" . lang('app.baru') . "</label></td>";
                    break;
                case '2':
                    echo "<td class='text-center'><label class='label label-primary'>" . lang('app.proses') . "</label></td>";
                    break;
                case '3':
                    echo "<td class='text-center'><label class='label label-warning'>" . lang('app.revisi') . "</label></td>";
                    break;
                case '4':
                    echo "<td class='text-center'><label class='label label-danger'>" . lang('app.tolak') . "</label></td>";
                    break;
                case '5':
                    echo "<td class='text-center'><label class='label label-danger'>" . lang('app.batal') . "</label></td>";
                    break;
                case '6':
                    echo "<td class='text-center'><label class='label label-primary'>" . lang('app.keuangan') . "</label></td>";
                    break;
                case '7':
                    echo "<td class='text-center'><label class='label label-biru'>" . lang('app.siapbayar') . "</label></td>";
                    break;
                case '8':
                    echo "<td class='text-center'><label class='label label-success'>" . lang('app.dibayar') . "</label></td>";
                    break;
            }
            echo "<td class='text-center'><a href='/$menu/input/$row->idunik' class='btn " . lang('app.btnDetil2') . "' data-toggle='tooltip' title='" . lang('app.detil') . "'>" . lang('app.btn_Detil2') . "</a></td>";
            echo "</tr>";
        endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries'); ?>/bower_components/extra/js/loadview.js"></script>