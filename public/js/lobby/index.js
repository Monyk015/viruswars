/**
 * Created by Monyk on 30.06.2016.
 */
var vm = new Vue({
    el: '#lobby-list',
    data: {
        lobbies: bag['lobbies']
    },
    computed: {
        countsOfPlayers: function()
        {
            var counts = new Array(this.lobbies.length);
            this.lobbies.forEach(function(lobby, index)
            {
                counts[index] = {};
                counts[index]['of'] = lobby.players.length;
                counts[index]['joined'] = 0;
                lobby.players.forEach(function(player)
                {
                    if(player.name != null)
                        counts[index]['joined']++;
                });
            });
            return counts;
        }
    },
    ready: function()
    {
        let socket = io('192.168.10.10:3000');

        socket.on('lobby-channel:' + 'App\\Events\\LobbyIsCreated', function(data)
        {
            vm.lobbies.push(data['lobby']);
        });

        socket.on('lobby-channel:' + 'App\\Events\\LobbyIsDestroyed', function(data)
        {
            let index = vm.lobbies.findIndex((lobby) => {
                return lobby['id'] == data['lobbyId'];
            });
            vm.lobbies.splice(index, 1);
        });

        socket.on('lobby-channel:' + 'App\\Events\\UserJoinsSlot', function(data)
        {
            let index = vm.lobbies.findIndex((lobby) => {
               return lobby['id'] == data['lobbyId'];
            });
            let lobby = vm.lobbies[index];
            lobby.players.$set(data['slotId'], data['user']);
            vm.lobbies.$set(index, lobby);
        });

        socket.on('lobby-channel:' + 'App\\Events\\UserLeavesSlot', function(data)
        {
            let index = vm.lobbies.findIndex((lobby) => {
                return lobby['id'] == data['lobbyId'];
            });
            let lobby = vm.lobbies[index];
            lobby.players.$set(data['slotId'],{});
            vm.lobbies.$set(index, lobby);
        });
    }
});