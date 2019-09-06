<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller
{
    var $titleController = '';
    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);
    }

    public function beforeFilter(Event $event)
    {
        // code
        $action = $this->request->params['action'];
        $controller = $this->request->params['controller'];
        $hierarchys = [];
        $hierarchys[] = ['title' => $this->titleController, 'controller' => $controller];
        if($action!='index') {
            if($action == 'add'){
                $pageTitle = "Thêm mới";
            } elseif($action=='edit'){
                $pageTitle = "Chỉnh sửa";
            } else {
                $pageTitle = "Cấp phát";
            }
            $hierarchys[] = ['title' => $pageTitle];
        } else {
            $pageTitle = 'Danh sách';
        }
        $pageTitle .= " ". $controller;
        if($action=='addFarmerFertilizer') $pageTitle = "";
        $this->set(compact('hierarchys', 'pageTitle'));
    }
}