<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Traits\HasRules;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Morilog\Jalali\CalendarUtils;

class Task extends Model
{
    use HasFactory , HasRules;

    protected $fillable=[
        'title',
        'explain',
        'end_date',
        'priority',
        'status',
    ];

    protected $casts=[
      'status'=>TaskStatus::class,
      'priority'=>TaskPriority::class,
    ];

    public static function rules()
    {
        return [
            'title' => ['required'],
            'explain' => ['nullable','max:255'],
            'end_date' => ['required'],
            'priority' => [Rule::enum(TaskPriority::class)],
            'status' => [Rule::enum(TaskStatus::class)],
        ];
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => CalendarUtils::strftime('Y/m/d', strtotime($value)),
            set: fn (string $value) => CalendarUtils::createCarbonFromFormat('Y/m/d',$value)->format('Y-m-d H:i'),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
