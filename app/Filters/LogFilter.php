<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class LogFilter extends Filter
{

    public function userIds(array $ids = [])
    {
        if (!empty($ids)) {
            $this->builder->whereHas('user', function (Builder $query) use ($ids) {
                $query->whereIn('id', $ids);
            });
        }
    }

    public function createdFrom(string $dateTime = null)
    {
        if ($dateTime) {
            $dateTime = Carbon::parse($dateTime);
            $this->builder->whereDate('created_at', '>=', $dateTime)
                ->whereTime('created_at', '>=', $dateTime->format('H:i'));
        }
    }

    public function createdTo(string $dateTime = null)
    {
        if ($dateTime) {
            $dateTime = Carbon::parse($dateTime);
            $this->builder->whereDate('created_at', '<=', $dateTime)
                ->whereTime('created_at', '<=', $dateTime->format('H:i'));
        }
    }
}
