<?php
/**
 *  UsersController
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
 *  UsersController - class
 *  Maintains authentication related actions (signup, login, logout...)
 *	TODO: -
 *  @package        controllers
 *  @author         Jaakko Paukamainen
 *  @copyright      Jaakko Paukamainen
 *  @license        GPL v2
 *  @version        1.0
 */

class UsersController extends AppController {
	public $name = 'Users';
	public $components = array('RecaptchaPlugin.Recaptcha', 'RequestHandler'); 
	public $helpers = array('RecaptchaPlugin.Recaptcha');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('signup', 'login', 'ajaxValidateField');
	}
	
	function login() {
		// If already logged in, redirect to home
		// TODO: redirect back where came from
		if($this->Session->read('Auth.User')) {
			$this->redirect('/');
		}
		if(!empty($this->data)) {
			// Get user record by username
			$dbUserData = $this->User->findByUsername($this->data['User']['username']);
			
			if(!empty($dbUserData)) {
				$isOldUser = $dbUserData['User']['password_salt'] != '';
				$plainPassword = $this->Auth->data['User']['password'];
				// Find out what kind of hashing is used
				if(!$isOldUser) {
					// Hash password
					$this->data['User']['password'] = $plainPassword;
					$this->data = $this->User->customHashPasswords($this->data);
				} else {
					// Fallback, try to identify with older hashing algorithm
					$this->data = $this->User->hashOldPassword($dbUserData, $plainPassword);
					// If user identifies with old hashing algorithm
					if($this->Auth->identify($this->data)) {
						// Update user record for new hash (hashing occurs in UserModel, beforeSave())
						$this->data['User']['password'] = $plainPassword;
						$this->data['User']['password_salt'] = '';
						$this->data = $this->User->save($this->data, array(
							'validate' => false, 
							'fieldList' => array('password', 'password_salt')
						));
						if(!empty($this->data)) CakeLog::write('activity', 'Updated password hashing for user '.$this->data['User']['username']);
					}
				}
				// Continue authentication
				if($this->Auth->login($this->data)) {
					$this->Session->setFlash('Successfully logged in!');
					$this->redirect('/');
				}
			}
		}
	}
	
	function logout() {
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}
	
	function signup() {
		if(!empty($this->data)) {
			$this->User->create();
			if($this->User->save($this->data)) {
				$this->Auth->login($this->data);
				$this->Session->setFlash('Registration successful!');
				$this->redirect('/');
			} 
		}
	}
	
}