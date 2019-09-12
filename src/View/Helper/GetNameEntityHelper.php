<?php
namespace App\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\View\Helper;

class GetNameEntityHelper extends Helper{
    public function getName($entity, $id){
        $query = TableRegistry::get($entity);
        $row = $query->findById($id)->first();
        return $row->get('name');
    }

    public function getUnit($id){
        $query = TableRegistry::get('Fertilizers');
        $row = $query->findById($id)->first();
        return $row->get('unit');
    }
}