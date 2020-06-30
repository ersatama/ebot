<?php


namespace App\Repositories\bot;

use App\bot;
use Auth;

class botRepositoryEloquent implements botRepositoryInterface
{
    protected $record = 30;

    public function get(int $page = 0) {
        $skip = $page * $this->record;
        return bot::select('id','name')->
        where([
            ['user','=',Auth::id()],
            ['deleted','=',0],
        ])
            ->skip($skip)
            ->take($this->record)
            ->orderByDesc('id')
            ->get();
    }

    public function limit():int
    {

        return intdiv($this->count() , $this->record);

    }

    public function count():int {

        return bot::where([
            ['user','=',Auth::id()],
            ['deleted','=',0],
        ])
            ->count();

    }

}
