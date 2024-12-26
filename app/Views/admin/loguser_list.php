<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <h5 class="card-title">Filter</h5>
                <div class="row g-2">
                    <div class="col-12 col-md-4 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="sUsername" name="sUsername" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?php foreach ($selectUser as $db) : ?>
                                    <option value="<?= $db->code ?>"><?= $db->code ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="sUsername"><?= lang('app.username') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="sIsi" name="sIsi" placeholder="<?= lang('app.menu data') ?>" />
                            <label for="sIsi"><?= lang('app.menu data') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 col-lg-2">
                        <button type="button" class="<?= json('btn search') ?> btn-search"><?= lang('app.btn search') ?></button>
                    </div>
                </div>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive viewTable"></div>
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->

<script>
    $(document).ready(function() { // idem $(function() {})
        $('.btn-search').trigger('click');
    });

    $(document).on('click', '.btn-search', function(e) {
        e.preventDefault();
        var getUsername = $("#sUsername").val();
        var getIsi = $("#sIsi").val();
        var getBlank = "<?= $blank ?>";
        $.ajax({
            url: "/search/log",
            type: "POST",
            data: {
                username: getUsername,
                isi: getIsi,
                blank: getBlank,
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