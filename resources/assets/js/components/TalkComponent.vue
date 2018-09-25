<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
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
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user_id: [String, Number],
            bot_id: [String, Number],
            scenario_id: [String, Number]
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
                    this.talkerea = this.talkerea
                     + '<div class="col-6"></div><div class="col align-self-end"><div class="talkbox usertalk rounded">'
                     + this.params.contents 
                     + '</div></div>';
                }

                this.$http.post('/api/repl', this.params)
                    .then(
                        response =>  {
                            this.params.contents = '';
                            this.talkerea = this.talkerea
                             + '<div class="col-6 justify-content-start"><div class="talkbox bottalk rounded">'
                             + response.data.systemText.expression 
                             + '</div></div><div class="col-6"></div>';
                        this.readonly = false; 
                    })
                    .then(function () {
                        // always executed
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
    }

    .talkbox{
        margin: 5px;
        padding: 5px;
    }

    .usertalk {
        background-color: #CCFF99;
    }

    .bottalk {
        background-color: #FFFFFF;
    }
</style>
<!-- <div class="col-6"></div> -->