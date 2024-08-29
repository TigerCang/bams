<table id="tabelload" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.username') ?></th>
            <th scope="col"><?= lang('app.kode') ?></th>
            <th scope="col"><?= lang('app.nama') ?></th>
            <th scope="col"><?= lang('app.perusahaan') ?></th>
            <th scope="col"><?= lang('app.divisi') ?></th>
            <th scope="col" width="10" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($user as $row) : ?>
            <tr>
                <td><?= $nomor++ ?>.</td>
                <td><?= $row->kode ?></td>
                <td>
                    <div class="d-inline-block align-middle">
                        <h7><?= $row->kodepeg ?></h7>
                        <p class="text-muted m-b-0"><?= $row->nip ?></p>
                    </div>
                </td>
                <td><?= $row->nama ?></td>
                <td><?= $row->perusahaan ?></td>
                <td>
                    <div class="d-inline-block align-middle">
                        <h7><?= $row->divisi ?></h7>
                        <p class="text-muted m-b-0"><?= $row->wilayah ?></p>
                    </div>
                </td>
                <td>
                    <div class="dropdown-primary dropdown"><?= lang('app.btnDropdown') ?>
                        <div class="dropdown-menu eddm dropdown-menu-right">
                            <a class="dropdown-item eddi resetdata" data-iduser="<?= $row->iduser ?>" data-username="<?= $row->kode ?>"><?= lang('app.ulang') ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/load.js"></script>
<script>
    $(document).on('click', '.resetdata', function(e) {
        e.preventDefault();
        var id = $(this).data('iduser');
        var username = $(this).data('username');
        var url = '/ulangsandi/resetdata';
        Swal.fire({
            text: "<?= lang('app.inforeset') ?>",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= lang('app.confirmreset') ?>',
            cancelButtonText: '<?= lang('app.batal') ?>'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        id: id,
                        username: username,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            flashdata('success', response.sukses);
                            caridata();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText);
                        alert(thrownError);
                    }
                });
            }
        });
    });
</script>