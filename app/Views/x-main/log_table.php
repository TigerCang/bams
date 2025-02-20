<table id="tableInit" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th width="150" <?= $uHid ?>><?= lang('app.username') ?></th>
            <th>MENU</th>
            <th width="100"><?= lang('app.action') ?></th>
            <th>Data</th>
            <th width="150"><?= lang('app.ip_address') ?></th>
            <th width="150"><?= lang('app.browser') ?></th>
            <th width="150"><?= lang('date') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($log as $index => $row) : ?>
            <tr>
                <td><?= $index + 1 ?>.</td>
                <td <?= $uHid ?>><?= $row->username ?></td>
                <td><?= filter_var($row->web_address, FILTER_VALIDATE_URL) ? '<a href="' . $row->web_address . '">' . $row->web_address . '</a>' : $row->web_address ?></td>
                <td><?= $row->action ?></td>
                <td><?= $row->data ?></td>
                <td><?= $row->ip_address ?></td>
                <td><?= $row->user_agent ?></td>
                <!-- <td><= date('d/m/Y H:i:s', $row->created_at) ?></td> -->
                <td><?= formatDate($row->created_at, '2') ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>