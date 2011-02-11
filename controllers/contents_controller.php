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

App::import('Lib', 'MassideaContents', array('file' => 'massidea_contents.php'));

class ContentsController extends AppController {
	
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
	public function add($contentType = 'challenge') {
		$errors = array();
		//$this->helpers[] = 'TinyMce.TinyMce'; //Commented out for future use...
		$this->Libloader->loadLib(array(
			'myContent' => array('file' => 'massidea_contents.php', 'className' => 'MassideaContents')
		));
		
		if(!$contentType = $this->myContent->validateContentType($contentType)) { //We validate the contentType received from url to prevent XSS.
			$contentType = 'challenge';
		}
		
		$this->set('content_type',$contentType);
		
		if (!empty($this->data)) { // If form has been posted
			$this->myContent->setContentData($this->data);
			if($this->Nodes->save($this->myContent->getContentData()) !== false){ //If saving the content was successfull then...
				$this->myContent->setContentId((int)$this->Nodes->last_id()); //Set the saved contents id
				$tags = $this->myContent->getTags();

				foreach($tags as $tag) {
					if($this->Nodes->save($tag) === false) { // If saving the tag was NOT successfull
						$errors['tags'][$tag] = 'Save failed'; // We set the tag to $error array for further inspection
					} else { // If saving the tag was successfull
						$tag_id = $this->Nodes->last_id(); // Get the saved tags id
						$this->Nodes->link($this->myContent->getContentId(),$tag_id); // Link content_id and tag_id
					}
				}
				
				$companies = $this->myContent->getCompanies();

				foreach($companies as $company) { //We go through the companies array

					if($this->Nodes->save($company) === false) { // If saving the tag was NOT successfull
						$errors['companies'][$company] = 'Save failed'; // We set the company to $error array for further inspection
					} else { // If saving the company was successfull
						$tag_id = $this->Nodes->last_id(); // Get the saved companys id
						$this->Nodes->link($this->myContent->getContentId(),$tag_id); // Link content_id and company_id
					}
				}
				
				$errors = array_merge($errors,$this->myContent->getErrors());
		
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