<?php

$this->layout('master')
    ->block('title', 'WeChat - Home')
    ->with([
        'auth' => $auth = app()->getComponent('auth'),
        'user' => $user = $auth->getUser()
    ]);
?>
<div x-data="{
        filterChatlist(){
            document.querySelectorAll('[chat-filter]').forEach(element => {
                element.style.display = (element.getAttribute('chat-filter').toLowerCase().includes($refs.search.value.toLowerCase()) ? 'block' : 'none')
            });
        },
        checkActivity(){
            var ids = [], timestamps = [];
            document.querySelectorAll('[activity]').forEach(element => {
                ids.push(element.getAttribute('activity'));
            });
            document.querySelectorAll('[timestamp]').forEach(element => {
                timestamps.push(element.getAttribute('timestamp'));
            });

            fetch('/activities', {
                method: 'POST',
                body: JSON.stringify({
                    _token: '<?= csrf_token() ?>',
                    ids: ids,
                    timestamps: timestamps
                }),
            })
                .then(res => res.json())
                .then(resp => {
                    resp.users.forEach(activity => {
                        document.querySelectorAll(`[activity='${activity.id}']`).forEach(element => {
                            element.classList.remove('bg-teal-400');
                            element.classList.remove('bg-amber-400');
                            element.classList.remove('bg-slate-400');
                            element.classList.add('bg-'+ activity.status +'-400');
                        });
                    });
                    resp.timestamps.forEach(timestamp => {
                        document.querySelectorAll(`[timestamp='${timestamp.time}']`).forEach(element => {
                            element.innerHTML = timestamp.info;
                        });
                    });
                });
        },
        pushNewMessage(message){
            var text = document.querySelector(`[chatlist] [pushchat='${message.sender}'] [message]`),
                time = document.querySelector(`[chatlist] [pushchat='${message.sender}'] [info] [time]`),
                unseen = document.querySelector(`[chatlist] [pushchat='${message.sender}'] [info] [unseen]`),
                message_info = '';

                if(message.type == 'textfile'){
                    message_info = `<span class='flex items-center'><svg xmlns='http://www.w3.org/2000/svg' class='fill-current w-4' viewBox='0 0 24 24'><path d='M19.937 8.68c-.011-.032-.02-.063-.033-.094a.997.997 0 0 0-.196-.293l-6-6a.997.997 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a.991.991 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a.99.99 0 0 0-.05-.258zM16.586 8H14V5.414L16.586 8zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10H6z'></path></svg> Send Attachment</span>`;
                }else if(message.type == 'voicecall'){
                    message_info = `<span class='flex items-center'><svg xmlns='http://www.w3.org/2000/svg' class='fill-current w-4' viewBox='0 0 24 24'><path d='M16.712 13.288a.999.999 0 0 0-1.414 0l-1.597 1.596c-.824-.245-2.166-.771-2.99-1.596-.874-.874-1.374-2.253-1.594-2.992l1.594-1.594a.999.999 0 0 0 0-1.414l-4-4a1.03 1.03 0 0 0-1.414 0l-2.709 2.71c-.382.38-.597.904-.588 1.437.022 1.423.396 6.367 4.297 10.268C10.195 21.6 15.142 21.977 16.566 22h.028c.528 0 1.027-.208 1.405-.586l2.712-2.712a.999.999 0 0 0 0-1.414l-3.999-4zM16.585 20c-1.248-.021-5.518-.356-8.874-3.712C4.343 12.92 4.019 8.636 4 7.414l2.004-2.005L8.59 7.995 7.297 9.288c-.238.238-.34.582-.271.912.024.115.611 2.842 2.271 4.502s4.387 2.247 4.502 2.271a.994.994 0 0 0 .912-.271l1.293-1.293 2.586 2.586L16.585 20z'></path><path d='M15.795 6.791 13.005 4v6.995H20l-2.791-2.79 4.503-4.503-1.414-1.414z'></path></svg> Missed Voice Call`;
                }else if(message.type == 'videocall'){
                    message_info = `<span class='flex items-center'><svg xmlns='http://www.w3.org/2000/svg' class='fill-current w-4' viewBox='0 0 24 24'><path d='M18 7c0-1.103-.897-2-2-2H6.414L3.707 2.293 2.293 3.707l18 18 1.414-1.414L18 16.586v-2.919L22 17V7l-4 3.333V7zm-2 7.586L8.414 7H16v7.586zM4 19h10.879l-2-2H4V8.121L2.145 6.265A1.977 1.977 0 0 0 2 7v10c0 1.103.897 2 2 2z'></path></svg> Missed Video Call`;
                }else{
                    message_info = message.content;
                }

            text.innerHTML = message_info;
            text.classList.remove('text-slate-500');
            text.classList.remove('font-semibold');
            text.classList.add('text-slate-600');
            text.classList.add('font-semibold');
            
            time.innerHTML = 'Moments Ago';
            time.style.display = 'block';
            time.setAttribute('timestamp', message.timestamp);

            unseen.innerHTML = parseInt(unseen.innerHTML) + 1;
            unseen.style.display = 'flex';

            document.querySelector(`[chatlist]`).prepend(document.querySelector(`[chatlist] [pushchat='${message.sender}']`));

            playSound('notification');
        }
    }" x-init="setInterval(() => checkActivity(), 60 * 1000), window.chatroom.bind('message', (message) => pushNewMessage(message));">
    <?php $this
        ->include('include.header')
        ->include('include.search')
        ->include('include.users')
        ->include('include.chatlist')
    ?>
</div>