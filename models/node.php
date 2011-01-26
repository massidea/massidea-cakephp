<?php
App::import('Model','Baseclass');
App::import('Model','Contents');
App::import('Model','Groups');
App::import('Model','Files');


class Node extends AppModel {
	var $name = 'Node';
	var $useTable = false;
	var $TableModel = null;
	static $cls = null;


	function delete($id = null, $cascade = true) {

		if (!is_array($id)) {
			$this->query("set @real_delete = 0");
			$this->query("delete from baseclasses where id = $id");
			$this->query("delete from deleted");
		} else {
			$bc = new Baseclass();
			$bc->deleteAll($id);
		}
	}

	function find($id = null, $limit = 0, $walk = true) {

		$tmp = null;
		if (is_array($tmp))
			$tmp = implode($id);
		else
			$tmp = (string)$id;
		$hash = sha1($tmp);

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
				$inst = $res['Baseclass']['type'] . 's';
			}

			$t = new $inst();
			$node = $t->find(array('id' => $id));
			$obj['Node'] = $node[$inst];
		}


		Cache::write('Node:'.$hash, $obj);

		return $obj;
		}
	}

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
                $hash = sha1($id);

                $obj = Cache::delete('Node:'.$hash);

	}
}
?>
