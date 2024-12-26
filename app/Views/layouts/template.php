<!DOCTYPE html>
<html lang="en-us">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title><?= lang('app.xprojek') ?> | <?= lang('app.xDescription') ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="SIMPRO WebApp">
    <meta name="author" content="#">

    <!-- Favicon icon -->
    <link rel="icon" href="<?= base_url('assets') ?>/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/bootstrap4-toggle-3.6.1/css/bootstrap4-toggle.css">
    <!-- icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/icon/feather/css/feather.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/icon/flag-icons/css/flag-icon.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/icon/material-design/css/material-design-iconic-font.min.css">
    <!-- animation nifty modal window effects css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/css/component.css">
    <!-- Font awesome star css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/jquery-bar-rating/css/css-stars.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/jquery-bar-rating/css/fontawesome-stars-o.css">
    <!-- Select 2 css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/select2/css/select2.min.css">
    <!-- Multi Select css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/multiselect/css/multi-select.css">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/pages/data-table/extensions/select/css/select.dataTables.min.css">
    <!-- Treeview css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/jstree/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/pages/treeview/treeview.css">
    <!-- jpro forms css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/pages/j-pro/css/j-forms.css">
    <!-- Tags css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/bootstrap-tagsinput/css/bootstrap-tagsinput.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/assets/css/jquery.mCustomScrollbar.css">
    <!-- extra css -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/extra/css/extra.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('libraries') ?>/bower_components/extra/css/paper.css">
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/jquery/js/jquery.min.js"></script>
    <script src="<?= base_url('libraries') ?>/assets/pages/data-table/extensions/select/js/select-custom.js"></script>
</head>

<body>
    <!-- nonaktif klik kanan -->
    <!-- <body oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;">  -->
    <!-- preloader -->
    <?= $this->include('layouts/preloader') ?>

    <div id="pcoded" class="pcoded text-selection-none">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <!-- navbar -->
            <?= $this->include('layouts/navbar') ?>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    <!-- sidebar -->
                    <?= $this->include('layouts/sidebar') ?>

                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-header" <?= ($t_dirac == lang('app.dasbor')) ? 'hidden' : '' ?>>
                                        <div class="row align-items-end">
                                            <div class="col-lg-8">
                                                <div class="page-header-title">
                                                    <?= $t_icon;
                                                    echo "<div class='d-inline'>";
                                                    echo "<h4>" . $t_menu . "</h4>";
                                                    echo "<span>" . $t_submenu . "</span>";
                                                    echo "</div>"; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="page-header-breadcrumb">
                                                    <ul class="breadcrumb breadcrumb-title">
                                                        <?= "<li class='breadcrumb-item'>" . $t_diricon . "</li>";
                                                        echo "<li class='breadcrumb-item'>" . $t_dir1 . "</li>";
                                                        echo (!empty($t_dir2)) ? ("<li class='breadcrumb-item'>" . $t_dir2 . "</li>") : '';
                                                        echo "<li class='breadcrumb-item active'><a href='" . $t_link . "'>" . $t_dirac . "</a></li>"
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- Page-header end -->

                                    <!-- Main content -->
                                    <?= $this->renderSection('content') ?>

                                </div>
                            </div><!-- Akhir main-body -->
                        </div>
                    </div><!-- Akhir pcoded content -->

                </div>
            </div>
        </div><!-- Akhir pcode container -->
    </div>

    <!-- Required Jquery -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/bootstrap4-toggle-3.6.1/js/bootstrap4-toggle.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <!-- modernizr js blank-->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/modernizr/js/modernizr.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/modernizr/js/css-scrollbars.js"></script>
    <!-- isotope js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/isotope/jquery.isotope.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/isotope/isotope.pkgd.min.js"></script>
    <!-- Masking js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/form-masking/inputmask.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/form-masking/jquery.inputmask.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/form-masking/autoNumeric.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/form-masking/form-mask.js"></script>
    <!-- Tree view js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/jstree/js/jstree.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/treeview/jquery.tree.js"></script>
    <!-- rating js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/jquery-bar-rating/js/jquery.barrating.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/js/rating.js"></script>
    <!-- Tags js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/bootstrap-tagsinput/js/typeahead.bundle.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script> -->
    <!-- Max-length js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/bootstrap-maxlength/js/bootstrap-maxlength.js"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/i18next/js/i18next.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
    <!-- data-table js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/data-table/js/jszip.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/data-table/js/pdfmake.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/data-table/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/data-table/extensions/select/js/dataTables.select.min.js"></script>
    <!-- Select 2 js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/select2/js/select2.full.min.js"></script>
    <!-- Multiselect js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/multiselect/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/js/jquery.quicksearch.js"></script>
    <!-- Sweet Alert -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- j-pro js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/j-pro/js/jquery.ui.min.js"></script>
    <!-- Custom js -->
    <!-- <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/advance-elements/swithces.js"></script> -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/js/script.min.js"></script>
    <!-- <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/data-table/extensions/select/js/select-custom.js"></script> -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/js/script.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/js/pcoded.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/js/vartical-layout.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/data-table/js/data-table-custom.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/advance-elements/select2-custom.js"></script>
    <!-- <script type="text/javascript" src="<?= base_url('libraries') ?>/assets/pages/dashboard/custom-dashboard.js"></script> -->
    <!-- extra js -->
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/extra.js"></script>
    <script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/kursor.js"></script>

    <!-- <script>// untuk full screen awal
        window.onload = function() {
            openFullscreen();
        };
    </script> -->
</body>

</html>