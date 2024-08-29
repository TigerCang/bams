<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMselect') ?>">
                <h4 class="modal-title"><?= lang('app.titlepilihdokumen') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-block mb-2 mt-2">
                <div class="dt-responsive table-responsive">
                    <table id="tabselect" class="table table-striped table-hover table-bordered nowrap">
                        <thead>
                            <?php
                            echo "<tr class='bghead'>";
                            echo "<th scope='col' width='10'>#</th>";
                            echo "<th scope='col'>" . lang('app.nodoc') . "</th>";
                            echo "<th scope='col'>" . lang('app.perusahaan') . "</th>";
                            echo "<th scope='col'>" . lang('app.wilayah') . "</th>";
                            echo "<th scope='col'>" . lang('app.divisi') . "</th>";
                            echo "<th scope='col'>" . lang('app.pilihan') . "</th>";
                            echo "<th scope='col'>" . lang('app.cabang') . "</th>";
                            echo "<th scope='col' width='10'>" . lang('app.ppn') . "</th>";
                            echo "<th scope='col' width='10'>" . lang('app.aksi') . "</th>";
                            echo "</tr>"; ?>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            foreach ($dokumen as $row) :
                                echo "<tr>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                echo "<td>$row->nodoc</td>";
                                echo "<td>$row->perusahaan</td>";
                                echo "<td>$row->wilayah</td>";
                                echo "<td>$row->divisi</td>";
                                echo "<td>" . lang('app.' . $row->pilihan) . "</td>";

                                switch ($row->pilihan) {
                                    case 'proyek':
                                        ($tuser['akses_proyek'] == '1' || preg_match("/,$row->cabang_id,/i", $tuser['proyek'])) ? $hid4 = '' : $hid4 = 'hidden';
                                        $kodecabang = $row->kodeproyek;
                                        $namacabang = $row->namaproyek;
                                        break;
                                    case 'alat':
                                        ($tuser['akses_alat'] == '1' || preg_match("/,$row->cabang_id,/i", $tuser['alat'])) ? $hid4 = '' : $hid4 = 'hidden';
                                        $kodecabang = $row->kodealat;
                                        $namacabang = $row->namaalat;
                                        break;
                                    case 'camp':
                                        ($tuser['akses_camp'] == '1' || preg_match("/,$row->cabang_id,/i", $tuser['camp'])) ? $hid4 = '' : $hid4 = 'hidden';
                                        $kodecabang = $row->kodecamp;
                                        $namacabang = $row->namacamp;
                                        break;
                                    case 'tanah':
                                        ($tuser['akses_aset'] == '1' || preg_match("/,$row->cabang_id,/i", $tuser['aset'])) ? $hid4 = '' : $hid4 = 'hidden';
                                        $kodecabang = $row->kodetanah;
                                        $namacabang = $row->namatanah;
                                        break;
                                    default:
                                        $hid4 = '';
                                        $kodecabang = '';
                                        $namacabang = '';
                                        break;
                                }

                                $hid1 = ($tuser['akses_perusahaan'] == '1' || preg_match("/,$row->perusahaan_id,/i", $tuser['perusahaan'])) ? '' : 'hidden';
                                $hid2 = ($tuser['akses_wilayah'] == '1' || preg_match("/,$row->wilayah_id,/i", $tuser['wilayah'])) ? '' : 'hidden';
                                $hid3 = ($tuser['akses_divisi'] == '1' || preg_match("/,$row->divisi_id,/i", $tuser['divisi'])) ? '' : 'hidden';
                                echo "<td>$kodecabang</td>";
                                echo "<td class='text-center'>" . (($row->ppn == '1') ? '<i class="fa fa-check"></i>' : '') . "</td>";
                                echo "<td class='text-center'><button $hid1 $hid2 $hid3 $hid4 id='selectdoc' class='btn " . lang('app.btnPilih2') . "' data-toggle='tooltip' title='" . lang('app.pilih') . "' data-pounik='" . $row->idunik . "' data-dokumen='" . $row->nodoc . "' data-perusahaan='" . $row->perusahaan_id . "' data-wilayah='" . $row->wilayah_id . "' data-divisi='" . $row->divisi_id . "' data-pilihan='" . $row->pilihan . "' data-cabang='" . $row->cabang_id . "' data-kodecabang='" . $kodecabang . "' data-namacabang='" . $namacabang . "' data-pajak='" . $row->ppn . "'>" . lang('app.btn_Pilih2') . "</button></td>";
                                echo "</tr>";
                            endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tabselect').DataTable({
            "ordering": true,
            "searching": true,
            "autoWidth": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All'],
            ],
            "iDisplayLength": 25,
        });

        $(document).on('click', '#selectdoc', function() {
            var pounik = $(this).data('pounik');
            var dokumen = $(this).data('dokumen');
            var perusahaan = $(this).data('perusahaan');
            var wilayah = $(this).data('wilayah');
            var divisi = $(this).data('divisi');
            var pilihan = $(this).data('pilihan');
            var cabang = $(this).data('cabang');
            var kodecabang = $(this).data('kodecabang');
            var namacabang = $(this).data('namacabang');
            var pajak = $(this).data('pajak');

            $('#mintaunik').val(pounik);
            $('#docminta').val(dokumen);
            $('#xpajak').val(pajak);
            $('#idperusahaan').val(perusahaan);
            $('#idwilayah').val(wilayah);
            $('#iddivisi').val(divisi);
            $('#idbeban').val(cabang);
            $('#beban').val(kodecabang);
            $('#namabeban').val(namacabang);
            $("#perusahaan").val(perusahaan).change();
            $("#wilayah").val(wilayah).change();
            $("#divisi").val(divisi).change();
            $("#pilihan").val(pilihan).change();
            datamintabarang();
            $('#modal-lampiran').modal('hide');
        })
    });
</script>