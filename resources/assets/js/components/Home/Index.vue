<template>
    <div class="container-fluid main-box">
        <div class="row">
            <Sidebar></Sidebar>
            <div class="col-sm-7 col-sm-offset-3 main-content">
                <tags v-on:changestyle="changestyle"></tags>
                <Articles :articleList="articleList"></Articles>
            </div>
    </div>
</template>
<style>

</style>
<script>
export default{

     components: {
            'Sidebar':require('./Sidebar.vue'),
            'Articles':require('./Articles.vue'),
            'Tags':require('./Tags.vue'),
     },
     data(){
          return{
            articleList: {},

          }
     },
     mounted(){

        this.loadData()

     },

     methods:{
         loadData(){
            this.$http.get('/api/article')
                    .then((response) => {
                        console.log(response.data.data);
                         this.articleList=response.data.data


                    }, (response) => {

                    })
         },
         changestyle(payload){
          this.$http.get('/api/article',{params: { style:payload }})
                    .then((response) => {

                        this.$nextTick(() => {
                       this.articleList=response.data.data
                    })

                    }, (response) => {

                    })
        }

     }



   }
</script>
