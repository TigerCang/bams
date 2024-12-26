<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-header pb-0">
                <h5 class="card-title">Filter</h5>
                <div class="row g-2 mb-4">
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="sObject" name="sObject" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?php foreach ($selectObject as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (session()->getFlashdata('flash-object') == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="sObject"><?= lang('app.object') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="sIsi" name="sIsi" placeholder="<?= lang('app.title description company region division') ?>" />
                            <label for="sIsi"><?= lang('app.data') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 col-lg-2">
                        <button type="button" class="<?= json('btn search') ?> btn-search"><?= lang('app.btn search') ?></button>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center row <?= (session()->getFlashdata('message') ? 'py-3' : 'py-0') ?> gap-3 gap-md-0">
                    <div>
                        <button type="button" class="<?= json('btn create') ?> btn-input" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn create') ?></button>
                    </div>
                </div>
                <?php if (session()->getFlashdata('message')) :
                    echo json('alert success-1') . session()->getFlashdata('message') . json('alert success-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive viewTable"></div>
        </div><!--/ Card -->

    </div><!--/ Col -->
</div><!--/ Row -->
<div class="modal-input" style="display: none;"></div>

<script>
    $(function() {
        $('.btn-search').trigger('click');
    });

    $(document).on('click', '.btn-input', function(e) {
        e.preventDefault();
        var getUnique = $(this).data('unique') || '';
        $.ajax({
            url: "<?= $link ?>/input",
            data: {
                search: getUnique,
            },
            dataType: "json",
            success: function(response) {
                $('.modal-input').html(response.data).show();
                $('#modal-input').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

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

    $(document).on('click', '.btn-search', function(e) {
        e.preventDefault();
        var getObject = $("#sObject").val();
        var getIsi = $("#sIsi").val();
        $.ajax({
            url: "<?= $link ?>/search",
            type: "POST",
            data: {
                object: getObject,
                isi: getIsi,
            },
            dataType: "json",
            success: function(response) {
                $('.viewTable').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })
</script>

<?= $this->endSection() ?>