<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- Page-body start -->
<div class="page-body">
    <form action="/cekitmk/save/<?= $idunik ?>" id="myForm" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput') ?>">
                        <h5><?= lang('app.header') ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <input type="text" class="form-control" id="idunik" name="idunik" value="<?= $idunik ?>">
                        <input type="text" class="form-control" id="idpegawai" name="idpegawai" value="<?= $pegawai1['0']->id ?>">
                        <input type="text" class="form-control" id="iduser" name="iduser" value="<?= $userid ?>">
                        <input type="text" class="form-control" id="levsetuju" name="levsetuju" value="<?= $level ?>">
                        <input type="text" class="form-control" id="potong" name="potong" value="<?= $kategori1['0']->setdef ?>">

                        <div class="form-group row">
                            <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                            <div class="col-sm-11">
                                <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                    <?= "<option>{$perusahaan1['0']->kode} => {$perusahaan1['0']->nama}</option>" ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                            <div class="col-sm-4">
                                <select id="wilayah" class="js-example-basic-single" name="wilayah" disabled>
                                    <?= "<option>{$wilayah1['0']->nama}</option>" ?>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                            <div class="col-sm-4">
                                <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                    <?= "<option>{$divisi1['0']->nama}</option>" ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput') ?>">
                        <h5><?= lang('app.dokumen') ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc') ?></label>
                            <div class="col-sm-4">
                                <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= $minta['0']->nodoc ?>">
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                            <div class="col-sm-2">
                                <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= $minta['0']->tgl_minta ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pegawai" class="col-sm-1 col-form-label"><?= lang('app.pegawai') ?></label>
                            <div class="col-sm-11">
                                <select id="pegawai" class="js-example-basic-single" name="pegawai" disabled>
                                    <?= "<option>{$pegawai1['0']->kode} => {$pegawai1['0']->nama}</option>" ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lampiran" class="col-sm-1 col-form-label"><?= lang('app.berkas') ?></label>
                            <div class="col-sm-11">
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput') ?>">
                        <h5><?= lang('app.inputdata') ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="kategori" class="col-sm-1 col-form-label"><?= lang('app.kategori') ?></label>
                            <div class="col-sm-11">
                                <select id="kategori" class="js-example-basic-single" name="kategori" disabled>
                                    <?= "<option>{$kategori1['0']->nama}</option>" ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggalaw" class="col-sm-1 col-form-label"><?= lang('app.dari') ?></label>
                            <div class="col-sm-2">
                                <input type="date" readonly class="form-control" id="tanggalaw" name="tanggalaw" value="<?= $minta['0']->tgl_cuti1 ?>">
                            </div>
                            <div class="col-sm-2">
                                <input type="date" readonly class="form-control" id="tanggalak" name="tanggalak" value="<?= $minta['0']->tgl_cuti2 ?>">
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="lama" class="col-sm-1 col-form-label"><?= lang('app.lamawaktu') ?></label>
                            <div class="col-sm-1">
                                <input type="number" readonly class="form-control" id="lama" name="lama" value="<?= $minta['0']->lama ?>" autocomplete="off">
                            </div>
                            <label class="col-sm-1 col-form-label"><?= lang('app.hari') ?></label>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                            <div class="col-sm-11">
                                <textarea readonly class="form-control" rows="3" id="keterangan" name="keterangan"><?= $minta['0']->catatan ?></textarea>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput') ?>">
                        <h5><?= lang('app.aksi') ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="aksi" class="col-sm-1 col-form-label"><?= lang('app.setuju') ?></label>
                            <div class="col-sm-4">
                                <select id="aksi" class="js-example-basic-single" name="aksi">
                                    <?php foreach ($selnama as $db) :
                                        if ($db->nama != 'cek') echo "<option value='{$db->nama}'>" . lang('app.' . $db->nama) . "</option>";
                                    endforeach ?>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="sisa" class="col-sm-1 col-form-label"><?= lang('app.sisacuti') ?></label>
                            <div class="col-sm-2">
                                <input type="number" readonly class="form-control" id="sisa" name="sisa" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                            <div class="col-sm-11">
                                <textarea class="form-control <?= (validation_show_error('catatan')) ? 'is-invalid' : '' ?>" harusisi rows="3" id="catatan" name="catatan" autocomplete="off"><?= old('catatan') ?></textarea>
                                <div class="invalid-feedback"><?= validation_show_error('catatan') ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div class="col-4"><button type="button" class="btn <?= lang('app.btnLogcat') ?> tampilaksilog"><?= lang('app.btn_Logcat') ?></button></div>
                            <div class="col-4 text-center"><?= "<button type='submit' class='btn " . lang('app.btnSave') . "'>" . lang('app.btn_Save') . "</button>" ?></div>
                            <div class="col-4"></div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div>
        </div>
    </form>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $('.tampilaksilog').click(function(e) {
            e.preventDefault();
            var getIDU = "<?= $idunik; ?>";
            $.ajax({
                url: "/cekitmk/logaksi",
                data: {
                    idunik: getIDU,
                    asal: 'mintacuti',
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

<?= $this->endSection() ?>