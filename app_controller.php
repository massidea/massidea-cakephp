<?php
/**
 *  AppController
 *
 *  This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 *  as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied  
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for  
 *  more details.
 * 
 *  You should have received a copy of the GNU General Public License along with this program; if not, write to the Free 
 *  Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 *  License text found in /license/
 */
 
/**
 *  AppController - class
 *
 *  @package        controllers
 *  @author         Jari Korpela
 *  @copyright      
 *  @license        GPL v2
 *  @version        1.0
 */

//App::import('i18n'); Needed for translations
App::import('Lib', 'Jsmeta', array('file' => 'jsmeta.php'));

class AppController extends Controller {
	public $layout = 'layout';
	public $helpers = array('Session', 'Html', 'Form', 'Cache');
	public $components = array('Session', 'Auth');
	public $Nodes;
	public $userId = null;
	
	public function beforeFilter() {
		$this->set('title_for_layout','Massidea.org');
		
		$this->userId = $this->Session->read('Auth.User.id');
		
		$this->Nodes = Classregistry::init('Node');
		$this->Nodes->map = array('RelatedCompany' => 'RelatedCompanies');
		
		/**
		 * Authentication component configurations
		 */
		$this->Auth->authenticate = ClassRegistry::init('User');
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->loginRedirect = '/';
		$this->Auth->allow('*');
		$this->Auth->authorize = 'controller';
		
		/**
		 * Setting content class
		 * 
		 * content_class is used to define how the page is viewed. Default contentWithSidebar.
		 * Should be overridden in controller if wished to use other class.
		 * The content_sidebar defines which side the sidebar is.
		 */
		$this->set('content_class','contentWithSidebar');
		$this->set('content_sidebar','right');
		
		/**
		 * Setting Logged in user ID to userId variable
		 */
		$this->set('userId',$this->userId);
		//End of automated class load for content
	}
	
	public function beforeRender() {
		$this->set('css_for_layout', $this->__getScripts('css'));
		$this->set('js_for_layout', $this->__getScripts('js'));
		
		/**
		 * Jsmeta - Inject JSON encoded PHP variables for Javascript access (hidden metabox in layout)
		 * Uses jsmeta.php in libs
		 */
		$Jsmeta = new Jsmeta();
		$this->set('Jsmeta',$Jsmeta->append("baseUrl",$this->base));	
	}

	/**
	 * __getScripts
	 * 
	 * $scriptArray is used to automatically load controller and action specific script files for layout if either one exists.
	 * 
	 * For example:
	 * We search for controller specific CSS file from: css/controller/controller.css
	 * Then we search for action specific CSS file from: css/controller/action.css
	 * 
	 * @param string $type script type
	 * @return array 
	 */
	private function __getScripts($type) {
		$scriptArray = array();
		if (file_exists(WWW_ROOT . $type . DS . strtolower($this->name) . DS . strtolower($this->name) . ".".$type)) {
			$scriptArray[] = strtolower($this->name) . DS . strtolower($this->name);
		}
		if (file_exists(WWW_ROOT . $type . DS . strtolower($this->name) . DS . $this->action . ".".$type)) {
			$scriptArray[] = strtolower($this->name) . DS . $this->action;
		}
		return $scriptArray;
	}
	
	public function isAuthorized() {
		return true;
	}
	
	/**
	 * ajaxValidateField
	 * 
	 * Ajax action for form validation.
	 * Usage: send ajax request to any controller and 
	 * this action validates the given parameters against
	 * model validation rules.
	 * 
	 * Returns JSON-encoded values.
	 * 
	 * @param array
	 * @return mixed If validates, returns 1. Otherwise returns validation error string.
	 */
	function ajaxValidateField() {
		if($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$this->autoLayout = false;
			
			$modelName = key($this->data);
			$fieldName = key($this->data[$modelName]);

			$this->loadModel($modelName);
			$this->{$modelName}->set($this->data);
			
			if(!$this->{$modelName}->validates(array('fieldList' => $fieldName))) {
				$reason = $this->{$modelName}->validationErrors;
				$reason = $reason[$fieldName];
			} else {
				$reason = 1;
			}
			echo json_encode($reason);
		} else {
			$this->redirect('/');
		}
	}

}