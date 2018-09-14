<?php
class Admin_Song
{
	function total_songs($user_id = 0, $kv = [])
	{
		$where = '';
		
		if (isset($kv['song_title']) && $kv['song_title'] == 1)
		{
		    $where .= " AND s.song_title != ''";
		}
		
		if (isset($kv['singer']) && $kv['singer'] == 1)
		{
		    $where .= " AND s.singer != ''";
		}
		
		if (isset($kv['mp3']) && $kv['mp3'] == 1)
		{
		    $where .= " AND s.mp3_master != ''";
		}
		
		$sql = "SELECT
	
				COUNT(*) As total_rows
		
			FROM song s
			WHERE 1=1
	
				AND s.is_deleted = 0
				AND s.created_by = %d
				{$where}
		";
		
		$sql = sprintf($sql, $user_id);
		
		$res = db_query($sql);
	
		return $res;
	}
	
	function songs($user_id = 0, $kv = [], $page = 1, $limit = PAGE_LIMIT)
	{
		$where = '';
		
		if (isset($kv['song_title']) && $kv['song_title'] == 1)
		{
			$where .= " AND s.song_title != ''";
		}
		
		if (isset($kv['singer']) && $kv['singer'] == 1)
		{
			$where .= " AND s.singer != ''";
		}
		
		if (isset($kv['mp3']) && $kv['mp3'] == 1)
		{
			$where .= " AND s.mp3_master != ''";
		}
		
		$sql = "SELECT
				
			s.*,
            (SELECT COUNT(*) FROM song_like WHERE song_id = s.song_id GROUP BY s.song_id) As total_like,
            (SELECT COUNT(*) FROM song_order WHERE song_id = s.song_id AND returncode = 100 GROUP BY s.song_id) As total_order,
            (SELECT COUNT(*) FROM song_download WHERE song_id = s.song_id GROUP BY s.song_id) As total_download
            		
		FROM song s
		WHERE 1=1
			
			AND s.is_deleted = 0
			AND s.created_by = %d
			{$where}
		
		ORDER BY s.created_at DESC
		
		LIMIT ".(($page-1) * $limit).", ".$limit;
		
		$sql = sprintf($sql, $user_id);
		
		$res = db_query($sql);
		
		$res->total_rows = $this->total_songs($user_id, $kv)->row['total_rows'];
		
		return $res;
	}
	
	function song($song_id = 0, $user_id = 0)
	{
	    $sql = "SELECT

            s.*
	    
            FROM song s
            WHERE 1=1
            
                AND s.song_id = %d
                AND s.created_by = %d
                AND s.is_deleted = 0
        ";
	    
	    $sql = sprintf($sql, $song_id, $user_id);
	    
	    $res = db_query($sql);
	    
	    if ($res->num_rows)
	    {
	        foreach ($res->rows as $k => $row)
	        {
	            $res->rows[$k]['photos'] = $this->song_images($song_id, $user_id)->rows;
	        }
	        
	        $res->row = $res->rows[0];
	    }
	    
	    return $res;
	}
	
	function song_images($song_id = 0, $user_id = 0)
	{
	    $sql = "SELECT
	        
            si.song_id,
            si.song_image_id,
            si.dimension
	        
            FROM song_image si
            LEFT JOIN song s ON s.song_id = si.song_id
            WHERE 1=1
	        
                AND si.song_id = %d
                AND si.is_active = 1
                AND s.user_id = %d
        ";
	    
	    $sql = sprintf($sql, $song_id, $user_id);
	    
	    $res = db_query($sql);
	    
	    if ($res->num_rows)
	    {
	        foreach ($res->rows as $k => $row)
	        {
	            $res->rows[$k]['dimension'] = unserialize($res->rows[$k]['dimension']);
	        }
	        
	        $res->row['dimension'] = unserialize($res->row['dimension']);
	    }
	    
	    return $res;
	}
	
	function song_image($song_id = 0, $song_image_id = 0, $user_id = 0)
	{
	    $sql = "SELECT
	        
            si.song_id,
            si.song_image_id,
            si.dimension
	        
            FROM song_image si
            LEFT JOIN song s ON s.song_id = si.song_id
            WHERE 1=1
	        
                AND si.song_id = %d
                AND si.song_image_id = %d
                AND si.is_active = 1
                AND s.user_id = %d
        ";
	    
	    $sql = sprintf($sql, $song_id, $song_image_id, $user_id);
	    
	    $res = db_query($sql);
	    
	    if ($res->num_rows)
	    {
	        foreach ($res->rows as $k => $row)
	        {
	            $res->rows[$k]['dimension'] = unserialize($res->rows[$k]['dimension']);
	        }
	        
	        $res->row['dimension'] = unserialize($res->row['dimension']);
	    }
	    
	    return $res;
	}
	
	/**
	 * Check if this user have a previous success order for a particular song
	 * @param number $song_id
	 * @param number $user_id
	 * @return stdClass
	 */
	
	function have_ordered($song_id = 0, $user_id = 0)
	{
	    $sql = "SELECT
	        
            so.song_order_id,
            s.song_title,
            s.singer
	        
        FROM song s
        LEFT JOIN song_order so ON so.song_id = s.song_id
        WHERE 1=1
	        
            AND so.song_id = %d
            AND so.user_id = %d
            AND so.returncode = 100
        ";
	    
	    $sql = sprintf($sql, $song_id, $user_id);
	    
	    $res = db_query($sql);
	    
	    return $res;
	}
	
	/**
	 * check of a song has a confirmed order from any customer
	 * @param number $song_id
	 * @return stdClass
	 */
	
	function has_order($song_id = 0)
	{
	    $sql = "SELECT
	        
            so.song_order_id
	        
        FROM song_order so
        WHERE 1=1
	        
            AND so.song_id = %d
            AND so.returncode = 100
        ";
	    
	    $sql = sprintf($sql, $song_id);
	    
	    $res = db_query($sql);
	    
	    return $res;
	}
}











