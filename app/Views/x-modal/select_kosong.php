<div class="modal fade" id="modal-pilih" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title judul-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <table id="tabelmodal" class="table table-striped table-hover nowrap">
                <thead>
                    <tr class="bghead">
                        <th width="5" hidden></th>
                        <th><?= lang('app.deskripsi') ?></th>
                        <th width="5" data-orderable="false"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td hidden></td>
                        <td class="text-center"><?= lang('app.errnodatatabel') ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>