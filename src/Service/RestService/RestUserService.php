<?php
namespace App\Service\RestService;

use Cake\ORM\TableRegistry;

/**
 * 
 */
class RestUserService
{
	var $userRepository;
	var $wardRepository;

	function __construct(){
		$this->userRepository = TableRegistry::get('Users', ['className' => 'App\Model\Table\UsersTable']);
		$this->wardRepository = TableRegistry::get('Wards', ['className' => 'App\Model\Table\WardsTable']);
	}

	function addUser($data){
		$ward = $this->wardRepository->newEntity();
        $ward->name = $data['ward'];
        $this->wardRepository->save($ward);

		$user = $this->userRepository->newEntity();
        $user = $this->userRepository->patchEntity($user, $data);
        
        $user->ward_id = $ward->id;
        $this->userRepository->save($user);
	}

	function login($request){
		$data = $request->getData();
		$user = $this->userRepository->find()->where(['username ='=> $data['username'], 'password' => $data['password'] ])->first();
		if(!$user) {
			return ['status' => 'wrong'];
		} else {
			$authenticate = $this->createToken($user);
			$user->authenticate = $authenticate;
			$this->userRepository->save($user);
			$request->getSession()->write('User.Ward.id', $user->ward_id);
			return ['status' => 200, 'authenticate' => $authenticate];
		}
	}

	function createToken($data)
	{
		$secretKey = "fakesecretkey";
	    /* Create a part of token using secretKey and other stuff */
	    $tokenGeneric = $secretKey; // It can be 'stronger' of course

	    /* Encoding token */
	    $token = hash('sha256', $tokenGeneric.$data);

	    return $token;
	}

	function getUser($authenticate){
		$user = $this->userRepository->find()->where(['authenticate ='=> $authenticate])->first();
		return $user;
	}

	function checklogin($data){
		$user = $this->getUser($data['authenticate']);
		if($user) return ['status' => 'isLogin'];
	}

	function logout($data){
		$user = $this->getUser($data['authenticate']);
		$user->authenticate = null;
		$this->userRepository->save($user);
		if($user) return ['status' => 200];
	}
}