<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="ri-menu-fill ri-22px"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
                    <i class="ri-search-line ri-22px scaleX-n1-rtl me-3"></i>
                    <span class="d-none d-md-inline-block text-muted"><?= lang('app.search+ctrl') ?></span>
                </a>
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Home -->
            <li class="nav-item dropdown-language dropdown me-1 me-xl-0">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="/" data-toggle="tooltip" title="<?= lang('app.home') ?>">
                    <i class="ri-home-2-line ri-22px"></i>
                </a>
            </li>
            <!-- Screen -->
            <li class="nav-item dropdown-language dropdown me-1 me-xl-0">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" onclick="javascript:toggleFullScreen()" data-bs-toggle="dropdown" data-toggle="tooltip" title="<?= lang('app.screen') ?>">
                    <i class="ri-expand-diagonal-line ri-22px full-screen"></i>
                </a>
            </li>
            <!-- shortcut  -->
            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-1 me-xl-0">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" data-toggle="tooltip" title="<?= lang('app.shortcut') ?>">
                    <i class="ri-star-smile-line ri-22px"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end py-0">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto"><?= lang('app.shortcut') ?></h5>
                            <!-- <a href="javascript:void(0)" class="dropdown-shortcuts-add text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i class="mdi mdi-view-grid-plus-outline mdi-24px"></i></a> -->
                        </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="mdi mdi-calendar fs-4"></i>
                                </span>
                                <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                <small class="text-muted mb-0">Appointments</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                                    <i class="mdi mdi-file-document-outline fs-4"></i>
                                </span>
                                <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                <small class="text-muted mb-0">Manage Accounts</small>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4 me-xl-1">
                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" data-toggle="tooltip" title="<?= lang('app.notification') ?>">
                    <i class="ri-notification-2-line ri-22px"></i>
                    <span class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom py-50">
                        <div class="dropdown-header d-flex align-items-center py-2">
                            <h6 class="mb-0 me-auto">Notification</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge rounded-pill bg-label-primary fs-xsmall me-2">8 New</span>
                                <a href="javascript:void(0)" class="btn btn-text-secondary rounded-pill btn-icon dropdown-notifications-all" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="ri-mail-open-line text-heading ri-20px"></i></a>
                            </div>
                        </div>
                    </li>
                    <!-- Isi Notification -->
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded-circle bg-label-warning"><i class="ri-error-warning-line"></i></span>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <h6 class="mb-1 small">CPU is running high</h6>
                                        <small class="mb-1 d-block text-body">CPU Utilization Percent is currently at 88.63%,</small>
                                        <small class="text-muted">5 days ago</small>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ri-close-line ri-20px"></span></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="border-top">
                        <div class="d-grid p-4">
                            <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                                <small class="align-middle">View all notifications</small>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="<?= base_url('assets/picture/user/' . session()->avatar) ?>" alt class="rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-2">
                                    <div class="avatar avatar-online">
                                        <img src="<?= base_url('assets/picture/user/' . session()->avatar) ?>" alt class="rounded-circle" />
                                    </div>
                                </div>
                                <div class="w-100">
                                    <span class="fw-medium d-block small">Nama Pegawai belum</span>
                                    <small class="fw-medium"><?= decrypt(session()->username) ?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/profile">
                            <i class="ri-user-3-line ri-22px me-3"></i>
                            <span class="align-middle"><?= lang('app.profile') ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/layouts">
                            <i class="ri-layout-3-line ri-22px me-3"></i>
                            <span class="align-middle"><?= lang('app.layouts') ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#changePassword">
                            <i class="ri-rotate-lock-line ri-22px me-3"></i>
                            <span class="align-middle"><?= lang('app.password') ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#message">
                            <i class="ri-question-answer-line ri-22px me-3"></i>
                            <span class="align-middle"><?= lang('app.message') ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/logactivity">
                            <i class="ri-pulse-line ri-22px me-3"></i>
                            <span class="align-middle"><?= lang('app.activity log') ?></span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <div class="d-grid px-4 pt-2 pb-1">
                            <a class="<?= json('btn logout') ?> d-flex" href="/logout">
                                <small class="align-middle"><?= lang('app.btn logout') ?></small>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div> <!--/ Navbar right-->

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="<?= lang('app.search+') ?>" aria-label="Search..." />
        <i class="mdi mdi-close search-toggler cursor-pointer"></i>
    </div>
</nav> <!--/ Navbar-->

<!-- Offcanvas for Changing Password -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="changePassword" aria-labelledby="changePassword" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="changePassword"><?= lang('app.change password') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body border-top">
        <?= $this->include('home/changePassword_input') ?>
    </div>
</div>

<!-- Offcanvas for Message -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="message" aria-labelledby="message" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="message"><?= lang('app.message') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body border-top">
        <?= $this->include('home/message_input') ?>
    </div>
</div>

<script>
    $('#changePassword').on('show.bs.offcanvas', function() {
        $(this).find('input').not('#usernameOC').val('');
        $(this).find('input').removeClass('is-invalid');
        $(this).find('.invalid-feedback').html('');
    });
</script>