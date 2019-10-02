'use strict';

const express = require('express');
const http = require('http');
const socket = require('socket.io');
var mongoose = require('mongoose');

const ChatSocketServer = require('./chat-socket');
const LocationSocketServer = require('./location-socket');

mongoose.connect("mongodb://localhost:27017/sic",
    { useNewUrlParser: true, useUnifiedTopology: true, useCreateIndex: true, useFindAndModify: false}, (err)=>{
    if(err){
        console.log(err)
    }else{
        console.log("Connection Done")
    }
});

class Server {
    constructor() {
        this.port = 5000;
        this.host = 'localhost';

        this.app = express();
        this.router = express.Router();
        this.http = http.Server(this.app); // Node js Server
        this.socket = socket(this.http); // Here Run A Socket io Module
    }

    runServer() {
        new ChatSocketServer(this.socket).chatSocketConnection(); // This Is Chat Socket Class
        new LocationSocketServer(this.socket).locationSocketConnection(); // This Is Location Socket Class

        // this.router.post('/chat', (req, res) => {
        //     new ChatSocketServer(this.socket).chatSocketConnection(); // This Is Chat Socket Class
        // });
        //
        // this.router.post('/location', (req, res) => {
        //     new LocationSocketServer(this.socket).locationSocketConnection(); // This Is Location Socket Class
        // });

        // Listening A Node Js Server
        this.http.listen(this.port, this.host, () => {
            console.log(`Nodejs server is running on ${this.host}:${this.port}`)
        });
    }
}

const app = new Server();
app.runServer(); // Run The Server Class

