<?php

$this->layout('master')
    ->block('title',  $friend->getDisplayName() . ' - WeChat')
    ->with([
        'auth' => $auth = app()->getComponent('auth'),
        'user' => $user = $auth->getUser(),
        'friend' => $friend
    ]);
?>

<div x-data='{
    chatlist: <?= json_encode($chatlist) ?>,
    messagePage: 1,
    hasMoreMessage: <?= !empty($chatlist) ?>,
    loading: false,
    createMessage(){
        if(this.loading) return;
        this.loading = true;
        var data = new FormData()
        data.append("file", $refs.sendFile.files[0] ?? null);
        data.append("message", $refs.sendMessage.value);
        data.append("to", "<?= $friend->id ?>");
        data.append("_token", "<?= csrf_token() ?>");

        fetch("/send/message", {
            method: "POST",
            body: data,
        })
            .then(res => res.json())
            .then(resp => {
                this.pushMessage(resp.data),
                $refs.sendFile.value = "", $refs.sendMessage.value = "";
            })
            .finally(() => this.loading = false);
    },
    scroll(){
        $refs.chatRoom.scrollTo(0, $refs.chatRoom.scrollHeight);
    },
    pushMessage(message){
        this.chatlist.Today ? this.chatlist.Today.push(message) : (this.chatlist.length == 0 ? this.chatlist = {Today: [message]} : this.chatlist.Today = [message]),
        setTimeout(() => this.scroll(), 10);
        if(!message.self && !activeClient){
            playSound("notification");
        }
    },
    hasNext(day, index){
        const current = this.chatlist[day][index], next = (this.chatlist[day][index + 1] ?? false);
        return next && next.sender == current.sender;
    },
    sendFile: null,
    checkOnlineStatus(){
        var ids = [];
        document.querySelectorAll("[onlinestatus]").forEach(element => {
            ids.push(element.getAttribute("onlinestatus"));
        });

        fetch("/activities", {
            method: "POST",
            body: JSON.stringify({
                _token: "<?= csrf_token() ?>",
                friend: "<?= $friend->id ?>",
                append: "seen",
                ids: ids
            }),
        })
            .then(res => res.json())
            .then(resp => {
                resp.users.forEach(onlinestatus => {
                    document.querySelectorAll(`[onlinestatus="${onlinestatus.id}"]`).forEach(element => {
                        element.innerHTML = onlinestatus.text;
                    });
                });
            });
    },
    loadMoreMessage(){
        this.hasMoreMessage = false;
        fetch("/messages", {
            method: "POST",
            body: JSON.stringify({
                _token: "<?= csrf_token() ?>",
                friend: "<?= $friend->id ?>",
                page: ++this.messagePage
            }),
        })
            .then(res => res.json())
            .then(resp => {
                if(resp.length != 0){
                    this.hasMoreMessage = true;
                }
                this.chatlist = {
                    ...resp,
                    ...this.chatlist,
                };
            });
    }
}' x-init="window.chatroom.bind('message', (message) => pushMessage(message)), setTimeout(() => checkOnlineStatus(), 5000), setInterval(() => checkOnlineStatus(), 45 * 1000);">
    <?php $this
        ->include('parts.chat.chatheader')
        ->include('parts.chat.chatfield')
        ->include('parts.chat.chatform')
    ?>
</div>