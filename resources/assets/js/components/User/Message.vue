<template>
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-8" id="notifications">
                <div id="conversations-sidebar" class="row">
                    <div class="lessons-nav lessons-nav--forum inline-nav">
                        <ul class="lessons-nav__primary">
                            <li  :class="{active : unread }">
                                <a href="" @click.prevent="changeunread()">
                                    <i class="fa fa-comments"></i>
                                    {{unreadnotify.length}} 条未读消息
                                </a>
                            </li>
                            <li :class="{active : allread }" >
                                <a href="" @click.prevent="changeall()">
                                    <i class="fa fa-database"></i>
                                    所有消息通知
                                </a>
                            </li>

                            <li id="lessons-nav--forum__rankings" class="pull-right">
                                <a href="" @click.prevent="markAllRead()" >
                                    <i class="fa fa-bell"></i>

                                    全部标记为已读</a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="widget-active clearfix">
                    <section class="widget-active__answer" v-show="unread" v-for="notify in unreadnotify">
                        <div class="widget-active--left">
                            <span class="fa fa-comment"></span>
                        </div>
                        <div class="widget-active--right">
                            <p class="widget-active--right__info">{{notify.created_at}}
                            </p>
                            <div class="widget-active--right__title" v-if="notify.data.type=='comment'">
                                <p><a target="_blank" href="">{{notify.data.user_name}}</a>回复了你的文章
                                    <router-link :to="{ name: 'article', params: { id:notify.data.article_id}}">
                                    <a href=""  @click="markAsRead(notify.id)">{{notify.data.article_title}}</a>
                                    </router-link>
                                </p>
                            </div>
                            <div class="widget-active--right__title" v-if="notify.data.type=='like'">
                                <p><a target="_blank" href="">{{notify.data.user_name}}</a>喜欢了你的文章
                                    <router-link :to="{ name: 'article', params: { id:notify.data.article_id}}">
                                        <a href=""  @click="markAsRead(notify.id)">{{notify.data.article_title}}</a>
                                    </router-link>
                                </p>
                            </div>
                            <div class="widget-active--right__title" v-if="notify.data.type=='follow'">
                                <p><a target="_blank" href="">{{notify.data.user_name}}</a>关注了你

                                </p>
                            </div>


                        </div>
                    </section>
                    <section class="widget-active__answer" v-show="allread" v-for="notify in allnotify">
                        <div class="widget-active--left">
                            <span class="fa fa-comment"></span>
                        </div>
                        <div class="widget-active--right">
                            <p class="widget-active--right__info">{{notify.created_at}}
                            </p>
                            <div class="widget-active--right__title" v-if="notify.data.type=='comment'">
                                <p><a target="_blank" href="">{{notify.data.user_name}}</a>回复了你的文章
                                    <router-link :to="{ name: 'article', params: { id:notify.data.article_id}}">
                                    <a href=""  @click="markAsRead(notify.id)">{{notify.data.article_title}}</a>
                                    </router-link>
                                </p>
                            </div>
                            <div class="widget-active--right__title" v-if="notify.data.type=='like'">
                                <p><a target="_blank" href="">{{notify.data.user_name}}</a>喜欢了你的文章
                                    <router-link :to="{ name: 'article', params: { id:notify.data.article_id}}">
                                        <a href=""  @click="markAsRead(notify.id)">{{notify.data.article_title}}</a>
                                    </router-link>
                                </p>
                            </div>
                            <div class="widget-active--right__title" v-if="notify.data.type=='follow'">
                                <p><a target="_blank" href="">{{notify.data.user_name}}</a>关注了你

                                </p>
                            </div>

                        </div>
                    </section>

                    <section class="widget-active__answer" v-if="unreadnotify.length=='0' && unread">
                        <div class="widget-active--left">
                        </div>
                        <div class="widget-active--right">
                            <div class="widget-active--right__title text-center">
                                <h2>没有未读消息</h2>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    export default{


        data(){
            return{
               unreadnotify:'',
               allnotify:'',
               unread:true,
               allread:false
            }
        },
        mounted(){

            this.getMessage()

        },

        methods:{

            getMessage(){

                this.$http.get('/api/user/getmessage')
                    .then((response) => {

                        this.unreadnotify=response.data.data.unreadnotify
                        this.allnotify=response.data.data.notify



                 })
            },
            markAsRead(id){
                 this.$http.get('/api/user/markasread/'+id)
                    .then((response) => {



                    })
            },
            markAllRead(){
                 this.$http.get('/api/user/markasread/')
                    .then((response) => {
                       this.unreadnotify=''


                    })
            },
            changeunread(){
                 this.allread=false
                 this.unread=true
            },
            changeall(){
                 this.allread=true
                 this.unread=false
            }


        }


    }
</script>
<style>
.container {
    font-size: 12px;
margin-top: 80px;
}
#conversations-sidebar {
    padding-left: 25px;
}
.row {
    margin-left: -15px;
    margin-right: -15px;
}
.lessons-nav {
    background: #f9f9f9;
}
.lessons-nav--forum ul {
    width: 100%;
}
.lessons-nav__primary {
    padding: 20px 10px 0 0;
}
.lessons-nav__primary {
    float: left;
    margin: 0;
    padding: 0;
}
.lessons-nav--forum li {
    margin-right: .8em;
    padding-right: .8em;
}
.lessons-nav li {
    border-right: none;
    font-size: 1.2em;
    display: inline-block;
    position: relative;
}
.lessons-nav--forum #lessons-nav--forum__leaderboard a {
    color: #4b4b4b;
}
.lessons-nav--forum li.active>a, .lessons-nav--forum li a:hover {
    border-bottom: 3px solid #00adb5;
    color: #00adb5;
}
.lessons-nav li.active a, .lessons-nav li>a:hover {
    color: #222;
    border-bottom: 3px solid #222;
}
.lessons-nav li a {
    display: block;
    padding-bottom: 15px;
    font-weight: 700;
    border-bottom: 3px solid transparent;
    color: #a7b3c2;
    text-decoration: none;
}
.widget-active section {
    padding: 10px 0;
    border-top: 1px solid #eee;
}
.widget-active--left {
    float: left;
    color: #ccc;
    font-size: 16px;
}
#notifications .widget-active__answer .fa {
    color: #4b4b4b;
}
.widget-active--right {
    margin-left: 30px;
}
</style>
