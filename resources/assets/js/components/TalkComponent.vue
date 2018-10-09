<template>
    <div>
        <div id="talkerea">
            <div class="row no-gutters" v-html="talkerea">
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col">
                <input id="contents" type="text" class="form-control" name="contents" v-model="params.contents" v-bind:readonly="readonly">
            </div>
            <div class="col-auto align-self-end">
                <button id="talk" class="btn btn-default" v-on:click="talkMessage" v-bind:disabled="readonly">発話</button>
            </div>
        </div>
    </div>
</template>

<script>
    var index = 0;
    export default {
        props: {
            user_id: [String, Number],
            bot_id: [String, Number],
            scenario_id: [String, Number],
            user_avatar: [String]
        },
        data: function () {
            return {
                talkerea: '',
                readonly: false,
                params: {
                    user_id: this.user_id,
                    bot_id: this.bot_id,
                    scenario_id: this.scenario_id,
                    contents: ''
                },
                speed: 400
            }
        },
        methods: {
            talkMessage: function() {
                if (this.params.contents.length == 0) {
                    return;
                }

                this.readonly = true;
                if (this.params.contents !== 'init') {
                    this.talkerea = this.talkerea
                     + '<div id="' + index +'" class="col-3"></div>'
                     + '<div class="col-9 align-self-end">'
                         + '<div class="row no-gutters">'
                             + '<div class="col talkbox usertalk rounded">'
                                 + this.params.contents
                             + '</div>'
                             + '<div class="col-auto avatar">'
                                 + '<img class="avatar_img" src="'
                                 + this.user_avatar
                                 + '">'
                             + '</div>'
                         + '</div>'
                     + '</div>';

                    var id = '#' + index;
                    var target = $(id);
                    index = index+1;
                    var position = target.offset().top;
                    $('body,html').animate({scrollTop:position}, this.speed, 'swing');

                    }
                this.$http.post('/api/repl', this.params)
                    .then(
                        response =>  {
                            this.params.contents = '';
                            this.talkerea = this.talkerea
                             + '<div id="' + index +'" class="col-9 justify-content-start">'
                                 + '<div class="row no-gutters">'
                                     + '<div class="col-auto avatar">'
                                         + '<img class="avatar_img" src="'
                                         + response.data.avatarImage
                                         + '">'
                                     + '</div>'
                                 + '<div class="col talkbox bottalk rounded">'
                                     + response.data.systemText.expression
                                 + '</div>'
                             + '</div>'
                             + '</div><div class="col-3"></div>';
                        this.readonly = false;

                    var id = '#' + index;
                    var target = $(id);
                    index = index+1;
                    var position = target.offset().top;
                    $('body,html').animate({scrollTop:position}, this.speed, 'swing');

                    })
                    .then(function () {
                        this.readonly = false;
                        this.params.contents = '';
                    });
            }
        },
        mounted() {
            this.params.contents = 'init';
            this.talkMessage();
        }
    }
</script>

<style type="text/css">
    #talkerea {
        height: 500px;
        background-color: #CCFFFF;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .avatar,
    .talkbox{
        margin: 5px;
        padding: 5px;
    }

    .avatar_img{
         height: 48px;
         width: 48px;
    }

    .usertalk {
        background-color: #CCFF99;
        z-index:1;
    }

    .usertalk:after {
        content: '';
        position: absolute;
        display: block;
        width: 0;
        height: 0;
        right: -15px;
        top: 0px;
        border-left: 40px solid #CCFF99;
        border-top: 15px solid transparent;
        border-bottom: 15px solid transparent;
        z-index:-1;
    }

    .bottalk {
        background-color: #FFFFFF;
        z-index:1;
    }

    .bottalk:before {
        content: '';
        position: absolute;
        display: block;
        width: 0;
        height: 0;
        left: -15px;
        border-right: 40px solid #FFFFFF;
        border-top: 15px solid transparent;
        border-bottom: 15px solid transparent;
        z-index:-1;
    }
</style>