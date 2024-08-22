<?php

namespace App\Enums;
enum TaskStatus: string
{

    case RUNNING ='running';
    case POSTPONED = 'postponed';
    case DONE = 'done';
    public function isRunning(): bool
    {
        return $this === self::RUNNING;
    }
    public function isPostponed(): bool
    {
        return $this === self::POSTPONED;
    }
    public function isDone(): bool
    {
        return $this === self::DONE;
    }

    public function getLabelText(): string
    {
        return match($this){
            self::RUNNING => 'در حال انجام',
            self::POSTPONED => 'به تعویق افتاده',
            self::DONE => 'کامل شده',
        };
    }

}
