<template>
    <div>
        <ul class="article-list list-unstyled clearfix">
            <li v-for="article in articleList" class="article-item" :class="article.images.length > 0 ? 'have-img' : ''">
                <a v-if="article.images.length > 0"  class="wrap-img">
                    <router-link :to="{ name: 'article', params: { id:article.id}}">
                    <img :src="article.images[0]" />
                    </router-link>
                </a>
                <div>
                    <p class="list-top">
                        <router-link :to="{ name: 'userhome', params: { id:article.user_id}}">
                        <a href="" class="author"><span>{{article.user_name}}</span></a>
                            </router-link>
                        <span class="time">{{ article.created_at}}</span>
                    </p>
                    <h4 class="title">

                        <router-link :to="{ name: 'article', params: { id:article.id}}">{{article.title}}</router-link>
                    </h4>
                    <div class="list-footer">
                        <span>阅读 {{article.visit_count}}</span>
                        <span> · 评论 {{article.comment_count}}</span>
                        <span> · 喜欢 {{article.like_count}}</span>
                    </div>
                </div>
            </li>
            <li v-if="articleList.length < 1" class="no-content">加载中</li>
        </ul>
    </div>
</template>
<style>

</style>
<script>
import { mapGetters } from 'vuex'
export default{

         props:['articleList']

        }
</script>
