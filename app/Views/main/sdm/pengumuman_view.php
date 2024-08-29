<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?= (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : ''); ?>
<div class="page-body">
    <form action="/pengumuman/save" id="myForm" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header <?= lang('app.bgList') ?>">
                        <h5><?= lang('app.uploadfile') ?></h5>
                    </div>
                    <!--  -->
                    <div class="card-block mt-2">
                        <div id="drop_zone">
                            <p><?= lang('app.drophere') ?></p>
                            <p><?= lang('app.atau') ?></p>
                            <p><button type="button" id="btnBrowse" class="btn <?= lang('app.btncBrowse') ?>"><span class="glyphicon glyphicon-folder-open"></span><?= lang('app.btnBrowse') ?></button></p>
                            <p id="file_info"></p>
                            <p><button type="submit" id="btnUpload" class="btn <?= lang('app.btncUpload') ?>"><span class="glyphicon glyphicon-arrow-up"></span><?= lang('app.btnUpload') ?></button></p>
                        </div>
                        <div>
                            <input type="file" style="display:none" class="form-control <?= (validation_show_error('filepdf') ? 'is-invalid' : '') ?>" id="filepdf" name="filepdf">
                            <div class="invalid-feedback"><?= validation_show_error('filepdf') ?></div>
                        </div>
                    </div>
                </div><!-- card end -->

            </div>
        </div>
    </form>
</div><!-- body end -->

<script>
    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

    var fileobj;
    $(document).ready(function() {
        $("#drop_zone").on("dragover", function(event) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        });

        $("#drop_zone").on("drop", function(event) {
            event.preventDefault();
            event.stopPropagation();
            fileobj = event.originalEvent.dataTransfer.files[0];
            var fname = fileobj.name;
            var fsize = fileobj.size;
            if (fname.length > 0) document.getElementById('file_info').innerHTML = "File name : " + fname + ' <br>File size : ' + bytesToSize(fsize);
            document.getElementById('filepdf').files[0] = fileobj;
            document.getElementById('btnUpload').style.display = "inline";
        });

        $('#btnBrowse').click(function() {
            document.getElementById('filepdf').click();
            document.getElementById('filepdf').onchange = function() {
                fileobj = document.getElementById('filepdf').files[0];
                var fname = fileobj.name;
                var fsize = fileobj.size;
                if (fname.length > 0) document.getElementById('file_info').innerHTML = "File name : " + fname + ' <br>File size : ' + bytesToSize(fsize);
                document.getElementById('btnUpload').style.display = "inline";
            };
        });
    });
</script>

<?= $this->endSection() ?>