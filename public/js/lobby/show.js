$(() =>
{
    vm = new Vue({
        el: '#container',
        data: {
            lobbyId: bag['lobbyId'],
            mode: bag['mode'],
            creator: bag['creator'],
            players: bag['players'],
            creatorRights: bag['creatorRights'],
            user: bag['user']
        },
        methods: {
            joinSlot: function(index)
            {
                $.get('/lobby/' + vm.lobbyId + '/join/' + index, function(data)
                {
                    if(data != 'True')
                        alert('Error joining slot');
                });
            },
            kickPlayer: function(index)
            {
                $.get('/lobby/' + vm.lobbyId + '/kick/' + index, function(data)
                {
                    if(data != 'True')
                        alert('Error kicking player');
                })
            },
            destroyLobby: function()
            {
                $.ajax({
                    'url': '/lobby/' + vm.lobbyId,
                    'type': 'DELETE',
                    'success': function(data)
                    {
                        if(data != 'True')
                            alert('Error destroying lobby');
                        else
                            window.location.replace('/lobby');
                    }
                });
            },
            leaveLobby: function()
            {
                $.get('/lobby/' + vm.lobbyId + '/leave/', function(data)
                {
                    if(data != 'True')
                        alert('Error leaving lobby');
                    else
                        window.location.replace('/lobby');
                });
            }
        },
        ready: function()
        {
            let socket = io('192.168.10.10:3000');
            socket.on('lobby-channel:' + 'App\\Events\\UserJoinsSlot', function(data)
            {
                if(vm.lobbyId == data['lobbyId'])
                    vm.players.$set(data['slotId'], data['user']);
            });
            socket.on('lobby-channel:' + 'App\\Events\\UserLeavesSlot', function(data)
            {
                if(vm.lobbyId == data['lobbyId'])
                    vm.players.$set(data['slotId'], {});
            });
            $.ajaxSetup({
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
    });

});