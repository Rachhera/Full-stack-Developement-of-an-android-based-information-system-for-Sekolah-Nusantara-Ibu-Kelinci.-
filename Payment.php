<?php

namespace App\Controllers;

class Payment extends BaseController
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
            'Data Pembayaran' => '#',
        );

        $data['uri'] = $this->uri;
        $this->template->title('Data Pembayaran');
        $this->template->content('paymentView', $data);
        $this->template->show('template/main');
    }
}
