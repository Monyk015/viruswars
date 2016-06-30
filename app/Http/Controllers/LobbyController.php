<?php

namespace App\Http\Controllers;

use App\Events\LobbyIsCreated;
use App\Events\LobbyIsDestroyed;
use App\Events\UserJoinsSlot;
use App\Events\UserLeavesSlot;
use App\Lobby;
use Illuminate\Http\Request;

use App\Http\Requests;

class LobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //dd(route('lobby.create'));
        $this->middleware('auth');
    }

    public function index()
    {
        return view('lobby.index', ['lobbies' => Lobby::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $creator = $request->user();
        $lobby = new Lobby();
        $lobby->creator = $creator;
        $lobby->players[0] = $creator;
        Lobby::save($lobby);
        event(new LobbyIsCreated($creator,$lobby));
        return redirect(route('lobby.show', ['lobby' => $lobby->id]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $lobbyId
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $lobbyId)
    {
        $user = $request->user();
        $lobby = Lobby::get($lobbyId);
        $data = (array)$lobby;
        return view('lobby.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $user = $request->user();
        event(new LobbyIsDestroyed($user, $id));
        return Lobby::delete($id);
    }

    
    /**
 * @param $lobbyId
 * @param $slotId
 * @param Request $request
 * @return string
 */

    public function kickPlayer($lobbyId, $slotId, Request $request)
    {
        $user = $request->user();
        $lobby = Lobby::get($lobbyId);
        if($lobby->creator['id'] != $user['id'])
            return 'No way';
        $this->leaveSlot($lobbyId,$slotId,$request);
        return 'True';
    }

    /**
     * @param $lobbyId
     * @param Request $request
     * @return string
     */
    public function leave($lobbyId, Request $request)
    {
        $user = $request->user();
        $players = collect(Lobby::get($lobbyId)->players);
        $slotId = $players->search(function($player) use ($user) {
            return get_class($player) != 'stdClass' && $player['id'] == $user['id'];
        });
        $this->leaveSlot($lobbyId,$slotId,$request);
        return 'True';
    }

    public function leaveSlot($lobbyId, $slotId, Request $request)
    {
        $user = $request->user();
        $lobby = Lobby::get($lobbyId);
        //dd($lobby->players[$slotId]);
        if (get_class($lobby->players[$slotId]) == 'stdClass')
            return 'Slot is already free';
        $lobby->players[$slotId] = new \stdClass();
        Lobby::save($lobby);
        event(new UserLeavesSlot($user, $lobbyId, $slotId));
    }

    public function joinSlot($lobbyId, $slotId, Request $request)
    {
        $user = $request->user();
        $lobby = Lobby::get($lobbyId);
        if (get_class($lobby->players[$slotId]) != 'stdClass')
            return 'Slot is busy';
        array_walk($lobby->players, function (&$player, $index) use ($request, $user, $lobbyId, $slotId)
        {
            if (get_class($player) != 'stdClass' && $player['id'] == $user['id'])
                $this->leaveSlot($lobbyId, $index, $request);
        });
        $lobby = Lobby::get($lobbyId);//fetching same lobby again after possible leaving of slot
        $lobby->players[$slotId] = $user;
        Lobby::save($lobby);
        event(new UserJoinsSlot($user, $lobbyId, $slotId));
        return 'True';
    }
}
