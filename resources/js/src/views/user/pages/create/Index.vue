<script setup>
  import { reactive } from "vue";
  import { useStore } from "vuex";
  import { useRouter } from "vue-router";
  import { propertyValues } from '../../useCases/propertyValues.js';
  import { useUploadFile } from "../../../../useCases/useUploadFile.js";

  const store = useStore();
  const router = useRouter();
  const { uploadedFile, uploadFile } = useUploadFile();

  const form = reactive({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    avatar: '',
    position_id: '',
  });

  const canEditProps = [
    'first_name',
    'last_name',
    'email',
    'phone',
    'position_id',
  ];

  const getData = () => {
    const formData = new FormData();

    canEditProps.forEach(key => {
      formData.append(key, form[key]);
    })

    if (uploadedFile.value !== null) {
      formData.append('avatar', uploadedFile.value);
    }

    return formData;
  }

  const create = () => {
    store.dispatch('user/createUserAsync', { data: getData() })
      .then(() => {
        router.push({ name: 'user-index' });
      });
  }
</script>

<template>
  <h3 class="my-4">User create</h3>

  <router-link :to="{ name: 'user-index' }">Users</router-link>

  <dl class="row mt-5">
    <template v-for="(value, key) of form" :key="key">
      <dt class="col-sm-5">{{ propertyValues[key].label ?? key }}</dt>
      <dd class="col-sm-7">
        <div class="form-group row mb-2 mt-2">
          <div class="col-md-6">
            <input
              v-if="canEditProps.includes(key)"
              type="text"
              v-model="form[key]"
              name="email"
              class="form-control"
              :placeholder="propertyValues[key].label"
              required
              autofocus
            >
            <dd v-else-if="key === 'avatar'">
              <input class="form-control" type="file" id="formFile" @change="uploadFile">
            </dd>
            <span v-else>{{ value }}</span>
          </div>
        </div>
      </dd>
    </template>
  </dl>

  <button type="submit" class="btn btn-primary btn-sm" @click="create">
    Create
  </button>
</template>

<style scoped>

</style>