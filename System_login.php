<?php

namespace App\Controllers;

use Config\Services;

class System_login extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        if ($this->session->administrator_logged_in == TRUE) {
            return redirect()->to('/dashboard');
        } else {
            if ($this->request->getGet('redirect_url') && trim($this->request->getGet('redirect_url')) != '') {
                $data['redirect_url'] = $_GET['redirect_url'];
            } else {
                $data['redirect_url'] = '';
            }

            $data['formAction'] = site_url('system_login/verify');
            $this->template->title('Login Administrator');
            $this->template->content('loginView', $data);
            $this->template->show('template/login');
        }
    }

    public function get_captcha()
    {
        $config = array(
            'image_width' => 265,
            'image_height' => 54,
        );
        $captcha = Services::Captcha();
        $captcha->generate_image($config);
    }

    public function verify()
    {
        $this->curl = \Config\Services::Curl();
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'username' => [
                'label' => 'username',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username harus diisi !',
                ],
            ],
            'password' => [
                'label' => 'password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi !',
                ],
            ],
            'captcha' => [
                'label' => 'captcha',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode unik harus diisi !',
                ],
            ],
        ]);

        $redirectUrl = $this->request->getPost('redirect_url');
        $redirect = "";

        $captcha = Services::Captcha();

        if ($validation->run($this->request->getPost()) == FALSE) {
            foreach ($validation->getErrors() as $key => $value) {
                $this->session->setFlashdata($key, $value);
            }
            if (trim($redirectUrl) != '') {
                $redirectUrl = LOGIN_URI . '?redirect_url=' . $redirectUrl;
                $redirect = LOGIN_URI . '?redirect_url=' . $redirectUrl;
            } else {
                $redirectUrl = LOGIN_URI;
                $redirect = LOGIN_URI;
            }
        } else {
            if (!$captcha->verify($this->request->getPost('captcha'))) {
                $this->session->setFlashdata('errorCaptcha', 'Kode Unik tidak sesuai!');

                if (trim($redirectUrl) != '') {
                    $redirectUrl = LOGIN_URI . '?redirect_url=' . $redirectUrl;
                    $redirect = LOGIN_URI . '?redirect_url=' . $redirectUrl;
                } else {
                    $redirectUrl = LOGIN_URI;
                    $redirect = LOGIN_URI;
                }
            } else {
                $username = addslashes($this->request->getPost('username'));
                $password = addslashes($this->request->getPost('password'));

                $data_login = $this->db->table('site_administrator')
                    ->select('*')
                    ->where('administrator_username', $username)
                    ->get()
                    ->getRow();

                if ($data_login) {
                    if (password_verify($password, $data_login->administrator_password)) {
                        $array_items = array(
                            'administrator_id' => $data_login->administrator_id,
                            'administrator_username' => $data_login->administrator_username,
                            'administrator_name' => $data_login->administrator_name,
                            'administrator_email' => $data_login->administrator_email,
                            'administrator_image' => $data_login->administrator_image,
                            'administrator_logged_in' => TRUE,
                            'filemanager' => TRUE
                        );
                        $this->session->set($array_items);
                    } else {
                        $this->session->setFlashdata('confirmation', 'Username / Password Salah!!');
                        if (trim($redirectUrl) != '') {
                            $redirectUrl = LOGIN_URI . '?redirect_url=' . $redirectUrl;
                            $redirect = LOGIN_URI . '?redirect_url=' . $redirectUrl;
                        } else {
                            $redirectUrl = LOGIN_URI;
                            $redirect = LOGIN_URI;
                        }
                    }
                } else {
                    $this->session->setFlashdata('confirmation', 'Username / Password Salah!!');
                    if (trim($redirectUrl) != '') {
                        $redirectUrl = LOGIN_URI . '?redirect_url=' . $redirectUrl;
                        $redirect = LOGIN_URI . '?redirect_url=' . $redirectUrl;
                    } else {
                        $redirectUrl = LOGIN_URI;
                        $redirect = LOGIN_URI;
                    }
                }
            }
        }
        return redirect()->to($redirect);
    }
}
