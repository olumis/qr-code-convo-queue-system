<?php
class Superadmin_Attendance
{
    function __construct() {}

    function students()
    {
        $sql = "SELECT
        
            a.*,
            ua.fullname,
            ua.faculty,
            ua.student_id
        
        FROM attendance a
        LEFT JOIN user_attr ua ON ua.user_id = a.user_id
        WHERE 1=1
        
            AND is_active = 0
        
        ";

        $res = db_query($sql);

        return $res;
    }
}