<?php


namespace App\Repositories\message;

use App\message;

class messageRepositoryEloquent implements messageRepositoryInterface
{
    public function store(int $bot, int $index, string $chat) {
        $ms = new message;
        $ms->bot   = $bot;
        $ms->index = $index;
        $ms->chat  = $chat;
        $ms->save();
    }

    public function getByBotIdAndChatId(int $bot, string $chat) {
        return message::where([
            ['bot','=',$bot],
            ['chat','=',$chat]
        ])
        ->orderByDesc('id')
        ->first();
    }
}
