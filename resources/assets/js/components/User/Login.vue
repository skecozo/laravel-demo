<template>
    <div class="sign">
    <div class="login">
    <div class="main">


        <h4 class="title">
            <div class="normal-title">
                <a :class="{active: sign == 'sign_in'}" @click="changeSign('sign_in') " >登录</a>
                <b>·</b>
                <a :class="{active: sign == 'sign_up'}" @click="changeSign('sign_up') ">注册</a>
            </div>
        </h4>

        <div class="js-sign-in-container" v-if="sign=='sign_in'">
            <form  accept-charset="UTF-8" method="post"  @submit.prevent="login()">
                <div class="input-prepend restyle js-normal">
                    <input placeholder="手机号或邮箱" type="text"
                           v-model="login_user.email">
                    <i class="fa fa-envelope-o"></i>
                </div>

                <div class="input-prepend">
                    <input placeholder="密码" type="password"
                           v-model="login_user.password">
                    <i class="fa fa-unlock-alt"></i>
                </div>
                <div class="remember-btn">
                    <input type="checkbox" value="true" checked="checked" ><span>记住我</span>
                </div>
                <div class="forget-btn">
                    <a class="" data-toggle="dropdown" href="">忘记密码?</a>
                    <ul class="dropdown-menu">
                        <li><a href="/users/password/mobile_reset">用手机号重置密码</a></li>
                        <li><a href="/users/password/email_reset">用邮箱重置密码</a></li>
                    </ul>
                </div>
                <input type="submit" name="commit" value="登录" class="sign-in-button">
            </form>
            <!-- 手机验证码登录modal -->

            <!-- 更多登录方式 -->
            <div class="more-sign">
                <h6>社交帐号登录</h6>
                <ul>
                    <li><a class="weibo" @click.stop.prevent="github()" ><i class="fa fa-github"></i></a>
                    </li>

            </div>
        </div>


        <div class="js-sign-up-container" v-if="sign=='sign_up'">
            <form class="new_user" accept-charset="UTF-8" method="post"
                  @submit.prevent="register()">
                <div class="input-prepend restyle">
                    <input placeholder="你的昵称"  type="text"
                           v-model="register_user.name">
                    <i class="fa fa-user"></i>
                </div>
                <div class="input-prepend restyle no-radius js-normal ">
                    <input placeholder="邮箱" type="text"
                         v-model="register_user.email">
                    <i class="fa fa-phone"></i>
                </div>


                <div class="input-prepend">
                    <input placeholder="设置密码" type="password"
                           v-model="register_user.password">
                    <i class="fa fa-unlock-alt"></i>
                </div>
                <input name="commit" value="注册" class="sign-up-button" type="submit">
                <p class="sign-up-msg">点击 “注册” 即表示您同意并愿意遵守简书<br> <a target="_blank" href="http://www.jianshu.com/p/c44d171298ce">用户协议</a> 和 <a target="_blank" href="http://www.jianshu.com/p/2ov8x3">隐私政策</a> 。</p>
            </form>  <!-- 海外手机号注册按钮 -->
            <!-- 更多注册方式 -->
            <div class="more-sign">
                <h6>社交帐号直接注册</h6>
                <ul>
                    <li><a class="weibo" ><i class="fa fa-github"></i></a></li>

                </ul>

            </div>
        </div>

    </div>
    </div>
    </div>
</template>
<script>
export default{

        data (){
            return {

                 sign:'sign_up',

                 register_user:{
                    email:'',
                    password:'',
                    name:''
                 },
                 login_user:{
                    email:'',
                    password:''
                 },
            }
        },

        mounted(){
           if(this.$route.query.type=='login'){

                 this.sign='sign_in'
           };

        },

        methods:{
             changeSign(sign){

                 this.sign =sign
                 console.log(windows.Session)
             },

             register(){
                 this.$http.post('/api/user/register',this.register_user )
                        .then((response) => {
                 this.$notify.success(response.data)


                  }, (response) => {

                  this.$notify.error(response.data)


                  })

             },

             login()
             {

             this.$http.post('/api/user/login',this.login_user )
                    .then((response) => {

                        let user =response.data.data
                    //   window.window.sessionStorage.user = JSON.stringify(user);
                    localStorage.setItem('id_token', response.data.meta.token);
                    localStorage.setItem('user', JSON.stringify(response.data.data));

                       //  console.log(localStorage.getItem('user'));

                        this.$store.dispatch('setUserInfo', user);
                        this.$router.push('/')


                    }, (response) => {

                       this.$notify.error(response.data)


                    })
             },

             github() {

                window.location.href = 'http://blog.hd/api/github'
                      this.$http.get('/api/github') .then((response) => {

                       let user =response.data.data
                    //   window.window.sessionStorage.user = JSON.stringify(user);
                         localStorage.setItem('id_token', response.data.meta.token);
                         localStorage.setItem('user', JSON.stringify(response.data.data));

                       //  console.log(localStorage.getItem('user'));

                        this.$store.dispatch('setUserInfo', user);
                        this.$router.go(-1)


                    })
             }



        },

    }
</script>
<style>
.sign {
    font-size: 14px;
    height: 100%;
    min-height: 750px;
    text-align: center;
}
.sign::before {
    content: "";
    display: inline-block;
    height: 85%;
    vertical-align: middle;
}
.sign .disable, .sign .disable-gray {
    opacity: 0.5;
    pointer-events: none;
}
.sign .disable-gray {
    background-color: #969696;
}
.sign .tooltip-error {
    background-attachment: scroll;
    background-clip: border-box;
    background-color: rgba(0, 0, 0, 0);
    background-image: none;
    background-origin: padding-box;
    background-position-x: 0;
    background-position-y: 0;
    background-repeat: repeat;
    background-size: auto auto;
    font-size: 14px;
    line-height: 25px;
    white-space: nowrap;
}
.sign .tooltip-error .tooltip-inner {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #fff;
    border-bottom-color: #ea6f5a;
    border-bottom-style: solid;
    border-bottom-width: 1px;
    border-image-outset: 0 0 0 0;
    border-image-repeat: stretch stretch;
    border-image-slice: 100% 100% 100% 100%;
    border-image-source: none;
    border-image-width: 1 1 1 1;
    border-left-color: #ea6f5a;
    border-left-style: solid;
    border-left-width: 1px;
    border-right-color: #ea6f5a;
    border-right-style: solid;
    border-right-width: 1px;
    border-top-color: #ea6f5a;
    border-top-style: solid;
    border-top-width: 1px;
    color: #333;
    max-width: 280px;
}
.sign .tooltip-error .tooltip-inner i {
    color: #ea6f5a;
    font-size: 20px;
    margin-right: 5px;
    position: static;
    vertical-align: middle;
}
.sign .tooltip-error .tooltip-inner span {
    display: inline-block;
    max-width: 230px;
    vertical-align: middle;
    white-space: normal;
}
.sign .tooltip-error.right .tooltip-arrow-border {
    border-right-color: #ea6f5a;
}
.sign .tooltip-error.right .tooltip-arrow-bg {
    border-right-color: #fff;
    left: 2px;
}
.sign .slide-error {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-bottom-color: #c8c8c8;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-bottom-style: solid;
    border-bottom-width: 1px;
    border-image-outset: 0 0 0 0;
    border-image-repeat: stretch stretch;
    border-image-slice: 100% 100% 100% 100%;
    border-image-source: none;
    border-image-width: 1 1 1 1;
    border-left-color: #c8c8c8;
    border-left-style: solid;
    border-left-width: 1px;
    border-right-color: #c8c8c8;
    border-right-style: solid;
    border-right-width: 1px;
    border-top-color: #c8c8c8;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    border-top-style: solid;
    border-top-width: 1px;
    margin-bottom: 15px;
    margin-left: 0;
    margin-right: 0;
    margin-top: 0;
    padding-bottom: 10px;
    padding-left: 0;
    padding-right: 0;
    padding-top: 10px;
}
.sign .slide-error i {
    color: #ea6f5a;
    font-size: 19px;
    margin-right: 10px;
    vertical-align: middle;
}
.sign .slide-error span {
    font-size: 15px;
    vertical-align: middle;
}
.sign .slide-error div {
    font-size: 13px;
    margin-top: 10px;
}
.sign .slide-error a {
    color: #3194d0;
}
.sign .logo {
    margin-left: 50px;
    position: absolute;
    top: 56px;
}
.sign .logo img {
    width: 100px;
}
.sign .main {
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
    display: inline-block;
    margin-bottom: 0;
    margin-left: auto;
    margin-right: auto;
    margin-top: 60px;
    padding-bottom: 30px;
    padding-left: 50px;
    padding-right: 50px;
    padding-top: 50px;
    vertical-align: middle;
    width: 400px;
}
.sign .reset-title, .sign .title {
    color: #969696;
    font-weight: 400;
    margin-bottom: 50px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 0;
    padding-bottom: 10px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 10px;
}
.sign .reset-title a, .sign .title a {
    color: #969696;
    padding-bottom: 10px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 10px;
    cursor: pointer;
}
.sign .reset-title a:hover, .sign .title a:hover {
    border-bottom-color: #ea6f5a;
    border-bottom-style: solid;
    border-bottom-width: 2px;
}
.sign .reset-title .active, .sign .title .active {
    border-bottom-color: #ea6f5a;
    border-bottom-style: solid;
    border-bottom-width: 2px;
    color: #ea6f5a;
    font-weight: 700;
}
.sign .reset-title b, .sign .title b {
    padding-bottom: 10px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 10px;
}
.sign .reset-title {
    color: #333;
    font-weight: 700;
}
.sign form {
    margin-bottom: 30px;
}
.sign form .input-prepend {
    margin-bottom: 20px;
    position: relative;
    width: 100%;
}
.sign form .input-prepend input {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: hsla(0, 0%, 71%, 0.1);
    border-bottom-color: #c8c8c8;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-bottom-style: solid;
    border-bottom-width: 1px;
    border-image-outset: 0 0 0 0;
    border-image-repeat: stretch stretch;
    border-image-slice: 100% 100% 100% 100%;
    border-image-source: none;
    border-image-width: 1 1 1 1;
    border-left-color: #c8c8c8;
    border-left-style: solid;
    border-left-width: 1px;
    border-right-color: #c8c8c8;
    border-right-style: solid;
    border-right-width: 1px;
    border-top-color: #c8c8c8;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-top-style: solid;
    border-top-width: 1px;
    height: 50px;
    margin-bottom: 0;
    padding-bottom: 4px;
    padding-left: 35px;
    padding-right: 12px;
    padding-top: 4px;
    vertical-align: middle;
    width: 100%;
}
.sign form .input-prepend i {
    color: #969696;
    font-size: 18px;
    left: 10px;
    position: absolute;
    top: 14px;
}
.sign form .input-prepend span {
    color: #333;
}
.sign form .input-prepend .ic-show {
    font-size: 12px;
    left: auto;
    right: 8px;
    top: 18px;
}
.sign form .restyle {
    margin-bottom: 0;
}
.sign form .restyle input {
    border-bottom-color: -moz-use-text-color;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-style: none;
    border-bottom-width: medium;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}
.sign form .no-radius input {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.sign form .slide-security-placeholder {
    background-color: hsla(0, 0%, 71%, 0.1);
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    height: 32px;
}
.sign form .slide-security-placeholder p {
    color: #999;
    margin-right: -7px;
    padding-top: 7px;
}
.sign .overseas-btn {
    color: #999;
    font-size: 14px;
}
.sign .overseas-btn:hover {
    color: #2f2f2f;
}
.sign .remember-btn {
    float: left;
    margin-bottom: 15px;
    margin-left: 0;
    margin-right: 0;
    margin-top: 15px;
}
.sign .remember-btn span {
    color: #969696;
    font-size: 15px;
    margin-left: 5px;
    vertical-align: middle;
}
.sign .forget-btn {
    float: right;
    font-size: 14px;
    margin-bottom: 15px;
    margin-left: 0;
    margin-right: 0;
    margin-top: 15px;
    position: relative;
}
.sign .forget-btn a {
    color: #999;
}
.sign .forget-btn a:hover {
    color: #333;
}
.sign .forget-btn .dropdown-menu {
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    left: auto;
    right: 0;
    top: 20px;
}
.sign .forget-btn .dropdown-menu a {
    color: #333;
    padding-bottom: 10px;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 10px;
}
.sign .sign-in-button, .sign .sign-up-button {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-attachment: scroll;
    background-clip: border-box;
    background-color: #42c02e;
    background-image: none;
    background-origin: padding-box;
    background-position-x: 0;
    background-position-y: 0;
    background-repeat: repeat;
    background-size: auto auto;
    border-bottom-color: -moz-use-text-color;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-bottom-style: none;
    border-bottom-width: medium;
    border-image-outset: 0 0 0 0;
    border-image-repeat: stretch stretch;
    border-image-slice: 100% 100% 100% 100%;
    border-image-source: none;
    border-image-width: 1 1 1 1;
    border-left-color: -moz-use-text-color;
    border-left-style: none;
    border-left-width: medium;
    border-right-color: -moz-use-text-color;
    border-right-style: none;
    border-right-width: medium;
    border-top-color: -moz-use-text-color;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    border-top-style: none;
    border-top-width: medium;
    clear: both;
    color: #fff;
    cursor: pointer;
    display: block;
    font-size: 18px;
    outline-color: -moz-use-text-color;
    outline-style: none;
    outline-width: medium;
    padding-bottom: 9px;
    padding-left: 18px;
    padding-right: 18px;
    padding-top: 9px;
    width: 100%;
}
.sign .sign-in-button:hover, .sign .sign-up-button:hover {
    background-attachment: scroll;
    background-clip: border-box;
    background-color: #3db922;
    background-image: none;
    background-origin: padding-box;
    background-position-x: 0;
    background-position-y: 0;
    background-repeat: repeat;
    background-size: auto auto;
}
.sign .sign-in-button {
    background-attachment: scroll;
    background-clip: border-box;
    background-color: #3194d0;
    background-image: none;
    background-origin: padding-box;
    background-position-x: 0;
    background-position-y: 0;
    background-repeat: repeat;
    background-size: auto auto;
}
.sign .sign-in-button:hover {
    background-attachment: scroll;
    background-clip: border-box;
    background-color: #187cb7;
    background-image: none;
    background-origin: padding-box;
    background-position-x: 0;
    background-position-y: 0;
    background-repeat: repeat;
    background-size: auto auto;
}
.sign .btn-in-resend, .sign .btn-up-resend {
    background-color: #42c02e;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    color: #fff;
    font-size: 13px;
    height: 36px;
    line-height: 36px;
    position: absolute;
    right: 7px;
    top: 7px;
    width: 100px;
}
.sign .btn-in-resend {
    background-color: #3194d0;
}
.sign .sign-up-msg {
    color: #969696;
    font-size: 12px;
    line-height: 20px;
    margin-bottom: 10px;
    margin-left: 0;
    margin-right: 0;
    margin-top: 10px;
    padding-bottom: 0;
    padding-left: 0;
    padding-right: 0;
    padding-top: 0;
    text-align: center;
}
.sign .sign-up-msg a, .sign .sign-up-msg a:hover {
    color: #3194d0;
}
.sign .overseas input {
    padding-left: 110px !important;
}
.sign .overseas .overseas-number {
    border-right-color: #c8c8c8;
    border-right-style: solid;
    border-right-width: 1px;
    color: #969696;
    font-size: 18px;
    height: 50px;
    left: 0;
    position: absolute;
    top: 0;
    width: 100px;
}
.sign .overseas .overseas-number span {
    display: block;
    font-size: 14px;
    margin-top: 17px;
    padding-left: 35px;
    text-align: left;
}
.sign .overseas .dropdown-menu {
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    font-size: 14px;
    max-height: 285px;
    overflow-y: auto;
    width: 100%;
}
.sign .overseas .dropdown-menu li .nation-code {
    display: inline-block;
    width: 65px;
}
.sign .overseas .dropdown-menu li a {
    font-size: 14px;
    line-height: 20px;
    padding-bottom: 6px;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 6px;
}
.sign .more-sign {
    margin-top: 30px;
}
.sign .more-sign h6 {
    color: #b5b5b5;
    font-size: 12px;
    margin-bottom: 20px;
    margin-left: 0;
    margin-right: 0;
    margin-top: 0;
    position: relative;
}
.sign .more-sign h6::before {
    left: 30px;
}
.sign .more-sign h6::after, .sign .more-sign h6::before {
    border-top-color: #b5b5b5;
    border-top-style: solid;
    border-top-width: 1px;
    content: "";
    display: block;
    position: absolute;
    top: 5px;
    width: 60px;
}
.sign .more-sign h6::after {
    right: 30px;
}
.sign .more-sign ul {
    list-style-image: none;
    list-style-position: outside;
    list-style-type: none;
    margin-bottom: 30px;
}
.sign .more-sign ul li {
    display: inline-block;
    margin-bottom: 0;
    margin-left: 3px;
    margin-right: 3px;
    margin-top: 0;
}
.sign .more-sign ul a {
    background-color: hsla(0, 0%, 71%, 0.2);
    border-bottom-left-radius: 50%;
    border-bottom-right-radius: 50%;
    border-top-left-radius: 50%;
    border-top-right-radius: 50%;
    display: block;
    height: 50px;
    line-height: 50px;
    width: 50px;
     cursor: pointer;
}
.sign .more-sign ul i {
    font-size: 24px;
}
.sign .more-sign .weibo {
    background-color: #e05244;
}
.sign .more-sign .weixin {
    background-color: #00bb29;
}
.sign .more-sign .qq {
    background-color: #498ad5;
}
.sign .more-sign .douban {
    background-color: #00820f;
}
.sign .more-sign .google {
    background-color: #e05244;
}
.sign .more-sign .iconfont {
    color: #fff;
}
.sign .more-sign .ic-more {
    color: #787878;
}
.sign .reset-password-input {
    border-bottom-left-radius: 4px !important;
    border-bottom-right-radius: 4px !important;
    border-top-left-radius: 4px !important;
    border-top-right-radius: 4px !important;
}
.sign .return {
    color: #969696;
    margin-left: -8px;
}
.sign .return:hover {
    color: #333;
}
.sign .return i {
    margin-right: 5px;
}
.sign .icheckbox_square-green {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-attachment: scroll;
    background-clip: border-box;
    background-color: rgba(0, 0, 0, 0);
    background-image: url("/assets/radio/green-062604c1c0196db73a5dda860fdbddb0.png");
    background-origin: padding-box;
    background-position-x: 0;
    background-position-y: 0;
    background-repeat: no-repeat;
    background-size: auto auto;
    border-bottom-color: -moz-use-text-color;
    border-bottom-style: none;
    border-bottom-width: medium;
    border-image-outset: 0 0 0 0;
    border-image-repeat: stretch stretch;
    border-image-slice: 100% 100% 100% 100%;
    border-image-source: none;
    border-image-width: 1 1 1 1;
    border-left-color: -moz-use-text-color;
    border-left-style: none;
    border-left-width: medium;
    border-right-color: -moz-use-text-color;
    border-right-style: none;
    border-right-width: medium;
    border-top-color: -moz-use-text-color;
    border-top-style: none;
    border-top-width: medium;
    cursor: pointer;
    display: inline-block;
    height: 18px;
    margin-bottom: 0;
    margin-left: 0;
    margin-right: 0;
    margin-top: 0;
    padding-bottom: 0;
    padding-left: 0;
    padding-right: 0;
    padding-top: 0;
    vertical-align: middle;
    width: 18px;
}
.sign .icheckbox_square-green.hover {
    background-position-x: -20px;
    background-position-y: 0;
}
.sign .icheckbox_square-green.checked {
    background-position-x: -40px;
    background-position-y: 0;
}
.sign .icheckbox_square-green.disabled {
    background-position-x: -60px;
    background-position-y: 0;
    cursor: default;
}
.sign .icheckbox_square-green.checked.disabled {
    background-position-x: -80px;
    background-position-y: 0;
}
@media not all, (min-resolution: 1.25dppx), (min-resolution: 120dpi) {
.sign .icheckbox_square-green {
    background-image: url("/assets/radio/green@2x-7f6fb7d319eec1b0f9e6cb4bc65b1146.png");
    background-size: 200px 20px;
}
}
</style>

