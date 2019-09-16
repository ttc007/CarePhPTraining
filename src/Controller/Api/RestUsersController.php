<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller\Api;

use Cake\ORM\TableRegistry;
use Cake\Controller\Controller;

use App\Service\RestService\RestUserService;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class RestUsersController extends Controller
{
    var $restUserService;
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        $this->restUserService = new RestUserService();
    }

    public function add()
    {
        $data = $this->request->getData();
        $this->restUserService->addUser($data);
    }

    public function login()
    {
        $data = $this->request->getData();
        $response = $this->restUserService->login($this->request);
        $this->set(compact('response'));
    }

    public function checklogin()
    {
        $data = $this->request->getData();
        $response = $this->restUserService->checklogin($data);
        $this->set(compact('response'));
    }

    public function logout()
    {
        $data = $this->request->getData();
        $response = $this->restUserService->logout($data);
        $this->request->getSession()->write('User.Ward.id', "");
        $this->set(compact('response'));
    }
}
