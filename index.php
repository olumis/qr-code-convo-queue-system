<?php

/**
 * load configuration file
 * config.php contains database credentials
 */

require_once 'config.php';

/**
 * zmq
 */

$context = new ZMQContext();

$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'index');

$socket->connect("tcp://localhost:5555");

/**
 * function to
 * get all unscanned students data
 */

function get_unscanned_student()
{
    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS);

    mysqli_select_db($mysqli, DB_NAME);

    $sql = "SELECT * FROM student WHERE is_scanned = 0";

    $res = mysqli_query($mysqli, $sql);

    mysqli_close($mysqli);

    if (is_object($res) && get_class($res) == 'mysqli_result')
    {
        $students = [];

        while ($row = mysqli_fetch_assoc($res))
        {
            $students[] = $row;
        }
    }

    return $students;
}

/**
 * function to
 * mark this student as is_scanned = 1
 */

function mark_student($student_id)
{
    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS);

    mysqli_select_db($mysqli, DB_NAME);

    $sql = "UPDATE student SET is_scanned = 1 WHERE student_id = %d";

    $sql = sprintf($sql, (int)$student_id);

    $res = mysqli_query($mysqli, $sql);

    if ($res === true)
    {
        return mysqli_affected_rows($mysqli);
    }
    else
    {
        throw new Exception(mysqli_error($mysqli));
    }
}

/**
 * function to
 * mark all students as 'is_scanned = 0'
 */

function reset_student()
{
    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS);

    mysqli_select_db($mysqli, DB_NAME);

    $sql = "UPDATE student SET is_scanned = 0";

    $res = mysqli_query($mysqli, $sql);

    if ($res === true)
    {
        return mysqli_affected_rows($mysqli);
    }
    else
    {
        throw new Exception(mysqli_error($mysqli));
    }
}

/**
 * function to
 * get one student info
 */

function student_info($student_id)
{
    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS);

    mysqli_select_db($mysqli, DB_NAME);

    $sql = "SELECT * FROM student WHERE student_id = %d";

    $sql = sprintf($sql, (int)$student_id);

    $res = mysqli_query($mysqli, $sql);

    mysqli_close($mysqli);

    if (is_object($res) && get_class($res) == 'mysqli_result')
    {
        $students = [];

        while ($row = mysqli_fetch_assoc($res))
        {
            $students[] = $row;
        }
    }

    /** return one result from db or empty array */

    return isset($students[0]) ? $students[0] : [];
}

/**
 * we receive a request to mark this student as 'is_scanned = 1'
 */

if (isset($_POST['update']) && isset($_POST['student_id']) && $_POST['student_id'])
{
    $_POST['student_id'] = (int)$_POST['student_id'];

    $status = mark_student($_POST['student_id']);

    /**
     * send a real time response to the browser via websocket
     */

    $json = [
        'id'        => 'mark.student',
        'msg'       => 'Student marked as scanned',
        'data'      => get_unscanned_student(),
        'active'    => student_info($_POST['student_id'])
    ];
    
    $socket->send(json_encode($json));

    exit();
}

/**
 * we receive a request to mark all students as 'is_scanned = 0'
 */

if (isset($_POST['reset']))
{
    $status = reset_student();

    /**
     * send a real time response to the browser via websocket
     */

    $json = [
        'id'   => 'reset.student',
        'msg'  => 'Student list has been reset'
    ];
    
    $socket->send(json_encode($json));

    exit();
}

/**
 * finally, we load our HTML file
 * pass along a variable into the HTML file:
 * - $unscanned_students
 */

$unscanned_students = get_unscanned_student();

require 'template/index.html';
