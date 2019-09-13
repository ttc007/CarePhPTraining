<?php
namespace App\Controller\Api;

use Cake\Controller\Controller;
use App\Service\RestService\RestFarmerService;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class RestFarmersController extends Controller
{
	var $restFarmerService;

	public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
		$this->restFarmerService = new RestFarmerService();
    }

	public function index()
    {
        $data = $this->request->getData();

        $response = $this->restFarmerService->filterFarmers($data);
        $this->set(['response' => $response]);
    }
}