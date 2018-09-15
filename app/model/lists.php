<?php

class lists
{
    function total_get($table = '')
    {
        $sql = "SELECT
            
			COUNT(*) As total_rows
            
		FROM list_%s WHERE 1=1";
        
        
        $sql = sprintf($sql, $table);
        
        $res = db_query($sql);
        
        return $res;
    }
    
    function get($table = '', $page = 1, $limit = PAGE_LIMIT, $order_by = 'ORDER BY name')
	{
		$sql = "SELECT

			*

		FROM list_%s
		WHERE 1=1
		
			{$order_by}
		
		LIMIT ".(($page-1) * $limit).", ".$limit;
		
		$sql = sprintf($sql, $table);
		
		$res = db_query($sql);
		
		$res->total_rows = $this->total_get($table)->row['total_rows'];
		
		return $res;
	}

	function one($table = '', $table_id = 0)
	{
		$sql = "SELECT
		
			*

		FROM list_%s
		WHERE 1=1
		
			AND %s_id = %d
		
		LIMIT 1
		
		";
		
		$sql = sprintf($sql, $table, $table, $table_id);
		
		$res = db_query($sql);

		return $res;
	}
}
