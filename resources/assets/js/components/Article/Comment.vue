<template>
    <div class="comment-container clearfix">
        <div class="comment-head clearfix">
            {{commentList.length }}条评论
            <a href="javascript:;" @click.prevent="goComment" class="goto-comment pull-right"><i class="fa fa-pencil"></i>添加新评论</a>
        </div>

        <div id="comment_list" >
            <div class="comment-item" v-for="(comment,index) in commentList">
                <div class="content">
                    <div class="meta-top">
                        <a class="avatar">
                            <img :src="comment.user_avatar " alt="comment.user_name" />
                        </a>
                        <a class="author-name link-light">{{comment.user_name}}</a>
                              <span class="reply-time">
                                {{comment.created_at}}
                              </span>
                    </div>

                    <p class="markdown-content" v-html="comment.content_html"></p>


                    <div class="comment-footer text-right">
                        <a v-if="userInfo.id==comment.user_id" class="reply" href="javascript:;" @click.prevent="deletecomment(index,comment)"><i class="fa fa-trash-o"></a>
                        <a v-if="userInfo.id==comment.user_id" class="reply" href="javascript:;" @click.prevent="showrevise(index)"><i class="fa fa-pencil"></a>
                        <a class="reply" href="javascript:;" @click.prevent="showReply(index,comment.user_name)"><i class="fa fa-reply"></a>
                    </div>

                    <reply v-show="comment.replys.length > 0" :replys="comment.replys" :index="index"></reply>

                    <form :id="index" :class="revise===index ? 'new_comment' :'new_comment hide'" @submit.prevent="reviseComment(comment)">
                        <div class="comment-text ">
                            <textarea v-model="comment.content" ></textarea>
                            <div>
                                <input type="submit"  value="修改评论" class="btn btn-info" />
                            </div>
                        </div>
                    </form>

                    <form :id="index" :class="reply===index ? 'new_comment' :'new_comment hide'" @submit.prevent="submitReply(index,comment)">
                        <div class="comment-text ">
                            <textarea v-model="replycontent"></textarea>
                            <div>
                                <input type="submit"  value="添加回复" class="btn btn-info" />
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <form v-show="userInfo" class="new_comment" @submit.prevent="submitComment()">
            <div class="comment-text">
                <textarea rows="7" id="editor" ></textarea>
                <div>
                    <input type="submit" id="comment_submit_btn" value="发表评论" class="btn btn-info" />
                </div>
            </div>
        </form>
        <div v-show="!userInfo">
            <p class="comment-signin">
                <button class="btn btn-info" @click.prevent="openLoginModal()">登录后发表评论</button>
            </p>
        </div>
    </div>
</template>
<style>

</style>
<script>
import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'
import { mapGetters } from 'vuex'
import {marked} from '../../lib/utils';
import $ from 'jquery'
export default{
      components:{'reply':require('./reply.vue') },
      computed: {
            ...mapGetters({
                userInfo: 'getUserInfo'
            })
        },
      data(){
            return {
                commentList:[],
                simplemde:'',
                revise:'',
                reply:'',
                replycontent:''


            }
      },


      mounted() {
         this.getCommentList();

             var simplemde =  this.simplemde = new SimpleMDE({
                   element: document.getElementById("editor"),
                    autofocus: false,
                    autoDownloadFontAwesome: false,
                    spellChecker: false,
                    placeholder: '写下你的评论',
                    toolbar: false,
                    tabSize: 1,
                });

            },
      methods:{
              getCommentList(){
              this.$http.get('/api/article/'+this.$route.params.id+'/comment')
                      .then((response) => {

                  response.data.data.forEach((data) => {
                      data.content_html = marked(data.content)
                      return data
                  })
                  this.commentList=response.data.data

                  })

             },
       //   goComment(){
        //  $('.CodeMirror').focus()
       // this.simplemde.autofocus.==true


        //  },
              submitComment(){
                  var formData = new FormData(event.target)
                  formData.append('user_id', this.userInfo.id)
                  formData.append('id', this.$route.params.id)
                  formData.append('type', 'article')
                  formData.append('content', this.simplemde.value())


                  this.$http.post('/api/comment', formData)
                          .then((response) => {
                  let Data = {
                    ...response.data.data,
                          content_html:marked(response.data.data.content)
                    };
                    this.simplemde.codemirror.setValue('')

                  this.commentList.push(
                          Data
                  );

              }, (response) => {

                     this.$notify.error(response.data)


                            })

              },
              showrevise(index){
                    this.revise=(this.revise===index) ?  '': index

              },

              reviseComment(comment){
                     this.$http.put('/api/comment/'+comment.id, comment)
                          .then((response) => {
                             comment.content_html=marked(response.data.data.content)
                             comment.content=''
                     })

              },

              deletecomment(index,comment){
                     this.$http.delete('/api/comment/'+comment.id)
                          .then((response) => {
                             this.commentList.splice(index,1)
                     })


              },
              showReply(index,name){
                    this.reply=(this.reply===index) ?  '': index
                    this.replycontent='@'+name
              },


              submitReply(index,comment){
                  var formData = new FormData(event.target)
                  formData.append('user_id', this.userInfo.id)
                  formData.append('id', comment.id)
                  formData.append('type', 'comment')
                  formData.append('content', this.replycontent)


                    this.$http.post('/api/comment/reply',formData)
                              .then((response) => {
                             this.commentList[index].replys.push({
                                                      id:response.data.data.id,
                                                      content:response.data.data.content,
                                                      created_at:response.data.data.created_at,
                                                      user:{
                                                      id:response.data.data.user_id,
                                                      name:response.data.data.user_name
                                                      },
                                                     });
                         })
              }

          }
        }
</script>
<style>

</style>
