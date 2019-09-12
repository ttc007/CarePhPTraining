<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->layout = false;
$this->extend('/Layout/default');

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $cakeDescription ?>
        </title>

        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('style.css') ?>
        <?= $this->Html->css('home.css') ?>
        <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
    </head>
    <body class="home">
        <?php
            echo $this->Form->create($farmerFertilizer, ['controller' => 'Farmers','action' => 'index','class' => "w-100 hidden", 'id'=>'formGetToken']);
            echo $this->Form->end();
        ?>
        <div class="row">
            <div class="col-md-12 text-center">
                <h5 class="w-100">Phân phối phân bón cho nông hộ
                    <h4><?= $this->GetNameEntity->getName('Farmers',$farmerFertilizer->farmer_id) ?></h4>
                </h5>
                <p>
                    Khu/thôn:<?= $this->GetNameEntity->getName('Villages',$farmer->village_id)?> 
                    - Số điện thoại: <?= $farmer->phone?> 
                    - Mã số: <?= $farmer->id?> 
                </p>
                <h4 class="w-100">
                    <?= $batch->name ?> - 
                    <?= $farmerFertilizer->season->name ?>
                </h4>
                <!-- <h5 class="w-100 text-muted">Ngày cấp phát dự kiến: <?= $batch->date_provide ?></h5> -->
                <input type="hidden" name="farmer_id" id='farmer_id' value="<?=$farmer->id?>" />
                <input type="hidden" name="batch_id" id='batch_id' value="<?=$farmerFertilizer->batch_id?>" />
                <input type="hidden" name="farmer_id" id='farmer_id' value="<?=$farmerFertilizer->season->id?>" />
                <?= $this->Html->link('', ['controller' => 'FarmerFertilizers',
                    'action' => 'allocationFertilizer'], ['class'=> 'btn hidden', 'id' => 'urlAllocationFertilizer']) ;   ?>

                <?= $this->Html->link('', ['controller' => 'Farmers',
                    'action' => 'index'], ['class'=> 'btn hidden', 'id' => 'urlFarmersIndex']) ;   ?>

                <?= $this->Html->link('', ['controller' => 'Api\RestFertilizers','action' => 'index'],
                    ['class'=> 'btn hidden', 'id' => 'urlApiFertilizer']) ;   ?>
            </div>
        </div>
        <div class="w-100 mt-3 row">
            <div class="col-md-12">
                <a onclick="addFarmerFertilizer()" style="color: #367bbf"><i class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="w-100 mt-1" id='divFertilizer'>
            <?php if(count($farmerFertilizers)==0){ ?>
                <div class="row rowFertilizer">
                    <div class="col-md-6">
                        <?= $this->Form->control('fertilizer_id', ['type' => 'select','options' => $this->GetOptions->get('Fertilizers'),'label'=>'',
                         'class' => 'select-fertilizer', 'onclick' =>  'selectFertilizerChange(this)']);?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('quantity',['label'=>'', 'value' => 0, 'class' => 'text-right w-75 pull-left', 'min'=>'0']);?>
                        <span class='unit-fertilizer' >Kg</span>
                    </div>
                    <div class="col-md-2">
                        <a onclick="removeFarmerFertilizer(this)"><i class="fa fa-remove"></i></a>
                    </div>
                </div>
            <?php } else { ?>
                <?php foreach ($farmerFertilizers as $key => $farmerFertilizer): ?>
                    <div class="row rowFertilizer">
                        <div class="col-md-6">
                            <?= $this->Form->control('fertilizer_id', ['type' => 'select','options'=>$this->GetOptions->get('Fertilizers'),'label'=>'', 'value' => $farmerFertilizer->fertilizer_id, 'class' => 'select-fertilizer', 'onclick' =>  'selectFertilizerChange(this)']);?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->control('quantity',['label'=>'', 'value' => $farmerFertilizer->quantity, 'class' => 'text-right w-75 pull-left', 'min'=>'0']);?>
                            <span class='unit-fertilizer' ><?=$this->GetNameEntity->getUnit($farmerFertilizer->fertilizer_id)?></span>
                        </div>
                        <div class="col-md-2">
                            <a onclick="removeFarmerFertilizer(this)"><i class="fa fa-remove"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button onclick="allocationFertilizer()">Cấp phát</button>
                <?php
                    echo $this->Html->link('Quay về', ['action' => 'index'], ['class'=> 'btn pull-right1']) ;   
                ?>
            </div>
        </div>
        
    </body>
    
</html>
