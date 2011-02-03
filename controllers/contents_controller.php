<?php
/**
 *  ContentsController
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
 *  ContentController - class
 *  Maintains actions for browsing, adding and viewin contents
 *
 *  @package        controllers
 *  @author         Jari Korpela
 *  @copyright      
 *  @license        GPL v2
 *  @version        1.0
 */

class ContentsController extends AppController {
	var $uses = null;
	var $Nodes = null;
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Nodes = Classregistry::init('Node');
	}
		
	/**
	 * browse Action - method
	 * Lists contents.
	 * 
	 * Routes that direct to this action are:
	 * Router::connect('/', array('controller' => 'contents', 'action' => 'browse', 'index'));
	 * Router::connect('/contents/challenge/', array('controller' => 'contents', 'action' => 'browse', 'challenge'));
	 * Router::connect('/contents/idea/', array('controller' => 'contents', 'action' => 'browse', 'idea'));
	 * Router::connect('/contents/vision/', array('controller' => 'contents', 'action' => 'browse', 'vision'));
	 * Router::connect('/contents/*', array('controller' => 'contents', 'action' => 'browse'));
	 * 
	 * @author	Jari Korpela
	 * @param	enum $content_type Accepted values: 'all', 'challenge', 'idea', 'vision'
	 */
	public function browse($content_type = 'all') {
		if(($content_type === 'challenge') || ($content_type === 'idea') || ($content_type === 'vision')) {
			$contents = $this->Nodes->find(array('type' => 'Content', 'class' => $content_type),array('limit' => 10),false);
		}
		else {
			$content_type = 'all';
			$contents = $this->Nodes->find(array('type' => 'Content'),array('limit' => 10),false);
		}
		$this->set('content_type',$content_type);
		$this->set('contents',$contents);
	}

	/**
	 * add action - method
	 * Adds content
	 * 
	 * Routes that direct to this action are:
	 * Router::connect('/contents/add/*', array('controller' => 'contents', 'action' => 'add'));
	 * 
	 * @author	Jari Korpela
	 * @param	enum $content_type Accepted values: 'all', 'challenge', 'idea', 'vision'
	 */
	public function add($content_type = 'challenge') {
		//We check the content_type received from url to prevent XSS.
		if(($content_type === 'challenge') || ($content_type === 'idea') || ($content_type === 'vision')) { 
			$this->set('content_type',$content_type);
		} else { 
			$this->set('content_type',$content_type);
		}
		
		if (!empty($this->data)) {
			$this->data['Privileges']['creator'] = NULL;
			//$this->data['Privileges']['privileges'] = '666';
			//var_dump($this->data);

			if($this->Nodes->save($this->data) !== false){
				$this->Session->setFlash('Your content has been saved.');
				$this->redirect('/');
			}

		}

		
	}
	
	/**
	 * edit action - method
	 * Edits content
	 * 
	 * @author	
	 * @param
	 */
	public function edit($content_id) {
		
	}
	
	/**
	 * delete action - method
	 * Deletes content
	 * 
	 * @author	
	 * @param
	 */
	public function delete($content_id) {
		
	}
	
	/**
	 * preview action - method
	 * Previews content
	 * 
	 * @author	
	 * @param
	 */
	public function preview($content_id) {
		
	}
	
	/**
	 * flag action - method
	 * Flags content
	 * 
	 * @author	
	 * @param
	 */
	public function flag($content_id) {
		
	}
	

}