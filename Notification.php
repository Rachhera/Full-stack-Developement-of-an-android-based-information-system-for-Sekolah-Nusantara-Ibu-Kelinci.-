<?php

namespace App\Controllers;

class Notification extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $this->show();
    }

    public function show()
    {
        $data['arrBreadcrumbs'] = array(
            'Notifikasi' => '#',
        );

        $data['uri'] = $this->uri;
        $this->template->title('Data Notifikasi');
        $this->template->content('notificationView', $data);
        $this->template->show('template/main');
    }
}
