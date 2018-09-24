<?php

$faculties = load_model('lists')->get('faculty')->rows;

$contents = file('resource/tcp1241_assign_tutorial_sept11.csv');

$contents = array_map('trim', $contents);

$contents = array_map(function($v)
{
    return [
        'fullname'      => explode(',',$v)[2],
        'student_id'    => explode(',',$v)[1]
    ];

}, $contents);

shuffle($contents);

$students = [];

foreach ($faculties as $faculty)
{
    $three = [];

    foreach ($contents as $k => $content)
    {
        if (count($three) < 3)
        {
            $three[] = [
                'fullname'      => $content['fullname'],
                'faculty'       => $faculty['name'],
                'student_id'    => $content['student_id']
            ];

            array_shift($contents);
        }
        else break;
    }

    $students[] = $three;
}


print_r($students);
