<?php

namespace App\Controllers;

class Announcement extends BaseController
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
            'Data Konten' => '#',
            'Pengumuman' => '#'
        );

        $data['uri'] = $this->uri;
        $this->template->title('Data Pengumuman');
        $this->template->content('announcementView', $data);
        $this->template->show('template/main');
    }
}
