<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AttendanceFilter extends Filter
{
    public function name(string $name = null)
    {
        return !$name ? $this->builder :
            $this->builder->whereHas('user', function (Builder $query) use ($name) {
                $query->where('name', $name);
            });
    }

    public function signin(string $date = null)
    {
        return !$date ? $this->builder :
            $this->builder->whereDate('signin', $date);
    }
}
