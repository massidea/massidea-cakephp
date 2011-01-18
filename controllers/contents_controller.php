<?php
class ContentsController extends AppController {
	public $uses = null;
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('title_for_layout','Massidea.org');
	}
	
	public function index() {
		
	}
	
	
}