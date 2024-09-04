<script setup>
  import { defineProps } from 'vue'

  defineProps({
    avatar: {
      type: Object,
      default: null,
    },
    showInfo: {
      type: Boolean,
      default: false,
    }
  });
</script>

<template>
  <span v-if="avatar !== null">
    <img :src="avatar.url" :alt="avatar.file_original_name" class="img-thumbnail float-start me-2" width="75">
    <div v-if="showInfo">
      <span class="d-block">Size: {{ avatar.width }} x {{ avatar.height }}</span>
      <span class="d-block">Is cropped: {{ avatar.is_cropped }}</span>
      <span class="d-block">Is optimized: {{ avatar.is_optimized }}</span>
    </div>
  </span>
  <span v-else>No avatar</span>
</template>

<style scoped>

</style>