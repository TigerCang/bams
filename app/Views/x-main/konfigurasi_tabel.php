<table id="tabelload" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.param') ?></th>
            <th scope="col" width="150" class="text-center"><?= lang('app.nilai') ?></th>
            <th scope="col" width="150"><?= lang('app.upby') ?></th>
            <th scope="col" width="10" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        if (is_array($konfigurasi)) {
            foreach ($konfigurasi as $row) : ?>
                <tr>
                    <td><?= $nomor++ ?>.</td>
                    <td><?= lang('app.' . $row['parameter']) ?></td>
                    <td class="text-center"><?= $row['nilai'] ?></td>
                    <td><?= $row['user'] ?></td>
                    <td>
                        <div class="dropdown-primary dropdown"><?= lang('app.btnDropdown') ?>
                            <div class="dropdown-menu eddm dropdown-menu-right">
                                <a class="dropdown-item eddi ubahdata" data-idunik="<?= $row['idunik'] ?>"><?= lang('app.ubah') ?></a>
                            </div>
                        </div>
                    </td>
                </tr>
        <?php endforeach;
        } ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/load.js"></script>
<script>
    $(document).on('click', '.ubahdata', function(e) {
        e.preventDefault();
        var getIDU = $(this).data('idunik');
        $.ajax({
            url: "/konfigurasi/modalkoreksi",
            data: {
                idunik: getIDU,
            },
            dataType: "json",
            success: function(response) {
                $('.modallampiran').html(response.data).show();
                $('#modal-lampiran').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    });
</script>