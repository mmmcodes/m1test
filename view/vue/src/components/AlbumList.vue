<script setup>
import { ref } from 'vue'

const albums = ref([])
</script>

<script>
export default {
  name: 'AlbumList'
}
</script>

<template>
  <section>
    <VaDataTable :items="albums" />
  </section>
</template>

<style>

</style>