<?php

namespace App\Controllers;

class User extends BaseController
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
            'User Data' => '#',
        );

        $data['uri'] = $this->uri;

        $this->template->title('User Data');
        $this->template->content('userListView', $data);
        $this->template->show('template/main');
    }
    
    public function profile()
    {
        $this->template->title('User Profile');
        $this->template->content('userProfileView');
        $this->template->show('template/main');
    }
}
