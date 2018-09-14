<?php

/**
 * auto create
 */

mysqli_autocommit($mysqli, false);

try
{
    $time = time();
    
    $page = [
        'page_name'     => '',
        'page_content'  => '',
        'page_seourl'   => '',
        'created_at'    => date('Y-m-d H:i:s', $time),
        'is_active'     => 0
    ];
    
    db_insert('page', $page);
    
    $page_id = mysqli_insert_id($mysqli);
    
    mysqli_commit($mysqli);
    
    redirect(u('/superadmin/page/edit?page_id=%d', $page_id));
}

catch(Exception $e)
{
    mysqli_rollback($mysqli);
    
    $_SESSION['error'][] = $e->getMessage();
}

redirect(u('/superadmin/page'));
