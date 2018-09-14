<?php
class Admin_Song_Order
{
    function __construct() {}
    
    function total_my_orders($user_id = 0)
    {
        $sql = "SELECT
            
            COUNT(*) As total_rows
            
        FROM song_order so
        LEFT JOIN song s ON s.song_id = so.song_id
        WHERE 1=1
            
            AND so.user_id = %d
            AND so.is_canceled = 0
            AND so.returncode = 100
            
        ";
        
        $sql = sprintf($sql, $user_id);
        
        $res = db_query($sql);
        
        return $res;
    }
    
    
    function my_orders($user_id = 0)
    {
        $sql = "SELECT
            
            so.*,
            s.*
            
        FROM song_order so
        LEFT JOIN song s ON s.song_id = so.song_id
        WHERE 1=1

            AND so.user_id = %d
            AND so.is_canceled = 0
            AND so.returncode = 100

        ORDER by s.singer, so.song_order_id DESC
            
        ";
        
        $sql = sprintf($sql, $user_id);
        
        $res = db_query($sql);
        
        if ($res->num_rows)
        {
            foreach ($res->rows as $k => $row)
            {
                $res->rows[$k]['form_post'] = unserialize($res->rows[$k]['form_post']);
                
                $res->rows[$k]['form_post']['ord_totalamt'] = number_format($res->rows[$k]['form_post']['ord_totalamt'], 2, '.', '');
                
            }
            
            $res->row['form_post'] = unserialize($res->row['form_post']);
            
            $res->row['form_post']['ord_totalamt'] = number_format($res->row['form_post']['ord_totalamt'], 2, '.', '');
            
        }
        
        $res->total_rows = $this->total_my_orders($user_id)->row['total_rows'];
        
        return $res;
    }
    
    function my_order($song_order_id = 0, $user_id = 0)
    {
        $sql = "SELECT

            so.*,
            s.*

        FROM song_order so
        LEFT JOIN song s ON s.song_id = so.song_id
        WHERE 1=1
        
            AND so.song_order_id = %d
            AND so.user_id = %d
            AND so.is_canceled = 0
        ";
        
        $sql = sprintf($sql, $song_order_id, $user_id);
        
        $res = db_query($sql);
        
        if ($res->num_rows)
        {
            $res->rows[0]['form_post'] = unserialize($res->rows[0]['form_post']);
            
            $res->row['form_post'] = unserialize($res->row['form_post']);
            
            /**
             * format ord_totalamt
             */
            
            $res->rows[0]['form_post']['ord_totalamt'] = number_format($res->rows[0]['form_post']['ord_totalamt'], 2, '.', '');
            
            $res->row['form_post']['ord_totalamt'] = number_format($res->row['form_post']['ord_totalamt'], 2, '.', '');
        }
        
        return $res;
    }
    
    /**
     * because fan orders are under song section
     * the sql will be based on $song_id instead of $song_order_id
     * @param number $song_id
     * @param number $song_owner_id
     * @return stdClass
     */
    
    function fan_orders($song_id = 0, $song_owner_id = 0)
    {
        $sql = "SELECT

            so.*,
            sop.is_paid,
            s.song_title,
            s.singer,
            u.email,
            ua.usertitle,
            ua.fullname,
            ua.mobile_no

        FROM song_order so
        LEFT JOIN song_order_payment sop ON sop.song_order_id = so.song_order_id
        LEFT JOIN song s ON s.song_id = so.song_id
        LEFT JOIN user u ON u.user_id = so.user_id
        LEFT JOIN user_attr ua ON ua.user_id = so.user_id
        WHERE 1=1

            AND so.song_id = %d
            AND s.created_by = %d
            AND so.returncode = 100

        ";
        
        $sql = sprintf($sql, $song_id, $song_owner_id);
        
        $res = db_query($sql);
        
        return $res;
    }
    
    function is_paid($song_id = 0, $user_id = 0)
    {
        $sql = "SELECT
            
            so.song_order_id
            
        FROM song_order so
        WHERE 1=1
            
            AND so.song_id = %d
            AND so.user_id = %d
            AND so.returncode = 100
            
        ";
        
        $sql = sprintf($sql, $song_id, $user_id);
        
        $res = db_query($sql);
        
        return $res;
    }
}





