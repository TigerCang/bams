<?php $o = substr($wenbrako, -1); ?>
<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMselect') ?>">
                <h4 class="modal-title"><?= lang('app.titlepilihalat') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--  -->
            <div class="card-block mt-2 mb-2">
                <div class="dt-responsive table-responsive">
                    <table id="tabelmodal" class="table table-striped table-hover nowrap">
                        <thead>
                            <?= "
                            <tr class='bghead'>
                                <th scope='col' width='10'>#</th>
                                <th scope='col'>" . lang('app.kode') . "</th>
                                <th scope='col'>" . lang('app.deskripsi') . "</th>
                                <th scope='col'>" . lang('app.kategori') . "</th>
                                <th scope='col'>" . lang('app.perusahaan') . "</th>
                                <th scope='col'>" . lang('app.divisi') . "</th>
                                <th scope='col' width='10' data-orderable='false'></th>
                            </tr>"; ?>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            if ($o == '1') {
                                echo "<tr>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td class='text-center'><button type='button' id='selectalat' class='btn " . lang('app.btncPilih2') . "' data-toggle='tooltip' title='" . lang('app.pilih') . "' data-id='' data-kode='' data-nomor='' data-nama='' data-kbli='' data-kodekbli='' data-namakbli='' data-perusahaan='' data-wilayah='' data-divisi=''>" . lang('app.btnPilih2') . "</button></td>";
                                echo "</tr>";
                            }
                            foreach ($alat as $row) :
                                echo "<tr>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                echo "<td>
                                        <div class='d-inline-block align-middle'>
                                            <h7>{$row->kode}</h7>
                                            <p class='text-muted m-b-0'>{$row->nomor}</p>
                                        </div>
                                    </td>";
                                echo "<td>$row->nama</td>";
                                echo "<td>$row->kategori</td>";
                                echo "<td>$row->perusahaan</td>";
                                echo "<td>
                                        <div class='d-inline-block align-middle'>
                                            <h7>{$row->divisi}</h7>
                                            <p class='text-muted m-b-0'>{$row->wilayah}</p>
                                        </div>
                                    </td>";
                                echo "<td class='text-center'>";
                                $hid1 = ($tuser['act_perusahaan'] == '1' || preg_match("/,$row->perusahaan_id,/i", $tuser['perusahaan']) ? '' : 'hidden');
                                $hid2 = ($tuser['act_divisi'] == '1' || preg_match("/,$row->divisi_id,/i", $tuser['divisi']) ? '' : 'hidden');
                                $hid3 = ($tuser['act_alat'] == '1' || preg_match("/,$row->id,/i", $tuser['alat']) ? '' : 'hidden');
                                echo "<button type='button' " . ($o == '0' ? "$hid1 $hid2 $hid3" : '') . " id='selectalat' class='btn " . lang('app.btncPilih2') . "' data-toggle='tooltip' title='" . lang('app.pilih') . "' data-id='{$row->id}' data-kode='{$row->kode}' data-nomor='{$row->nomor}' data-nama='{$row->nama}' data-kbli='{$row->kbli_id}' data-kodekbli='{$row->kodekbli}' data-namakbli='{$row->namakbli}' data-perusahaan='{$row->perusahaan_id}' data-wilayah='{$row->wilayah_id}' data-divisi='{$row->divisi_id}'>" . lang('app.btnPilih2') . "</button>";
                                echo "</td>";
                                echo "</tr>";
                            endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/modal.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#selectalat', function() {
            var id = $(this).data('id');
            var kode = $(this).data('kode');
            var nomor = $(this).data('nomor');
            var nama = $(this).data('nama');
            var kbli = $(this).data('kbli');
            var kodekbli = $(this).data('kodekbli');
            var namakbli = $(this).data('namakbli');
            var perusahaan = $(this).data('perusahaan');
            var wilayah = $(this).data('wilayah');
            var divisi = $(this).data('divisi');
            var w01 = "<?= substr($wenbrako, 0, 1) ?>";
            var b01 = "<?= substr($wenbrako, 3, 1) ?>";
            var a01 = "<?= substr($wenbrako, 5, 1) ?>";

            if (w01 == '1') {
                $("#perusahaan").val(perusahaan).change();
                $("#wilayah").val(wilayah).change();
                $("#divisi").val(divisi).change();
            }
            if (b01 == '0') {
                $('#idalat').val(id);
                $('#kodealat').val(kode);
                $('#namaalat').val(nama);
            } else {
                $('#idbeban').val(id);
                $('#kodebeban').val(kode);
                $('#namabeban').val(nama);
            }
            if (a01 == '1') loadanggaran();
            $('#modal-lampiran').modal('hide');
        })
    });
</script>