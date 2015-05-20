<?php

/*{{{	library Rule change logs

Working with CRT (Compile Rule Table) in _SESSION

Date.Time		Description
-----------		---------------------------------------------------------------
150205.0919		First create this class in lib							//pitak
150216.1240		Revise change of table rules, field rule_enable			//pitak

-----------		---------------------------------------------------------------
}}}*/

define('TABLE_MENU', 'core.menus');

class Rule {

	public static $LastRejectInfo = array();		// [Rule_ID, CRT_Version]
	
	//-------------------------------------------------------------------------

	public static function compile($uid) {	/*{{{
		Load and compile rule from core.rules
		Filter by user id
		Return:
			CRT		//on Success	CRT = array('version'=>tm18, rules = [rule_id => rule_rec])
			false	//on Any Error
		*/
		global $db;
		//
		//---- Query all data id from database
		// Read Position id that belong to user
		if (($aPos=$db->select('core.positions',['user_id'=>$uid],['id']))
			===FALSE) return(false);
		//
		// Read Role id that belong to user
		if (($aRol=$db->select('core.user_roles',['user_id'=>$uid],['role_id']))
			===FALSE) return(false);
		//
		// Read Department id that belong to user
		if (($aDep=$db->select('core.user_departments',['user_id'=>$uid],['department_id']))
			===FALSE) return(false);
		//
		// Read Group id that belong to user
		if (($aGro=$db->select('core.user_ugroups',['user_id'=>$uid],['ugroup_id']))
			===FALSE) return(false);
		//
		//----- Prepare Condition for query where cluase
		$where = [];
		//
		// User
		$list_user = [0, $uid];
			$where[] = 'user_id in ('.implode(',',$list_user).')';
		//
		// Poistion
		$list_position = [];
		if (!empty($aPos)) {
			$list_position = [0];
			foreach($aPos as $rec) $list_position[] = $rec['id'];
			$where[] = 'position_id in ('.implode(',',$list_position).')';
		}
		//
		// Role
		$list_role = [];
		if (!empty($aRol)) {
			$list_role[] = 0;		
			foreach($aRol as $rec) $list_role[] = $rec['role_id'];
			$where[] = 'role_id in ('.implode(',',$list_role).')';
		}
		//
		// Department
		$list_department = [];
		if (!empty($aDep)) {
			$list_department[] = 0;
			foreach($aDep as $rec) $list_department[] = $rec['department_id'];
			$where[] = 'department_id in ('.implode(',',$list_department).')';
		}
		//
		// Group
		$list_group = [];
		if (!empty($aGro)) {
			$list_group[] = 0;
			foreach($aGro as $rec) $list_group[] = $rec['group_id'];
			$where[] = 'group_id in ('.implode(',',$list_group).')';
		}
		//
		//---- Build query from select from Rules
		if (($Rules=$db->query("
			SELECT id,no,ad,action,item,user_id,position_id,role_id,department_id,ugroup_id
			FROM core.rules
			WHERE enable='Y' and (".implode(" OR ",$where).")
			ORDER BY no DESC"))
			===FALSE) return(false);
		$CRT=[];
		$CRT['version'] = $db->select('core.tm18()')[0]['tm18'];
		$CRT['rules'] = [];
		//
		// add ignore condition to each list
		$list_user[] = -1;
		$list_position[] = -1;
		$list_role[] = -1;
		$list_department[] = -1;
		$list_group[] = -1;
		//
		// fetch each rule by condition
		foreach($Rules as $rec) {
			// compare condition with 'AND'
			if (
				in_array($rec['user_id'], $list_user)&&
				in_array($rec['position_id'], $list_position)&&
				in_array($rec['role_id'], $list_role)&&
				in_array($rec['department_id'], $list_department)&&
				in_array($rec['ugroup_id'], $list_group)
			)
				// pass all condition then accept in compile table
				$CRT['rules'][$rec['id']] = $rec;
		}
		//
		//----- Return last Perfect compile Result
		return($CRT);

	}	/*}}}*/

	public static function check($action,$item,$CRT=null) {	/*{{{
		Check and Test rule condition from CRT in $_SESSION
		Return:
			[Rule_ID, CRT_Version]		//on Accept
			False						//on Reject
		*/
		Rule::$LastRejectInfo = [-1, 0];
		$action=strtoupper(trim($action));
		$item=strtoupper(trim($item));
		if (''==$action||''==$item) return(false);

		// check and auto select CRT from session if exists
		if (NULL===$CRT) 
			if (isset($_SESSION['CRT'])) 
				$CRT = $_SESSION['CRT'];

		// validate CRT structure
		if (NULL===$CRT) return(false);
		if (!isset($CRT['rules'])) return(false);
		if (!isset($CRT['version'])) return(false);

		$version=$CRT['version'];
		$rules=$CRT['rules'];

		$id=-1;	// No Rule found
		$list_action = ['ALL', $action];
		$list_item = ['ALL', $item];

		foreach($rules as $id=>$rule) {
			if (
				in_array($rule['action'], $list_action) &&
				in_array($rule['item'], $list_item)
			) {
				// Matching then check Flag 'A'=Allow, 'D'=Deny
				if ($rule['ad']=='A') {
					// Accept Rule
					return([$id, $version]);
				}
				else {
					// Reject Rule
					Rule::$LastRejectInfo = [$id, $version];
					return(false);
				}
			}
		}

		// Nothing Matching Rule
		Rule::$LastRejectInfo = [$id, $version];		// Default Reject Info
		return(false);

	} /*}}}*/

	public static function cmt($CRT=null) {	/*{{{
		Create Compile-Menu-Table from table core.menus by
		compare and verity with CRT
		return:
			Menu Structure Tree		//on Success
			NULL					//on Nothing
			FALSE					//on Any Error
		*/
		global $db;
		$log = new Logs(__METHOD__);
		$log->debug('Compile CMT from CRT by '.((NULL===$CRT)?('SESSION'):('PREFER')));

		// Retrive all record from table menu
		$rows = $db->select(TABLE_MENU,['enable'=>'Y'],null,'level,parent,sort,id');
		if (false===$rows || (!is_array($rows))) {
			$log->error('Error select from '.TABLE_MENU);
			return(FALSE);
		}
		if (empty($rows)) {
			$log->warning('No data from '.TABLE_MENU.' that match condition');
			return(NULL);
		}
		$log->debug('Retrive '.count($rows).' rows of MENU record');

		// Fetch and compile each rows
		$CMT = [];
		$NODE = [];		// menu.id => MenuRecord
		foreach ($rows as $row) {
			// check parent existing, if NO then SKIP
			$parent = $row['parent'];
			if ($parent>0 && (!isset($NODE[$parent]))) continue;

			if ($parent>0) $menuParent = &$NODE[$parent]; else $menuParent=NULL;
			$id = $row['id'];

			// check require action&item in CRT
			if (FALSE===Rule::check(
					$row['req_rule_action'],
					$row['req_rule_item'], $CRT)
			) continue;

			// filter extra field
			foreach ($row as $k=>$v)
				if (substr($k,0,1)=='_') unset($row[$k]);

			// attch special sub-menu record
			$row['sub_menu'] = [];

			// attach menu record to result
			if ($parent>0) {	// sub menu
				$menuParent['sub_menu'][$id] = $row;
				$NODE[$id] = &$menuParent['sub_menu'][$id];	// create pointer to SUB_MENU in $CMT
			}
			else {	// root menu
				$CMT[$id] = $row;
				$NODE[$id] = &$CMT[$id];	// create pointer to $CMT
			}
		}

		// Return complete Tree Menu Result
		$log->debug('Finish compile menu for '.count($NODE).' node(s)');
		return($CMT);

	}	/*}}}*/

	//-------------------------------------------------------------------------
}
?>
