$(() => {
    let socket = io ('192.168.10.10:3000');
    socket.on('lobby-channel:'+'App\\Events\\UserJoinsSlot', function (data)
    {
        if(vm.lobbyId == data['lobbyId'])
            vm.players[data['slotId']] = data['user'];
    });
    vm.methods = {
        
    }
});