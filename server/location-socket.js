'use strict';
const axios = require('axios').default;
const mongoose = require('mongoose');
require('./models/locationModel');
var locationSchema = mongoose.model('locations');

class LocationSocket {
    constructor(socket) {
        this.io = socket;
    }

    ioConfig() {
        this.io.of("/location").use((socket, next) => {
            socket['id'] = 'location_' + socket.handshake.query.user_id;

            if (socket.handshake.query.username !== '' || socket.handshake.query.username !== 'undefined') {
                socket['username'] = socket.handshake.query.username;
            } else {
                socket['username'] = [];
            }

            console.log(socket.id);
            next();
        });
    }

    response_location(socket) {
        socket.on('send_location', (data) => {
            async function makeRequest() {
                const config = {
                    method: 'post',
                    url: 'http://localhost:6001/api/employee/profile/update-location',
                    data: {
                        EmpId: data.user_id,
                        lat: data.lat,
                        lng: data.lng,
                        alt: data.alt,
                        speed: data.speed,
                        bearing_heading: data.bearing_heading
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

                let location = new locationSchema({
                    EmpId: data.user_id,
                    lat: data.lat,
                    lng: data.lng,
                    alt: data.alt,
                    speed: data.speed,
                    bearing_heading: data.bearing_heading
                });
                location.save((error) => {
                    if (error) {
                        console.log(error);
                    } else {
                        console.log('Location added');
                    }
                });
            }

            makeRequest();

            this.io.of("/location").emit('get_location', {
                user_id: data.user_id,
                lat: data.lat,
                lng: data.lng,
                alt: data.alt,
                speed: data.speed,
                bearing_heading: data.bearing_heading
            });
            console.log(data);
        });
    }

    locationSocketConnection() {
        this.ioConfig();
        this.io.of("/location").on('connection', (socket) => {
            this.response_location(socket);
            this.socketDisconnect(socket);
        });
    }

    socketDisconnect(socket) {
        socket.on('disconnect', (data) => {
            socket.disconnect();
        })
    }
}

module.exports = LocationSocket;
