<?php

namespace App\Enums;
enum TaskPriority: string
{
    case HIGH = 'high';
    case MEDIUM = 'medium';
    case LOW = 'low';


    public function isHigh(): bool
    {
        return $this === self::HIGH;
    }

    public function isMedium(): bool
    {
        return $this === self::MEDIUM;
    }

    public function isLow(): bool
    {
        return $this === self::LOW;
    }

    public function getLabelText(): string
    {
        return match($this){
            self::HIGH => 'بالا',
            self::MEDIUM => 'متوسط',
            self::LOW => 'پایین',
        };
    }
}
