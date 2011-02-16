<?php
/**
 * Content - class for content related things
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
 *  Content -  class
 *
 *  @package    Components
 *  @author     Jari Korpela
 *  @copyright  2011 Jari Korpela
 *  @license    GPL v2
 *  @version    1.0
 */ 
class Content_Component extends object { //The _ is added because we cant use word Content because its reserved for controller
	var $components = array('DataHandler');
	
	private $__type = 'Content';
	protected $_contentType = null;
	protected $_contentData = array();
	protected $_contentSpecificData = array();
	protected $_privileges = array();
	protected $_savedData = array();
	protected $_contentId = null;
		
	protected function _setContentId($id) {
		$this->_contentId = $id;
	}
	
	public function getContentId() {
		return $this->_contentId;
	}
	
	/**
	 * getContentType
	 * @return string $contentType 
	 */
	public function getContentType() {
		return $this->_contentType;
	}
	
	public function getContentData() {
		$node = $this->_contentData;
		$node['data'] = $this->_contentSpecificData;
		$content = $this->DataHandler->parseToNodes(array($node),$this->__type);
		return $content;
	}
		
	public function saveContent() {
		if(!empty($this->_contentData)) {
			
			$node = $this->_contentData;
			$node['data'] = $this->_contentSpecificData;
			
			$content = $this->DataHandler->parseToNodes(array($node),$this->__type);
			$contentId = $this->DataHandler->saveData($content);
			$contentId = $contentId[0];
			
			$this->_setContentId($contentId); //Set the saved contents id
			return $contentId;
		}
	}
	
	public function setAllContentDataForSave($data) {
		$this->setContentDataForSave($data['Node']);
		$this->setContentSpecificData($data['Specific']);
		$this->setContentPrivileges($data['Privileges']);
		return $this;
	}
	
	public function setContentPrivileges($data) {
		$this->DataHandler->setPrivileges($this->_privileges); // Privileges must be set before parsing is possible	
		return $this;
	}
	
	public function setContentSpecificData($data) {
		$contentSpecificData = $this->DataHandler->addHtmlSpecialCharsToArrayValues($data);
		$contentSpecificData = $this->DataHandler->toExternals($contentSpecificData);
		$this->_contentSpecificData = $contentSpecificData;
	}
	
	/**
	 * setContentData
	 * Separates data to contentSpecificData, tags, companies and contentData
	 * @param array $data
	 * @return $this
	 */
	public function setContentDataForSave($data) {	
		$contentData = $this->DataHandler->addHtmlSpecialCharsToArrayValues($data);
		$this->_contentData = $contentData;
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