<script setup>
  import { useStore } from "vuex";

  const store = useStore();

  const getToken = () => {
    store.dispatch('getToken').then(response => {
      const { token } = response.data;

      store.commit('setAccessToken', token);
    })
  }

  const removeAccessToken = () => {
    store.commit('clearAccessToken');
  }
</script>

<template>
  <div class="container my-4">

    <button
      v-if="store.getters['getAccessToken'] === null"
      type="submit"
      class="btn btn-primary"
      @click="getToken"
    >
      Get access token
    </button>
    <button
        v-else
        type="submit"
        class="btn btn-danger"
        @click="removeAccessToken"
    >
      Remove access token
    </button>

    <hr>

    <router-view />
  </div>
</template>

<style scoped>

</style>
