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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Controller\Controller;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class RestFertilizersController extends Controller
{
    var $fertilizerQuery;
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->fertilizerQuery = TableRegistry::get('Fertilizers', ['className' => 'App\Model\Table\FertilizersTable']);
    }

    public function index()
    {
        $fertilizers = $this->fertilizerQuery->find()
                        ->where([
                            'ward_id' => $this->request->query('ward_id'), 
                            'id not in'=> $this->request->query('selectfertilizerBefores')
                        ])->all();
        $this->set(array(
            'fertilizers' => $fertilizers
        ));
    }

    public function add()
    {
        $fertilizer = $this->fertilizerQuery->newEntity();
        if ($this->request->is('post')) {
            $fertilizer = $this->fertilizerQuery->patchEntity($fertilizer, $this->request->getData());
            $this->fertilizerQuery->save($fertilizer);
            $this->Flash->error(__('Unable to add your blog.'));
        }
        $this->set('fertilizer', $fertilizer);
    }

    public function get($id)
    {
        $fertilizer = $this->fertilizerQuery->findById($id)->firstOrFail();
        $this->set('fertilizer', $fertilizer);
    }
}
