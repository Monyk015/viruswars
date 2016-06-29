<?php

namespace App;
use Redis;

class Lobby
{
//    public function creator()
//    {
//        return $this->belongsTo('App\User','creator_id');
//    }
//
//    public function getPlayer(int $number)
//    {
//        return $this->belongsTo('App\User',"player$number".'_id');
//    }
    //lobby15
    //lobby25
    //'lobby'.$id => value
    //
    public $id;
    public $players = [];
    public $creator;
    public $mode;


    public function __construct(array $players = [], User $creator = null,string $mode = 'virus')
    {
        $this->mode = $mode;
        if($this->mode == 'virus')
            $this->players = array_pad($this->players, 4, null);//todo:regulating with config
        foreach($this->players as $key => $value)
            $this->players[$key] = new \stdClass();
        Redis::incr('maxId');
        $this->id = Redis::get('maxId');
        $this->creator = $creator;
        $this->players[0] = $this->creator;
    }

    public static function save(Lobby $lobby)
    {
        if(Redis::zcount('lobbies', $lobby->id,$lobby->id) > 0)//checking if element with current id is already present
            Redis::zremrangebyscore('lobbies', $lobby->id,$lobby->id);//deleting it
        Redis::zadd('lobbies',$lobby->id, serialize($lobby));

    }

    public static function get($lobbyId)
    {
        return unserialize(Redis::zrangebyscore('lobbies',$lobbyId,$lobbyId)[0]);
    }

    public static function delete($lobbyId)
    {
        if(Redis::zremrangebyscore('lobbies', $lobbyId, $lobbyId))
            return 'True';
        return 'False';
    }

    public static function all()
    {
        $all = collect(Redis::zrange('lobbies', 0, -1));
        $all = $all->map(function($item){
            return unserialize($item);
        });
        return $all;
    }

    public static function clear()
    {
        Redis::del('lobbies');
        Redis::del('maxId');
    }
}
