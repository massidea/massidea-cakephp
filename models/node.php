<?php

/**
* @author Jussi Raitanen <jussi.raitanen@samk.fi>
* @package Model
*/

App::import('Model','Baseclass');
App::import('Model','Contents');
App::import('Model','Groups');
App::import('Model','Files');


/**
* @package Model
*/
class Node extends AppModel {
	var $name = 'Node';
	var $useTable = false;
	var $TableModel = null;
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
* @param integer $limit
* @param boolean $walk Can be used to find all objects that relates directly.
*/
	function find($id = null, $limit = 0, $walk = true) {

		$hash = $this->_createHash($id);
		$obj = Cache::read('Node:'.$hash);

		if ($obj !== false)
			return $obj;
		

		$bc = new Baseclass();
		$class = get_class($bc);

		if(is_array($id)) {
			if ($type = isset($id['type']) ? $id['type'] : null ) {
				$inst = $type . 's';
				$bc = new $inst();
				$class = get_class($bc);
			}

			$result = $bc->find('all', array('conditions' => $id, 'limit' => $limit) );
			$nodes = null;

			if ($walk) {
			foreach ($result as $res) {
				Node::$cls = $res[$class]['type'];
				$node = $this->find($res[$class]['id']);
					$nodes[] = $node;
			}
			return $nodes;
			}

			return $result;
		} else {

		$m = $bc->query("select * from mapping as o2, baseclasses as o1 inner join baseclasses as o3 on o1.id where o2.parent_object = o1.id and o3.id=o2.child_object and o1.id = $id;");
		$obj = null;
                $obj['relates'];

		if($m) {
		$inst = $m[0]['o1']['type'] . 's';

		$t = new $inst();
		$node = $t->find(array('id' => $id));
		$obj['Node'] = $node[$inst];

                foreach ($m as $d) {
			$id = $d['o3']['id'];
			$inst = $d['o3']['type'] . 's';

			$t = new $inst();
			$result = $t->find(array('id' => $id));
			$object = $result[$inst];
			$obj['relates'][] = $object;
                }
		
		} else {
			$inst = null;
			if (!empty(Node::$cls))
				$inst = Node::$cls . 's';
			else {
				$res = $bc->find(array('id' => $id));
				if ($res)
					$inst = $res['Baseclass']['type'] . 's';
			}

			if ($inst) {
				$t = new $inst();
				$node = $t->find(array('id' => $id));
				$obj['Node'] = $node[$inst];
			}
		}


		Cache::write('Node:'.$hash, $obj);

		return $obj;
		}
	}

/**
* Inserts a new object or modifies existing object.
* @param array $data Actual node to be passed.
*/
	function save($data) {

		$bc = new Baseclass();

		$type = $data['type'];
		$inst = $type . 's';
		$base_data['type'] = $data['type'];
		
		if (isset($data['id']))
			$base_data['id'] = $data['id'];

		$bc->save($base_data);
		$last_id = $bc->getLastInsertId();

		if ($last_id)
			$data['id'] = $last_id;

		$t = new $inst();
		$t->save($data);

		$id = (string)$data['id'];
                $hash = $this->_createHash($id);

                $obj = Cache::delete('Node:'.$hash);
	}

/**
* Creates a sha1 hash from passed value.
* @param mixed $value
*/
	function _createHash($value) {

		$tmp = null;
                if (is_array($value))
                        $tmp = implode($value);
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
		$hardlink = (int)$hardlink;
		@$res = $this->query("insert into mapping(parent_object,child_object,hardlink) values($parent,$child,$hardlink)");

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
		$res = $this->query("delete from mapping where parent_object = $parent and child_object = $child");

		$phash = $this->_createHash($parent);
                $chash = $this->_createHash($child);

                Cache::delete('Node:'.$phash);
                Cache::delete('Node:'.$chash);
	}
}

?>
