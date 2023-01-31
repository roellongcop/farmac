<?php

use app\helpers\App;

$this->addCssFile('css/chatbot');
$this->registerJsFile(App::publishedUrl('/vue3/vue.global.js', Yii::getAlias('@app/assets')));
$this->addJsFile('js/chatbot', [], ['type' => 'module']);

$themeColor = App::setting('chatbot')->theme_color;
$this->registerCss(<<< CSS
    .chat-logs::-webkit-scrollbar-thumb {
        background-color: {$themeColor};
    }
    .scroller-thumb::-webkit-scrollbar-thumb {
        background-color: {$themeColor};
    }
    .btn-scroller:hover {
        background: {$themeColor};
        border-color: {$themeColor};
        color: #fff;
    }

    p.msg {
        /*layout*/
        position: relative;
        max-width: 75%;
        color: #666;
        width: fit-content;
        /*padding: 10px 15px !important;*/
        
        /*looks*/
        background-color: #fff;
        padding: 1.125em 1.5em;
        border-radius: 1rem;
    }
    .self p.msg {
        float: right;
        color: #fff;
    }

    .user p.msg::before {
        /*layout*/
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        bottom: 100%;
        left: 1.5em; /*offset should move with padding of parent*/
        border: .75rem solid transparent;
        border-top: none;

        /*looks*/
        border-bottom-color: #fff;
        filter: drop-shadow(0 -0.0625rem 0.0625rem rgba(0, 0, 0, .1));
    }

    .self p.msg::before {
        /*layout*/
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        bottom: -9px;
        right: 1.5em;
        border: 0.75rem solid transparent;
        border-top: none;

        /*looks*/
        border-bottom-color: {$themeColor};
        filter: drop-shadow(0 -0.0625rem 0.0625rem rgba(0, 0, 0, .1));
        transform: rotate(180deg);
    }

CSS);
?>

<div id="chatbot">
    
    <div id="chat-circle" class="btn btn-raised" :style="{background: chatbot.theme_color}">
        <div id="chat-overlay"></div>
        <i class="fab fa-rocketchat"></i>
    </div>

    <div class="chat-box">
        <div class="chat-box-header" :style="{background: chatbot.theme_color}">
            <img :src="chatbotPhotoUrl" class="img-fluid chatbot-photo">
            {{chatbot.name}}
        </div>
        <div class="chat-box-body">
            <div class="chat-box-overlay">   
            </div>
            <div class="chat-logs" ref="conversationsContainer" @scroll="messageScroll">
                <div v-for="(message, index) in messages" :key="message.id" :class="messageClass(message)" class="chat-msg">



                    <div v-if="showTimesent(index)" class="timeSent" v-html="message.timeSent"></div>
                    <!-- <div class="cm-msg-text" :class="messageStyleClass(index)" :style="messageStyle(message)" :id="'message-id-' + message.id" v-html="message.displayMessage">
                    </div> -->
                    <p class="msg" :class="messageStyleClass(index)" :id="'message-id-' + message.id" v-html="message.displayMessage" :style="messageStyle(message)"></p>
                </div>

                <div v-if="messageFormState.content.length">
                    <div v-for="(content, index) in messageFormState.content" :key="index" class="chat-msg self">
                        <div class="timeSent">Sending...</div>
                        <div class="cm-msg-text-placeholder" v-html="content"></div>
                    </div>
                </div>
            </div>
           
            <div class="scrollToBottomContainer" v-if="showScrollable">
                <span></span>
                <span>
                    <button @click="scrollToBottom" class="btn btn-outline-primary font-weight-bold btn-sm btn-pill">
                        Scroll to Bottom
                    </button>
                </span>
                <span></span>
            </div>
        </div>
        <div class="chat-input">      
            <div class="input-group">
                <input class="form-control" autocomplete="off" type="text" id="chat-input" v-model="messageModel" placeholder="Send a message..." @keydown.enter.exact.prevent="sendNewMessage()"/>
                
                <div class="input-group-append submit-btn-container">
                    <button @click="sendNewMessage()" type="submit" class="chat-submit btn" id="chat-submit"><i class="fab fa-telegram-plane" :style="{color: chatbot.theme_color}"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
