<?php
class Admin_Song_Order_Payment
{
    function __construct() {}
    
    function total_payments($owner_id = 0)
    {
        $sql = "SELECT
            
            COUNT(*) total_rows
            
        FROM song_order_payment sop
        LEFT JOIN song_order so ON so.song_order_id = sop.song_order_id
        LEFT JOIN song s ON s.song_id = so.song_id
        WHERE 1=1
            
            AND sop.owner_id = %d
            AND so.returncode = 100
            
        ";

        $sql = sprintf($sql, $owner_id);
        
        $res = db_query($sql);
        
        return $res;
    }

    function total_pending_payments($owner_id = 0)
    {
        $sql = "SELECT
            
            COUNT(*) total_rows
            
        FROM song_order_payment sop
        LEFT JOIN song_order so ON so.song_order_id = sop.song_order_id
        LEFT JOIN song s ON s.song_id = so.song_id
        WHERE 1=1
            
            AND sop.owner_id = %d
            AND so.returncode = 100
            AND sop.is_paid = 0
            
        ";

        $sql = sprintf($sql, $owner_id);
        
        $res = db_query($sql);
        
        return $res;
    }
    
    function payments($owner_id = 0)
    {
        $sql = "SELECT

            sop.*,
            so.*,
            s.*,
            (SELECT usertitle FROM user_attr WHERE user_id = sop.owner_id) As owner_usertitle,
            (SELECT fullname FROM user_attr WHERE user_id = sop.owner_id) As owner_fullname,
            (SELECT usertitle FROM user_attr WHERE user_id = sop.buyer_id) As buyer_usertitle,
            (SELECT fullname FROM user_attr WHERE user_id = sop.buyer_id) As buyer_fullname,
            (SELECT email FROM user WHERE user_id = sop.buyer_id) As buyer_email,
            (SELECT mobile_no FROM user_attr WHERE user_id = sop.buyer_id) As buyer_mobile_no

        FROM song_order_payment sop
        LEFT JOIN song_order so ON so.song_order_id = sop.song_order_id
        LEFT JOIN song s ON s.song_id = so.song_id
        WHERE 1=1

            AND sop.owner_id = %d
            AND so.returncode = 100

        ";

        $sql = sprintf($sql, $owner_id);
        
        $res = db_query($sql);
        
        return $res;
    }
    
    /**
     * get one payment record
     * @param number $song_order_payment_id
     * @return stdClass
     */
    
    function one($song_order_payment_id = 0)
    {
        $sql = "SELECT
            
            sop.*,
            so.*,
            s.*,
            (SELECT usertitle FROM user_attr WHERE user_id = sop.owner_id) As owner_usertitle,
            (SELECT fullname FROM user_attr WHERE user_id = sop.owner_id) As owner_fullname,
            (SELECT usertitle FROM user_attr WHERE user_id = sop.buyer_id) As buyer_usertitle,
            (SELECT fullname FROM user_attr WHERE user_id = sop.buyer_id) As buyer_fullname
            
        FROM song_order_payment sop
        LEFT JOIN song_order so ON so.song_order_id = sop.song_order_id
        LEFT JOIN song s ON s.song_id = so.song_id
        WHERE 1=1
            
            AND so.returncode = 100
            AND sop.song_order_payment_id = %d
            
        ";
        
        $sql = sprintf($sql, $song_order_payment_id);
        
        $res = db_query($sql);
        
        return $res;
    }
}



