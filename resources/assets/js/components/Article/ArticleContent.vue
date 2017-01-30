<template>
    <div>
    <div class="container">
        <div class="author-info">
            <div class="btn btn-small"  :class="follow ?'btn-dafault following':'btn-success follow' ">
                <a data-type="json"  data-remote="true"  data-method="post" >
                    <i class='fa' :class="follow ? ' fa-check' :'fa-plus'"></i>
                    <span @click.prevent="addfollow()">{{ follow ? '已关注':'添加关注'}}</span></a>
            </div>


            <a class="avatar" >
                <img :src="articleDetail.user_avatar" alt="100">
            </a>            <span class="label">
                作者
            </span>
            <a class="author-name blue-link" href="/users/775437de46fe">
                <span>{{articleDetail.user_name}}</span>
            </a>              <span>{{articleDetail.published_time}}</span>
            <div>
                <span>被{{articleDetail.user_followings_count}}人关注</span>，<span>获得了{{articleDetail.user_likes_count}}个喜欢</span>
            </div>
        </div>
    </div>

    <div  class="content">
            <div class="article-container">
            <h1 class="title">{{ articleDetail.title }}</h1>
            <div class="counts">
                <span class="views-count">阅读{{articleDetail.visit_count}}</span>
                <span class="comments-count">评论{{articleDetail.comment_count}}</span>
                <span class="likes-count">喜欢{{articleDetail.like_count}}</span>
            </div>
            <div class="markdown-content"  v-html="markcontent"></div>
            </div>
    </div>
    </div>
</template>

<script>

export default {
    props:['articleDetail','follow','markcontent'],

       methods:{
          addfollow() {

           this.$parent.handleaddfollow()

          }
       }
}
</script>
<style>
.container .author-info {
    padding-top:15px;
	padding-bottom: 15px;
	margin-bottom: 30px;
	border-bottom: 1px solid #eeeeee;
	overflow: hidden;
	font-size: 12px;
	color: #999999
}

.container .author-info .follow,.container .author-info .following {
	float: right;
	margin-top: 10px
}

.container .author-info .follow>span,.container .author-info .following>span {
	display: inline-block;
	line-height: 13px
}

.container .author-info .avatar {
	float: left;
	width: 40px;
	height: 40px;
	margin-right: 10px
}

.container .author-info .label {
	background: none;
	border: 1px solid #e78170;
	color: #e78170;
	text-shadow: none;
	font-size: 11px;
	font-weight: normal;
	line-height: 1
}

.container .author-info .author-name {
	margin: 0 5px
}

.container .author-info>div {
	margin-top: 3px
}
.avatar img {
	width: 100%;
	height: 100%;
	border: 2px solid white;
	border-radius: 50%;
	box-sizing: border-box
}

.avatar:hover img {
	border-color: #e78170
}

</style>

