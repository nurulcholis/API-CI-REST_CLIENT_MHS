<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;

class Welcome extends CI_Controller {

	private $_client;

	public function __construct()
	{
		$this->_client = new Client([
			'base_uri' => 'http://localhost:8080/rest_server/api/',
			'auth' => ['admin','1234']
		]);
	}

	public function index()
	{
		try {
			$response = $this->_client->request('GET','mahasiswa',[
				'query' => [
					'token' => '12345'
				]
			]);

			$result = json_decode($response->getBody()->getContents(),true);
			echo json_encode($result['data']);
		} catch(Exception $e) {
			$error = json_decode($e->getResponse()->getBody()->getContents(),true);
			echo json_encode( $error['error']);
		}
	}

	public function id($id)
	{
		try {
			$response = $this->_client->request('GET','mahasiswa',[
				'query' => [
					'token' => '12345',
					'id' => $id
				]
			]);
			
			$result = json_decode($response->getBody()->getContents(),true );
			if( $result['status'] ) {
				echo json_encode($result['data'][0]);
			} else {
				echo json_encode($result['message']);
			}
			
		} catch(Exception $e) {
			$error = json_decode($e->getResponse()->getBody()->getContents(),true);
			echo json_encode($error['error']);
		}
	}
}
