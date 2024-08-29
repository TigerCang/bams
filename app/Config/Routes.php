<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->GET('/', 'Home::index');

// Login _________________________________________________________________________________________________________________________
$routes->GET('/logout', 'Login::logout');
$routes->GET('/signup', 'Login::viewSignup');
$routes->GET('/lupasandi', 'Login::viewSandi');
$routes->group('login', function ($routes) {
    $routes->GET('/', 'Login');
    $routes->POST('auth', 'Login::auth');
    $routes->POST('reset', 'Login::resetsandi');
    $routes->POST('signup', 'Login::signup');
});

// Home _________________________________________________________________________________________________________________________
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/home', function () {
    return redirect()->to('/');
});
$routes->GET('/profile', 'Home::profilpegawai', ['filter' => 'auth']);
$routes->GET('/sandi', 'Home::sandi', ['filter' => 'auth']);
$routes->POST('/savepass', 'Home::savepass', ['filter' => 'auth']);
$routes->GET('/logdata', 'Home::logdata', ['filter' => 'auth']);
$routes->GET('/lang/{locale}', 'Home::bahasa');

// Administrator _________________________________________________________________________________________________________________________
$routes->group('konfigurasi', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\Konfigurasi::index');
    $routes->GET('input', 'admin\Konfigurasi::inputData');
    $routes->POST('save', 'admin\Konfigurasi::saveData');
});
$routes->group('role', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\Role::index');
    $routes->GET('input', 'admin\Role::inputData');
    $routes->POST('save', 'admin\Role::saveData');
});
$routes->group('user', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\User::index');
    $routes->GET('input', 'admin\User::inputData');
    $routes->POST('save', 'admin\User::saveData');
    $routes->POST('usernama', 'campur\LoadMain::loadUser');
});
$routes->group('token', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\Token::index');
    $routes->GET('input', 'admin\Token::inputData');
    $routes->POST('save', 'admin\Token::saveData');
});
$routes->group('loguser', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'file\admin\LogUser::index');
    $routes->GET('tablog', 'file\admin\LogUser::tabellog');
});
$routes->group('ulangsandi', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'file\admin\ResetSandi::index');
    $routes->GET('tabdata', 'file\admin\ResetSandi::tabeldata');
    $routes->POST('resetdata', 'file\admin\ResetSandi::resetdata');
});

// Deklarasi _________________________________________________________________________________________________________________________
$routes->group('perusahaan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\Perusahaan::index');
    $routes->GET('input', 'main\deklarasi\Perusahaan::inputData');
    $routes->POST('save', 'main\deklarasi\Perusahaan::saveData');
});
$routes->group('divisi', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\Divisi::index');
    $routes->GET('input', 'main\deklarasi\Divisi::inputData');
    $routes->POST('cari', 'campur\LoadMain::cariBerkas');
    $routes->POST('save', 'main\deklarasi\Divisi::saveData');
});
$routes->group('nuser', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\nUser::index');
    $routes->GET('input', 'main\deklarasi\nUser::inputData');
    $routes->POST('save', 'main\deklarasi\nUser::saveData');
    $routes->POST('usernama', 'campur\LoadMain::loadUser');
});
$routes->group('satuan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\Satuan::index');
    $routes->GET('input', 'main\deklarasi\Satuan::inputData');
    $routes->POST('save', 'main\deklarasi\Satuan::saveData');
});
$routes->group('nodokumen', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\NomorDokumen::index');
    $routes->GET('input', 'main\deklarasi\NomorDokumen::inputData');
    $routes->POST('save', 'main\deklarasi\NomorDokumen::saveData');
});
$routes->group('noform', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\NomorForm::index');
    $routes->GET('input', 'main\deklarasi\NomorForm::inputData');
    $routes->POST('save', 'main\deklarasi\NomorForm::saveData');
});
$routes->group('kateproyek', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\KateProyek::index');
    $routes->GET('input', 'main\deklarasi\KateProyek::inputData');
    $routes->POST('save', 'main\deklarasi\KateProyek::saveData');
});
$routes->group('biayalangsung', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\BiayaLangsung::index');
    $routes->GET('input', 'main\deklarasi\BiayaLangsung::inputData');
    $routes->POST('cari', 'campur\LoadMain::cariBiaya');
    $routes->POST('save', 'main\deklarasi\BiayaLangsung::saveData');
});
$routes->group('biayataklangsung', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\BiayaTakLangsung::index');
    $routes->GET('input', 'main\deklarasi\BiayaTakLangsung::inputData');
    $routes->POST('cari', 'campur\LoadMain::cariBiaya');
    $routes->POST('save', 'main\deklarasi\BiayaTakLangsung::saveData');
    $routes->POST('akun', 'campur\Loadmain::loadAkun');
});
$routes->group('sumberdaya', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\SumberDaya::index');
    $routes->GET('input', 'main\deklarasi\SumberDaya::inputData');
    $routes->POST('cari', 'campur\LoadMain::cariBiaya');
    $routes->POST('save', 'main\deklarasi\SumberDaya::saveData');
    $routes->POST('akun', 'campur\LoadMain::loadAkun');
});
$routes->group('jarak', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\Jarak::index');
    $routes->GET('input', 'main\deklarasi\Jarak::inputData');
    $routes->POST('cari', 'campur\LoadMain::cariRuas');
    $routes->POST('save', 'main\deklarasi\Jarak::saveData');
});
$routes->group('setanggaran', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\deklarasi\SetAnggaran::index');
    $routes->GET('input', 'main\deklarasi\SetAnggaran::inputData');
    $routes->POST('add', 'main\deklarasi\SetAnggaran::tambahData');
    $routes->POST('save', 'main\deklarasi\SetAnggaran::saveData');
    $routes->GET('tabel', 'main\deklarasi\SetAnggaran::tabelData');
    $routes->POST('biaya', 'campur\LoadMain::loadBiaya');
    $routes->POST('akun', 'campur\LoadMain::loadAkun');


    // $routes->GET('/', 'file\deklarasi\Anggaran::index');
    // $routes->GET('input', 'file\deklarasi\Anggaran::crany');
    // $routes->GET('input/(:any)', 'file\deklarasi\Anggaran::showdata/$1');
    // $routes->POST('additem', 'file\deklarasi\Anggaran::tambahdata');
    // $routes->POST('edititem', 'file\deklarasi\Anggaran::updatedata');
    // $routes->POST('delitem', 'file\deklarasi\Anggaran::deletedata');
    // $routes->POST('save', 'file\deklarasi\Anggaran::savedata');
    // $routes->GET('modalkoreksi', 'file\deklarasi\Anggaran::modaldata');
    // $routes->POST('akun', 'extra\Loadfile::loadakun');
    // $routes->POST('biaya', 'extra\Loadfile::loadbiaya');
    // $routes->GET('tabbudget', 'file\deklarasi\Anggaran::tabelbudget');
});
// ____________________________________________________________________________________________________________________________
$routes->group('lampiran', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('tabel', 'campur\Lampiran::tabelLampiran');
    $routes->GET('input', 'campur\Lampiran::modalLampiran');
    $routes->POST('save', 'campur\Lampiran::saveLampiran');
    $routes->POST('delete', 'campur\Lampiran::deleteLampiran');
});
$routes->group('cabang', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\aset\Cabang::index');
    $routes->GET('input', 'main\aset\Cabang::inputData');
    $routes->POST('save', 'main\aset\Cabang::saveData');
});
$routes->group('proyek', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\aset\Proyek::index');
    $routes->GET('input', 'main\aset\Proyek::inputData');
    $routes->POST('cari', 'main\aset\Proyek::cariProyek');
    $routes->POST('save', 'main\aset\Proyek::saveData');
    $routes->POST('kabupaten', 'main\aset\Proyek::loadKabupaten');
});
$routes->group('ruas', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\aset\Ruas::index');
    $routes->GET('input', 'main\aset\Ruas::inputData');
    $routes->POST('cari', 'campur\LoadMain::cariRuas');
    $routes->POST('save', 'main\aset\Ruas::saveData');
    $routes->POST('proyek', 'main\aset\Ruas::loadProyek');
    $routes->POST('klikproyek', 'main\aset\Ruas::outfocusProyek');
});

// $routes->group('subruas', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'file\deklarasi\Subruas::index');
//     $routes->GET('input', 'file\deklarasi\Subruas::crany');
//     $routes->GET('input/(:any)', 'file\deklarasi\Subruas::showdata/$1');
//     $routes->POST('save', 'file\deklarasi\Subruas::savedata');
//     $routes->GET('tabdata', 'file\deklarasi\Subruas::tabeldata');
//     $routes->POST('loadproyek', 'extra\Loadfile::loadproyek');
//     $routes->POST('ruas', 'extra\Loadfile::loadruas');
// });
$routes->group('alat', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\aset\Alat::index');
    $routes->GET('input', 'main\aset\Alat::inputData');
    $routes->POST('cari', 'main\aset\Alat::cariAlat');
    $routes->POST('save', 'main\aset\Alat::saveData');
    $routes->POST('biaya', 'campur\LoadMain::loadBiaya');
});
$routes->group('tool', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\aset\Tool::index');
    $routes->GET('input', 'main\aset\Tool::inputData');
    $routes->POST('cari', 'main\aset\Tool::cariAlat');
    $routes->POST('save', 'main\aset\Tool::saveData');
    $routes->POST('biaya', 'campur\LoadMain::loadBiaya');
});
$routes->group('tanahbangunan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\aset\TanahBangunan::index');
    $routes->GET('input', 'main\aset\TanahBangunan::inputData');
    $routes->POST('cari', 'main\aset\TanahBangunan::cariTanah');
    $routes->POST('save', 'main\aset\TanahBangunan::saveData');
    $routes->POST('biaya', 'campur\LoadMain::loadBiaya');
});
$routes->group('inventaris', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'file\aset\Inventaris::index');
    $routes->GET('input', 'file\aset\Inventaris::crany');
    $routes->GET('input/(:any)', 'file\aset\Inventaris::showdata/$1');
    $routes->POST('save', 'file\aset\Inventaris::savedata');
    $routes->GET('tabdata', 'file\aset\Inventaris::tabeldata');
    $routes->GET('basecamp', 'extra\Loadfile::modalcamp');
    $routes->POST('pegawai', 'extra\Loadfile::loadpenerima');
});
// ____________________________________________________________________________________________________________________________
$routes->group('akuntansi', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\akuntansi\Akuntansi::index');
    $routes->GET('input', 'main\akuntansi\Akuntansi::inputData');
    $routes->POST('cari', 'main\akuntansi\Akuntansi::cariData');
    $routes->POST('save', 'main\akuntansi\Akuntansi::saveData');
});
$routes->group('akungrup', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\akuntansi\AkunGrup::index');
    $routes->GET('input', 'main\akuntansi\AkunGrup::inputData');
    $routes->POST('cari', 'main\akuntansi\AkunGrup::cariData');
    $routes->POST('save', 'main\akuntansi\AkunGrup::saveData');
    $routes->POST('akun', 'campur\LoadMain::loadAkun');
});
$routes->group('akunkas', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\akuntansi\AkunKas::index');
    $routes->GET('input', 'main\akuntansi\AkunKas::inputData');
    $routes->POST('cari', 'main\akuntansi\AkunKas::cariData');
    $routes->POST('save', 'main\akuntansi\AkunKas::saveData');
    $routes->POST('akun', 'campur\LoadMain::loadAkun');
});
$routes->group('akunpajak', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\akuntansi\AkunPajak::index');
    $routes->GET('input', 'main\akuntansi\AkunPajak::inputData');
    $routes->POST('cari', 'main\akuntansi\AkunPajak::cariData');
    $routes->POST('save', 'main\akuntansi\AkunPajak::saveData');
    $routes->POST('akun', 'campur\LoadMain::loadAkun');
});
$routes->group('kbli', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\akuntansi\Kbli::index');
    $routes->GET('input', 'main\akuntansi\Kbli::inputData');
    $routes->POST('cari', 'main\akuntansi\Kbli::cariData');
    $routes->POST('save', 'main\akuntansi\Kbli::saveData');

    // $routes->GET('/', 'file\akuntansi\Dokumenpajak::index');
    // $routes->GET('input', 'file\akuntansi\Dokumenpajak::crany');
    // $routes->GET('input/(:any)', 'file\akuntansi\Dokumenpajak::showdata/$1');
    // $routes->POST('save', 'file\akuntansi\Dokumenpajak::savedata');
    // $routes->GET('tabdata', 'file\akuntansi\Dokumenpajak::tabeldata');
});
// ____________________________________________________________________________________________________________________________
$routes->group('barang', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\barang\Barang::index');
    $routes->GET('input', 'main\barang\Barang::inputData');
    $routes->POST('cari', 'main\barang\Barang::cariBarang');
    $routes->POST('save', 'main\barang\Barang::saveData');
});
$routes->group('bahan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\barang\Bahan::index');
    $routes->GET('input', 'main\barang\Bahan::inputData');
    $routes->POST('cari', 'main\barang\Bahan::cariBarang');
    $routes->POST('save', 'main\barang\Bahan::saveData');
    $routes->POST('biaya', 'campur\LoadMain::loadBiaya');
    $routes->POST('satuan', 'main\barang\Bahan::loadSatuan');
});
$routes->group('noseri', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'file\item\Noseri::index');
    $routes->GET('input', 'file\item\Noseri::crany');
    $routes->GET('input/(:any)', 'file\item\Noseri::showdata/$1');
    $routes->POST('save', 'file\item\Noseri::savedata');
    $routes->POST('alat', 'extra\Loadfile::loadalat');
    $routes->GET('tabdata', 'file\item\Noseri::tabelbarang');
});
$routes->group('gudang', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\barang\Gudang::index');
    $routes->GET('input', 'main\barang\Gudang::inputData');
    $routes->POST('save', 'main\barang\Gudang::saveData');
});
// ____________________________________________________________________________________________________________________________
$routes->group('penerima', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\penerima\Penerima::index');
    $routes->GET('input', 'main\penerima\Penerima::inputData');
    $routes->POST('cari', 'main\penerima\Penerima::cariPenerima');
    $routes->POST('save', 'main\penerima\Penerima::saveData');
});
$routes->group('tautp', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'file\penerima\Tautp::index');
    $routes->GET('input/(:any)', 'file\penerima\Tautp::showdata/$1');
    $routes->POST('save', 'file\penerima\Tautp::savedata');
});
$routes->group('rekanalat', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\penerima\RekanAlat::index');
    $routes->GET('input', 'main\penerima\RekanAlat::inputData');
    $routes->POST('cari', 'main\penerima\RekanAlat::cariAlat');
    $routes->POST('save', 'main\penerima\RekanAlat::saveData');
    $routes->POST('penerima', 'campur\LoadMain::loadPenerima');
});

$routes->group('rekanalat', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'file\penerima\RekanAlat::index');
    $routes->GET('input', 'file\penerima\RekanAlat::crany');
    $routes->GET('input/(:any)', 'file\penerima\RekanAlat::showdata/$1');
    $routes->POST('save', 'file\penerima\RekanAlat::savedata');
    $routes->POST('penerima', 'extra\Loadfile::loadpenerima');
    $routes->GET('tabdata', 'file\penerima\RekanAlat::tabeldata');
});
// ____________________________________________________________________________________________________________________________
$routes->group('cuti', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\sdm\Cuti::index');
    $routes->GET('input', 'main\sdm\Cuti::inputData');
    $routes->POST('save', 'main\sdm\Cuti::saveData');
});
$routes->group('kalender', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\sdm\Kalender::index');
    $routes->GET('input', 'main\sdm\Kalender::inputData');
    $routes->POST('save', 'main\sdm\Kalender::saveData');
});
$routes->group('katerating', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\sdm\KateRating::index');
    $routes->GET('input', 'main\sdm\KateRating::inputData');
    $routes->POST('save', 'main\sdm\KateRating::saveData');
});
$routes->group('pengumuman', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'file\sdm\Pengumuman::index');
    $routes->POST('save', 'file\sdm\Pengumuman::savedata');
});
$routes->group('pegawai', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\sdm\Pegawai::index');
    $routes->GET('input', 'main\sdm\Pegawai::inputData');
    $routes->POST('cari', 'main\sdm\Pegawai::cariPegawai');
    $routes->POST('save', 'main\sdm\Pegawai::saveData');
    $routes->POST('cabang', 'campur\LoadMain::loadCabang');
    $routes->POST('usernama', 'campur\LoadMain::loadUser');
    $routes->POST('atasan', 'campur\LoadMain::loadPenerima');
});
// $routes->group('pegawai', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('tabdata', 'file\sdm\Pegawai::tabeldata');
//     $routes->GET('tablampir', 'extra\Lampiran::tabellampiran');
//     $routes->GET('modallampir', 'extra\Lampiran::modallampiran');
//     $routes->POST('savelampir', 'extra\Lampiran::savelampiran');
//     $routes->POST('dellampir', 'extra\Lampiran::deletelampiran');
//     $routes->GET('basecamp', 'extra\Loadfile::modalcamp');
//     $routes->POST('pegawai', 'extra\Loadfile::loadpenerima');
//     $routes->POST('user', 'extra\Loadfile::loaduser');
// });
$routes->group('jabatan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\sdm\Jabatan::index');
    $routes->GET('input', 'main\sdm\Jabatan::inputData');
    $routes->POST('cari', 'campur\LoadMain::cariBerkas');
    $routes->POST('save', 'main\sdm\Jabatan::saveData');
});

// Transaksi Umum____________________________________________________________________________________________________________________________
$routes->group('anggbiayal', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trumum\anggaran\Biayalangsung::index');
    $routes->GET('input', 'trumum\anggaran\Biayalangsung::crany');
    $routes->GET('input/(:any)', 'trumum\anggaran\Biayalangsung::showdata/$1');
    $routes->POST('additem', 'trumum\anggaran\Biayalangsung::tambahdata');
    // $routes->POST('edititem', 'trumum\anggaran\Cabang::updatedata');
    // $routes->POST('delitem', 'trumum\anggaran\Cabang::deletedata');

    // $routes->POST('addbudget', 'umum\anggaran\Cabang::tambahdata');
    // $routes->POST('savedoc', 'umum\anggaran\Cabang::savedokumen');
    // // $routes->GET('bataldoc/(:any)', 'umum\anggaran\Biayatidaklangsung::canceldokumen/$1');
    $routes->GET('tabinduk', 'extra\Loadtran::tabelanggaraninduk');
    $routes->GET('proyek', 'extra\Loadfile::modalproyek');
    $routes->POST('ruas', 'extra\Loadfile::loadruas');
    $routes->POST('biaya', 'extra\Loadfile::loadbiaya');

    $routes->GET('tabbiaya', 'extra\Loadtran::tabeldataanggaran');
    $routes->POST('savedoc', 'trumum\anggaran\Biayalangsung::savedata');
    $routes->GET('modalbatal', 'trumum\anggaran\Biayalangsung::modalbatal');

    $routes->POST('bataldoc', 'trumum\anggaran\Biayalangsung::canceldata');

    // $routes->POST('loadbudget', 'umum\anggaran\Cabang::loadbudgetbawaan');
    // // $routes->GET('editkas', 'proyek\anggaran\Biayatidaklangsung::modalkoreksikas');
    // // $routes->POST('delbudget', 'umum\anggaran\Camp::deletedata');
});
$routes->group('anggobjek', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trumum\anggaran\Objek::index');
    $routes->GET('input', 'trumum\anggaran\Objek::crany');
    $routes->GET('input/(:any)', 'trumum\anggaran\Objek::showdata/$1');
    $routes->POST('additem', 'trumum\anggaran\Objek::tambahdata');
    $routes->POST('edititem', 'trumum\anggaran\Objek::updatedata');
    $routes->POST('delitem', 'trumum\anggaran\Objek::deletedata');

    // $routes->POST('addbudget', 'umum\anggaran\Cabang::tambahdata');
    // $routes->POST('savedoc', 'umum\anggaran\Cabang::savedokumen');
    // // $routes->GET('bataldoc/(:any)', 'umum\anggaran\Biayatidaklangsung::canceldokumen/$1');
    $routes->GET('tabinduk', 'extra\Loadtran::tabelanggaraninduk');
    $routes->GET('beban', 'extra\Loadfile::modalbeban');
    $routes->POST('akun', 'extra\Loadfile::loadakun');
    $routes->POST('biaya', 'extra\Loadfile::loadbiaya');

    $routes->GET('tabbiaya', 'extra\Loadtran::tabeldataanggaran');
    // $routes->POST('loadbudget', 'umum\anggaran\Cabang::loadbudgetbawaan');
    // // $routes->GET('editkas', 'proyek\anggaran\Biayatidaklangsung::modalkoreksikas');
    // // $routes->POST('delbudget', 'umum\anggaran\Camp::deletedata');
});



// $routes->group('sojual', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'umum\penjualan\SOJual::index');
//     $routes->GET('input', 'umum\penjualan\SOJual::crany');
//     $routes->GET('input/(:any)', 'umum\penjualan\SOJual::showdata/$1');
//     $routes->POST('addjual', 'umum\penjualan\SOJual::tambahdata');
//     // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
//     $routes->GET('tabsales', 'extra\Loadtran::tabelsalesinduk');
//     $routes->GET('camp', 'extra\Loadfile::modalcamp');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('penerima1', 'extra\Loadfile::loadpenerima1');
//     $routes->POST('pelanggan', 'extra\Loadfile::loadpenerima');
//     $routes->POST('barang', 'extra\Loadfile::loadbarang');
//     $routes->POST('alat', 'extra\Loadfile::loadalat');
//     $routes->POST('tanah', 'extra\Loadfile::loadtanah');
//     $routes->POST('inventaris', 'extra\Loadfile::loadinventaris');
//     $routes->POST('satuan', 'umum\penjualan\SOJual::loadsatuan');
//     $routes->POST('bentuk', 'umum\penjualan\SOJual::loadbentuk');
//     $routes->POST('loadcamp', 'umum\penjualan\SOJual::loadcamp');
//     $routes->GET('tabsalesitem', 'extra\Loadtran::tabelsalesanak');

//     // $routes->POST('biaya', 'Komponen::loadbiaya');
//     // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
//     // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
// });

// $routes->group('sosewa', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'umum\penjualan\SOSewa::index');
//     $routes->GET('input', 'umum\penjualan\SOSewa::crany');
//     $routes->GET('input/(:any)', 'umum\penjualan\SOSewa::showdata/$1');
//     $routes->POST('addjual', 'umum\penjualan\SOSewa::tambahdata');
//     // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
//     $routes->GET('tabsales', 'extra\Loadtran::tabelsalesinduk');
//     $routes->GET('camp', 'extra\Loadfile::modalcamp');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('penerima1', 'extra\Loadfile::loadpenerima1');
//     $routes->POST('pelanggan', 'extra\Loadfile::loadpenerima');
//     $routes->POST('barang', 'extra\Loadfile::loadbarang');
//     $routes->POST('alat', 'extra\Loadfile::loadalat');
//     $routes->POST('tanah', 'extra\Loadfile::loadtanah');
//     $routes->POST('inventaris', 'extra\Loadfile::loadinventaris');
//     $routes->POST('satuan', 'umum\penjualan\SOSewa::loadsatuan');
//     $routes->POST('bentuk', 'umum\penjualan\SOSewa::loadbentuk');
//     $routes->POST('loadcamp', 'umum\penjualan\SOSewa::loadcamp');
//     $routes->GET('tabsalesitem', 'extra\Loadtran::tabelsalesanak');

//     // $routes->POST('biaya', 'Komponen::loadbiaya');
//     // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
//     // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
// });

// Transaksi Item____________________________________________________________________________________________________________________________
$routes->group('mintabarang', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Mintabarang::index');
    $routes->GET('input', 'tritem\pembelian\Mintabarang::crany');
    $routes->GET('input/(:any)', 'tritem\pembelian\Mintabarang::showdata/$1');
    $routes->POST('peminta', 'extra\Loadfile::loaduser');
    $routes->POST('additem', 'tritem\pembelian\Mintabarang::tambahdata');
    $routes->POST('edititem', 'tritem\pembelian\Mintabarang::updatedata');
    $routes->POST('delitem', 'tritem\pembelian\Mintabarang::deletedata');
    $routes->POST('item', 'extra\Loadfile::loadbarang');
    $routes->POST('jasa', 'extra\Loadfile::loadakun');
    $routes->POST('satuan', 'tritem\pembelian\Mintabarang::loadsatuan');
    $routes->GET('modalkoreksi', 'tritem\pembelian\Mintabarang::modaldata');
    $routes->GET('mbarang', 'extra\Loadfile::modalbarang');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarang');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('savedoc', 'tritem\pembelian\Mintabarang::savedata');
    $routes->POST('bataldoc', 'tritem\pembelian\Mintabarang::canceldata');
    $routes->POST('confdoc', 'tritem\pembelian\Mintabarang::confirmdata');
});
$routes->group('cekada', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Cekada::index');
    $routes->GET('input/(:any)', 'tritem\pembelian\Cekada::showdata/$1');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarang');
    $routes->POST('additem', 'tritem\pembelian\Cekada::tambahdata');
    $routes->POST('savedoc', 'tritem\pembelian\Cekada::savedata');
    $routes->GET('mbarang', 'extra\Loadfile::modalbarang');
});
$routes->group('cekbarang', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Cekbarang::index');
    $routes->GET('input/(:any)', 'tritem\pembelian\Cekbarang::showdata/$1');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarang');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('savedoc', 'tritem\pembelian\Cekbarang::savedata');
});
$routes->group('tawarharga', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Tawarharga::index');
    $routes->GET('input/(:any)', 'tritem\pembelian\Tawarharga::showdata/$1');
    $routes->POST('additem', 'tritem\pembelian\Tawarharga::tambahdata');
    $routes->POST('edititem', 'tritem\pembelian\Tawarharga::updatedata');
    $routes->POST('delitem', 'tritem\pembelian\Tawarharga::deletedata');
    $routes->POST('suplier', 'extra\Loadfile::loadpenerima');
    $routes->GET('mbarang', 'extra\Loadfile::modalbarang');
    $routes->GET('msuplier', 'extra\Loadfile::modalpenerima');
    $routes->GET('modalkoreksi', 'tritem\pembelian\Tawarharga::modaldata');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarang');
    $routes->GET('tabharga', 'extra\Loadtran::tabelhargatawar');
    // $routes->POST('savedoc', 'tritem\pembelian\Tawarharga::savedata');
});
$routes->group('pilihharga', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Pilihharga::index');
    $routes->GET('input/(:any)', 'tritem\pembelian\Pilihharga::showdata/$1');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabharga', 'extra\Loadtran::tabeltawar');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('suplier', 'tritem\pembelian\Pilihharga::pilihpenawaran');
    // $routes->POST('savedoc', 'tritem\pembelian\Pilihharga::savedata');
});

// $routes->group('bandingharga', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'tritem\pembelian\Bandingharga::index');
//     $routes->GET('input/(:any)', 'tritem\pembelian\Bandingharga::showdata/$1');
//     $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
// $routes->GET('showitem', 'Komponen::modalitem');
// $routes->POST('save', 'pembelian\Bandingharga::savedata');
// $routes->POST('penerima', 'Komponen::loadpenerima');
// $routes->GET('tabbarang', 'Komponen::tabelbarang');
// $routes->GET('tabtawar', 'pembelian\Bandingharga::modalpenawaran');
// $routes->POST('deltawar', 'pembelian\Bandingharga::deletepenawaran');
// $routes->POST('pilihtawar', 'pembelian\Bandingharga::pilihpenawaran');
// });
// $routes->group('pesanbarang', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'pembelian\Pesanbarang::index');
//     $routes->GET('input', 'pembelian\Pesanbarang::crany');
//     $routes->GET('input/(:any)', 'pembelian\Pesanbarang::showdata/$1');
//     $routes->GET('tabpesan', 'Komponen::tabelpesanbarang');
//     $routes->POST('penerima', 'Komponen::loadpenerima');
//     $routes->POST('biaya', 'Komponen::loadakun');
//     $routes->GET('dokumen', 'pembelian\Pesanbarang::modaldokumen');
//     $routes->GET('tabbarang', 'pembelian\Pesanbarang::tabelbarang');
//     $routes->GET('tabbiaya', 'pembelian\Pesanbarang::tabelbiaya');
//     $routes->POST('addbiaya', 'pembelian\Pesanbarang::savebiaya');
//     $routes->POST('save/(:any)', 'pembelian\Pesanbarang::savedata/$1');
// });
// $routes->group('terimabarang', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'pembelian\Terimabarang::index');
//     $routes->GET('input/(:any)', 'pembelian\Terimabarang::showdata/$1');
//     $routes->GET('tabpesan', 'Komponen::tabelpesanbarang');
//     $routes->GET('tabbarang', 'pembelian\Terimabarang::tabelbarang');
//     $routes->GET('tabmasuk', 'pembelian\Terimabarang::tabelpomasuk');
//     $routes->POST('save', 'pembelian\Terimabarang::savedata');
// });
// $routes->group('cekpo', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'pembelian\Cekpo::index');
//     $routes->GET('tabpesan', 'Komponen::tabelpesanbarang');
//     $routes->GET('input/(:any)', 'pembelian\Cekpo::showdata/$1');
//     $routes->GET('tabbarang', 'pembelian\Cekpo::tabelbarang');
//     $routes->POST('save', 'pembelian\Cekpo::savedata');
//     $routes->GET('logaksi', 'Komponen::tabellogaksi');
// });

$routes->group('ambilbarang', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pengambilan\Ambilbarang::index');
    $routes->GET('input', 'tritem\pengambilan\Ambilbarang::showdata');
    $routes->POST('additem', 'tritem\pengambilan\Ambilbarang::tambahdata');
    $routes->POST('edititem', 'tritem\pengambilan\Ambilbarang::updatedata');
    $routes->POST('delitem', 'tritem\pengambilan\Ambilbarang::deletedata');

    $routes->POST('pegawai', 'extra\Loadfile::loadpenerima');
    $routes->POST('perusahaan', 'tritem\pengambilan\Ambilbarang::loadperusahaan');
    $routes->POST('atk', 'tritem\pengambilan\Ambilbarang::loadatk');
    $routes->POST('atkm', 'tritem\pengambilan\Ambilbarang::loadatk');
    // $routes->POST('satuan', 'tritem\pembelian\Mintabarang::loadsatuan');
    // $routes->GET('modalkoreksi', 'tritem\pembelian\Mintabarang::modaldata');
    // $routes->GET('mbarang', 'extra\Loadfile::modalbarang');
    $routes->GET('tabambil', 'extra\Loadtran::tabelambilbarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarangambil');
    $routes->GET('modalinput', 'tritem\pengambilan\Ambilbarang::modalinput');
    $routes->GET('modalkoreksi', 'tritem\pengambilan\Ambilbarang::modaldata');

    // $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('saveatk', 'tritem\pengambilan\Ambilbarang::saveatk');
    // $routes->POST('bataldoc', 'tritem\pembelian\Mintabarang::canceldata');
    // $routes->POST('confdoc', 'tritem\pembelian\Mintabarang::confirmdata');

});

// Proyek____________________________________________________________________________________________________________________________
// $routes->group('anggproyekbl', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'proyek\anggaran\BiayaL::index');
//     $routes->GET('input', 'proyek\anggaran\BiayaL::crany');
//     $routes->GET('input/(:any)', 'proyek\anggaran\BiayaL::showdata/$1');
//     $routes->POST('addbudget', 'proyek\anggaran\BiayaL::tambahdata');
//     $routes->POST('savedoc', 'proyek\anggaran\BiayaL::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'proyek\anggaran\Biayatidaklangsung::canceldokumen/$1');
//     $routes->GET('tabanginduk', 'extra\Loadtran::tabelanggaraninduk');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('ruas', 'extra\Loadfile::loadruas');
//     $routes->POST('biaya', 'extra\Loadfile::loadbiaya');
//     $routes->GET('tabbudget', 'extra\Loadtran::tabelanggarananak');
//     $routes->POST('loadbudget', 'proyek\anggaran\BiayaL::loadbudgetbawaan');
//     // $routes->GET('editkas', 'proyek\anggaran\Biayatidaklangsung::modalkoreksikas');
//     $routes->POST('delbudget', 'proyek\anggaran\BiayaL::deletedata');
// });
// $routes->group('anggproyekbtl', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'proyek\anggaran\BiayaTL::index');
//     $routes->GET('input', 'proyek\anggaran\BiayaTL::crany');
//     $routes->GET('input/(:any)', 'proyek\anggaran\BiayaTL::showdata/$1');
//     $routes->POST('addbudget', 'proyek\anggaran\BiayaTL::tambahdata');
//     $routes->POST('savedoc', 'proyek\anggaran\BiayaTL::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'proyek\anggaran\Biayatidaklangsung::canceldokumen/$1');
//     $routes->GET('tabanginduk', 'extra\Loadtran::tabelanggaraninduk');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('biaya', 'extra\Loadfile::loadbiaya');
//     $routes->GET('tabbudget', 'extra\Loadtran::tabelanggarananak');
//     $routes->POST('loadbudget', 'proyek\anggaran\BiayaTL::loadbudgetbawaan');
//     // $routes->GET('editkas', 'proyek\anggaran\Biayatidaklangsung::modalkoreksikas');
//     $routes->POST('delbudget', 'proyek\anggaran\BiayaTL::deletedata');
// });
// $routes->group('accbudget', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'proyek\anggaran\Accbudget::index');
//     $routes->GET('input/(:any)', 'proyek\anggaran\Accbudget::showdata/$1');
//     $routes->POST('addbudget', 'proyek\anggaran\Accbudget::tambahdata');
//     $routes->POST('savedoc', 'proyek\anggaran\Accbudget::savedokumen');
//     $routes->GET('bataldoc/(:any)', 'proyek\anggaran\Accbudget::canceldokumen/$1');
//     $routes->GET('tabbudget', 'extra\Loadtran::tabelbudgetinduk');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('ruas', 'extra\Loadfile::loadruas');
//     $routes->POST('biaya', 'extra\Loadfile::loadbiaya');
//     $routes->GET('tabbudgetitem', 'extra\Loadtran::tabelbudgetanak');

//     // $routes->GET('editkas', 'proyek\anggaran\Biayalangsung::modalkoreksikas');
//     $routes->POST('delitem', 'proyek\anggaran\Biayalangsung::deletedata');
// });

// ALAT____________________________________________________________________________________________________________________________
$routes->group('sewaalat', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'alat\order\Sewaalat::index');
    $routes->GET('input', 'alat\order\Sewaalat::crany');
    $routes->GET('input/(:any)', 'alat\order\Sewaalat::showdata/$1');
    $routes->POST('addjual', 'alat\order\Sewaalat::tambahdata');
    // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
    // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
    $routes->GET('tabsales', 'extra\Loadtran::tabelsalesinduk');
    $routes->GET('proyek', 'extra\Loadfile::modalproyek');
    $routes->POST('penerima1', 'extra\Loadfile::loadpenerima1');
    $routes->POST('pelanggan', 'extra\Loadfile::loadpenerima');
    $routes->POST('alat', 'extra\Loadfile::loadalat');
    $routes->POST('bentuk', 'alat\order\Sewaalat::loadbentuk');
    $routes->POST('loadcamp', 'alat\order\Sewaalat::loadcamp');
    $routes->GET('tabsalesitem', 'extra\Loadtran::tabelsalesanak');

    // $routes->POST('biaya', 'Komponen::loadbiaya');
    // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
    // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
});
$routes->group('tiketproyek', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'alat\tiket\Tiketproyek::index');
    $routes->POST('addtiket', 'alat\tiket\Tiketproyek::tambahdata');
    $routes->GET('camp', 'extra\Loadfile::modalcamp');
    $routes->POST('docjual', 'alat\tiket\Tiketproyek::loadsojual');
    $routes->POST('gantidocjual', 'alat\tiket\Tiketproyek::outfocusdocjual');
    $routes->POST('gantiruas', 'alat\tiket\Tiketproyek::outfocusruas');
    $routes->POST('gantidocsewa', 'alat\tiket\Tiketproyek::outfocusdocsewa');
    $routes->POST('gantijasa', 'alat\tiket\Tiketproyek::outfocusjasa');
    $routes->POST('gantibarang', 'alat\tiket\Tiketproyek::outfocusbarang');
    $routes->POST('alat', 'alat\tiket\Tiketproyek::loadalat');
    $routes->POST('gantialat', 'alat\tiket\Tiketproyek::outfocusalat');
    $routes->POST('supir', 'extra\Loadfile::loadpenerima');
    $routes->POST('gantisupir', 'alat\tiket\Tiketproyek::outfocussupir');
    $routes->GET('tabtiket', 'extra\Loadtran::tabeltiket');

    // $routes->GET('beban', 'Komponen::modalbeban');
    // $routes->POST('biaya', 'Komponen::loadbiaya');
    // $routes->GET('tabitembiaya', 'Komponen::tabelbudgetanak');
    // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
    // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
});
$routes->group('cektiket', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'alat\tiket\Cektiket::index');
    $routes->POST('notiket', 'alat\tiket\Cektiket::loadtiket');
    $routes->POST('datatiket', 'alat\tiket\Cektiket::outfocustiket');
    $routes->POST('save', 'alat\tiket\Cektiket::savedata');

    // $routes->GET('camp', 'extra\Loadfile::modalcamp');

    // $routes->GET('input', 'camp\tiket\Cektiket::showdata');
    // $routes->POST('loadproyek', 'file\aset\Ruas::loadproyek');
    // $routes->POST('gantidokumen', 'camp\tiket\Cektiket::outfocusdokumen');
    // $routes->GET('tabtiket', 'extra\Loadtran::tabeltiket');
    // $routes->POST('loadproyek', 'extra\Loadfile::loadproyek');
});

$routes->group('tsproyek', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'alat\tiket\Tsproyek::index');
    // $routes->POST('addtiket', 'alat\tiket\Tsproyek::tambahdata');
    // $routes->GET('camp', 'extra\Loadfile::modalcamp');
    $routes->POST('docsewa', 'alat\tiket\Tsproyek::loadsosewa');
    // $routes->POST('gantidocjual', 'alat\tiket\Tsproyek::outfocusdocjual');
    // $routes->POST('gantiruas', 'alat\tiket\Tsproyek::outfocusruas');
    // $routes->POST('gantidocsewa', 'alat\tiket\Tsproyek::outfocusdocsewa');
    // $routes->POST('gantibahan', 'alat\tiket\Tsproyek::outfocusbahan');
    // $routes->POST('alat', 'alat\tiket\Tsproyek::loadalat');
    // $routes->POST('gantialat', 'alat\tiket\Tsproyek::outfocusalat');
    // $routes->POST('supir', 'extra\Loadfile::loadpenerima');
    // $routes->POST('gantisupir', 'alat\tiket\Tsproyek::outfocussupir');
    // $routes->GET('tabtiket', 'extra\Loadtran::tabeltiket');

    // $routes->GET('beban', 'Komponen::modalbeban');
    // $routes->POST('biaya', 'Komponen::loadbiaya');
    // $routes->GET('tabitembiaya', 'Komponen::tabelbudgetanak');
    // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
    // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
});
// CAMP____________________________________________________________________________________________________________________________
$routes->group('jualbahan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'camp\order\Jualbahan::index');
    $routes->GET('input', 'camp\order\Jualbahan::crany');
    $routes->GET('input/(:any)', 'camp\order\Jualbahan::showdata/$1');
    $routes->POST('addjual', 'camp\order\Jualbahan::tambahdata');
    // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
    // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
    $routes->GET('tabsales', 'extra\Loadtran::tabelsalesinduk');
    $routes->GET('camp', 'extra\Loadfile::modalcamp');
    $routes->GET('proyek', 'extra\Loadfile::modalproyek');
    $routes->POST('penerima1', 'extra\Loadfile::loadpenerima1');
    $routes->POST('pelanggan', 'extra\Loadfile::loadpenerima');
    $routes->POST('item', 'extra\Loadfile::loadbarang');
    $routes->POST('satuan', 'camp\order\Jualbahan::loadsatuan');
    $routes->POST('loadcamp', 'camp\order\Jualbahan::loadcamp');
    $routes->GET('tabsalesitem', 'extra\Loadtran::tabelsalesanak');

    // $routes->POST('biaya', 'Komponen::loadbiaya');
    // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
    // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
});

// Transaksi Kas____________________________________________________________________________________________________________________________
$routes->group('kaspindah', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'kas\mintakas\KasPindah::index');
    $routes->GET('input', 'kas\mintakas\KasPindah::inputData');
    $routes->POST('cari', 'campur\LoadTransaksi::tabelKasinduk');
    $routes->POST('save', 'kas\mintakas\KasPindah::saveData');
    $routes->GET('klikbeban', 'campur\LoadMain::modalBeban');
    $routes->POST('peminta', 'campur\LoadMain::loadUser');
    $routes->POST('penerima', 'campur\LoadMain::loadPenerima');
    $routes->POST('akun', 'campur\LoadMain::loadAkun');
});
$routes->group('uangmuka', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'kas\mintakas\UangMuka::index');
    $routes->GET('input', 'kas\mintakas\UangMuka::inputData');
    $routes->POST('cari', 'campur\LoadTransaksi::tabelKasinduk');
    $routes->POST('save', 'kas\mintakas\UangMuka::saveData');
    $routes->GET('klikbeban', 'campur\LoadMain::modalBeban');
    $routes->POST('peminta', 'campur\LoadMain::loadUser');
    $routes->POST('penerima', 'campur\LoadMain::loadPenerima');
    $routes->POST('akun', 'campur\LoadMain::loadAkun');
});
$routes->group('uangjalan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'kas\mintakas\UangJalan::index');
    $routes->GET('input', 'kas\mintakas\UangJalan::inputData');
    $routes->POST('cari', 'campur\LoadTransaksi::tabelKasinduk');
    $routes->POST('save', 'kas\mintakas\UangJalan::saveData');
    $routes->POST('penerima', 'campur\LoadMain::loadPenerima');
    $routes->POST('supir', 'campur\LoadMain::loadPenerima');
    $routes->POST('klikpenerima', 'kas\mintakas\UangJalan::outfocusPenerima');
    $routes->POST('kliksupir', 'kas\mintakas\UangJalan::outfocusSupir');
});
// ____________________________________________________________________________________________________________________________
$routes->group('cekkas', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'kas\cekkas\CekKas::index');
    $routes->GET('input', 'kas\cekkas\CekKas::inputData');
    $routes->POST('cari', 'campur\LoadTransaksi::tabelKasinduk');
    $routes->POST('save', 'kas\cekkas\CekKas::saveData');
});
// $routes->group('kaspindah', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'kas\Kaspindah::index');
//     $routes->GET('input', 'kas\Kaspindah::crany');
//     $routes->GET('input/(:any)', 'kas\Kaspindah::showdata/$1');
//     $routes->POST('save', 'kas\Kaspindah::savedata');
//     $routes->GET('bataldoc/(:any)', 'kas\Kaspindah::canceldokumen/$1');
//     $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     $routes->GET('user', 'Komponen::modaluser');
//     $routes->GET('beban', 'Komponen::modalbeban');
//     $routes->POST('akun', 'Komponen::loadakun');
//     $routes->GET('tabkas', 'Komponen::tabelkas');
//     $routes->GET('addlampir', 'kas\Kaspindah::modallampiran');
//     $routes->POST('savelampir', 'kas\Kaspindah::savelampiran');
//     $routes->POST('dellampir', 'kas\Kaspindah::deletelampiran');
// });


// $routes->group('kaslangsung', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'trkas\pengeluaran\Kaslangsung::index');
//     $routes->GET('input', 'trkas\pengeluaran\Kaslangsung::crany');
//     $routes->GET('input/(:any)', 'trkas\pengeluaran\Kaslangsung::showdata/$1');
//     $routes->POST('peminta', 'extra\Loadfile::loaduser');

//     $routes->POST('additem', 'trkas\pengeluaran\Kaslangsung::tambahdata');
//     // $routes->POST('edititem', 'trkas\pengeluaran\Kaslangsung::updatedata');
//     // $routes->POST('delitem', 'trkas\pengeluaran\Kaslangsung::deletedata');

//     // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
//     // $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     // $routes->GET('user', 'Komponen::modaluser');
//     $routes->GET('tabminta', 'extra\Loadtran::tabelmintakas');

//     $routes->GET('beban', 'extra\Loadfile::modalbeban');
//     $routes->POST('penerima', 'extra\Loadfile::loadpenerima');
//     $routes->POST('ruas', 'extra\Loadfile::loadruas');
//     $routes->POST('anggaran', 'extra\Loadtran::loadanggaran');
//     // $routes->POST('biaya', 'extra\Loadfile::loadbiaya');

//     // $routes->POST('akun', 'extra\Loadfile::loadakun');

//     // $routes->POST('ruas', 'Komponen::loadruas');
//     // $routes->POST('biaya', 'Komponen::loadbiaya');
//     $routes->POST('sumberdaya', 'extra\loadfile::loadbiaya');
//     // $routes->POST('akun', 'Komponen::loadakun');

//     $routes->GET('tabkas', 'extra\loadtran::tabeldatakas');
//     // $routes->GET('editkas', 'kas\Kaslangsung::modalkoreksikas');
//     // $routes->POST('delkas', 'kas\Kaslangsung::deletedata');
//     // $routes->GET('tabbiaya', 'extra\Loadtran::tabelbiayaanggaran');
// });

// $routes->group('kasum', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'kas\Kasum::index');
//     $routes->GET('input', 'kas\Kasum::crany');
//     $routes->GET('input/(:any)', 'kas\Kasum::showdata/$1');
//     $routes->POST('save', 'kas\Kasum::savedata');
//     $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     $routes->GET('user', 'Komponen::modaluser');
//     $routes->GET('beban', 'Komponen::modalbeban');
//     $routes->POST('penerima', 'Komponen::loadpenerima');
//     $routes->POST('akun', 'kas\Kasum::loadakun');
//     $routes->POST('supir', 'Komponen::loadpegawai');
//     $routes->POST('barang', 'Komponen::loadbarang');
//     $routes->GET('tabkas', 'Komponen::tabelkas');
//     $routes->POST('delkas', 'kas\Kasum::deletekas');
// });
// $routes->group('kasnonlangsung', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'kas\Kasnonlangsung::index');
//     $routes->GET('input', 'kas\Kasnonlangsung::crany');
//     $routes->GET('input/(:any)', 'kas\Kasnonlangsung::showdata/$1');
//     $routes->POST('save', 'kas\Kasnonlangsung::savedata');
//     $routes->POST('updatedoc', 'kas\Kasnonlangsung::updatedokumen');
//     $routes->GET('bataldoc/(:any)', 'kas\Kasnonlangsung::canceldokumen/$1');
//     $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     $routes->GET('user', 'Komponen::modaluser');
//     $routes->GET('beban', 'Komponen::modalbeban');
//     $routes->POST('penerima', 'Komponen::loadpenerima');
//     $routes->POST('ruas', 'Komponen::loadruas');
//     $routes->POST('biaya', 'Komponen::loadbiaya');
//     $routes->POST('sumberdaya', 'Komponen::loadbiaya');
//     $routes->POST('akun', 'Komponen::loadakun');
//     $routes->POST('kbli', 'Komponen::loadkbli');
//     $routes->GET('tabkas', 'Komponen::tabelkas');
//     $routes->GET('koreksikas', 'kas\Kaslangsung::modalkoreksi');
//     $routes->POST('delkas', 'kas\Kaslangsung::deletekas');
//     $routes->GET('tabuangmuka', 'kas\Kasnonlangsung::tabeluangmuka');
//     $routes->GET('adduangmuka', 'kas\Kasnonlangsung::modaluangmuka');
//     $routes->POST('saveuangmuka', 'kas\Kasnonlangsung::saveuangmuka');
// });

$routes->group('keuangan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trkas\pengeluaran\Keuangan::index');
    $routes->GET('input/(:any)', 'trkas\pengeluaran\Keuangan::showdata/$1');
    $routes->POST('pajakitem', 'trkas\pengeluaran\Keuangan::pajakdata');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintakas');
    $routes->GET('tabkas', 'extra\loadtran::tabeldatakas');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('savedoc', 'trkas\pengeluaran\Keuangan::savedata');
});
$routes->group('potongpajak', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trkas\pengeluaran\Potongpajak::index');
    $routes->GET('input/(:any)', 'trkas\pengeluaran\Potongpajak::showdata/$1');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintakas');
    $routes->GET('tabkas', 'extra\loadtran::tabeldatakas');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('savedoc', 'trkas\pengeluaran\Potongpajak::savedata');
});
// $routes->group('kasir', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'kas\Kasir::index');
//     $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     $routes->GET('input/(:any)', 'kas\Kasir::showdata/$1');
//     $routes->GET('tabkas', 'Komponen::tabeldatakas');
//     $routes->POST('savedoc/(:any)', 'kas\Kasir::savedokumen/$1');
// });

// HRD____________________________________________________________________________________________________________________________


// $routes->group('itmk', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'hrd\Itmk::index');
//     $routes->GET('input', 'hrd\Itmk::crany');
//     $routes->GET('input/(:any)', 'hrd\Itmk::showdata/$1');
//     $routes->POST('save/(:any)', 'hrd\Itmk::savedata/$1');
//     $routes->POST('pegawai', 'Komponen::loadpegawai');
//     $routes->POST('detilpegawai', 'hrd\Itmk::loadpegawai');
//     $routes->GET('tabminta', 'Komponen::tabelmintacuti');
// });
// $routes->group('cekitmk', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'hrd\Cekitmk::index');
//     $routes->GET('input/(:any)', 'hrd\Cekitmk::showdata/$1');
//     $routes->POST('save/(:any)', 'hrd\Cekitmk::savedata/$1');
//     $routes->GET('tabminta', 'Komponen::tabelmintacuti');
//     $routes->GET('logaksi', 'Komponen::tabellogaksi');
// });
// $routes->group('nilaipegawai', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'hrd\Nilaipegawai::index');
//     $routes->GET('input', 'hrd\Nilaipegawai::crany');
//     $routes->GET('input/(:any)', 'hrd\Nilaipegawai::showdata/$1');
//     // $routes->POST('save/(:any)', 'hrd\Nilaipegawai::savedata/$1');
//     $routes->POST('pegawai', 'Komponen::loadpegawai');
//     $routes->POST('detilpegawai', 'hrd\Itmk::loadpegawai');
//     $routes->GET('tabminta', 'Komponen::tabelnilaipegawai');
// });
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
