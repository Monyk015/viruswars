@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Lobby</div>
                    <div class="panel-body">
                        <ul class="list-group" id="player-list">
                            <li class="list-group-item" v-for="(index,player) in players">
                                <div class="btn" v-if="player.name">
                                    @{{player.name}}
                                </div>
                                <div v-on:click="joinSlot(index)" class="btn btn-link" v-if="player.name == null">
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
                    },
                    methods: {
                        joinSlot: function (index)
                        {
                            $.get ('/lobby/' + vm.lobbyId + '/join/' + index, function (data)
                            {
                                if (data != 'True')
                                    alert ('Error joining slot');
                            });
                        }
                    },
                    ready: function()  {
                            let socket = io ('192.168.10.10:3000');
                            socket.on ('lobby-channel:' + 'App\\Events\\UserJoinsSlot', function (data)
                            {
                                if (vm.lobbyId == data['lobbyId'])
                                    vm.players.$set(data['slotId'],data['user']);
                                //vm.players.reverse().reverse();
                            });
                            socket.on ('lobby-channel:' + 'App\\Events\\UserLeavesSlot', function (data)
                            {
                                if (vm.lobbyId == data['lobbyId'])
                                    vm.players.$set(data['slotId'],{});//vm.$set('players', data['players']);
                                //vm.players.reverse().reverse();
                            });
                        }
                })
                ;
    </script>
    <script src="../js/lobby/show.js"></script>
@endsection