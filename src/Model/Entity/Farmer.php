<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
use App\Model\Entity\Farmer;
use Cake\ORM\TableRegistry;

class Farmer extends Entity {
    public function village(){
    	$villages = TableRegistry::get('Villages', ['className' => 'App\Model\Table\VillagesTable']);
    	return $villages::findById($this->village_id)->firstOrFail();
    }
}