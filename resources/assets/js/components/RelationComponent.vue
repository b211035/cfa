<template>
    <div v-if="user_list">
        <div class="row border-bottom border-top">
            <div class="col">ID</div>
            <div class="col">生徒名</div>
            <div class="col"></div>
            <div class="col"></div>
        </div>
        <div>
            <template v-for="user in user_list">
                <div class="row border-bottom">
                    <div class="col">{{ user.id }}</div>
                    <div class="col">{{ user.user_name }}</div>
                    <div class="col">
                        <div v-if="user.teacher_id">
                            <a href="#" @click="disable(user.id)">生徒認証解除</a>
                        </div>
                        <div v-else>
                            <a href="#" @click="enable(user.id)">生徒認証</a>
                        </div>
                    </div>
                    <div class="col"><a href="#" @click="log(user.id)">会話ログ確認</a></div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            users: [String],
            user_list: [Object]
        },
        data: function () {
            return {
                params: {
                    user_list: [],
                },
            }
        },
        methods: {
            enable: function(id){
                this.$http.post('/teacher/user/enable/' + id)
                    .then(
                        response =>  {
                            this.user_list = response.data.user;
                        }
                    );
            },
            disable: function(id){
                this.$http.post('/teacher/user/disable/' + id)
                    .then(
                        response =>  {
                            this.user_list = response.data.user;
                        }
                    );
            },
            log: function(id){
                window.location.href = '/teacher/user/log/' + id;
            }
        },
        mounted() {
            this.user_list = $.parseJSON(this.users);
        }
    }
</script>
