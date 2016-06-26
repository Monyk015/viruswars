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
        var vm = new Vue ({
            el: '#lobby-list',
            data: {
                lobbies: <?= $lobbies ?>
            },
            computed: {
                countsOfPlayers: function ()
                {
                    var counts = new Array (this.lobbies.length);
                    this.lobbies.forEach (function (lobby, index)
                    {
                        counts[index] = {};
                        counts[index]['of'] = lobby.players.length;
                        counts[index]['joined'] = 0;
                        lobby.players.forEach (function (player)
                        {
                            if (player != null)
                                counts[index]['joined']++;
                        });
                    });
                    return counts;
                }
            }
        });
    </script>
@endsection