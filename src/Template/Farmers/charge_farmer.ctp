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
        <style type="text/css">
            .container{
                max-width: 1200px;
            }
            .row{
                max-width: 1200px;
            }
        </style>
    </head>
    <body class="home">
        <div class="row pb-5">
            <div class="w-100 text-center">
                <h4>Cashing </h4>
                <h3><?= $farmer->name ?></h3>
                <p>
                    Khu/thôn:<?= $this->GetNameEntity->getName('Villages',$farmer->village_id)?> 
                    - Số điện thoại: <?= $farmer->phone?> 
                    - Mã số: <?= $farmer->id?> 
                </p>
                <h4><?= $season->name ?></h4>
            </div>
            <?php $totalFarmer = 0; ?>
            <?php foreach ($batchs as $key => $batch): ?>
                <h5><?= $batch->name ?></h5>
                <?php $totalBatch = 0; ?>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Tên cấp phát</th>
                        <th>Đơn giá</th>
                        <th>Đơn vị</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                    <?php foreach ($farmer->batchs[$batch->id] as $key => $farmerFertilizer): ?>
                        <tr>
                            <td><?= $this->GetNameEntity->getName('Fertilizers',  $farmerFertilizer->fertilizer_id)  ?></td>
                            <td class="text-right"><?= number_format($farmerFertilizer->price) ?>đ</td>
                            <td><?= $farmerFertilizer->unit  ?></td>
                            <td><?= $farmerFertilizer->quantity  ?></td>
                            <td class="text-right"><b><?= number_format($farmerFertilizer->quantity*$farmerFertilizer->price) ?>đ</b></td>
                            <?php $totalBatch += $farmerFertilizer->quantity*$farmerFertilizer->price; ?>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td colspan="4" class="text-center"><b>Tổng <?= $batch->name ?></b></td>
                        <td class="text-right"><b class="text-danger"><?= number_format($totalBatch) ?>đ</b></td>
                        <?php $totalFarmer += $totalBatch; ?>
                    </tr>
                </table>
            <?php endforeach ?>

            <table class="table table-bordered table-striped mt-5">
                <tr>
                    <td colspan="4" class="text-center"><h5>Tổng <b><?= $season->name ?></b></h5></td>
                    <td class="text-right"><h5><b class="text-danger"><?= number_format($totalFarmer) ?>đ</b></h5></td>
                </tr>
            </table>
        </div>
        
    </body>
    
</html>
