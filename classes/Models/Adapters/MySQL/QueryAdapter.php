<?php

class WSAL_Adapters_MySQL_Query implements WSAL_Adapters_QueryInterface
{
    protected $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }

    /**
     * @return string Generated sql.
     */
    protected function GetSql($query, &$args = array())
    {
        $conditions = $query->getConditions();

        $sWhereClause = "";
        foreach ($conditions as $fieldName => $fieldValue) {
            if (empty($sWhereClause)) {
                $sWhereClause .= " WHERE ";
            } else {
                $sWhereClause .= "AND ";
            }
            $sWhereClause .= $fieldName . " = %s";
            $args[] = $fieldValue;
        }

        $fromDataSets = $query->getFrom();
        $columns = $query->getColumns();
        $orderBys = $query->getOrderBy();

        $sLimitClause = "";
        if ($query->getLimit()) {
            $sLimitClause .= " LIMIT ";
            if ($query->getOffset()) {
                $sLimitClause .= $query->getOffset() . ", ";
            }
            $sLimitClause .= $query->getLimit();
        }
        $fields = (empty($columns))? '*' : implode(',', $columns);
        return 'SELECT ' . $fields
            . ' FROM ' . implode(',', $fromDataSets)
            . $sWhereClause
            // @todo GROUP BY goes here
            // @todo HAVING goes here
            . (!empty($orderBys) ? (' ORDER BY ' . implode(', ', array_keys($orderBys)) . ' ' . implode(', ', array_values($orderBys))) : '')
            . $sLimitClause;
    }
    
    protected function getActiveRecordAdapter()
    {
        return new WSAL_Adapters_MySQL_ActiveRecord($this->connection);
    }
    
    /**
     * @return WSAL_Models_ActiveRecord[] Execute query and return data as $ar_cls objects.
     */
    public function Execute($query)
    {
        $args = array();
        $sql = $this->GetSql($query, $args);

        $occurenceAdapter = $query->getConnector()->getAdapter("Occurrence");

        if (in_array($occurenceAdapter->GetTable(), $query->getFrom())) {
            return $occurenceAdapter->LoadMulti($sql, $args);
        } else {
            return $this->getActiveRecordAdapter()->LoadMulti($sql, $args);
        }
    }
    
    /**
     * @return int Use query for counting records.
     */
    public function Count($query)
    {
        // back up columns, use COUNT as default column and generate sql
        $cols = $query->getColumns();
        $query->clearColumns();
        $query->addColumn('COUNT(*)');

        $args = array();
        $sql = $this->GetSql($query, $args);

        // restore columns
        $query->setColumns($cols);
        // execute query and return result
        return $this->getActiveRecordAdapter()->CountQuery($sql, $args);
    }
    
    /**
     * Use query for deleting records.
     */
    public function Delete($query)
    {
        //TO DO: FIX THIS ONE

        // back up columns, remove them for DELETE and generate sql
        $cols = $query->getColumns();
        $query->clearColumns();

        //TO DO: FIX THIS
        $args = array();
        $sql = $this->GetSql($query, $args);
        
        //restore columns        
        $query->setColumns($cols);
        
        // execute query
        call_user_func(array($this->getActiveRecordAdapter(), 'DeleteQuery'), $sql, $args);
    }
}
