<template>
    <div @keyup="myMethod()" :class="[key_style ? '' : 'hide-wrap-btn']" class="wrap-btn " style="top: -1px;">
        <!-- Notebook and collections button upper left -->
        <div class="article-related pull-left">
            <a class="collection-menu-btn" data-toggle="modal" data-target="#collection-menu" href="javascript:void(null);">
                <i class="fa fa-th"></i>
            </a>          <a class="notebooks-menu-btn" data-toggle="modal" data-target="#notebooks-menu" href="javascript:void(null);"><i class="fa fa-list-ul"></i></a>
            <div class="related-avatar-group activities"></div>
        </div>
        <!-- ******* -->
        <div v-if="userInfo" class="navbar-shrink"  >
        <div>
            <a  href="" class="pull-right shrink-avatar" data-toggle="dropdown"  data-hover="dropdown"   style="top:-3px"
               >
                <img :src=" userInfo.avatar" >
            </a>

            <ul  class="dropdown-menu pull-right"    style="margin-top: 0px">

                <li>
                    <router-link :to="'/user/index'">
                        <a href=""> <i class="fa fa-user"></i>
                            个人主页
                        </a>

                    </router-link></li>

                <li>
                    <router-link :to="'/create'">
                        <a href="#"> <i class="fa fa-heart"></i>
                            写文章
                        </a>
                    </router-link>
                </li>
                <li role="separator" class="divider"></li>
                <li> <a href="" @click.prevent="logout()">  <i class="fa fa-sign-out"   ></i> 退出登录</a></li>
            </ul>

        </div>
            <router-link :to="'/user/message'">
            <a class="notify pull-right " data-toggle="modal" >
                <i class="fa fa-envelope" ></i>
                <i class="num" v-if="unreadnotify.length>0">{{unreadnotify.length}}</i>
            </a>
            </router-link>


        </div>
<div v-else>
    <router-link :to="{ name: 'user', query: { type: 'register' }}" >
        <a class="login" data-signup-link="true" data-toggle="modal" href="">
            <i class="fa fa-user"></i> 注册
        </a>
    </router-link>
    <router-link :to="{ name: 'user', query: { type: 'login' }}" >
    <a class="login" data-signin-link="true" data-toggle="modal" href="/sign_in">
        <i class="fa fa-sign-in"></i> 登录
    </a>
    </router-link>
</div>

        <!-- Buttons upper right -->
        <!-- ******* -->

    </div>
</template>
<style>
.num {
    background-color: #80bd01;
    color: #fff;
    width: 20px;
    height: 20px;
    line-height: 20px;
    vertical-align: middle;
    text-align: center;
    border-radius: 50%;
    position: absolute;
    right: 70px;
    top: 30px;
    z-index: 10;
  }
</style>
<script>
 import { mapGetters } from 'vuex'
    export default{
      computed: {
            ...mapGetters({
                userInfo: 'getUserInfo'
            })
            },
        data(){
            return{
                key_style:true,
                key_code:'0',
                unreadnotify:'',

            }
        },
        mounted()
        {

        this.getMessage();
         window.addEventListener('scroll', this.myMethod)

        },
         methods: {
         getMessage()
         {
            this.$http.get('/api/user/getmessage')
                    .then((response) => {
                        console.log(response.data.data);
                        this.unreadnotify=response.data.data.unreadnotify
                        this.allnotify=response.data.data.notify



                    })
         },
          myMethod () {


                        if(this.key_code>document.body.scrollTop){
                               this.key_code=document.body.scrollTop
                               this.key_style=false
                            }
                           else{
                               this.key_code=document.body.scrollTop
                               this.key_style=true
                            }




                },
                 logout()
       {
        localStorage.removeItem('id_token')
        localStorage.removeItem('user')
        this.$store.dispatch('logoutuser');
       }

        },
        components:{

        }
    }
</script>
<style>
   .notify {
    width: 32px;
    height: 32px;
    margin-right: 10px;
    display: inline-block;
    border-radius: 50%;
    border: 1px solid #e78170;
    color: #e78170;
    text-align: center;
    line-height: 32px;
}
</style>
