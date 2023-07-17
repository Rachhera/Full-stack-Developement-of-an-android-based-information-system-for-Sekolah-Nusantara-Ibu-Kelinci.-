<?php

namespace App\Controllers;

class Dashboard extends BaseController
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
            'Dashboard' => '#',
        );

        $data['uri'] = $this->uri;
        $this->template->title('Dashboard');
        $this->template->content('dashboardView', $data);
        $this->template->show('template/main');
    }
}
