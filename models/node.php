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
		$privileges = $bc->find('all', array('conditions' => $id, 'limit' => $limit) );

		if(is_array($id)) {
			if ($type = isset($id['type']) ? $id['type'] : null ) {
				$inst = $type . 's';
				$bc = new $inst();
				$class = get_class($bc);
			}

			$result = $bc->find('all', array('conditions' => $id, 'limit' => $limit) );
			$nodes = null;

			$index = 0;
			foreach ($result as $res) {
				$result[$index]['Node'] = $result[$index][$class];
				$result[$index]['Privileges'] = array('creator' => $privileges[$index]['Baseclass']['creator'], 'privileges' => $privileges[$index]['Baseclass']['privileges']);
				unset($result[$index][$class]);
				$index++;
			}

			if ($walk) {
			foreach ($result as $res) {
				static $node_id = 0;
				Node::$cls = $res['Node']['type'];
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
		$inst = $m[0]['o1']['type'] . 's';

		$t = new $inst();
		$node = $t->find(array('id' => $id));
		$obj['Node'] = $node[$inst];
		$obj['Privileges'] = array('creator' =>  $m[0]['o1']['creator'], 'privileges' =>  $m[0]['o1']['privileges']);

                foreach ($m as $d) {
			$id = $d['o3']['id'];
			$inst = $d['o3']['type'] . 's';

			$t = new $inst();
			$result = $t->find(array('id' => $id));
			$object = $result[$inst];
			$obj['relates'][] = $object;
                }
		
		} else {
			$res = null;
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
				$obj['Privileges'] = array('creator' => $res['Baseclass']['creator'], 'privileges' => $res['Baseclass']['privileges']);
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

		if(!isset($data['Node']['type']))
			return NULL;

		$bc = new Baseclass();

		$type = $data['Node']['type'];
		$inst = $type . 's';
		$base_data['type'] = $data['Node']['type'];
		$base_data['creator'] = $data['Privileges']['creator'];
		$base_data['privileges'] = $data['Privileges']['privileges'];
		
		if (isset($data['Node']['id']))
			$base_data['id'] = $data['Node']['id'];

		$bc->save($base_data);
		$last_id = $bc->getLastInsertId();

		if ($last_id)
			$data['Node']['id'] = $last_id;

		$node_data = $data['Node'];

		$t = new $inst();
		$t->save($node_data);

		$id = (string)$node_data['id'];
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
