<?php
class Profile extends AppModel {
	var $name = 'Profile';
	var $primaryKey = 'id';

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Group' => array(
			'className' => 'Group',
			'joinTable' => 'profiles_groups',
			'foreignKey' => 'profile_id',
			'associationForeignKey' => 'group_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	var $validate = array(
		'hometown' => array(
			'rule' => 'notEmpty',
			'message' => 'This field cannot be left blank'
		),
		'status' => array(
			'rule' => 'notEmpty',
			'message' => 'This field cannot be left blank'
		)
	);
	
}
?>