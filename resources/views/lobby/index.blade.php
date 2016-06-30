@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Lobbies</div>
                    <div class="panel-body">
                        <ul class="list-group" id="lobby-list" v-show="lobbies.length > 0">
                            <li class="list-group-item" v-for="(index,lobby) in lobbies">
                                <a href="{{url('lobby')}}/@{{ lobby.id }}">@{{ lobby.creator.name }}
                                    (@{{ countsOfPlayers[index]['joined']}}/@{{ countsOfPlayers[index]['of']}})</a>
                            </li>
                        </ul>
                        <a href="{{url('/lobby/create')}}">Create new lobby</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let bag = {
            lobbies: <?= $lobbies ?>
        };
    </script>
    <script src="../js/lobby/index.js"></script>
@endsection