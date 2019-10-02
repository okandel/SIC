function status_user(status_span, add_status_class) {
    var status_user = ['online', 'offline'];
    $.each(status_user, function (k, v) {
        $('.' + status_span).removeClass(v);
    });
    $('.' + status_span).addClass(add_status_class);
    $('.' + status_span).next().html(add_status_class);
}

$(document).ready(function(){
    var myList = [];
    $('.user').each(function () {
        var uid = $(this).attr('uid');
        myList.push(uid);
    });

    var my_status = $('.current_status').attr('status');
    if (my_status === "online") {
        $('#status_btn').removeClass('btn-warning');
        $('#status_btn').addClass('btn-success');
    } else if (my_status === "offline") {
        $('#status_btn').removeClass('btn-success');
        $('#status_btn').addClass('btn-warning');
    }
    var socket = io('http://localhost:5000/chat',
        {query: {
                user_id: user_id,
                username: username,
                my_list: myList.join(','),
                status: my_status
            }}
         );

    var array_emit = ['is_online', 'iam_online', 'iam_offline', 'new_status'];
    $.each(array_emit, function (k, v) {
        socket.on(v, (data) => {
            status_user(data.user_id, data.status);
        });
    });

    socket.on('request_status', function (data) {
        console.log($('.current_status').attr('status'));
       socket.emit('response_status', {
           to_user: data.user_id,
           my_status: $('.current_status').attr('status')
       });
    });

    socket.on('connect', function (data) {
        $('.user').each(function () {
            var uid = $(this).attr('uid');
            socket.emit('check_online', {
                user_id: 'user_'+uid
            })
        });
    });

    $(document).on('click change', '.status', function () {
        var status_user = $(this).attr('status');
        $('.current_status').attr('status', status_user);
        if (status_user === 'online') {
            $('.current_status').text("Online");
            $('#status_btn').removeClass('btn-warning');
            $('#status_btn').addClass('btn-success');
        } else if (status_user === 'offline') {
            $('.current_status').text("Offline");
            $('#status_btn').removeClass('btn-success');
            $('#status_btn').addClass('btn-warning');
        }
        socket.emit('change_status', {
           status: status_user
        })
    });

    //==================================================================


    function private_chatbox(username, userID) {
        chatPopup1 =
            '<div class="chat-header clearfix">\n' +
            // '    <img src="{{url(\'/assets/images/xs/avatar1.jpg\')}}" alt="avatar" />\n' +
            '    <div class="chat-about">\n' +
            '        <div class="chat-with">Chat with <span id="chat_title" class="text-primary"></span></div>\n' +
            // '             <div class="chat-num-messages">already 32 messages</div>\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="chat-history" style="max-height: 79.4%">\n' +
            '    <ul>\n' +
            '       <li class="clearfix msg_box box'+userID+'" rel="'+ userID+'">\n' +
            '          <div class="msg_wrap"> ' +
            '              <div class="msg_body">\t' +
            '                  <div class="msg_push" style="margin-bottom: 23%"></div>\n' +
            '              </div>' +
            '          </div>\n' +
            '       </li>\n' +
            '    </ul>' +
            '</div>' +
            '<div class="chat-message clearfix" rel="'+ userID+'" style="position: fixed; width: inherit; bottom: 0; background-color: #eeeeee">\n' +
            '     <div class="form-group">\n' +
            '         <div class="form-line">\n' +
            '              <span class="broadcast"></span>\n' +
            '                   <textarea style="background-color: white" id="msg_textarea" class="form-control msg_input" placeholder="Enter message"></textarea>\n' +
            '         </div>\n' +
            '     </div>\n' +
            '     <button id="send_btn" class="btn btn-raised btn-default">Send</button>\n' +
            '     <a href="#" class="btn btn-raised btn-warning"><i class="zmdi zmdi-camera"></i></a>\n' +
            '     <a href="#" class="btn btn-raised btn-info"><i class="zmdi zmdi-file-text"></i></a>\n' +
            '</div>' ;

        $(".chat_container").html(chatPopup1);
        $('#chat_title').html(username);
    }

    $(document).on('click', '.sidebar-user-box', function() {
        var userID = $(this).attr("uid");
        var username = $(this).children('div').children('.name').text() ;
        private_chatbox(username, 'user_'+userID);

        $.ajax({
            url: 'http://localhost:6001/api/employee/chat/get-messages',
            method: "post",
            data: {
                UserId: user_id,
                EmployeeId: userID
            },
            headers: {
                'Content-Type': 'application/json',
                'x-auth-token': '3a62f4437cf8208c3a5dda16daf0cb29',
                'x-lang-code': 'en-us',
                'x-user-type': '0',
            },
            success: function (data) {
                if (data) {
                    data.data.forEach(function (d) {
                        // console.log($('.boxuser_'+d.EmployeeId).attr('rel').split('_')[1]);
                        // debugger;

                        var layout_class="" ,owner_layout_class="";//my-message , other-message
                        var owner="";//my-message , other-message

                        if (d.from_entry_type === 'U') {
                            owner_layout_class = "";
                            layout_class = "my-message ";
                            owner = d.UserId;
                        } else {
                            owner_layout_class = "text-right";
                            layout_class = "other-message float-right";
                            owner = d.EmployeeId;
                        }

                        if (d.from_entry_type === 'U') {
                            $(
                                '<div class="message-data '+owner_layout_class+'" style="clear: both"> \n' +
                                '    <span class="message-data-name">'+owner+'</span> \n' +
                                '    <span class="message-data-time">'+d.created_at +'</span> &nbsp; \n' +
                                '</div>' +
                                '<div class="message '+layout_class+' " style="clear: both">'+d.message+'</div>'
                            )
                                .insertBefore(' .msg_push');
                        } else {
                            $(
                                '<div class="message-data '+owner_layout_class+'" style="clear: both"> \n' +
                                '    <span class="message-data-time">'+d.created_at +'</span> &nbsp; \n' +
                                '    <span class="message-data-name">'+owner+'</span> \n' +
                                '</div>' +
                                '<div class="message '+layout_class+' " style="clear: both">'+d.message+'</div>'
                            )
                                .insertBefore(' .msg_push');
                        }

                    });
                }
            },
            error: function (err) {
                console.log(err);
            }
        })
    });

    socket.on('new_private_msg', function (data) {
        if (!$('.msg_box').hasClass('box'+data.from_uid)) {
            private_chatbox(data.username, data.from_uid);
        }

        $('.box'+data.from_uid+' .broadcast').html('');

        if (data.who_is === 'user_'+user_id) {
            $(
                '<div class="message-data" style="clear: both">\n' +
                '    <span class="message-data-name">\n' +
                // '       <i class="zmdi zmdi-circle online"></i> ' +
                data.username+
                '    </span>' +
                '    <span class="message-data-time">'+new Date(Date.now()).toLocaleString()+'</span>\n' +
                '</div>' +
                '<div class=" message my-message" style="clear: both">'+data.message+'</div>'
            )
                .insertBefore('[rel="'+data.from_uid+'"] .msg_push');
        } else {
            $(
                '<div class="message-data text-right" style="clear: both"> \n' +
                '    <span class="message-data-time">'+new Date(Date.now()).toLocaleString()+'</span> &nbsp; \n' +
                '    <span class="message-data-name">'+data.username+'</span> \n' +
                // '    <i class="zmdi zmdi-circle me"></i> \n' +
                '</div>' +
                '<div class="message other-message float-right" style="clear: both">'+data.message+'</div>'
            )
                .insertBefore('[rel="'+data.from_uid+'"] .msg_push');
        }
        $('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);

    });


    $(document).on('keypress', 'textarea' , function(e) {
        var chatbox = $(this).parents().parents().parents().attr("rel") ;
        var msg = $(this).val();
        if (e.keyCode == 13 && !e.shiftKey) {
            e.preventDefault();
            $(this).val('');
            if(msg.trim().length !== 0){
                socket.emit('send_private_msg', {
                    message: msg,
                    to: chatbox,
                    UserId: user_id,
                    EmployeeId: chatbox,
                    ClientRepId: null,
                    MissionId: 1,
                    from_entry_type: "U",
                    GroupId: null
                });
            }
        } else {
            socket.emit('broadcast_private', {
                to: chatbox,
                username: username
            })
        }
    });
    $(document).on('click', '#send_btn', function () {
        var chatbox = $('textarea').parents().parents().parents().attr("rel") ;
        var msg = $('textarea').val();
        if(msg.trim().length !== 0){
            socket.emit('send_private_msg', {
                message: msg,
                to: chatbox,
                UserId: user_id,
                EmployeeId: chatbox,
                ClientRepId: null,
                MissionId: 1,
                from_entry_type: "U",
                GroupId: null
            });
            $('textarea').val('');
        }

    });

    socket.on('new_broadcast', function(data) {
        $('.box'+data.from+' .broadcast').html('<img src="'+typingUrl+'" alt="typing"/>');

        setTimeout(function () {
            $('.box'+data.from+' .broadcast').html('');
        }, 5000);
    });

});
