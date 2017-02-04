<template>
    <div class="col-sm-3 sidebar-box">
        <div v-if="indexImg">
            <div class="cover-img" :style="{backgroundImage: 'url(' + indexImg + ')'}"></div>
                 <div class="bottom-block">
                    <h1>简书</h1>
                    <h3>交流故事，沟通想法</h3>
                    <p>一个基于内容分享的社区</p>
                    <router-link :to="'/user/create'">
                    <a><i class="fa fa-home"></i>提笔写篇文章</a>
                    </router-link>
                </div>
        </div>
    </div>
</template>
<script>
export default{
    data(){
       return {
            indexImg:'http://upload.jianshu.io/daily_images/images/Jmy82E7yJEBiBNAuGU_N.jpg'

       }
    }
  }



</script>
<style>
  .bottom-block a {
    color: #ffffff;
    text-align: center;
    display: block;
    width: 120px;
    border-radius: 5px;
    height: 30px;
    background-color: #6bd95b;
}
</style>