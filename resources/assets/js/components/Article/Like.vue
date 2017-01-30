<template>
    <div class="article-share clearfix">
        <a href="javascript:;" class="like-btn" :class=" isLike ? 'note-liked' :'' " @click.prevent="toggleLike()">
      <span class="like-content">
        <i class="fa" :class="islike ? 'fa-heart' : 'fa-heart-o'"></i>  喜欢
      </span>
            <span  class="like-count">{{ likeCount }}</span>
        </a>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  props:['islike','likeCount'],

  computed: {
        ...mapGetters({
            userInfo: 'getUserInfo'
        })
  },

  methods:{

      toggleLike() {
            this.$http.get('/api/article/'+this.$route.params.id+'/like')
                        .then((response) => {
                 this.$emit('changelike',response.data)

            })

      }

    }


}
</script>
