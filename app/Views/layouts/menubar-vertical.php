<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <img src="<?= base_url('assets/image/logo-trans.png') ?>" height="30" class="me-4">
            <span class="app-brand-text demo menu-text fw-bold ms-2">BAMS</span>
        </a>
        <a href="javascript:void(0);" class="highlight-menu layout-menu-toggle menu-link text-large ms-auto">
            <svg class="klikini" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z" fill="currentColor" fill-opacity="0.6" />
                <path d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z" fill="currentColor" fill-opacity="0.38" />
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Administrator -->
        <li class="menu-item" <?= ((preg_match("/A01/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-user-gear me-3"></i>
                <div data-i18n="<?= lang('app.administrator') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/101/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="" class="menu-link">
                        <div data-i18n="<?= lang('app.database') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/102/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/konfigurasi" class="menu-link">
                        <div data-i18n="<?= lang('app.konfigurasi') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/103/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/role" class="menu-link">
                        <div data-i18n="<?= lang('app.role') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/A02/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.user') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/104/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/user" class="menu-link">
                                <div data-i18n="<?= lang('app.user') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/105/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/token" class="menu-link">
                                <div data-i18n="<?= lang('app.token') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/loguser" class="menu-link">
                                <div data-i18n="<?= lang('app.log user') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/107/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/resetsandi" class="menu-link">
                                <div data-i18n="<?= lang('app.reset sandi') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li> <!--/ Administrator -->

        <!-- Main Data -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.data utama') ?>"></span></li>
        <!-- Deklarasi -->
        <li class="menu-item" <?= ((preg_match("/A01/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-signs-post me-3"></i>
                <div data-i18n="<?= lang('app.deklarasi') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/perusahaan" class="menu-link">
                        <div data-i18n="<?= lang('app.perusahaan') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/divisi" class="menu-link">
                        <div data-i18n="<?= lang('app.wilayah divisi') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/nuser" class="menu-link">
                        <div data-i18n="<?= lang('app.user anak') ?>"></div>
                    </a>
                </li>
                <li>
                    <div data-i18n="<?= json('xgaris') ?>"></div>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/satuan" class="menu-link">
                        <div data-i18n="<?= lang('app.satuan') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/dokumen" class="menu-link">
                        <div data-i18n="<?= lang('app.dokumen') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.penomoran') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/nodokumen" class="menu-link">
                                <div data-i18n="<?= lang('app.kode dokumen') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/noform" class="menu-link">
                                <div data-i18n="<?= lang('app.kode form') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.biaya proyek') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/kateproyek" class="menu-link">
                                <div data-i18n="<?= lang('app.kategori proyek') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/biayalangsung" class="menu-link">
                                <div data-i18n="<?= lang('app.biaya langsung') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/biayataklangsung" class="menu-link">
                                <div data-i18n="<?= lang('app.biaya taklangsung') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/sumberdaya" class="menu-link">
                                <div data-i18n="<?= lang('app.sumber daya') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.rumus') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/jarak" class="menu-link">
                                <div data-i18n="<?= lang('app.jarak') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/tarif" class="menu-link">
                                <div data-i18n="<?= lang('app.tarif') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/jobmix" class="menu-link">
                                <div data-i18n="<?= lang('app.jobmix') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/setanggaran" class="menu-link">
                        <div data-i18n="<?= lang('app.anggaran bawaan') ?>"></div>
                    </a>
                </li>
            </ul>
        </li><!--/ Deklarasi -->

        <!-- Cabang -->
        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-sitemap me-3"></i>
                <div data-i18n="<?= lang('app.cabang aset') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/cabang" class="menu-link">
                        <div data-i18n="<?= lang('app.cabang') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.proyek') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/proyek" class="menu-link">
                                <div data-i18n="<?= lang('app.proyek') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/ruas" class="menu-link">
                                <div data-i18n="<?= lang('app.ruas') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/subruas" class="menu-link">
                                <div data-i18n="<?= lang('app.sub ruas') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.alat') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/alat" class="menu-link">
                                <div data-i18n="<?= lang('app.alat') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/tool" class="menu-link">
                                <div data-i18n="<?= lang('app.tool') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/tanahbangunan" class="menu-link">
                        <div data-i18n="<?= lang('app.tanah bangunan') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/inventaris" class="menu-link">
                        <div data-i18n="<?= lang('app.inventaris') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Cabang -->

        <!-- Akuntansi -->
        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-scale-balanced me-3"></i>
                <div data-i18n="<?= lang('app.akuntansi') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/akuntansi" class="menu-link">
                        <div data-i18n="<?= lang('app.coa') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/akungrup" class="menu-link">
                        <div data-i18n="<?= lang('app.akun grup') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/akunbawaan" class="menu-link">
                        <div data-i18n="<?= lang('app.akun bawaan') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/akunkas" class="menu-link">
                        <div data-i18n="<?= lang('app.kas bank') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/akunpajak" class="menu-link">
                        <div data-i18n="<?= lang('app.pajak') ?>"></div>
                    </a>
                </li>
                <li>
                    <div data-i18n="<?= json('xgaris') ?>"></div>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/kbli" class="menu-link">
                        <div data-i18n="<?= lang('app.lain') ?>"></div>
                    </a>
                </li>
            </ul>
        </li><!--/ Akuntansi -->

        <!-- Barang -->
        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-cubes-stacked me-3"></i>
                <div data-i18n="<?= lang('app.barang') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/barang" class="menu-link">
                        <div data-i18n="<?= lang('app.barang') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/bahan" class="menu-link">
                        <div data-i18n="<?= lang('app.bahan') ?>"></div>
                    </a>
                </li>
                <li>
                    <div data-i18n="<?= json('xgaris') ?>"></div>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/noseri" class="menu-link">
                        <div data-i18n="<?= lang('app.noseri') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/gudang" class="menu-link">
                        <div data-i18n="<?= lang('app.gudang') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Barang -->

        <!-- Penerima -->
        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-shop me-3"></i>
                <div data-i18n="<?= lang('app.penerima') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/penerima" class="menu-link">
                        <div data-i18n="<?= lang('app.penerima') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/rekanalat" class="menu-link">
                        <div data-i18n="<?= lang('app.rekan alat') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/tautperusahaan" class="menu-link">
                        <div data-i18n="<?= lang('app.taut perusahaan') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Penerima -->

        <!-- SDM -->
        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-people-group me-3"></i>
                <div data-i18n="<?= lang('app.sdm') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/cuti" class="menu-link">
                        <div data-i18n="<?= lang('app.cuti') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/kalender" class="menu-link">
                        <div data-i18n="<?= lang('app.kalender') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/pengumuman" class="menu-link">
                        <div data-i18n="<?= lang('app.pengumuman') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/katerating" class="menu-link">
                        <div data-i18n="<?= lang('app.kategori rating') ?>"></div>
                    </a>
                </li>
                <li>
                    <div data-i18n="<?= json('xgaris') ?>"></div>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.pegawai') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/pegawai" class="menu-link">
                                <div data-i18n="<?= lang('app.pegawai') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/jabatan" class="menu-link">
                                <div data-i18n="<?= lang('app.jabatan golongan') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.gaji') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/atributgaji" class="menu-link">
                                <div data-i18n="<?= lang('app.atribut gaji') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/gaji" class="menu-link">
                                <div data-i18n="<?= lang('app.gaji') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li> <!--/ SDM -->

        <!-- Transaksi Umum -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksi umum') ?>"></span></li>
        <!-- Menu Anggaran -->
        <li class="menu-item" <?= ((preg_match("/A01/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-notebook-outline"></i>
                <div data-i18n="<?= lang('app.anggaran') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/anggaranbiayalangsung" class="menu-link">
                        <div data-i18n="<?= lang('app.biayalangsung') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/anggaranbiayalangsung" class="menu-link">
                        <div data-i18n="<?= lang('app.biayataklangsung') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/anggaransumberdaya" class="menu-link">
                        <div data-i18n="<?= lang('app.satuandetil') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/anggarannonproyek" class="menu-link">
                        <div data-i18n="<?= lang('app.nonproyek') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.revisi') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/revisibiayalangsung" class="menu-link">
                                <div data-i18n="<?= lang('app.biayalangsung') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/revisibiayataklangsung" class="menu-link">
                                <div data-i18n="<?= lang('app.biayataklangsung') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/revisisumberdaya" class="menu-link">
                                <div data-i18n="<?= lang('app.satuandetil') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/revisinonproyek" class="menu-link">
                                <div data-i18n="<?= lang('app.nonproyek') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/accanggaran" class="menu-link">
                        <div data-i18n="<?= lang('app.tandatangan') ?>"></div>
                    </a>
                </li>

            </ul>
        </li>

        <!-- Transaksi Barang -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksibarang') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Transaksi Divisi -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksidivisi') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Transaksi Kas -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksi kas') ?>"></span></li>
        <!-- Minta kas -->
        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-money-bill me-3"></i>
                <div data-i18n="<?= lang('app.minta kas') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/kaslangsung" class="menu-link">
                        <div data-i18n="<?= lang('app.kas langsung') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/uangmuka" class="menu-link">
                        <div data-i18n="<?= lang('app.uang muka') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/uangjalan" class="menu-link">
                        <div data-i18n="<?= lang('app.uang jalan') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/kaspindah" class="menu-link">
                        <div data-i18n="<?= lang('app.kas pindah') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/kastaklangsung" class="menu-link">
                        <div data-i18n="<?= lang('app.kas taklangsung') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Minta kas -->

        <!-- Pengecekan -->
        <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-money-bill me-3"></i>
                <div data-i18n="<?= lang('app.cek kas') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/cekkas" class="menu-link">
                        <div data-i18n="<?= lang('app.tanda tangan') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/keuangan" class="menu-link">
                        <div data-i18n="<?= lang('app.keuangan') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/potongpph" class="menu-link">
                        <div data-i18n="<?= lang('app.potong pph') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", $tmenu['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/cekkasir" class="menu-link">
                        <div data-i18n="<?= lang('app.cek kasir') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Cek kas -->

        <!-- Transaksi Akuntansi -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksiakuntansi') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Transaksi SDM -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksisdm') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Laporan -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.laporan') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Lain Lain -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.lainlain') ?>"></span></li>
        <li class="menu-item">
            <a href="/faq" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-lifebuoy"></i>
                <div data-i18n="<?= lang('app.faq') ?>"></div>
            </a>
        </li>

        <li class="menu-item">
            <a href="" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-lifebuoy"></i>
                <div data-i18n="<?= lang('app.help') ?>"></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-lifebuoy"></i>
                <div data-i18n="<?= lang('app.dukungan') ?>"></div>
            </a>
        </li>



    </ul>
</aside>