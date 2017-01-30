<template>
    <ul class="sort-tags list-unstyled clearfix">
        <li>
            <a :class="{'active':(options.sortName == 'created_at')}" @click="changeSort('created_at')" href="javascript:;">最新</a>
        </li>
        <li>
            <a :class="{'active':(options.sortName == 'visit_count')}" @click="changeSort('visit_count')" href="javascript:;">热门</a>
        </li>

        <li v-for="tag in tagList">
            <a :class="{'active':(options.tagId == tag.id)}" @click="changeTag(tag.id)" href="javascript:;">{{tag.text}}</a>
        </li>
        <li>
          	<span class="search clearfloat">
				<span class="input">
					<input type="search" v-model="serachdata"  placeholder="搜索">
				</span>
				<span class="search-icon" @click="serach()" ><i class="fa fa-search"></i></span>

			</span>
        </li>


    </ul>
</template>


<script>

export default{


        data () {

            return {
                options: {currentPage: 1, itemsPerPage: 10,sortName:'created_at',tagId: ''},
                tagList:''

            }
        },
        mounted() {

             this.$http.get('/api/tags')
                        .then((response) => {
                            this.tagList = response.data.data
                        })

        },


        methods:{
             changeSort(sortName){
                     this.options.sortName=sortName
                     this.options.tagId=''
                     this.$emit('changestyle',sortName)
             },

             changeTag(tag_id){
                     this.options.tagId=tag_id
                     this.options.sortName=''
                     this.$emit('changestyle',tag_id)
             },

             serach(){

                    this.$http.post('/api/serach', {serachdata:this.serachdata})
                                .then((response) => {
                                        this.$store.dispatch('serachArticle', response.data);
                                        localStorage.setItem('searchdata', JSON.stringify(response.data));
                                        this.$router.push('/search')
                                }, (response) => {

                                         this.$notify.error(response.data)


                                 })
             }


        }

}
</script>
<style>
    .search input{
    padding-right: 10px;
    padding-left: 10px;
    width: 160px;
    height: 25px;
    border: 1px solid #efefef;
    border-radius: 10px;
}
.search input:focus{
    outline: none;
    box-shadow: none;
    border-color: rgba(82,168,236,0.8);
}
</style>


