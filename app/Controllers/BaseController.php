<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Menu;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $session;
    protected $validation;
    protected $user;
    protected $menu;
    protected $level;
    protected $key = 'KeySan17yIn#F3d0r@';
    protected $method = 'AES-256-CBC';

    // protected $language;
    // protected $logModel;
    // protected $userModel;
    // protected $roleModel;
    // protected $konfigurasiModel;
    // protected $iduModel;
    // protected $mainModel;
    // protected $tranModel;

    // protected $urls;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    // protected $helpers = [];
    protected $helpers = ['url', 'form', 'satu_helper', 'json_helper', 'ganti_helper'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        // Preload any models, libraries, etc, here.

        // Inisialisasi request dan session
        $this->request = $request;
        $this->session = session();

        // Inisialisasi model dan library lainnya
        $this->userModel = new \App\Models\admin\UserModel();
        $this->roleModel = new \App\Models\admin\RoleModel();
        $this->konfigurasiModel = new \App\Models\admin\KonfigurasiModel();
        $this->logModel = new \App\Models\admin\LogModel();
        $this->iduModel = new \App\Models\campur\IDUnikModel();
        $this->mainModel = new \App\Models\campur\MainModel();
        $this->transaksiModel = new \App\Models\campur\TransaksiModel();

        // Set language based on session
        $this->language = service('language');
        $this->language->setLocale($this->session->lang);
        // Set validasi
        $this->validation = \Config\Services::validation();


        $this->menu = $this->roleModel->getRole($this->user['role_id'] ?? '');
        $this->menu = [
            'menu_1' => '101,102,103,104,105,106'
        ];

        $this->user = $this->userModel->getUser($this->session->usernama);
        $this->level = $this->konfigurasiModel->getKonfigurasi('jumlah setuju');
        $this->urls = explode('/', $_SERVER['REQUEST_URI']);

        // Language
        // $request = \Config\Services::request();

        // $this->session = \Config\Services::session();


        // $this->anu = $this->konfigurasiModel->getKonfigurasi();
        // $this->levacc = (isset($this->user['acc_setuju']) ? ($this->user['acc_setuju'] == '0' ? $this->level[0]['nilai'] : $this->user['acc_setuju'] - 1) : '0');

        Menu::setMenu($this->menu);
        Menu::setUser($this->user);

        helper(['text', 'session', 'filesystem']);
    }

    /**
     * Method to render views with common data.
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    protected function render($view, $data = [])
    {
        $commonData = [
            'tampilan' => (splitUser('tampilan', $this->user)[0]),
            'tuser' => $this->user,
            'tmenu' => $this->menu,
            'tlevel' => $this->level[0]['nilai'],
        ];

        $data = array_merge($commonData, $data);
        echo view($view, $data);
    }

    protected function encryptData($data)
    {
        $ivLength = openssl_cipher_iv_length($this->method);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encrypted = openssl_encrypt($data, $this->method, $this->key, 0, $iv);
        $encryptedData = base64_encode($iv . $encrypted);
        return $encryptedData;
    }

    protected function decryptData($encryptedData)
    {
        $ivLength = openssl_cipher_iv_length($this->method);
        $data = base64_decode($encryptedData);
        $iv = substr($data, 0, $ivLength);
        $encrypted = substr($data, $ivLength);
        $decrypted = openssl_decrypt($encrypted, $this->method, $this->key, 0, $iv);
        return $decrypted;
    }
}
