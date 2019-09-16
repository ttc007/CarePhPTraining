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
$this->extend('/Layout/login-layout');

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $cakeDescription ?>
        </title>

    </head>
    <body class="home">
        <div class="row">
            <div class="users form">
                <form  id='container-form' onsubmit='register'>
                    <fieldset>
                        <legend><?= __('Register') ?></legend>
                        <?= $this->Form->control('username', ['label' => 'Tên đăng nhập']) ?>
                        <?= $this->Form->control('password', ['label' => 'Mật khẩu']) ?>
                        <?= $this->Form->control('confirmPassword', ['type'=>'password', 'label' => 'Xác nhận mật khẩu']) ?>
                        <?= $this->Form->control('ward', ['label' => 'Xã/thị trấn']) ?>
                        <a onclick='register()' class="btn btn-filter">Đăng kí</a>
                        <?= $this->Html->link('Đăng nhập', ['action' => 'login'], ['class'=> 'button-register']); ?>
                   </fieldset>
                </form>
            </div>
        </div>

    </body>
</html>
