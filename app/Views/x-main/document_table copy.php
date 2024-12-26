<table id="tableInit" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th><?= lang('app.title') ?></th>
            <th><?= lang('app.description') ?></th>
            <th width="200"><?= lang('app.company') ?></th>
            <th width="200"><?= lang('app.date') ?></th>
            <th width="100" class="text-center"><?= json('status') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($document as $index => $row) :
            $label = labelBadge('main', ($row->adaptation)) ?>
            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                <td><?= $index + 1 ?>.</td>
                <td><?= $row->title ?></td>
                <td><?= $row->name ?></td>
                <td><span><?= $row->company ?></span>
                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->division ?></small>
                </td>
                <td><?= ($row->end_date == '0000-00-00' ? formatDate($row->start_date, '1') : formatDate($row->start_date, '1') . ' - ' . formatDate($row->end_date, '1')) ?></td>
                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
                <td>
                    <div class="dropdown">
                        <a href="javascript:void(0);" data-bs-toggle="dropdown"><?= json('btn i-dropdown') ?></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownLink">
                            <li><a href="javascript:void(0);" class="dropdown-item btn-input" data-unique="<?= $row->unique ?>"><?= lang('app.read'); ?></a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item btn-download" data-object="<?= $row->object ?>" data-attachment="<?= $row->attachment ?>"><?= lang('app.download'); ?></a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>