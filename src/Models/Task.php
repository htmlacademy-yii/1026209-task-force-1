<?php

namespace Taskforce\Models;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCEL = 'cancelled';
    const STATUS_WORK = 'work';
    const STATUS_FAILED = 'failed';
    const STATUS_DONE = 'done';

    const ACTION_REPLY = 'reply';
    const ACTION_CANCEL = 'cancel';
    const ACTION_FAIL = 'fail';
    const ACTION_DONE = 'done';

    const CUSTOMER = 'customer';
    const EXECUTOR = 'executor';

    private string $status;

    private int $executor_id;
    private int $customer_id;

    public function __construct($executor_id, $customer_id)
    {
        $this->executor_id = $executor_id;
        $this->customer_id = $customer_id;
        $this->status = 'new';
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public static function getStatusesMap()
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCEL => 'Отменено',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_WORK => 'На выполнении',
            self::STATUS_FAILED => 'Провалено'
        ];
    }

    public static function getActionsMap()
    {
        return [
            self::ACTION_REPLY => 'Откликнуться',
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_FAIL => 'Отказаться',
            self::ACTION_DONE => 'Выполнено',
        ];
    }

    public static function getNextStatus(string $action)
    {
        $actionStatuses = [
            self::ACTION_REPLY => self::STATUS_WORK,
            self::ACTION_CANCEL => self::STATUS_CANCEL,
            self::ACTION_FAIL => self::STATUS_FAILED,
            self::ACTION_DONE => self::STATUS_DONE
        ];
        return $actionStatuses[$action];
    }

    public static function getAvailableActions(string $role, string $status)
    {
        $actionsMap = [
            self::EXECUTOR => [
                self::STATUS_NEW => self::ACTION_REPLY,
                self::STATUS_WORK => self::ACTION_FAIL
            ],
            self::CUSTOMER => [
                self::STATUS_NEW => self::ACTION_CANCEL,
                self::STATUS_WORK => self::STATUS_DONE
            ]
        ];
        return $actionsMap[$role][$status] ?? [];
    }
}

