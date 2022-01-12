<script setup>
import {ref, reactive, defineProps, onMounted, computed} from 'vue'
import {useApi} from '../composables/useApi'

const {$get, $post} = useApi()

const {id} = defineProps({
  id: {
    type: Number,
    required: true
  }
})

const album = reactive({
      id: 0,
      title: '',
      artist: '',
      year: 1970,
      duration: 0,
      bought_at: 0,
      created_at: 0,
      price: 0,
      vault: {},
      coverSrc: ''
    }),
    cover = ref(),
    loading = ref(true),
    dirty = ref(false)

const coverPath = computed(() => album.coverSrc ?? false),
    isSubmitable = computed(() => loading.value === false && dirty.value === true)

const toggleLoading = () => loading.value = !loading.value

const getAlbum = async (id) => {
  const album = await $get(`show/${id}`)
  toggleLoading()
  return album
}

const loadAlbum = () => album.value = getAlbum()

const postAlbum = (data) => {
  toggleLoading()
  $post('update', data)
  toggleLoading()
}

onMounted(() => {
  loadAlbum()
})
</script>

<script>
export default {
  name: "AlbumForm"
}
</script>

<template>
  <section>
    <div v-if="coverPath">
      <VaImage :src="coverPath" />
    </div>
    <VaFileUpload v-model="cover" type="gallery" file-types="image/*" />
    <VaInput
        label="Название альбома"
        v-model="album.title"
        :disabled="loading"
        :rules="[(v) => v.length > 0 || `Пустое поле`]"
    />
    <VaInput
        label="Исполнитель"
        v-model="album.artist"
        :disabled="loading"
    />
    <VaInput
        label="Год"
        v-model="album.year"
        :disabled="loading"
    />
    <VaInput
        label="Длительность"
        v-model="album.duration"
        :disabled="loading"
    />
    <VaInput
        label="Куплен"
        v-model="album.bought_at"
        :disabled="loading"
    />
    <VaInput
        label="Цена"
        v-model="album.price"
        :disabled="loading"
    />
    <VaButton
        :disabled="isSubmitable"
        @click="postAlbum"
    >
      Сохранить
    </VaButton>
  </section>
</template>

<style>

</style>