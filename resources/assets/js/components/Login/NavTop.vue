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

      <a class="app-download-btn" href="/apps/download?utm_medium=top-sugg-down&amp;utm_source=note-show">App下载</a>
      <a class="login" data-signup-link="true" data-toggle="modal" href="/sign_up">
         <i class="fa fa-user"></i> 注册
      </a>  <a class="login" data-signin-link="true" data-toggle="modal" href="/sign_in">
      <i class="fa fa-sign-in"></i> 登录
   </a>

      <!-- Buttons upper right -->
      <!-- ******* -->

   </div>
</template>
<style>
.wrap-btn {
    font-family: -apple-system, "Helvetica Neue", Arial, "PingFang SC", "lucida grande", "lucida sans unicode", lucida, helvetica, "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
}
</style>
<script>
import { mapGetters } from 'vuex'
    export default{
   computed: {
            ...mapGetters({
                  key_style:'key_style'

                })
            },

    mounted () {
         //   window.addEventListener('keyup', this.myMethod)
            window.addEventListener('scroll', this.myMethod)
    },
 methods: {      //这里使用methods

                    over(message, event) {
                        alert(message+event);   //弹出鼠标从我上面滑过,事件是[object MouseEvent]
                    },
                   warn() {
                        alert('1');   //弹出鼠标从我上面滑过,事件是[object MouseEvent]
                    },
                     myMethod () {
 // alert(document.body.scrollTop)
                   this.$store.dispatch('change_key_code',document.body.scrollTop)
                }
                }

    }
</script>
