<?php
require_once '../../vendor/autoload.php';

use Taskforce\Models\Task;


$task = new Task(10,20);

$actionsMap = [
'reply' => 'Откликнуться',
'cancel' => 'Отменить',
'fail' => 'Отказаться',
'done' => 'Выполнено'
];

assert($task->getActionsMap() == $actionsMap);
assert($task->getAvailableActions('executor', 'new') == TASK::ACTION_REPLY, 'Откликнуться на задачу');
assert($task->getNextStatus('reply') == Task::STATUS_WORK, 'Перехо в статус в работе');
