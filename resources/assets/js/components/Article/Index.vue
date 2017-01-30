<template>
    <div class="article-box">
        <ArticleContent :articleDetail="articleDetail" :follow="follow"
                        :markcontent="markcontent"></ArticleContent>
        <Like :islike="islike" v-on:changelike="changelike"
              :likeCount='articleDetail.like_count' ></Like>
        <Comment :userInfo="userInfo"></Comment>

    </div>
</template>
<style>

</style>
<script>

import { mapGetters } from 'vuex';
import {marked} from '../../lib/utils';
export default{
    components: {
            'ArticleContent':require('./ArticleContent.vue'),
            'Comment':require('./Comment.vue'),
            'Like':require('./Like.vue')
            },


    computed: {
        ...mapGetters({
            userInfo: 'getUserInfo'
        })
    },

    data () {
            return {
        articleDetail:[],
                markcontent:'',
                islike:false,
                follow:false
            }
        },
    mounted(){

           this.getArticle()
    },

    methods:{

            getArticle(){

                    this.$http.get('/api/article/'+this.$route.params.id)
                            .then((response) => {
                    this.articleDetail=response.data.data
                    this.markcontent=marked(response.data.data.content)
                    this.islike=response.data.meta.meta.islike
                    this.follow=response.data.meta.meta.isfollower


                    })
            },

            changelike(payload) {
                this.islike=! this.islike,
                this.articleDetail.like_count=payload.article_like_count,
                this.articleDetail.user_likes_count=payload.user_like_count

            },

            handleaddfollow(){
                 this.$http.get('/api/user/'+this.articleDetail.user_id+'/follower')
                            .then((response) => {
                 this.follow=!this.follow
                 this.articleDetail.user_followings_count=response.data


                 })
            }



    }
  }
</script>
