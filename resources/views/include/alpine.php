<body x-data="{
    stunConfig: {
        iceServers: [{
            urls: ['stun:stun1.l.google.com:19302', 'stun:stun2.l.google.com:19302']
        }], iceCandidatePoolSize: 10
    },
    pc: new RTCPeerConnection(this.stunConfig),
    localStream: null,
    playSound(type, loop = false, volume = 1){
        window.sounds[type].currentTime = 0;
        window.sounds[type].loop = loop;
        window.sounds[type].volume = volume;
        window.sounds[type].play();
    },
    stopSound(type){
        window.sounds[type].pause();
    },
    accessError: null,
    outgoingData: {popup: false, type: null, isBusy: false, alreadyInCall: false, isRinging: false, user:{id: null, name: null, avatar: null}},
    // Outgoing Methods
    startCall(type, user){
        this.outgoingData.type = type;
        this.outgoingData.isBusy = false;
        this.outgoingData.isRinging = false;
        this.outgoingData.alreadyInCall = false;
        this.outgoingData.user = user;
        this.outgoingData.popup = true;
        this.playSound('ringing', true, 0.2);
        fetch('/socket/' + this.outgoingData.user.id, {
            method: 'POST',
            body: JSON.stringify({
                _token: '<?= csrf_token() ?>',
                event: 'call-request',
                data: {
                    type: this.outgoingData.type,
                    user: {
                        id: <?= $user->id ?>,
                        name: '<?= $user->getDisplayName() ?>',
                        avatar: '<?= $user->meta('avatar') ?>',
                    }
                }
            }),
        });
    },
    cancelCall(){
        fetch('/socket/' + this.outgoingData.user.id, {
            method: 'POST',
            body: JSON.stringify({
                _token: '<?= csrf_token() ?>',
                event: 'call-cancel',
                data: {
                    type: this.outgoingData.type,
                    user: <?= $user->id ?>
                }
            }),
        });
        this.clearOutgoing();
    },
    clearOutgoing(){
        this.outgoingData.popup = false;
        this.outgoingData.isBusy = false;
        this.outgoingData.alreadyInCall = false;
        this.outgoingData.isRinging = false;
        this.stopSound('ringing');
    },
    callBusy(){
        this.outgoingData.isBusy = true;
        this.stopSound('ringing');
    },
    callRinging(){
        this.outgoingData.isRinging = true;
    },
    alreadyInCall(){
        this.outgoingData.alreadyInCall = true;
        this.stopSound('ringing');
    },
    async callAccepted(data){
        this.clearOutgoing();
        this.roomData.type = data.type;
        this.roomData.user = this.outgoingData.user;
        this.roomData.endCall = false;
        this.roomData.popup = true;
        // PC #2: Create Answer to Receiver Offer
        await this.prepareWebCamForPc();
        await this.pc.setRemoteDescription(data.pcDescription);
        await this.pc.createAnswer();
        await this.pc.setLocalDescription(this.pc.localDescription);
        fetch('/socket/' + this.roomData.user.id, {
            method: 'POST',
            body: JSON.stringify({
                _token: '<?= csrf_token() ?>',
                event: 'pc-answer',
                data: {
                    type: this.roomData.type,
                    user: <?= $user->id ?>,
                    pcDescription: this.pc.localDescription
                }
            }),
        });
    },
    // Incoming Methods
    incomingData: {popup: false, type: null, user:{id:null, avatar: null, name: null}},
    setIncomingData(data){
        if(this.pc.iceConnectionState === 'connected'){
            fetch('/socket/' + data.user.id, {
                method: 'POST',
                body: JSON.stringify({
                    _token: '<?= csrf_token() ?>',
                    event: 'already-in-call',
                    data: {
                        type: data.type,
                        user: <?= $user->id ?>
                    }
                }),
            });
        }else{
            this.incomingData.popup = true;
            this.incomingData.type = data.type;
            this.incomingData.user = data.user;
            this.playSound('ringtone', true);
            fetch('/socket/' + data.user.id, {
                method: 'POST',
                body: JSON.stringify({
                    _token: '<?= csrf_token() ?>',
                    event: 'call-ringing',
                    data: {
                        type: data.type,
                        user: <?= $user->id ?>
                    }
                }),
            });
        }
    },
    rejectCall(){
        fetch('/socket/' + this.incomingData.user.id, {
            method: 'POST',
            body: JSON.stringify({
                _token: '<?= csrf_token() ?>',
                event: 'call-busy',
                data: {
                    type: this.incomingData.type,
                    user: <?= $user->id ?>
                }
            }),
        });
        this.closePopup();
    },
    closePopup(){
        this.incomingData.popup = false;
        this.stopSound('ringtone');
    },
    async acceptCall(){
        this.incomingData.popup = false;
        this.roomData.type = this.incomingData.type;
        this.roomData.user = this.incomingData.user;
        this.roomData.endCall = false;
        this.roomData.popup = true;
        this.stopSound('ringtone');
        // PC #1: Create a PC Offer for Sender
        await this.prepareWebCamForPc();
        await this.pc.createOffer({
            offerToReceiveAudio: true,
            offerToReceiveVideo: this.incomingData.type == 'video'
        });
        await this.pc.setLocalDescription(this.pc.localDescription);
        fetch('/socket/' + this.incomingData.user.id, {
            method: 'POST',
            body: JSON.stringify({
                _token: '<?= csrf_token() ?>',
                event: 'call-accepted',
                data: {
                    type: this.incomingData.type,
                    user: <?= $user->id ?>,
                    pcDescription: this.pc.localDescription
                }
            }),
        });
    },
    async prepareWebCamForPc(){
        let video = document.querySelector('#localVideo');
        try {
            this.localStream = await navigator.mediaDevices.getUserMedia({
                audio: true,
                video: this.roomData.type == 'video'
            });
            this.localStream.getTracks().forEach(track => this.pc.addTrack(track, this.localStream));
            video.srcObject     = this.localStream;
            video.ontimeupdate  = () => this.roomData.talkTime = this.formatTalkTime(video.currentTime);
        } catch(error) {
            this.accessError = '<b>Failed To Access Microphone/Camera</b> <br/>' + error;
        }
        this.pc.onicecandidate = e => {
            if (e.candidate !== null) {
                fetch('/socket/' + this.roomData.user.id, {
                    method: 'POST',
                    body: JSON.stringify({
                        _token: '<?= csrf_token() ?>',
                        event: 'ice-candidate',
                        data: {
                            type: this.roomData.type,
                            user: <?= $user->id ?>,
                            iceCandidate: e.candidate
                        }
                    })
                });
            }
        }
        this.pc.ontrack = e => {
            document.querySelector('#remoteVideo').srcObject = e.streams[0];
        }
    },
    async setPcAnswer(data){
        if (this.pc.localDescription) {
            await this.pc.setRemoteDescription(data.pcDescription)
        }
    },
    async setIceCandidate(data){
        if (this.pc.localDescription) {
            await this.pc.addIceCandidate(new RTCIceCandidate(data.iceCandidate));
        }
    },
    // Call Room Methods
    roomData: {popup: false, endCall: false, talkTime: null, duration: null, type: null, user:{id:null, name: null, avatar: null}},
    formatTalkTime(time){
        var minutes, seconds;
        minutes = Math.floor(time / 60);
        minutes = (minutes >= 10) ? minutes : '0' + minutes;
        seconds = Math.floor(time % 60);
        seconds = (seconds >= 10) ? seconds : '0' + seconds;
        return minutes + ':' + seconds;
    },
    hangUp(){
        fetch('/socket/' + this.roomData.user.id, {
            method: 'POST',
            body: JSON.stringify({
                _token: '<?= csrf_token() ?>',
                event: 'call-hangup',
                data: {
                    type: this.roomData.type,
                    user: <?= $user->id ?>
                }
            }),
        });
        this.endCall();
    },
    endCall(){
        this.pc.close();
        this.pc = new RTCPeerConnection(this.stunConfig);
        this.localStream.getTracks().forEach(track => track.stop());
        this.localStream = null;

        let local = document.querySelector('#localVideo'),
            remote = document.querySelector('#remoteVideo'),
            duration = local.currentTime;

        this.unloadVideo(local);
        this.unloadVideo(remote);
        
        this.roomData.duration = this.formatTalkTime(duration);
        this.roomData.endCall = true;
    },
    unloadVideo(video) {
        if (video) {
            video.pause(), video.removeAttribute('src'), video.load();
        }
    },
    async closeWindow(){
        if (this.pc.iceConnectionState === 'connected') {
            await this.hangUp();
        }
        if(this.outgoingData.popup){
            await this.cancelCall();
        }
        if(this.incomingData.popup){
            await this.rejectCall();
        }
    }
}" x-init="
    window.chatroom.bind('call-request', (data) => setIncomingData(data)),
    window.chatroom.bind('call-cancel', (data) => closePopup(data)),
    window.chatroom.bind('already-in-call', (data) => alreadyInCall(data)),
    window.chatroom.bind('call-busy', (data) => callBusy(data)),
    window.chatroom.bind('call-ringing', (data) => callRinging(data)),
    window.chatroom.bind('call-accepted', (data) => callAccepted(data)),
    window.chatroom.bind('call-hangup', (data) => endCall(data)),
    window.chatroom.bind('pc-answer', (data) => setPcAnswer(data)),
    window.chatroom.bind('ice-candidate', (data) => setIceCandidate(data)),
    window.addEventListener('beforeunload', () => closeWindow());
" class="text-slate-800 bg-gradient-to-b from-sky-100 to-fuchsia-200 flex items-center justify-center container min-h-screen">