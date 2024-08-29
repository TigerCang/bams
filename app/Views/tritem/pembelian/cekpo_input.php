<div onload="flashdata()"></div>

<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="page-body">
    <form action="/cekpo/save" id="myForm" method="POST">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.header'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <?php
                        switch ($pesan[0]->pilihan) {
                            case 'proyek':
                                $beban = $proyek1[0]->kode;
                                $namabeban = $proyek1[0]->paket;
                                break;
                            case 'camp':
                                $beban = $camp1[0]->kode;
                                $namabeban = $camp1[0]->nama;
                                break;
                            case 'alat':
                                $beban = $alat1[0]->kode;
                                $namabeban = $alat1[0]->nama;
                                break;
                            case 'tanah':
                                $beban = $tanah1[0]->kode;
                                $namabeban = $tanah1[0]->nama;
                                break;
                            default:
                                $beban = '';
                                $namabeban = '';
                                break;
                        } ?>

                        <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik; ?>">
                        <input type="hidden" class="form-control" id="mintaunik" name="mintaunik" value="<?= (!empty($pesan)) ? $pesan[0]->idunik : ''; ?>">
                        <input type="hidden" class="form-control" id="xpajak" name="xpajak" value="<?= (!empty($pesan)) ? $pesan[0]->stpajak : ''; ?>">
                        <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= (empty($pesan)) ? old('idperusahaan') : $pesan[0]->perusahaan_id; ?>">
                        <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= (empty($pesan)) ? old('idwilayah') : $pesan[0]->wilayah_id; ?>">
                        <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= (empty($pesan)) ? old('iddivisi') : $pesan[0]->divisi_id; ?>">
                        <input type="hidden" class="form-control" id="xpilihan" name="xpilihan" value="<?= (empty($pesan)) ? old('xpilihan') : $pesan[0]->pilihan; ?>">
                        <input type="hidden" class="form-control" id="idbeban" name="idbeban" value="<?= (empty($pesan)) ? old('idbeban') : $pesan[0]->cabang_id; ?>">


                        <input type="text" class="form-control" id="levsetuju" name="levsetuju" value="<?= $tuser['acc_setuju']; ?>">
                        <input type="text" class="form-control" id="levpo" name="levpo" value="<?= $pesan[0]->level_pos; ?>">
                        <input type="text" class="form-control" id="iduser" name="iduser" value="<?= $tuser['id']; ?>">

                        <div class="form-group row">
                            <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan'); ?></label>
                            <div class="col-sm-11">
                                <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                    <option><?= $pesan[0]->perusahaan . '&emsp;=>&emsp;' . $pesan[0]->namaperusahaan; ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah'); ?></label>
                            <div class="col-sm-4">
                                <select id="wilayah" class="js-example-basic-single" name="wilayah" disabled>
                                    <option><?= $pesan[0]->wilayah; ?></option>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi'); ?></label>
                            <div class="col-sm-4">
                                <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                    <option><?= $pesan[0]->divisi; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.dokumen'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="penerima" class="col-sm-1 col-form-label"><?= lang('app.suplier'); ?></label>
                            <div class="col-sm-11">
                                <select id="penerima" class="js-example-basic-single" name="penerima" disabled>
                                    <option value="<?= $penerima1[0]->id; ?>"><?= $penerima1[0]->kode . ' => ' . $penerima1[0]->nama ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="docminta" class="col-sm-1 col-form-label"><?= lang('app.nodoc'); ?></label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" id="docminta" name="docminta" value="<?= $pesan[0]->nodoc; ?>" autocomplete="off">
                                    <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal'); ?></label>
                            <div class="col-sm-2">
                                <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= $pesan[0]->tglpo; ?>">
                            </div>
                            <label for="norev" class="col-sm-1 col-form-label text-right"><?= lang('app.norev'); ?></label>
                            <div class="col-sm-1">
                                <input type="text" readonly class="form-control" id="norev" name="norev" value="0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan'); ?></label>
                            <div class="col-sm-4">
                                <select id="pilihan" class="js-example-basic-single" name="pilihan" disabled>
                                    <option><?= ($pesan[0]->pilihan == '') ? lang('app.pilih-') : lang('app.' . $pesan[0]->pilihan); ?>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="nopesan" class="col-sm-1 col-form-label"><?= lang('app.nopesan'); ?></label>
                            <div class="col-sm-4">
                                <input type="text" readonly class="form-control" id="nopesan" name="nopesan" value="<?= $pesan[0]->nodocpesan; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="beban" class="col-sm-1 col-form-label"><?= lang('app.cabang'); ?></label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" id="beban" name="beban" value="<?= $beban; ?>">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" id="namabeban" name="namabeban" value="<?= $namabeban; ?>" autocomplete="off">
                                    <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- Akhir card table-->
                <div class="dt-responsive table-responsive tabelbarang"></div>

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.aksi'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="aksi" class="col-sm-1 col-form-label"><?= lang('app.setuju'); ?></label>
                            <div class="col-sm-4">
                                <select id="aksi" class="js-example-basic-single" name="aksi">
                                    <?php foreach ($selnama as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= ($db->nama == 'cek') ? (($tuser['acc_setuju'] == '0') ? '' : 'disabled') : (($tuser['acc_setuju'] != '0') ? '' : 'disabled');  ?>><?= lang('app.' . $db->nama); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan'); ?></label>
                            <div class="col-sm-11">
                                <textarea class="form-control <?= ($validation->hasError('catatan')) ? 'is-invalid' : ''; ?>" harusisi rows="4" id="catatan" name="catatan" autocomplete="off" placeholder="<?= lang('app.harusisi'); ?>"><?= old('catatan'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('catatan'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn <?= lang('app.btnLogaksi'); ?> tampilaksilog"><?= lang('app.btn_Logaksi'); ?></button>
                            </div>
                            <div>
                                <button type="submit" class="btn <?= lang('app.btnSave'); ?>"><?= lang('app.btn_Save'); ?></button>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div>
        </div>
    </form>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    function datamintabarang() {
        var getIDU = $("#mintaunik").val();
        var getpesanIDU = $("#idunik").val();
        var getpenerima = $("#penerima").val();
        var getnodoc = $("#docminta").val();
        var getpajak = $("#xpajak").val();
        $.ajax({
            url: "/cekpo/tabbarang",
            data: {
                idunik: getIDU,
                pesanidunik: getpesanIDU,
                penerima: getpenerima,
                nodoc: getnodoc,
                pajak: getpajak,
                meabpr: '000010',
            },
            dataType: "json",
            success: function(response) {
                $('.tabelbarang').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        datamintabarang();

        $('.tampilaksilog').click(function(e) {
            e.preventDefault();
            var getIDU = "<?= $idunik; ?>";
            $.ajax({
                url: "/cekpo/logaksi",
                data: {
                    idunik: getIDU,
                    asal: 'pesanbarang',
                },
                dataType: "json",
                success: function(response) {
                    $('.modallampiran').html(response.data).show();
                    $('#modal-lampiran').modal('show')
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        })
    });
</script>

<?= $this->endSection(); ?>