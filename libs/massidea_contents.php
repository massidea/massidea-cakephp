<?php
/**
 * Contents - class for content related things
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied  
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for  
 * more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free 
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * License text found in /license/
 */

/**
 *  Contents -  class
 *
 *  @package    Libs
 *  @author     Jari Korpela
 *  @copyright  2011 Jari Korpela
 *  @license    GPL v2
 *  @version    1.0
 */ 
App::import('Vendor', 'content_externals');
class MassideaContents {
	
	protected $_contentType = null;
	protected $_error = array();
	protected $_contentData = array();
	protected $_contentSpecificData = array();
	protected $_tags = array();
	protected $_companies = array();
	protected $_privileges = array();
	protected $_contentId = null;
	
	private function __parseTags($tags) {
		if($this->_privileges !== null) {
			$tagArray = array();
			foreach($tags as $tag) { // We go through the tags array
					$tagArray[] = array('Node' => array(
											'name' => trim($tag), // Set tag name and trim off whitespaces from beginning and end of the tag
											'type' => 'Tag'), // Set node type to Tag so Node knows we are saving a Tag
										'Privileges' => $this->_privileges // Set privileges
					); 
			}
			
			return $tagArray;
		} else {
			return false;
		}
	}
	
	private function __parseCompanies($companies) {
		if($this->_privileges !== null) {
			$companyArray = array();
			foreach($companies as $company) { // We go through the companies array
				$companyArray[] = array('Node' => array(
											'name' => trim($company), // Set company name and trim off whitespaces from beginning and end of the company
											'type' => 'RelatedCompany'), //Set node type to RelatedCompany so it knows we are saving a RelatedCompany
										'Privileges' => $this->_privileges // Set privileges
				); 
			}
			return $companyArray;
		} else {
			return false;
		}
	}
	
	public function getContentId() {
		return $this->_contentId;
	}
	
	public function getCompanies() {
		return $this->_tags;
	}
	
	public function getTags() {
		return $this->_tags;
	}
	
	/**
	 * getContentType
	 * @return string $contentType 
	 */
	public function getContentType() {
		return $this->_contentType;
	}
	
	public function getErrors() {
		return $this->_error;
	}
	
	public function getContentData() {
		return array('Node' => $this->_contentData, 'Privileges' => $this->_privileges);
	}
	
	public function setContentId($id) {
		if(is_numeric($id)) {
			$this->_contentId = $id;
			return true;
		}
		return false;
	}
	
	/**
	 * setContentData
	 * Separates data to contentSpecificData, tags, companies and contentData
	 * @param array $data
	 * @return $this
	 */
	public function setContentData($data) {	
		$privileges = $data['Privileges'];
		$this->_privileges = $privileges;
		
		$tags = explode(',',$data['Tags']['tags']); // Get tags to array
		$companies = explode(',',$data['Companies']['companies']); // Get companies to array
		
		$tags = $this->__parseTags($tags);
		$companies = $this->__parseCompanies($companies);
		
		$contentSpecificData = to_externals($data['Specific']);
		$this->_contentSpecificData = $contentSpecificData;
		
		$this->_tags = $tags;
		$this->_companies = $companies;
		$this->_contentData = $data['Node'];
		return $this;
	}

	/**
	 * validateContentType
	 * Validates and sets contents content type
	 * @param string $contentType
	 * @return object AddContent
	 */
	public function validateContentType($contentType) {
		if(($contentType === 'challenge') || ($contentType === 'idea') || ($contentType === 'vision')) { 
			$this->_contentType = $contentType;
		} else {
			$this->_contentType = null;
		}
	
		return $this->_contentType;
	}
	

}

?>