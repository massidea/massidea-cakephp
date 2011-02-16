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
	
	public $components = array('Content_','Tag_','Company_');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Nodes->map = array('RelatedCompany' => 'RelatedCompanies');
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
	public function browse($contentType = 'all') {
		if($contentType = $this->Content_->validateContentType($contentType)) { 
			$contents = $this->Nodes->find(array('type' => 'Content', 'class' => $contentType),array('limit' => 10),false);
		}
		else {
			$contentType = 'all';
			$contents = $this->Nodes->find(array('type' => 'Content'),array('limit' => 10),false);
		}
		$this->set('content_type',$contentType);
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
	public function add($contentType = 'challenge') {
		//$this->helpers[] = 'TinyMce.TinyMce'; //Commented out for future use...

		if(!$contentType = $this->Content_->validateContentType($contentType)) { //We validate the contentType received from url to prevent XSS.
			$this->redirect(array('controller' => '/'));
		}

		$this->set('content_type',$contentType);

		if (!empty($this->data)) { // If form has been posted
			$this->data['Privileges']['creator'] = NULL;
			$this->Content_->setAllContentDataForSave($this->data);
			$this->Tag_->setTagsForSave($this->data['Tags']['tags']);
			$this->Company_->setCompaniesForSave($this->data['Companies']['companies']);
			
			if($this->Content_->saveContent() !== false) { //If saving the content was successfull then...

				$this->Tag_->linkTagsToObject($this->Content_->getContentId()); //We have content ID after content has been saved
				$this->Company_->linkCompaniesToObject($this->Content_->getContentId());
				
				$errors = array();		
				if(empty($errors)) {
					$this->Session->setFlash('Your content has been successfully saved.', 'flash'.DS.'successfull_operation');
					
				} else {
					$this->Session->setFlash('Your content has NOT been successfully saved.');
				}
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