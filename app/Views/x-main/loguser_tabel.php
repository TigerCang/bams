<table id="tabelload" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col" <?= $uhid ?>><?= lang('app.username') ?></th>
            <th scope="col">Menu</th>
            <th scope="col"><?= lang('app.aksi') ?></th>
            <th scope="col">Data</th>
            <th scope="col"><?= lang('app.alamatip') ?></th>
            <th scope="col" width="40"><?= lang('app.tanggal') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($isilog as $row) : ?>
            <tr>
                <td><?= $nomor++ ?>.</td>
                <td <?= $uhid ?>><?= $row->created_by ?></td>
                <td>/<?= $row->menu ?></td>
                <td><?= lang('app.' . $row->aksi) ?></td>
                <td><?= $row->data ?></td>
                <td><?= $row->ip_address ?></td>
                <td><?= date('d-m-y h:i:s', strtotime($row->created_at)) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/load.js"></script>