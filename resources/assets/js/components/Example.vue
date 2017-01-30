<template>
    <div>

<NavBar></NavBar>
        <router-view></router-view>


    </div>
</template>

<script>

  export default {

    data () {
      return {

      }
    },
    components: {
            'NavBar':require('./Home/NavBar.vue'),
            'NavTop':require('./Home/NavTop.vue'),


    }
  }
</script>