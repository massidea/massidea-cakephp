<?php

/**
* @author Jussi Raitanen <jussi.raitanen@samk.fi>
* @package Model
*/

App::import('Model','Baseclass');



/**
* @package Model
*/
class Node extends AppModel {
	var $name = 'Node';
	var $useTable = false;
	var $TableModel = null;
	var $last_id = null;
	private $_map = array();
	private $_map_keys = array();
	static $cls = null;

/**
* Deletes a record or multiple records based on criteria.
* @param mixed $id Can be passed as an array or a single id.
* @param boolean $cascade Not used.
*/
	function delete($id = null, $cascade = true) {

		if (!is_array($id)) {
			$this->query("set @real_delete = 0");
			$this->query("delete from baseclasses where id = $id");
			$this->query("delete from deleted");
		} else {
			$bc = new Baseclass();
			$bc->deleteAll($id);
		}

		$hash = $this->_createHash($id);
                $obj = Cache::delete('Node:'.$hash);
	}

/**
* Returns all nodes that matches the criteria.
* @param mixed $id Can be passed as an array or a single id.
* @param array $params See CakePHP find
* @param boolean $walk Can be used to find all objects that relates directly.
*/
	function find($id = null, $params = array(), $walk = true) {

		$hash = $this->_createHash($id);
		$obj = Cache::read('Node:'.$hash);

		if ($obj !== false)
			return $obj;

		$bc = new Baseclass();
		$class = get_class($bc);

		if(is_array($id)) {
			if ($type = isset($id['type']) ? $id['type'] : null ) {

				$inst = $this->get_type($type);

				$bc = new $inst();
				$class = get_class($bc);
			}

			$_type = $inst;
			unset($id['type']);

			$cond = array('conditions' => $id, 'fields' => array('*'), 'joins' => array( array('table' => 'baseclasses', 'alias' => 'Privileges', 'type' => 'left', 'conditions' => array("Privileges.id = $_type.id") ) ) );
			$cond = array_merge($cond, $params);

			$result = $bc->find('all', $cond);

			$nodes = null;

			$index = 0;
			foreach ($result as $res) {
				$result[$index]['Node'] = $result[$index][$class];
				unset($result[$index][$class]);
				$index++;
			}



			if ($walk) {
			foreach ($result as $res) {
				static $node_id = 0;
				$node = $this->find($res['Node']['id']);

				$nodes[$node_id] = $node;
				$node_id++;
			}

			return $nodes;
			}

			return $result;
		} else {

		$m = $bc->query("select * from mapping as o2, baseclasses as o1 inner join baseclasses as o3 on o1.id where o2.parent_object = o1.id and o3.id=o2.child_object and o1.id = $id;");
		$obj = null;
                $obj['relates'];

		if($m) {
		$inst = $this->get_type($m[0]['o1']['type']);

		$t = new $inst();
		$node = $t->find(array('id' => $id));
		$obj['Node'] = $node[$inst];
		$obj['Privileges'] = array('creator' =>  $m[0]['o1']['creator'], 'privileges' =>  $m[0]['o1']['privileges']);

                foreach ($m as $d) {
			$id = $d['o3']['id'];
			$inst = $this->get_type($d['o3']['type']);

			$t = new $inst();
			$result = $t->find(array('id' => $id));
			$object = $result[$inst];
			$obj['relates'][] = $object;
                }
		
		} else {
			$res = null;
			$inst = null;

//			if (!empty(Node::$cls))
//				$inst = Node::$cls . 's';
//			else {
				$res = $bc->find(array('id' => $id));
				if ($res)
					$inst = $this->get_type($res['Baseclass']['type']);
//			}

			if ($inst) {
				$t = new $inst();
				$node = $t->find(array('id' => $id));
				$obj['Node'] = $node[$inst];
				$obj['Privileges'] = array('creator' => $res['Baseclass']['creator'], 'privileges' => $res['Baseclass']['privileges']);
			}
		}

		Cache::write('Node:'.$hash, $obj);

		return $obj;
		}
	}

/**
* Inserts a new object or modifies existing object.
* @param array $data Actual node to be saved
*/
	function save($data) {

		if(!isset($data['Node']['type']))
			return NULL;

		$bc = new Baseclass();

//		$type = $data['Node']['type'];
		$type = $this->get_type($data['Node']['type']);


		$inst = $type;
		@$base_data['type'] = $data['Node']['type'];
		@$base_data['creator'] = $data['Privileges']['creator'];
		@$base_data['privileges'] = $data['Privileges']['privileges'];
		
		if (isset($data['Node']['id']))
			$base_data['id'] = $data['Node']['id'];

		$bc->save($base_data);
		$last_id = $bc->getLastInsertId();

		if ($last_id)
			$data['Node']['id'] = $last_id;

		$node_data = $data['Node'];

		$this->last_id = $data['Node']['id'];

		$t = new $inst();
		$success = $t->save($node_data);

		$id = (string)$node_data['id'];
                $hash = $this->_createHash($id);

                $obj = Cache::delete('Node:'.$hash);

		return $success;
	}

/**
* Creates a sha1 hash from passed value.
* @param mixed $value
*/
	function _createHash($value) {

		$tmp = null;
                if (is_array($value)) {
			foreach ($value as $v)
				$tmp .= is_array($v) ? implode($v) : $v;
		}
                else
                        $tmp = (string)$value;
                $hash = sha1($tmp);

		return $hash;
	}

/**
* Links together two nodes.
* @param integer $parent Parent node
* @param integer $child Child node
* @param boolean $hardlink If hardlink is true and parent is deleted then the child node will be deleted automatically. 
* @return Returns true if linked successfully otherwise false
*/
	function link($parent, $child, $hardlink = true) {

		$parent_node = $this->find($parent);
		$child_node = $this->find($child);

		$res = null;

		if ($parent_node['Node']['type'] == $child_node['Node']['type']) {
			@$res = $this->query("insert into linked_contents(`from`,`to`) values($parent,$child)");
		} else {
			$hardlink = (int)$hardlink;
			@$res = $this->query("insert into mapping(parent_object,child_object,hardlink) values($parent,$child,$hardlink)");
		}

                $phash = $this->_createHash($parent);
                $chash = $this->_createHash($child);

                Cache::delete('Node:'.$phash);
                Cache::delete('Node:'.$chash);

		if ($res)
			return true;
		return false;
	}

/**
* Removes the link between two nodes.
* @param integer $parent Parent node
* @param integer $child Child node
*/
	function removeLink($parent, $child) {

                $parent_node = $this->find($parent);
                $child_node = $this->find($child);
		$res = null;

		if ($parent_node['Node']['type'] == $child_node['Node']['type']) {
			@$res = $this->query("delete from linked_contents where `from` = $parent and `to` = $child");
		} else {
			@$res = $this->query("delete from mapping where parent_object = $parent and child_object = $child");
		}

		$phash = $this->_createHash($parent);
                $chash = $this->_createHash($child);

                Cache::delete('Node:'.$phash);
                Cache::delete('Node:'.$chash);

		return $res;
	}

/**
* Returns last inserted id
*/
	function last_id() {
		return $this->last_id;
	}

	function __set($name, $value) {
		$this->_map = array_merge($this->_map, $value);
		$this->_map_keys = array_keys($this->_map);
	}

/**
* Returns node type
* @param mixed $parent Node type
*/
	private function get_type($type) {
		$inst = null;
		if (!in_array($type, $this->_map_keys))
	                $inst = $type . 's';
                else
        	        $inst = $this->_map[$type];

		return $inst;
	}
}

?>
