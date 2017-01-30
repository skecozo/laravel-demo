<template>

    <div class="col-md-8 col-sm-offset-2  ">
    <form  @submit.prevent="addArticle"  role="form"  >
    <div class="col-sm-10">
        <input  v-model="article.title" id="title" class="form-control" style="height:40px"  name="title" type="text" placeholder="请输入标题">
    </div>
    <div class="col-sm-10">
        <multiselect v-model="article.tag"
                     tag-placeholder="Add this as new tag"
                     placeholder="添加或搜索标签"
                     label="text"
                     track-by="id"
                     :options="allTag"
                     :multiple="true"
                     :taggable="true"
                     :limit="5"
                     >
        </multiselect>
    </div>
        <div class="form-group">
            <div class="col-sm-10">
                <textarea id="editor"></textarea>
            </div>
        </div>
        <div class="col-sm-10">
            <button  type="submit" class="btn btn-primary pull-right" style="font-weight: bold;">
                发表帖子
            </button>
        </div>

        </form>
    </div>



</template>
<style >
    .col-md-8
    {
    margin-top:50px
    }
</style>
<script>
import { default as SimpleMDE } from 'simplemde/dist/simplemde.min.js'
import Multiselect from 'vue-multiselect'
import marked from '../../lib/utils'
import highlight from 'highlight.js'
import { mapGetters } from 'vuex'
export default{
        components: {
            Multiselect

        },

        computed: {
            ...mapGetters({
                userInfo: 'getUserInfo'
            })
            },

        data(){
            return {


                allTag: [],
                simplemde:'',
                article: {
                    tag: [],
                    title: '',
                    content: '',
                },
            }
              },

        created() {

               this.$http.get('/api/tags')
                    .then((response) => {
                        this.allTag = response.data.data
                    })
            },
        mounted() {
               var simplemde = this.simplemde= new SimpleMDE({
                     element: document.getElementById("editor"),
                     autoDownloadFontAwesome: false,
                    spellChecker: false,
                    placeholder: '将图片直接拖动到编辑区即可上传',
               });
                simplemde.codemirror.on("drop", function(editor,e){
                             // console.log(e.dataTransfer.files[0]);
                      if(!(e.dataTransfer&&e.dataTransfer.files)){
                          alert("该浏览器不支持操作");
                          return;
                      }
                      for(var i=0;i<e.dataTransfer.files.length;i++){
                          console.log(e.dataTransfer.files[i]);
                          fileUpload(e.dataTransfer.files[i]);
                      }
                      e.preventDefault();
                            });

                simplemde.codemirror.on("paste",function(editor,e){
                      if(!(e.clipboardData&&e.clipboardData.items)){
                      alert("该浏览器不支持操作");
                      return;
                      }
                      for (var i = 0, len = e.clipboardData.items.length; i < len; i++) {
                        var item = e.clipboardData.items[i];
                       // console.log(item.kind+":"+item.type);
                      if (item.kind === "string") {
                            item.getAsString(function (str) {
                                // str 是获取到的字符串
                        })
                      } else if (item.kind === "file") {
                            var pasteFile = item.getAsFile();
                            // pasteFile就是获取到的文件
                            console.log(pasteFile);
                            fileUpload(pasteFile);
                        }
                      }
                });

                function fileUpload(fileObj){

                      var formData = new FormData(event.target);
                      formData.append("file",fileObj);
                      console.log(formData);


                Vue.http.post('/api/upload', formData)
                            .then((response) => {
                       var data=simplemde.codemirror.getValue()
                       simplemde.codemirror.setValue(data+response.data.url)



                           })
                 }
                 window.addEventListener("drop",function(e){
                     e = e || event;
                     e.preventDefault();
                     if (e.target.tagName == "textarea") {  // check wich element is our target
                       e.preventDefault();
                     }
                },false);
                },


        methods:{
                addArticle()
                {

                var formData = new FormData(event.target)
                var tagIDs = []
                for(var i = 0 ; i < this.article.tag.length ; i++) {
                            tagIDs[i] = this.article.tag[i].id
                        }


                formData.append('title', this.article.title)
                formData.append('content', this.simplemde.value())
                formData.append('user_id', this.userInfo.id)
                formData.append('tag', JSON.stringify(tagIDs))

                 this.$http.post('/api/article', formData)
                        .then((response) => {

                        console.log(response.data);

                        }, (response) => {

                          this.$notify.error(response.data)


                        })

            }

            }

        }




</script>


