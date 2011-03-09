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
	
	public $components = array('Cookie','Cookievalidation','Content_','Tag_','Company_');
	public $uses = array('Language');
	
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
			$contents = $this->Nodes->find(array('type' => 'Content', 'class' => $contentType),array('limit' => 10),true);
		}
		else {
			$contentType = 'all';
			$contents = $this->Nodes->find(array('type' => 'Content'),array('limit' => 10),true);
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

		if (!empty($this->data)) { // If form has been posted
			$this->data['Privileges']['creator'] = NULL;
			$this->Content_->setAllContentDataForSave($this->data);
			$this->Tag_->setTagsForSave($this->data['Tags']['tags']);
			$this->Company_->setCompaniesForSave($this->data['Companies']['companies']);

			if($this->Content_->saveContent() !== false) { //If saving the content was successfull then...

				//These are yet to be fixed and waits for updates
				//$this->Tag_->linkTagsToObject($this->Content_->getContentId()); //We have content ID after content has been saved
				//$this->Company_->linkCompaniesToObject($this->Content_->getContentId());

				$errors = array();		
				if(empty($errors)) {
					$this->Session->setFlash('Your content has been successfully saved.', 'flash'.DS.'successfull_operation');
					
				} else {
					$this->Session->setFlash('Your content has NOT been successfully saved.');
				}
				
				if($this->Content_->getContentPublishedStatus() === 1) {
					$this->redirect('/');
				}
				else {
					$this->redirect(array('controller' => 'contents', 'action' => 'edit', $this->Content_->getContentId()));
				}
			} else {
				$this->Session->setFlash('Your content has NOT been successfully saved.');
			}
		} else { // If FORM is NOT Posted

			//$this->helpers[] = 'TinyMce.TinyMce'; //Commented out for future use...
	
			if(!$contentType = $this->Content_->validateContentType($contentType)) { //We validate the contentType received from url to prevent XSS.
				$this->redirect(array('controller' => '/'));
			}
	
			$this->set('language_list',$this->Language->find('list',array('order' => array('Language.name' => 'ASC'))));
			$this->set('content_type',$contentType);
		}
	}
	
	/**
	 * edit action - method
	 * Edits content
	 * 
	 * @author	
	 * @param
	 */
	public function edit($contentId = -1) {
		if (!empty($this->data)) { // If form has been posted
			$this->data['Privileges']['creator'] = NULL;
			$this->Content_->setAllContentDataForSave($this->data);
			$this->Tag_->setTagsForSave($this->data['Tags']['tags']);
			$this->Company_->setCompaniesForSave($this->data['Companies']['companies']);
			
			if($this->Content_->saveContent() !== false) { //If saving the content was successfull then...
				
				//$this->Tag_->removeLinksToObject($this->Content_->getContentId()); //Not yet working
				$this->Tag_->linkTagsToObject($this->Content_->getContentId()); //We have content ID after content has been saved
				$this->Company_->linkCompaniesToObject($this->Content_->getContentId());
				
				$errors = array();		
				if(empty($errors)) {
					$this->Session->setFlash('Your content has been successfully saved.', 'flash'.DS.'successfull_operation');
					
				} else {
					$this->Session->setFlash('Your content has NOT been successfully saved.');
				}
				$this->redirect('/');
			} else {
				$this->Session->setFlash('Your content has NOT been successfully saved.');
			}
		} else {
			if($contentId == -1) {
				$this->redirect('/');
			}
			$content = $this->Nodes->find(array('type' => 'Content', 'Contents.id' => $contentId),array(),true);
			if(empty($content)) {
				$this->Session->setFlash('Invalid content ID');
				$this->redirect('/');
			} else {
				$this->Content_->setAllContentDataForEdit($content[0]);
				$editData = $this->Content_->getContentDataForEdit();
				$this->data = $editData;
			}
			$this->set('language_list',$this->Language->find('list',array('order' => array('Language.name' => 'ASC'))));
			$this->set('content_type',$content[0]['Node']['class']);
		}
	}
	
	/**
	 * view action - method
	 * Views content
	 * 
	 * @author	
	 * @param
	 */
	public function view($contentId = -1) {
		if($contentId == -1) {
			$this->redirect('/');
		}

		$content = $this->Nodes->find(array('type' => 'Content', 'Contents.id' => $contentId),array(),true);

		$sidebarCookies = $this->Cookie->read('expandStatus');
		$groups = $this->Cookievalidation->getGroups('contentsView','expandStatus');
		if(!empty($sidebarCookies)) {
			$sidebarCookies = $this->Cookievalidation->doMatchCheck($sidebarCookies);
		} else {
			$sidebarCookies = $this->Cookievalidation->useDefaults();
		}

		$this->set('sidebarCookies',$sidebarCookies);

		if(empty($content)) {
			$this->Session->setFlash('Invalid content ID');
			$this->redirect('/');
		}
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