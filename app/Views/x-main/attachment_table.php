<?php $eHid = ($objHidden == 'employee' ? '' : 'hidden');
$neHid = ($objHidden == 'employee' ? 'hidden' : ''); ?>

<table id="tableAttachment" class="table table-striped table-hover">
    <thead>
        <tr class="tr-color">
            <th width="5">#</th>
            <th width="200"><?= lang('app.category') ?></th>
            <th><?= lang('app.keeper') ?></th>
            <th <?= $eHid ?>>SKA</th>
            <th <?= $eHid ?>><?= lang('app.level') ?></th>
            <th <?= $eHid ?>><?= lang('app.qualification') ?></th>
            <th <?= $eHid ?>><?= lang('app.reference year') ?></th>
            <th <?= $eHid ?>><?= lang('app.registration number') ?></th>
            <th <?= $eHid ?>><?= lang('app.association') ?></th>
            <th <?= $neHid ?>><?= lang('app.title') ?></th>
            <th <?= $neHid ?>><?= lang('app.description') ?></th>
            <th width="250"><?= lang('app.date') ?></th>
            <!-- <th width="200"><= lang('app.save by') ?></th> -->
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($attachment as $index => $row) : ?>
            <tr <?= ($row['is_active'] == '0') ? 'class="backgroundInactive"' : '' ?>>
                <td><?= $index + 1 ?>.</td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['keeper'] ?></td>
                <td <?= $eHid ?>><?= $row['ska'] ?></td>
                <td <?= $eHid ?>><?= $row['level'] ?></td>
                <td <?= $eHid ?>><?= $row['qualification'] ?></td>
                <td <?= $eHid ?>><?= $row['year'] ?></td>
                <td <?= $eHid ?>><?= $row['registration_number'] ?></td>
                <td <?= $eHid ?>><?= $row['association'] ?></td>
                <td <?= $neHid ?>><?= $row['title'] ?></td>
                <td <?= $neHid ?>><?= $row['description'] ?></td>
                <td><?= ($row['end_date'] == '0000-00-00' ? formatDate($row['start_date'], '1') : formatDate($row['start_date'], '1') . ' - ' . formatDate($row['end_date'], '1')) ?></td>
                <!-- <td><= $row['user'] ?></td> -->
                <td>
                    <?php if ($row['is_active'] == '1') : ?>
                        <div class="dropdown">
                            <a href="javascript:void(0);" data-bs-toggle="dropdown"><?= json('btn i-dropdown') ?></a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownLink">
                                <li><a href="javascript:void(0);" class="dropdown-item btn-inactive" data-unique="<?= $row['object_uniq'] ?>" data-title="<?= $row['title'] ?>"><?= lang('app.btn inactive'); ?></a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item btn-delete" data-unique="<?= $row['object_uniq'] ?>" data-title="<?= $row['title'] ?>"><?= lang('app.btn delete'); ?></a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item btn-download" data-object="<?= $row['object'] ?>" data-attachment="<?= $row['attachment'] ?>"><?= lang('app.btn download'); ?></a></li>
                            </ul>
                        </div>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>
<script>
    $(document).on('click', '.btn-download', function(e) {
        e.preventDefault();
        var getObject = $(this).data('object');
        var getAttachment = $(this).data('attachment');
        $.ajax({
            url: "<?= base_url('assets/attachment') ?>/" + getObject + "/" + getAttachment,
            type: 'GET',
            xhrFields: {
                responseType: 'blob' // response as binary data
            },
            success: function(data, status, xhr) {
                // make URL for file blob
                var blob = new Blob([data], {
                    type: xhr.getResponseHeader('Content-Type')
                });
                var downloadUrl = window.URL.createObjectURL(blob);

                // make link download temporary dan auto click
                var a = document.createElement("a");
                a.href = downloadUrl;
                a.download = xhr.getResponseHeader('Content-Disposition').split('filename=')[1].replace(/['"]/g, ''); // Get file name from header
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);

                // release URL blob after download finish
                window.URL.revokeObjectURL(downloadUrl);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText);
                // alert(thrownError);
            }
        });
    })
</script>