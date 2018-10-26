<template>
    <div>
        <div id="talkerea">
                <template v-for="(log, key, count) in log_list">
                    <div class="row no-gutters" v-if="log.sender_flg == 1">
                        <div class="col-9 justify-content-start">
                            <div class="row no-gutters">
                                <div class="col-auto avatar">
                                    <img class="avater_image" :src=log.avater_image>
                                </div>
                                <div class="col talkbox bottalk rounded">
                                    <span v-html="log.contents"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3"></div>
                    </div>

                    <div class="row no-gutters" v-else>
                        <div class="col-3"></div>
                        <div class="col-9 align-self-end">
                            <div class="row no-gutters">
                                <div class="col talkbox usertalk rounded">
                                    <span v-html="log.contents"></span>
                                </div>
                                <div class="col-auto avatar">
                                    <img class="avater_image" :src=log.avater_image>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
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
    export default {
        props: {
            logs: [String],
            log_list: [Object],
            user_id: [String, Number],
            bot_id: [String, Number],
            scenario_id: [String, Number],
            haslog: [String, Number],
            user_avatar: [String]
        },
        data: function () {
            return {
                log_list: [],
                talkerea: '',
                readonly: false,
                params: {
                    user_id: this.user_id,
                    bot_id: this.bot_id,
                    scenario_id: this.scenario_id,
                    contents: ''
                }
            }
        },
        methods: {
            talkMessage: function() {
                if (this.params.contents.length == 0) {
                    return;
                }
                this.readonly = true;

                if (this.params.contents !== 'init') {

                    var obj = Object.assign({}, this.log_list[0]);
                    obj.avater_image = this.user_avatar;
                    obj.contents = this.params.contents;
                    obj.sender_flg = 0;
                    this.log_list.push(obj);

                    Vue.nextTick()
                      .then(function () {
                            var scrollHeight = document.getElementById("talkerea").scrollHeight;
                            document.getElementById("talkerea").scrollTop = scrollHeight;
                      })

                }

                this.$http.post('/api/repl', this.params)
                    .then(
                        response =>  {

                            var obj = Object.assign({}, this.log_list[0]);
                            obj.avater_image = response.data.avatarImage;
                            obj.contents = response.data.systemText.expression;
                            obj.sender_flg = 1;
                            this.log_list.push(obj);

                            this.readonly = false;
                            this.params.contents = '';

                            Vue.nextTick()
                              .then(function () {
                                    var scrollHeight = document.getElementById("talkerea").scrollHeight;
                                    document.getElementById("talkerea").scrollTop = scrollHeight;
                              })

                    });
            }
        },
        mounted() {
            this.log_list = $.parseJSON(this.logs);

            Vue.nextTick()
              .then(function () {
                    var scrollHeight = document.getElementById("talkerea").scrollHeight;
                    document.getElementById("talkerea").scrollTop = scrollHeight;
              })

            if (this.haslog == 0) {
                this.params.contents = 'init';
                this.talkMessage();
            }
        }
    }
</script>