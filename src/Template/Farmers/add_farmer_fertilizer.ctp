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
            echo $this->Form->create($farmerFertilizer, ['action' => 'index','class' => "w-100 hidden", 'id'=>'formGetToken']);
            echo $this->Form->end();
        ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h5 class="w-100">Distribution of fertilizer to households 
                        <h4><?= $this->GetNameEntity->getName('Farmers',$farmerFertilizer->farmer_id) ?></h4>
                    </h5>
                    <p>
                        Khu/thôn:<?= $this->GetNameEntity->getName('Villages',$farmer->village_id)?> 
                        - Số điện thoại: <?= $farmer->phone?> 
                        - Mã số: <?= $farmer->id?> 
                    </p>
                    <h4 class="w-100">
                        <?= $this->GetNameEntity->getName('Batchs',$farmerFertilizer->batch_id) ?> - 
                        <?= $farmerFertilizer->season->name ?>
                        <a onclick="addFarmerFertilizer()" style="color: #367bbf"><i class="fa fa-plus"></i></a><br> 
                    </h4>
                    <input type="hidden" name="farmer_id" id='farmer_id' value="<?=$farmer->id?>" />
                    <input type="hidden" name="batch_id" id='batch_id' value="<?=$farmerFertilizer->batch_id?>" />
                    <input type="hidden" name="farmer_id" id='farmer_id' value="<?=$farmerFertilizer->season->id?>" />
                    <?= $this->Html->link('', ['action' => 'allocationFertilizer'], ['class'=> 'btn hidden', 'id' => 'urlAllocationFertilizer']) ;   ?>
                </div>
            </div>
            <div class="w-100 mt-5" id='divFertilizer'>
                <?php foreach ($farmerFertilizers as $key => $farmerFertilizer): ?>
                    <div class="row rowFertilizer">
                        <div class="col-md-6">
                            <?= $this->Form->control('fertilizer_id', ['type' => 'select','options'=>$this->GetOptions->get('Fertilizers'),'label'=>'', 'value' => $farmerFertilizer->fertilizer_id]);?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->control('quantity',['label'=>'', 'value' => $farmerFertilizer->quantity, 'class' => 'text-right w-75 pull-left', 'min'=>'0']);?>
                            <span style="display: inline-block;margin: 5px;font-size: 15px">Kg</span>
                        </div>
                        <div class="col-md-2">
                            <a onclick="removeFarmerFertilizer(this)"><i class="fa fa-remove"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button onclick="allocationFertilizer()">Cấp phát</button>
                    <?php
                        echo $this->Html->link('Quay về', ['action' => 'index'], ['class'=> 'btn pull-right1']) ;   
                    ?>
                </div>
            </div>
        <?php
            // echo $this->Form->end();
        ?>
    </body>
    <script type="text/javascript">
        function addFarmerFertilizer(){
            $("#divFertilizer").append(`
                <div class="row rowFertilizer"> 
                    <div class="col-md-6">
                        <?= $this->Form->control('fertilizer_id', ['type' => 'select','options'=>$this->GetOptions->get('Fertilizers'),'label'=>'']);?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('quantity',['label'=>'', 'value' => 0, 'class' => 'text-right w-75 pull-left', 'min'=>'0']);?>
                        <span style="display: inline-block;margin: 5px;font-size: 15px">Kg</span>
                    </div>
                    <div class="col-md-2">
                        <a onclick="removeFarmerFertilizer(this)"><i class="fa fa-remove"></i></a>
                    </div>
                </div>
            `);
        }
        function removeFarmerFertilizer(obj){
            $(obj).closest("div.rowFertilizer").remove();
        }
        function allocationFertilizer(){
            var dataSubmit = [];
            $.each($(".rowFertilizer"), function(i, row){
                dataSubmit.push({
                    farmer_id: $("#farmer_id").val(),
                    season_id:$("#season_id").val(),
                    batch_id:$("#batch_id").val(),
                    fertilizer_id: $(row).find("[name=fertilizer_id]").val(),
                    quantity: $(row).find("[name=quantity]").val(),
                });
            });
            $.ajax({
                url: $("#urlAllocationFertilizer").attr('href'),
                type:"POST",
                async: false,
                data: {
                    dataSubmit:dataSubmit,
                    _csrfToken: $("[name=_csrfToken]").val(),
                    farmer_id: $("#farmer_id").val(),
                    batch_id:$("#batch_id").val(),
                },
                success:function(data){
                    location.href = $("#formGetToken").attr("action");
                }
            });
        }
    </script>
</html>