<table id="tableCompany2" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th><?= lang('app.name') ?></th>
            <th width="300"><?= lang('app.identity number') ?></th>
            <th><?= lang('app.position') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($company as $index => $row) : ?>
            <tr>
                <td><?= $index + 1 ?>.</td>
                <td><?= $row->name ?></td>
                <td><?= $row->identity ?></td>
                <td><?= $row->position ?></td>
                <td><?php if (thisUser()['act_button'][3] == '1') : ?>
                        <a href="javascript:void(0);" class="btn-delete" data-unique="<?= $row->unique ?>" data-name="<?= $row->name ?>"><?= json('btn i-delete') ?></a>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>