<?php

namespace App\Controllers;

class News extends BaseController
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
            'Berita' => '#'
        );

        $data['uri'] = $this->uri;
        $this->template->title('Data Berita');
        $this->template->content('newsView', $data);
        $this->template->show('template/main');
    }
}
