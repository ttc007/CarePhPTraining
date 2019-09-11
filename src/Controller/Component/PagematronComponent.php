<?php
namespace App\Controller\Component;

use Cake\Event\Event;
use Cake\Controller\Component;

class PagematronComponent extends Component
{
    public $controller = null;

    public function setController($controller)
    {
        $this->controller = $controller;
        if (!isset($this->controller->paginate)) {
            $this->controller->paginate = [];
        }
    }

    public function startup(Event $event)
    {
        $this->setController($event->getSubject());
    }

    public function adjust($length = 'short')
    {
        $this->controller->paginate['order'] = ['Users.id' => 'asc'];
        switch ($length) {
            case 'long':
                $this->controller->paginate['limit'] = 100;
            break;
            case 'medium':
                $this->controller->paginate['limit'] = 50;
            break;
            default:
                $this->controller->paginate['limit'] = 5;
            break;
        }
    }
}