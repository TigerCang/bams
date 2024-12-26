<table id="tableCompany1" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th><?= lang('app.status') ?></th>
            <th><?= lang('app.address') ?></th>
            <th><?= lang('app.city') ?></th>
            <th><?= lang('app.phone') ?></th>
            <th><?= lang('app.fax') ?></th>
            <th><?= lang('app.email') ?></th>
            <th><?= lang('app.tax number') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($company as $index => $row) : ?>
            <tr>
                <td><?= $index + 1 ?>.</td>
                <td><?= $row->status ?></td>
                <td><?= $row->address ?></td>
                <td><?= $row->city ?></td>
                <td><?= $row->phone ?></td>
                <td><?= $row->fax ?></td>
                <td><?= $row->email ?></td>
                <td><?= $row->tax_number ?></td>
                <td><?php if (thisUser()['act_button'][3] == '1') : ?>
                        <a href="javascript:void(0);" class="btn-delete" data-unique="<?= $row->unique ?>" data-address="<?= $row->address ?>"><?= json('btn i-delete') ?></a>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>