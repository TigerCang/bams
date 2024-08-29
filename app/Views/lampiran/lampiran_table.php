<table id="tabelLampiran" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th width="5" hidden></th>
            <th><?= lang('app.judul') ?></th>
            <th><?= lang('app.deskripsi') ?></th>
            <th><?= lang('app.tanggal') ?></th>
            <th><?= lang('app.saby') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lampiran as $index => $row) : ?>
            <tr>
                <td hidden><?= $index + 1 ?>.</td>
                <td><?= $row['judul'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td><?= formatTanggal($row['tanggal']) ?></td>
                <td><?= $row['user'] ?></td>
                <td>
                    <div class="d-flex align-items-sm-center justify-content-sm-center">
                        <button type="button" class="<?= json('btn titik') ?>" data-bs-toggle="dropdown" aria-expanded="false"><?= json('btn ititik') ?></button>
                        <div class="dropdown-menu dropdown-menu-end m-0">
                            <a href="<?= base_url('assets/berkas/' . $param . '/' . $row['lampiran']) ?>" class="dropdown-item"><?= lang('app.lihat') ?></a>
                            <a href="javascript:void(0);" class="dropdown-item" onclick="hapus('<?= $row['id'] ?>')"><?= lang('app.hapus'); ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>
<script>
    function hapus(id) {
        var url = '/lampiran/delete';
        Swal.fire({
            title: "<?= lang('app.tanya hapus') ?>",
            text: "<?= lang('app.info hapus') ?>",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "<?= lang('app.konf hapus') ?>",
            customClass: {
                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                cancelButton: 'btn btn-outline-secondary waves-effect'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: "<?= ucfirst(trim(lang('app.judul hapus'))) ?>",
                            text: "<?= lang('app.ok hapus') ?>",
                            customClass: {
                                confirmButton: 'btn btn-primary waves-effect waves-light'
                            }
                        });
                        dataLampiran();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText);
                        alert(thrownError);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    icon: 'error',
                    title: "<?= ucfirst(trim(lang('app.judul batal'))) ?>",
                    text: "<?= lang('app.ok batal') ?>",
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    }
                });
            }
        });
    }
</script>