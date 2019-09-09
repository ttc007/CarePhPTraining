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
            } elseif($action == 'addFarmerFertilizer') {
                $pageTitle = "Cấp phát";
            } elseif($action == 'charge') {
                $pageTitle = "Tính tiền";
            } else {
                $pageTitle = "Tính tiền toàn bộ xã/thị trấn";
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