<template>
   <div>
        <div class="user" v-if="user">
            <div class="row-fluid" >
                <!-- aside -->
                <div class="user-aside col-sm-10"  >
                    <div class="people">

                        <div class="basic-info">
                            <div class="avatar">
                                <img :src="user.avatar" alt="3">
                            </div>
                            <h3><a style="display: inline;">{{user.name}}</a></h3>
                        </div>

                        <div class="user-stats ">
                            <ul class="clearfix">
                                <li>
                                    <a href=""><b>{{user.followers_count}}</b><span>关注</span></a>
                                </li>
                                <li>
                                    <a href=""><b>{{user.followings_count}}</b><span>粉丝</span></a>
                                </li>
                                <br>
                                <li>
                                    <a href=""><b>{{user.contents_count}}</b><span>文章</span></a>
                                </li>

                                <li>
                                    <a><b>{{user.likes_count}}</b><span>收获喜欢</span></a>
                                </li>
                            </ul>
                        </div>
                        <div style="  color: #fff">
                    <button class="btn btn-large btn-success" href="">关注</button>
                        </div>
                    <!-- <hr> notebooks -->
                    <!-- <hr> collections -->
                    <!-- <hr> editable collections -->
                </div>
                </div>

            </div>
        </div>
    </div>
</template>
<style>

</style>

<script>
    import { mapGetters } from 'vuex'
export default{
        data(){
            return{
                user:''
            }
        },

        computed: {
            ...mapGetters({
                userInfo: 'getUserInfo',

            })
        },
        mounted() {

            this.getUser()



        },

        methods:{

            getUser(){

                this.$http.get('/api/user/userinfo/'+this.$route.params.id)
                        .then((response) => {

                this.user=response.data.data


                })
            },


        }
    }
</script>
<style>

    body.night-mode .timeline-content .article .article-content,
    body.night-mode .timeline-content .comment-content   {
        background-color: #2f2f2f;
    }.row-fluid {
	width: 100%;
	*zoom: 1
}

.row-fluid:before,.row-fluid:after {
	display: table;
	content: "";
	line-height: 0
}

.row-fluid:after {
	clear: both
}

.row-fluid [class*="span"] {
	display: block;
	width: 100%;
	min-height: 30px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	float: left;
	margin-left: 0%;
	*margin-left: -0.05319%
}

.row-fluid [class*="span"]:first-child {
	margin-left: 0
}

.row-fluid .controls-row [class*="span"]+[class*="span"] {
	margin-left: 0%
}



.row-fluid .span3 {
	width: 25.0%;
	*width: 24.94681%
}



.row-fluid .span9 {
	width: 75.0%;
	*width: 74.94681%
}


.row-fluid .offset3 {
	margin-left: 25.0%;
	*margin-left: 24.89362%
}

.row-fluid .offset3:first-child {
	margin-left: 25.0%;
	*margin-left: 24.89362%
}

.user .user-aside {
	position: fixed;
	top: 0;
	bottom: 0;
	left: 45px;
	padding: 80px 30px;
	overflow: auto;
	border-right: 1px solid #d9d9d9;
	box-shadow: -1px 1px 6px rgba(0,0,0,0.35)
}

.user .people {
	padding: 0 0 20px;
	text-align: center
}

.user .people .avatar {
	width: 90px;
	height: 90px;
	margin: 0 auto 10px
}

.user .basic-info .signed_author {
	display: block;
	width: 108px;
	height: 24px;
	margin-left: auto;
	margin-right: auto;
	margin-bottom: 15px;
	border: 1px solid #e78170;
	border-radius: 13px;
	font-size: 12px;
	line-height: 24px;
	color: #e78170;
	text-align: center
}

.user .basic-info .signed_author img {
	height: 14px
}

.user .basic-info .about {
	margin: 15px 0;
	text-align: center
}

.user .basic-info .about p.intro {
	margin-bottom: 0;
	line-height: 24px;
	word-wrap: break-word
}

.user .basic-info .about a {
	font-size: 12px;
	font-weight: normal;
	line-height: 20px
}

.user .basic-info .about .cancel,.user .basic-info .about .cancel:hover {
	color: #555555
}

.user .basic-info p i {
	position: relative;
	top: -1px;
	margin-right: 5px
}

.user .btn-group>.dropdown-menu {
	right: 0;
	min-width: inherit;
	text-align: left;
	font-size: 12px
}

.user .btn-group>.dropdown-menu::before,.user .btn-group>.dropdown-menu::after {
	left: 88px
}

.user .btn-group>.dropdown-menu::before {
	top: -9px
}

.user .btn-group>.dropdown-menu::after {
	top: -8px
}

.user .btn-group>.dropdown-menu .divider {
	margin: 5px 0
}

.user .btn-group>.dropdown-menu i {
	width: 14px;
	display: inline-block
}

.user .btn-group>.dropdown-menu .dropdown-menu {
	min-width: inherit;
	width: 116px;
	border-top-right-radius: 0;
	-webkit-transform: translate(-116px, 32px);
	-ms-transform: translate(-116px, 32px);
	transform: translate(-116px, 32px)
}

.user .btn-group>.dropdown-menu .dropdown-menu a {
	padding: 3px 10px
}

.user .basic-info .about .intro-form {
	display: none
}

.user .basic-info .about .intro-form textarea,.user .basic-info .about .intro-form input[type="text"] {
	width: 100%;
	max-height: 300px;
	padding: 10px;
	resize: none;
	box-sizing: border-box
}

.user .basic-info .about .intro-form input[type="text"] {
	height: 38px
}

.user .basic-info .sns a {
	width: 20px;
	height: 20px;
	padding: 0 2px;
	display: inline-block
}

.user .basic-info .sns a i {
	border-radius: 3px;
	color: white
}

.user .basic-info .sns a .fa-weixin {
	padding: 3px 2px;
	background: #49be38;
	vertical-align: middle;
	font-size: 14px
}

.user .basic-info .sns a img {
	border-radius: 3px;
	opacity: 0.8;
	filter: alpha(opacity=80)
}

.user .basic-info .sns a img:hover {
	opacity: 1;
	filter: alpha(opacity=100)
}

.user .user-stats {
	margin-top: 15px;
	font-size: 12px;
	color: #999999
}

.user .user-stats ul {
	margin: 0
}

.user .user-stats li {
	display: inline-block;
	margin-bottom: 10px;
	border-right: 1px solid #d9d9d9;
	text-align: left
}

.user .user-stats li:last-child {
	border: none
}

.user .user-stats a {
	padding: 0 10px
}

.user .user-stats li a,.user .user-stats li b {
	display: block;
	font-size: 16px;
	font-weight: normal
}

.user .user-stats li b {
	font-style: italic
}

.user .user-stats span {
	font-size: 12px
}

.user .my-books,.user .my-collections {
	margin-bottom: 30px
}

.user .recent-post {
	max-width: 800px;
	padding: 30px 80px;
	word-break: break-word
}

.user .recent-post ul.nav-tabs {
	margin-bottom: 0;
	border-width: 2px
}

.user .recent-post ul.nav-tabs li {
	margin-right: 20px
}

.user .recent-post ul.nav-tabs li i {
	display: none
}

.user .recent-post ul.nav-tabs li a,.user .recent-post ul.nav-tabs li a:hover {
	padding-left: 0;
	padding-right: 0;
	margin-bottom: -1px;
	background: none;
	border: none;
	border-radius: 0
}

.user .recent-post ul.nav-tabs li.active a {
	border-bottom: 2px solid #555555
}

.user .recent-post ul.nav-tabs li.pull-right {
	margin-right: 0
}

.user .recent-post ul.nav-tabs li.pull-right a {
	font-size: 12px
}

.user .recent-post .article-list {
	margin-top: 20px
}

.user .recent-post .article-list .list-top .author-name,.user .recent-post .article-list .list-top em {
	display: none
}

.user .recent-post .subscribing li .avatar {
	background: #e78170;
	text-align: center;
	line-height: 40px
}

.user .recent-post .subscribing li .avatar i {
	color: white
}

.user .recent-post .subscribing a.follow {
	margin-top: 7px
}

@media (max-width: 768px) {
	.user .user-aside {
		position: static;
		float: none;
		width: 100%;
		padding: 70px 10px 10px;
		border-right: 0;
		box-shadow: none
	}

	.user .people {
		padding-top: 45px
	}

	.user .user-stats br {
		display: none
	}

	.user .recent-post {
		float: none;
		width: 100%;
		padding: 10px;
		margin-left: 0
	}
}

@media (min-width: 1588px) {
	.user .user-aside {
		left: 170px
	}
}

.timeline-content {
	margin: 0 0 20px 0;
	list-style-type: none
}

.timeline-content li {
	position: relative;
	padding: 30px 0 30px 30px;
	margin-left: 60px;
	border-left: 1px solid #d9d9d9
}

.timeline-content a {
	color: #4094c7
}

.timeline-content a:hover {
	color: #075b8d
}

.timeline-content a.active,.timeline-content a:active,.timeline-content a:focus {
	color: #075b8d
}

.timeline-content a.disabled,.timeline-content a.disabled:hover,.timeline-content a.disabled:focus,.timeline-content a.disabled:active,.timeline-content a.disabled.active,.timeline-content a[disabled],.timeline-content a[disabled]:hover,.timeline-content a[disabled]:focus,.timeline-content a[disabled]:active,.timeline-content a[disabled].active {
	cursor: not-allowed;
	color: #999999
}

.timeline-content .meta {
	margin-top: 7px;
	font-size: 12px;
	color: #999999
}

.timeline-content .meta a {
	margin-right: 5px
}

.timeline-content .timeline-list {
	max-width: 1000px
}

.timeline-content .avatar-container {
	position: absolute;
	top: 30px;
	left: -22px;
	bottom: 0
}

.timeline-content .avatar {
	width: 40px;
	height: 40px;
	display: inline-block;
	border: 2px solid white;
	text-align: center
}

.timeline-content .avatar i {
	display: inline-block;
	margin-top: 13px;
	color: white
}

.timeline-content .collection-update .avatar,.timeline-content .notebook-update .avatar {
	background-color: #e78170
}

.timeline-content .article .article-content {
	background-color: whitesmoke
}

.timeline-content .article .title {
	display: block;
	padding: 20px 20px 0;
	font-size: 18px;
	font-weight: bold;
	line-height: 27px
}

.timeline-content .article p {
	padding: 10px 20px 20px;
	font-size: 12px
}

.timeline-content .comment-content {
	display: inline-block;
	padding: 10px 15px;
	margin: 0;
	background-color: whitesmoke
}

.timeline-content .comment-content i {
	color: #b1b1b1;
	font-size: 10px
}

.timeline-content .comment-content .fa-quote-left {
	margin-right: 5px
}

.timeline-content .comment-content .fa-quote-right {
	margin-left: 5px
}

.timeline-content .comment-content img {
	width: 20px;
	height: 20px
}

.timeline-content .comments {
	padding: 10px;
	margin: 10px 0 0;
	background-color: whitesmoke
}

.timeline-content .comments img {
	display: block;
	margin: 0 auto
}

.timeline-list .article-list {
	margin-top: 20px;
	margin-left: 35px
}

@media (max-width: 767px) {
	.user .timeline-left-aside {
		left: 40px;
		border: 1px solid #d9d9d9
	}
}

@media (max-width: 768px) {
	.timeline-content li {
		margin-left: 40px
	}

	.timeline-list .article-list {
		margin-left: 0
	}
}

@media (max-width: 979px) {
	.user .timeline-left-aside .help-block {
		display: none
	}
}

</style>
