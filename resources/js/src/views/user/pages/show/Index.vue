<script setup>
  import Avatar from '../../components/Avatar.vue'
  import { onMounted, ref } from "vue";
  import { useStore } from "vuex";
  import { useRoute } from "vue-router";
  import { userMapper } from '../../useCases/mappers.js';
  import { propertyValues } from '../../useCases/propertyValues.js';
  import { isMe } from "../../../../services/helpers/index.js";

  const store = useStore();
  const route = useRoute();
  const { uuid } = route.params;

  const user = ref({});

  const loadUser = () => {
    store.dispatch('user/showUserAsync', { uuid })
      .then(response => {
        user.value = userMapper(response.data.user);
      })
  }

  onMounted(loadUser);

</script>

<template>
  <h3 class="my-4">User show</h3>

  <router-link :to="{ name: 'user-index' }">Users</router-link>
  <router-link v-if="! isMe(user)" :to="{ name: 'user-edit', params: { uuid } }" class="text-success ms-4">Edit</router-link>

  <dl class="row mt-5">
    <template v-for="(value, key) of user" :key="key">
      <dt class="col-sm-5">{{ propertyValues[key]?.label ?? key }}</dt>
      <dd class="col-sm-7" v-if="key === 'avatar'">
        <Avatar :avatar="value" show-info />
      </dd>
      <dd class="col-sm-7" v-else>{{ value }}</dd>
    </template>
  </dl>
</template>

<style scoped>

</style>