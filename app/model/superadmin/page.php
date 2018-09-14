<?php
class Superadmin_Page
{
    function __construct() {}
    
    function total_pages()
    {
        $sql = "SELECT COUNT(*) As total_rows FROM page WHERE 1=1 AND is_active = 1";
        
        $res = db_query($sql);
        
        return $res;
    }
    
    function pages()
    {
        $sql = "SELECT * FROM page WHERE 1=1 AND is_active = 1";
        
        $res = db_query($sql);
        
        $res->total_rows = $this->total_pages();
        
        return $res;
    }
    
    function page($page_id = 0)
    {
        $sql = "SELECT * FROM page WHERE 1=1 AND page_id = %d AND is_active = 1";
        
        $sql = sprintf($sql, $page_id);
        
        $res = db_query($sql);
        
        return $res;
    }
    
    function seourl($page_seourl = '')
    {
        global $mysqli;
        
        $sql = "SELECT * FROM page WHERE 1=1 AND page_seourl = '%s' AND is_active = 1 LIMIT 1";
        
        $sql = sprintf($sql, mysqli_real_escape_string($mysqli, $page_seourl));
        
        $res = db_query($sql);
        
        return $res;
    }
}