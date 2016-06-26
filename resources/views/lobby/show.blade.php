@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Lobby</div>
                    <div class="panel-body">
                        <ul class="list-group" id="player-list">
                            <li class="list-group-item" v-for="player in players">
                                <div class="btn"  v-if="player.name">
                                    @{{player.name}}
                                </div>
                                <div class="btn btn-link" v-if="!player">
                                    Join slot.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var vm = new Vue ({
            el: '#player-list',
            data: {
                lobbyId: <?= json_encode($id) ?>,
                mode: <?= json_encode($mode) ?>,
                creator: <?= json_encode($creator) ?>,
                players: <?= json_encode($players) ?>
            }
        });
    </script>
    <script src="../js/lobby/show.js"></script>
@endsection