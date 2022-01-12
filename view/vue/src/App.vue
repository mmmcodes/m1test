<script setup>
import AlbumList from "~/components/AlbumList.vue";
import AlbumDetails from "~/components/AlbumDetails.vue";
</script>

<template>
  <section>
    <VaNavbar color="dark">
      <template #left>
        <VaNavbarItem>Мои альбомы</VaNavbarItem>
      </template>
      <template #right>
        <VaNavbarItem>
          <VaButton outline>Добавить</VaButton>
        </VaNavbarItem>
      </template>
    </VaNavbar>
    <div class="app">
      <div class="app__list">
        <AlbumList />
      </div>
      <div class="app__details">
        <AlbumDetails />
      </div>
    </div>
    <VaModal title="Добавление альбома">
      <slot>

      </slot>
    </VaModal>
  </section>
</template>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,400;1,700&display=swap');
@import url('https://fonts.googleapis.com/icon?family=Material+Icons');

* {
  box-sizing: border-box;
}

.app {
  display: flex;
  width: 100%;
  padding: 1rem;

  &__list {
    flex: 1 1 79%;
    padding-right: 1rem;
  }

  &__details {
    flex: 1 1 21%;
  }
}
</style>
