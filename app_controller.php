<?php
class AppController extends Controller {
	public $layout = 'layout';
	
	public function beforeFilter() {
		$this->set('baseUrl',Dispatcher::baseUrl());		
	}
}