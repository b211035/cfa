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
            <div class="col-auto align-self-end">
                <button id="back" class="btn btn-secondary" v-on:click="backMessage" v-bind:disabled="readonly">戻る</button>
            </div>
        </div>
    </div>
</template>

<script>
    if (typeof Object.assign != 'function') {
      Object.defineProperty(Object, "assign", {
        value: function assign(target, varArgs) { // .length of function is 2
          'use strict';
          if (target == null) { // TypeError if undefined or null
            throw new TypeError('Cannot convert undefined or null to object');
          }

          var to = Object(target);

          for (var index = 1; index < arguments.length; index++) {
            var nextSource = arguments[index];

            if (nextSource != null) { // Skip over if undefined or null
              for (var nextKey in nextSource) {
                // Avoid bugs when hasOwnProperty is shadowed
                if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                  to[nextKey] = nextSource[nextKey];
                }
              }
            }
          }
          return to;
        },
        writable: true,
        configurable: true
      });
    }
    export default {
        props: {
            logs: [String],
            log_list: [Object],
            user_id: [String, Number],
            group_id: [String, Number],
            bot_id: [String, Number],
            scenario_id: [String, Number],
            haslog: [String, Number],
            stop: [String, Number],
            user_avatar: [String]
        },
        data: function () {
            return {
                log_list: [],
                talkerea: '',
                readonly: false,
                params: {
                    user_id: this.user_id,
                    group_id: this.group_id,
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

                if (this.params.contents !== 'init' && this.params.contents !== 'back') {

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

                            if (
                                response.data.systemText.expression_org.indexOf('\end') == -1 &&
                                response.data.systemText.expression_org.indexOf('\stop') == -1
                                ) {
                                this.readonly = false;
                            } else if(response.data.systemText.expression_org.indexOf('\end2') != -1) {
                                setTimeout(function(){
                                     window.location.href = $("#return").attr('href');
                                }, 15000);
                            } else {
                                setTimeout(function(){
                                     window.location.href = $("#return").attr('href');
                                }, 10000);
                            }
                            this.params.contents = '';

                            Vue.nextTick()
                              .then(function () {
                                    var scrollHeight = document.getElementById("talkerea").scrollHeight;
                                    document.getElementById("talkerea").scrollTop = scrollHeight;
                              })

                    });
            },
            backMessage: function() {
                this.params.contents = 'back';
                this.talkMessage();
            }
        },
        mounted() {
            this.log_list = $.parseJSON(this.logs);

            Vue.nextTick()
              .then(function () {
                    var scrollHeight = document.getElementById("talkerea").scrollHeight;
                    document.getElementById("talkerea").scrollTop = scrollHeight;
              })

            if (this.haslog == 0 || this.stop == 1) {
                this.params.contents = 'init';
                this.talkMessage();
            }
        }
    }
</script>