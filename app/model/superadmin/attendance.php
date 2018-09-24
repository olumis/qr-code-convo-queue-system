<?php
class Superadmin_Attendance
{
    function __construct() {}
    
    function total_students()
    {
        $sql = "SELECT
        
            COUNT(*) As total_rows
        
        FROM attendance a
        LEFT JOIN user u ON u.user_id = a.user_id
        WHERE 1=1
        
            AND u.is_active = 1

        ";

        $res = db_query($sql);

        return $res;
    }

    function students()
    {
        $sql = "SELECT
        
            a.*,
            ua.fullname,
            ua.student_id
        
        FROM attendance a
        LEFT JOIN user u ON u.user_id = a.user_id
        LEFT JOIN user_attr ua ON ua.user_id = a.user_id
        WHERE 1=1
        
            AND a.is_active = 0
            AND u.is_active = 1
        
        ORDER BY a.created_at ASC, ua.faculty ASC
        
        ";

        $res = db_query($sql);

        return $res;
    }

    function student($user_id = 0)
    {
        $sql = "SELECT
        
            a.*,
            ua.fullname,
            ua.student_id
        
        FROM attendance a
        LEFT JOIN user u ON u.user_id = a.user_id
        LEFT JOIN user_attr ua ON ua.user_id = a.user_id
        WHERE 1=1
        
            AND a.is_active = 1
            AND a.user_id = %d
            AND u.is_active = 1
        
        LIMIT 1
        
        ";

        $sql = sprintf($sql, $user_id);

        $res = db_query($sql);

        return $res;
    }
}