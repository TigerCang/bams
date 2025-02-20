<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title title-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <table id="tableData" class="table table-striped table-hover">
                    <thead>
                        <tr class="tr-color">
                            <th width="5">#</th>
                            <th><?= lang('app.title') ?></th>
                            <th width="150"><?= lang('app.total') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($budget as $index => $row) : ?>
                            <tr>
                                <td><?= $index + 1 ?>.</td>
                                <td><?= $row->title ?></td>
                                <td><?= formatComa($row->total) ?></td>
                                <td><a href="javascript:void(0);" class="btn-input" data-unique="<?= $row->unique ?>"><?= json('btn i-select') ?></a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div> <!--/ Modal Content -->
    </div> <!--/ Modal Dialog -->
</div> <!--/ Modal fade -->

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>