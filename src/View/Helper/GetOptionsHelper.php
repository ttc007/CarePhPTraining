<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

class GetOptionsHelper extends Helper
{
    var $helpers = array('Html','javascript','Session');

    public function get($entity, $order = []){
        $ward_id = $this->Session->read('User.Ward.id');
        $conditions = ['ward_id' => $ward_id];
        if($entity=='Seasons') $order = ['id' => 'DESC'];
        // if($entity=='Fertilizers') $conditions = [];

        $query = TableRegistry::get($entity);
        $rows = $query->find()->where($conditions);
        $rows = $rows->order($order);
        $rows = $rows->all();
        $options = [];
        foreach ($rows as $key => $row) {
            $options[$row->get('id')] = $row->get('name');
        }
        return $options;
    }
}