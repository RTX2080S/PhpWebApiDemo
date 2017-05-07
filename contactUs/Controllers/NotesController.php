<?php

require '../Models/NoteMailer.php';

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if (isset($request->action) && !empty($request->action)) {
    $action = $request->action;
    switch ($action) {
        case 'leaveNote' :
            if (isset($request->action)) {
                leaveNote($request->content);
            } else {
                echo 2;
            }
            break;
    }
}

function leaveNote($content) {
    $mailer = new NoteMailer($content);

    echo $mailer->Send();
    return true;
}
