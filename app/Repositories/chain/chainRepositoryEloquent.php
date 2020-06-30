<?php


namespace App\Repositories\chain;

use App\chain;

class chainRepositoryEloquent implements chainRepositoryInterface
{
    public function countByBotId(int $bot) {

        return chain::where([
            ['bot','=',$bot],
            ['deleted','=',0]
        ])
            ->count();
    }
}
