<?php

namespace App\Controllers;

class Calendar extends BaseController
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
            'Data Kalender' => '#',
        );

        $data['uri'] = $this->uri;
        $this->template->title('Data Kalender');
        $this->template->content('calendarView', $data);
        $this->template->show('template/main');
    }
}
