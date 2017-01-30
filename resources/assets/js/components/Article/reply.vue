<template>
  <div class="reply-list">
    <div v-for="reply in replys" class="reply-item">
      <p class="reply-content">
        <a class="reply-user link-light">{{reply.user.name}}</a>：
        {{reply.content}}
      </p>
      <div class="reply-footer text-right">
        <a class="reply" href="javascript:;" @click.prevent="showReply(index,reply.user.name)" >回复</a>
        <span class="reply-time pull-left">{{ reply.created_at  }}</span>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  props:['replys','index'],
  methods:{
   showReply(index,name){
      this.$parent.showReply(index,name)
    }
  }
}
</script>