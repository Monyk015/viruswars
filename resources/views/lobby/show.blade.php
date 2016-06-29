@extends('layouts.app')

@section('content')
    <div class="container" id="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Lobby</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="(index,player) in players">
                                <div v-if="player.name">
                                    <div class="btn">
                                        @{{player.name}}
                                    </div>
                                    <div v-on:click="kickPlayer(index)" class="kick-player-button" v-if="user['id'] == creator['id'] && player['id'] != user['id']">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div v-on:click="joinSlot(index)" class="btn btn-link" v-if="player.name == null">
                                    Join slot.
                                </div>
                            </li>
                        </ul>
                        <div class="leave-or-destroy-button btn btn-default" v-on:click="destroyLobby" v-if="user['id'] == creator['id']">Destroy lobby</div>
                        <div class="leave-or-destroy-button btn btn-default" v-on:click="leaveLobby" v-else>Leave lobby</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let bag = {
            lobbyId: <?= json_encode($id) ?>,
            mode: <?= json_encode($mode) ?>,
            creator: <?= json_encode($creator) ?>,
            players: <?= json_encode($players) ?>,
            user: <?= json_encode(Auth::user()) ?>
        };

    </script>
    <script src="../js/lobby/show.js"></script>
@endsection