<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use App\Model\Entity\User;
use App\Controller\Component\PagematronComponent;
use Cake\Controller\Controller;
use App\Model\Entity\Ward;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;


class UsersController extends AppController
{
    var $wardQuery;
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Pagematron');
        // $this->loadComponent('Auth');

        $this->wardQuery = TableRegistry::get('Wards', ['className' => 'App\Model\Table\WardsTable']);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function index()
    {
        $this->Pagematron->adjust();
        $users = $this->paginate($this->Users->find()->where(['id > ' => 1]));
        $this->set('users', $users);
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $ward = $this->wardQuery->newEntity();
            $ward->name = $this->request->getData()['ward'];
            $this->wardQuery->save($ward);

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if($user->password!=$user->confirmPassword) {
                $this->Flash->error(__('Confirm password không khớp'));
                return $this->redirect(['action' => 'add']);
            }
            $user->password = User::_setPassword($this->request->getData()['password']);
            $user->ward_id = $ward->id;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }

    public function login()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->request->getSession()->write('User.Ward.id', $user['ward_id']);
                $this->request->getSession()->write('Village.id', "");
                $this->request->getSession()->write('Season.id', "");

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
        $this->set('user', $user);
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}