<?php
class Admin_Marketer_Client
{
    function __construct() {}

    function clients($marketer_id = 0)
    {
        $sql = "SELECT

            mc.*,
            u.email,
            ua.usertitle,
            ua.fullname,
            ua.mobile_no
        
        FROM marketer_client mc
        LEFT JOIN user u ON u.user_id = mc.client_id
        LEFT JOIN user_attr ua ON ua.user_id = mc.client_id
        WHERE 1=1

            AND mc.marketer_id = %d
        
        ORDER BY ua.fullname
        ";

        $sql = sprintf($sql, $marketer_id);

        $res = db_query($sql);

        return $res;
    }
    
    function ismine($marketer_id = 0, $client_id = 0)
    {
        $sql = "SELECT

            mc.*,
            ua.usertitle,
            ua.fullname
        
        FROM marketer_client mc
        LEFT JOIN user_attr ua ON ua.user_id = mc.client_id
        WHERE 1=1

            AND mc.marketer_id = %d
            AND mc.client_id = %d

        ";

        $sql = sprintf($sql, $marketer_id, $client_id);

        $res = db_query($sql);

        return $res;
    }
}
