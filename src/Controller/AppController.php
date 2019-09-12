<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Log\Log;

class AppController extends Controller
{
    var $titleController = '';
    var $ward_id;

    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Farmers',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);

        $this->ward_id = $this->request->getSession()->read('User.Ward.id');
    }

    public function beforeFilter(Event $event)
    {
        $action = $this->request->params['action'];
        $controller = $this->request->params['controller'];
        $hierarchys = [];
        $hierarchys[] = ['title' => $this->titleController, 'controller' => $controller];
        if($action!='index') {
            if($action == 'add'){
                $pageTitle = "Thêm mới ". $this->titleController;;
            } elseif($action=='edit'){
                $pageTitle = "Chỉnh sửa ". $this->titleController;;
            } elseif($action == 'addFarmerFertilizer') {
                $pageTitle = "Cấp phát";
            } elseif($action == 'charge') {
                $pageTitle = "Tính tiền";
            } elseif($action == 'chargeFarmer') {
                $pageTitle = "Tính tiền nông hộ";
            } elseif($action == 'searchFarmer') {
                $pageTitle = "Tìm kiếm nông hộ";
            } else {
                $pageTitle = "Tính tiền toàn bộ xã/thị trấn";
            }
            $hierarchys[] = ['title' => $pageTitle];
        } else {
            $pageTitle = 'Danh sách '. $this->titleController;
        }
        if($action=='addFarmerFertilizer') $pageTitle = "";
        $this->set(compact('hierarchys', 'pageTitle'));
    }
}