<?php
class Admin_Song_Download
{
    function __construct() {}
    
    function total_download($song_id = 0)
    {
        $sql = "SELECT
            
            COUNT(*) As total_rows
            
        FROM song_download sd
        WHERE 1=1
            
            AND sd.song_id = %d

        GROUP BY sd.song_id

        ";
        
        $sql = sprintf($sql, $song_id);
        
        $res = db_query($sql); 
        
        return $res;
    }
    
    /**
     * get mp3 master 
     * @param number $song_id
     * @param number $user_id
     * @return stdClass
     */
    
    function my_download($song_id = 0, $user_id = 0)
    {
        $sql = "SELECT
            
            s.song_id,
            so.user_id,
            s.mp3_master,
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
}