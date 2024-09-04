<script setup>
  import Avatar from '../../components/Avatar.vue'
  import {onMounted, ref} from "vue";
  import { useStore } from "vuex";
  import {useRoute, useRouter} from "vue-router";
  import { userMapper } from '../../useCases/mappers.js';
  import { propertyValues } from '../../useCases/propertyValues.js';
  import {useUploadFile} from "../../../../useCases/useUploadFile.js";

  const store = useStore();
  const route = useRoute();
  const router = useRouter();
  const { uploadedFile, uploadFile } = useUploadFile();
  const { uuid } = route.params;

  const user = ref({});

  const canEditProps = [
    'first_name',
    'last_name',
    'email',
    'phone',
    'position_id',
  ];

  const getData = () => {
    const formData = new FormData();

    formData.append('_method', 'PUT');

    canEditProps.forEach(key => {
      formData.append(key, user.value[key]);
    })

    if (uploadedFile.value !== null) {
      formData.append('avatar', uploadedFile.value);
    }

    return formData;
  }

  const loadUser = () => {
    store.dispatch('user/showUserAsync', { uuid })
      .then(response => {
        user.value = userMapper(response.data.user);
      })
  }

  const update = () => {
    store.dispatch('user/updateUserAsync', { uuid, data: getData() })
      .then(() => {
        router.push({ name: 'user-index' });
      });
    console.log('Update: ', getData());
  }

  onMounted(loadUser);

</script>

<template>
  <h3 class="my-4">User edit</h3>

  <router-link :to="{ name: 'user-index' }">Users</router-link>
  <router-link :to="{ name: 'user-show', params: { uuid } }" class="ms-4">Show</router-link>

  <dl class="row mt-5">
    <template v-for="(value, key) of user" :key="key">
      <dt class="col-sm-5">{{ propertyValues[key]?.label ?? key }}</dt>
      <dd class="col-sm-7">
        <div class="form-group row mb-2 mt-2">
          <div class="col-md-6">
            <input
              v-if="canEditProps.includes(key)"
              type="text"
              v-model="user[key]"
              name="email"
              class="form-control"
              :placeholder="propertyValues[key].label"
              required
              autofocus
            >
            <dd v-else-if="key === 'avatar'">
              <Avatar :avatar="value" show-info />
              <input class="form-control mt-3" type="file" id="formFile" @change="uploadFile">
            </dd>
            <span v-else>{{ value }}</span>
          </div>
        </div>
      </dd>
    </template>
  </dl>

  <a href="#" class="btn btn-primary btn-sm" @click="update">Update</a>
</template>

<style scoped>

</style>