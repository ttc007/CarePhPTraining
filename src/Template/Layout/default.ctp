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

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->script('app.js') ?>
    
    <?= $this->Html->css('home.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?= $this->Html->link('', ['controller' => 'Api\RestGroups','action' => 'index'], ['class'=> 'btn hidden', 'id' => 'urlApiGroup']) ;   ?>
    <input type="hidden" id="ward_id" value="<?= $ward_id ?>">
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href=""><?= $this->fetch('title', 'PHPCAKE TRAINING') ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <li class="li-header-user">
                    <a target="_blank" class="header-user"><?= $this->Html->image('user-icon.png', ['class'=>'user-icon', 'style'=>'height:40px']) ?></a>
                    <div class="header-menu-user">
                        <ul>
                            <li><?= $this->Html->link('Quản lí nông hộ', ['controller' => 'Farmers', 'action' => 'index']) ?></li>
                            <li><?= $this->Html->link('Quản lí mùa vụ', ['controller' => 'Seasons', 'action' => 'index']) ?></li>
                            <li><?= $this->Html->link('Quản lí đợt', ['controller' => 'Batchs', 'action' => 'index']) ?></li>
                            <li><?= $this->Html->link('Quản lí phân bón', ['controller' => 'Fertilizers', 'action' => 'index']) ?></li>
                            <li><?= $this->Html->link('Quản lí thôn/khu', ['controller' => 'Villages', 'action' => 'index']) ?></li>
                            <li><?= $this->Html->link('Quản lí tổ', ['controller' => 'Groups', 'action' => 'index']) ?></li>
                            <li><?= $this->Html->link('Đăng xuất', ['controller' => 'Users', 'action' => 'logout']) ?></li>
                        </ul>
                    </div>
                </li>
            </ul>
            <?= $this->Html->link('Tính tiền', ['controller' => 'Charges','action' => 'index'], ['class'=> 'btn pull-right charge-menu']) ;   ?>
        </div>
    </nav>

    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <div class="row mt-4">
            <?php echo $this->element('breadcrumb',[
            'hierarchys' => $hierarchys]); ?>
            <h3 class="pageTitle">
                <?= $pageTitle ?> 
                <?php if($this->request->params['action']=='index'):?>
                    <?= $this->Html->link("+", ['action' => 'add']) ?>
                <?php endif?>
            </h3>

        </div>
        <?= $this->fetch('content') ?>
    </div>
    <footer class="mt-4">
        <div class="row">
            &nbsp;
        </div>
    </footer>
</body>
</html>
