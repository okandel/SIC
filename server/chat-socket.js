'use strict';
const axios = require('axios').default;

class ChatSocket {
    constructor(socket) {
        this.io = socket;
        this.online_users = [];
        this.status = '';
    }

    online_sockets() {
        // console.log("========== online_sockets ===============");
        // console.log(this.io.of('/chat').sockets);
        // console.log("=========================");
        // console.log(Object.keys(this.io.of('/chat').sockets));
        // console.log("=========================");
        return Object.keys(this.io.of('/chat').sockets);
    }

    ioConfig() {
        this.io.of('/chat').use((socket, next) => {


            socket['id'] = 'user_' + socket.handshake.query.user_id;

            if (socket.handshake.query.my_list !== '' || socket.handshake.query.my_list !== 'undefined') {
                socket['my_friends'] = socket.handshake.query.my_list.split(',');
            } else {
                socket['my_friends'] = [];
            }

            if (socket.handshake.query.username !== '' || socket.handshake.query.username !== 'undefined') {
                socket['username'] = socket.handshake.query.username;
            } else {
                socket['username'] = [];
            }

            if (socket.handshake.query.status !== '' || socket.handshake.query.status !== 'undefined') {
                socket['status'] = socket.handshake.query.status;
            } else {
                socket['status'] = 'online';
            }
            console.log(socket.id);
            next();
        })
    }

    online(user_id) {
        return this.online_users.indexOf(user_id) !== -1;
    }

    emit(user_id, name, data) {
        if (this.online(user_id)) {
            this.io.of('/chat').sockets[user_id].emit(name, data);
        }
    }

    emit_from(use_type, from, user_id, name, data) {
        if (use_type === "online" && this.online(from)) {
            this.io.of('/chat').sockets[user_id].emit(name, data);
        } else if (use_type === "offline" && !this.online(from)) {
            this.io.of('/chat').sockets[user_id].emit(name, data);
        }
    }

    chatSocketConnection() {
        this.ioConfig();
        this.io.of('/chat').on('connection', (socket) => {
            this.online_users = this.online_sockets();

            this.check_online(socket);
            this.response_status(socket);
            this.user_status(socket);
            this.private_message(socket); // Send private message from user to user
            this.broadcast_private(socket);
            // this.request_messages(socket);
            this.socketDisconnect(socket); // Disconnect User List
        });
    }

    check_online(socket) {
        socket.on('check_online', (data) => {
            // tell other users that i'am online
            this.emit(data.user_id, 'iam_online', {user_id: socket.id, status: socket.status});
            this.emit(data.user_id, 'request_status', {user_id: socket.id});

            this.emit_from('online', data.user_id, socket.id, 'is_online', {user_id: data.user_id, status: 'online'});
            this.emit_from('offline', data.user_id, socket.id, 'is_online', {user_id: data.user_id, status: 'offline'});
        });
    }

    user_status(socket) {
        // change user status
        socket.on('change_status', (data) => {
            var my_friends = socket.my_friends;
            if (my_friends.length > 0) {
                my_friends.forEach((user) => {
                    this.emit('user_' + user, 'new_status', {user_id: socket.id, status: data.status});
                })
            }
        });
    }

    response_status(socket) {
        socket.on('response_status', (data) => {
            this.emit(data.to_user, 'is_online', {status: data.my_status, user_id: socket.id});
        });
    }

    broadcast_private(socket) {
        socket.on('broadcast_private', (data) => {
            this.emit(data.to, 'new_broadcast', {from: socket.id, to: data.to, username: data.username});
        });
    }

    private_message(socket) {
        socket.on('send_private_msg', (data) => {
            //store message
            async function makeRequest() {
                try {
                    console.log(data.EmployeeId);
                    var _EmployeeId = data.EmployeeId.split('_');
                    // var _ClientRepId = data.ClientRepId.split('_');
                    const config = {
                        method: 'post',
                        url: 'http://localhost:6001/api/employee/chat/store-message',
                        data: {
                            UserId: data.UserId,
                            EmployeeId: _EmployeeId[1],
                            // ClientRepId: _ClientRepId,
                            MissionId: data.MissionId,
                            from_entry_type: data.from_entry_type,
                            GroupId: data.GroupId,
                            message: data.message
                        },
                        headers: {
                            'Content-Type': 'application/json',
                            'x-auth-token': '3a62f4437cf8208c3a5dda16daf0cb29',
                            'x-lang-code': 'en-us',
                            'x-user-type': '0',
                        },
                    };
                    let res = await axios(config);
                    console.log(res.data);
                } catch (e) {
                    console.log(e);
                }
            }

            //send message to my chat
            this.emit(socket.id, 'new_private_msg', {
                username: socket.username,
                from_uid: data.to,
                who_is: socket.id,
                message: data.message,
            });
            makeRequest();

            //send message to the other user
            this.emit(data.to, 'new_private_msg', {
                username: socket.username,
                from_uid: socket.id,
                who_is: socket.id,
                message: data.message
            });
        })
    }

    // request_messages(socket) {
    //     socket.on('request_messages', (data) => {
    //         //get messages
    //
    //         async function makeRequest() {
    //             try {
    //                 const config = {
    //                     method: 'post',
    //                     url: 'http://localhost:6001/api/employee/chat/get-messages',
    //                     data: {
    //                         UserId: data.UserId,
    //                         EmployeeId: data.EmployeeId
    //                     },
    //                     headers: {
    //                         'Content-Type': 'application/json',
    //                         'x-auth-token': '3a62f4437cf8208c3a5dda16daf0cb29',
    //                         'x-lang-code': 'en-us',
    //                         'x-user-type': '0',
    //                     },
    //                 };
    //                 let res = await axios(config);
    //                 // console.log(res.data);
    //                 socket.emit('response_messages', {
    //                     messages: res.data,
    //                 });
    //             } catch (e) {
    //                 console.log(e);
    //             }
    //         }
    //         makeRequest();
    //     })
    // }


    socketDisconnect(socket) {
        socket.on('disconnect', (data) => {
            var my_friends = socket.my_friends;
            if (my_friends.length > 0) {
                my_friends.forEach((user) => {
                    this.emit('user_' + user, 'iam_offline', {
                        user_id: socket.id,
                        status: 'offline'
                    });
                })
            }
            socket.disconnect();
            var index = this.online_users.indexOf(socket.id);
            this.online_sockets().splice(index, 1);
            this.online_users.splice(index, 1);
        })
    }
}

module.exports = ChatSocket;
