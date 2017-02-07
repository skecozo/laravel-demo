<template>
    <div class="navbar-box navbar-skin">
        <div class="navbar-menu">
            <router-link :to="'/'" >
            <a class="navbar-item logo" :class="{'active':$route.name !== 'apps'}" title="首页">
                简
            </a>
            </router-link>
        </div>

        <div class="navbar-expanded">
            <div>
                <a class="navbar-item change-mode" href="javascript:;" @click="changeMode()">
                    <i v-if="styleMode === 'day-mode'" class="fa fa-moon-o"></i>
                    <i v-else class="fa fa-sun-o"></i>
                </a>
            </div>
            <div v-if=" userInfo">
                <router-link :to="'/user/message'">
                    <a href="javascript:;" class="navbar-item "  title="消息">
                        <i class="fa fa-envelope"></i>
                        <i class="messagenum">{{unreadnotify.length}}</i>
                    </a>
                </router-link>

                <router-link :to="'/user'">
                <a href="javascript:;" class="navbar-item "  title="个人主页">
                    <i class=" fa fa-home"></i>
                </a>
                </router-link>

                <router-link :to="'/user/create'">
                <a href="javascript:;" class="navbar-item "  title="写文章">
                    <i class=" fa fa-pencil"></i>
                </a>
                </router-link>
                <a href="javascript:;" class="navbar-item expanded-logout" @click="logout()" title="登出">
                    <i class="fa fa-sign-out"></i>
                </a>
                <a  href="javascript:;" class="navbar-item expanded-avatar">
                    <img :src=" userInfo.avatar"/>
                </a>
            </div>
            <div v-else>
                <router-link :to="'/user'">
                <a  class="navbar-item" title="登录">
                    <i class="fa fa-sign-in"></i>
                </a>
                </router-link>
            </div>
        </div>


        <div class="navbar-shrink">
            <div v-if=" userInfo" class="pull-right">

                    <a href="javascript:;" class="shrink-avatar" data-toggle="dropdown">
                        <img :src=" userInfo.avatar"/>
                    </a>

                    <ul name="dropdown-menu" class="dropdown-menu pull-right">

                        <li>
                            <router-link :to="'/user/create'">
                            <a ><i class="fa fa-pencil"></i>写文章</a>
                            </router-link>
                        </li>

                        <li>
                            <router-link :to="'/user'">
                            <a ><i class="fa fa-home"></i>个人主页</a>
                            </router-link>
                        </li>

                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="javascript:;" class="shrink-logout" @click="logout()">
                                <i class="fa fa-sign-out"></i> 登出
                            </a>
                        </li>
                    </ul>
            </div>

            <div v-else class="pull-right">
                <router-link :to="'/user'">
                <a  class="shrink-login" title="登录">
                    <i class="fa fa-sign-in"></i> 登录
                </a>
                </router-link>
            </div>
            <a class="pull-right navbar-item change-mode" href="javascript:;" @click="changeMode()">
                <i v-if="styleMode === 'day-mode'" class="fa fa-moon-o"></i>
                <i v-else class="fa fa-sun-o"></i>
            </a>
        </div>

    </div>
</template>
<style>

</style>
<script>
import { mapGetters } from 'vuex'
    export default{
         computed: {
            ...mapGetters({
                userInfo: 'getUserInfo'
            })
         },

         data () {
            return {
                styleMode: localStorage.getItem('styleMode') || 'day-mode',
                unreadnotify:'',
            }
         },


         beforeMount(){

            document.body.className =  this.styleMode

         },

          mounted(){

                     this.getMessage();

          },

          methods:{
               changeMode(){
                        this.styleMode = (this.styleMode == 'day-mode')?'night-mode':'day-mode'
                        localStorage.setItem('styleMode',this.styleMode);
                        this.$nextTick(() => {
                          document.body.className = this.styleMode
                        })

                },
               logout() {
                         localStorage.removeItem('id_token')
                         localStorage.removeItem('user')
                         this.$store.dispatch('logoutuser');
                         this.$router.push('/')
               },
               getMessage(){
                    if(this.userInfo){
                        this.$http.get('/api/user/getmessage')
                                .then((response) => {

                                    this.unreadnotify=response.data.data.unreadnotify
                                    this.allnotify=response.data.data.notify



                                })
                                }
               },
          },
  }


</script>
<style>
    .messagenum{
    border-radius: 50%;

    color: #FFFFFF;
    position: absolute;
    width: 20px;
    height: 20px;
    background-color: #FF0000;

    }
</style>