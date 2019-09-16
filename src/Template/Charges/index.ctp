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
        
        <style type="text/css">
            .container{
                max-width: 1500px;
            }
            .row{
                max-width: 1500px;
            }
        </style>
        <?= $this->Html->script('charge.js') ?>
    </head>
    <body class="home">
        <?= $this->Html->link("", ['action' => 'chargeFarmer'], ['class'=> 'hidden', 'id' => 'urlChargeFarmer']) ?>
        <?php echo $this->Form->create( null ,['class'=>'form-filter']); ?>
            <div class="row">
                <div class="col-md-3">
                    <?php
                        echo $this->Form->control('season_id', ['type' => 'select','options'=>$this->GetOptions->get('Seasons'), 'label' => 'Mùa vụ'
                        ]);
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                        echo $this->Form->control('village_id', ['type' => 'select','options'=>$this->GetOptions->get('Villages'), 'label'=> 'Khu/thôn',
                            'onchange'=>'villageChange(this)']);
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                        echo $this->Form->control('group_id', ['type' => 'select','options'=>[], 'label'=> 'Tổ']);
                    ?>
                </div>
                <div class="col-md-3">
                    <a class="btn-filter" onclick="filterFarmer()">Lọc</a>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
        <div class="row">
            <div class="w-100 text-right">
                <?= $this->Html->link("", ['action' => 'chargeWard'], ['class'=> 'hidden', 'id' => 'urlChargeWard']) ?>
                <a class="charge" onclick="chargeWard()">Tính tiền toàn bộ xã/thị trấn</a>
            </div>
            <div class="w-100">
                <div id='search-form-div' class="pull-right w-25"></div>
            </div>
            <table class="table table-bordered table-striped" id='table-farmer'>
                <tr id="thead-farmer"></tr>
                <tbody id='tbody-farmer'></tbody>
            </table>

            <div class="paginate">
                <ul class="ul-paginate"></ul>
                <div class="paginate-count"></div>
            </div>
        </div>
        
    </body>
    <script type="text/javascript">
        
    </script>
</html>
