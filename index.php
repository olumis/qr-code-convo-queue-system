<?php

/**
 * load configuration file
 * config.php contains database credentials
 */

require_once 'config.php';

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
 * get all scanned students data
 */

function get_scanned_student()
{
    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS);

    mysqli_select_db($mysqli, DB_NAME);

    $sql = "SELECT * FROM student WHERE is_scanned = 1";

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

    mysqli_close($mysqli);

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

    $sql = sprintf($sql, (int)$student_id);

    $res = mysqli_query($mysqli, $sql);

    mysqli_close($mysqli);

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
 * we receive a request to mark this student as 'is_scanned = 1'
 */

if (isset($_POST['update']) && isset($_POST['student_id']) && $_POST['student_id'])
{
    $_POST['student_id'] = (int)$_POST['student_id'];

    mark_student($_POST['student_id']);
}

/**
 * we receive a request to mark all students as 'is_scanned = 0'
 */

if (isset($_POST['reset']))
{
    reset_student();
}

/**
 * load HTML file
 * pass along a variable into the HTML file:
 * - $unscanned_students
 */

$unscanned_students = get_unscanned_student();

require 'template/index.html';
