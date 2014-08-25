<?php

class WSAL_DB_OccurrenceQuery extends WSAL_DB_Query {
	const LIKE_LEFT = 'l';
	const LIKE_RIGHT = 'r';
	
	/**
	 * Contains meta-specific arguments to be AND'ed together
	 * @var array
	 */
	public $meta_where = array();
	
	/**
	 * Contains arguments to be used in meta conditions.
	 * @var array
	 */
	public $meta_args = array();
	
	public function GetSql(){
		$sql = parent::GetSql();
		if (count($this->meta_where)) {
			$tmp = new WSAL_DB_Meta();
			$sql[] = 'id IN (
				SELECT DISTINCT occurrence_id
				FROM ' . $tmp->GetTable() . '
				WHERE ' . implode(' AND ', $this->meta_where) . '
			)';
		}
		return $sql;
	}
	
	public function GetArgs(){
		$args = parent::GetArgs();
		foreach ($this->meta_args as $arg) $args[] = $arg;
		return $args;
	}
	
	/**
	 * Find occurrences matching an exact named meta value.
	 * @param string $name Meta name.
	 * @param string $value Meta value.
	 */
	public function WhereMetaIs($name, $value){
		$this->meta_where[] = 'name = %s AND value = %s';
		$this->meta_args[] = $name;
		$this->meta_args[] = $value;
	}
	
	/**
	 * Find occurrences matching a named meta containing a value.
	 * @param string $name Meta name.
	 * @param string $value Meta value.
	 * @param string $type Where to check for (left, right, both or none) see LIKE_* constants
	 */
	public function WhereMetaLike($name, $value, $type){
		$this->meta_where[] = 'name = %s AND value LIKE %s';
		$this->meta_args[] = $name;
		$value = esc_sql($value);
		if (strpos($type, self::LIKE_LEFT) !== false) $value = '%' . $value;
		if (strpos($type, self::LIKE_RIGHT) !== false) $value = $value . '%';
		$this->meta_args[] = $value;
	}
	
	/**
	 * Find occurrences matching a meta condition.
	 * @param string $cond Meta condition.
	 * @param array $args Condition arguments.
	 */
	public function WhereMeta($cond, $args){
		$this->meta_where[] = $cond;
		foreach ($args as $arg) $this->meta_args[] = $arg;
	}
}
