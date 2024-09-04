<script setup>
  import Avatar from '../../components/Avatar.vue'
  import {computed, onMounted, reactive, ref} from "vue";
  import { useStore } from "vuex";
  import { userMapper } from '../../useCases/mappers.js';
  import { isMe } from "../../../../services/helpers/index.js";

  const store = useStore();

  const paginationControls = reactive({
    page: null,
    next_url: null,
    prev_url: null,
  });
  const users = ref([]);

  const loadUsers = (params = {}) => {
    store.dispatch('user/loadUsersAsync', { params }).then(response => {
      const { users: items, page, links: { next_url, prev_url } } = response.data

      paginationControls.page = page
      paginationControls.next_url = next_url
      paginationControls.prev_url = prev_url

      users.value = items.map(userMapper);
    })
  }

  const nextPage = () => {
    paginationControls.page++;
    loadUsers({ page: paginationControls.page })
  }

  const prevPage = () => {
    paginationControls.page--;
    loadUsers({ page: paginationControls.page })
  }

  const reloadUsers = () => {
    users.value = [];

    loadUsers();
  }

  const deleteUser = ({ uuid, full_name }) => {
    const isConfirmed = confirm(`Are you sure?\r\nDo you want delete the user '${full_name}'`);

    if (isConfirmed) {
      store.dispatch('user/deleteUsersAsync', { uuid })
          .then(reloadUsers);
    }
  }

  const hasAccessToken = computed(() => store.getters['getAccessToken'] !== null)

  onMounted(loadUsers);

</script>

<template>
  <h3 class="my-4">Users ({{ users.length }})</h3>

  <router-link
    v-if="hasAccessToken"
    :to="{ name: 'user-create' }"
    class="btn btn-sm btn-primary"
  >
    Create
  </router-link>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Full Name</th>
        <th scope="col">Email</th>
        <th scope="col">Created At</th>
        <th scope="col">Updated At</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(user, idx) of users" :key="++idx">
        <th scope="row">{{ idx }}</th>
        <td>
          <Avatar :avatar="user.avatar" />
          <p>{{ user.full_name }}</p>
        </td>
        <td>{{ user.email }}</td>
        <td>{{ user.created_at }}</td>
        <td>{{ user.updated_at }}</td>
        <td>
          <router-link class="btn btn-primary btn-sm me-2" :to="{ name: 'user-show', params: { uuid: user.uuid } }">Show</router-link>
          <template v-if="hasAccessToken">
            <router-link v-if="! isMe(user)" class="btn btn-success btn-sm me-2" :to="{ name: 'user-edit', params: { uuid: user.uuid } }">Edit</router-link>
            <button
                v-if="! isMe(user)"
                type="submit"
                class="btn btn-danger btn-sm"
                @click="deleteUser(user)"
            >Delete</button>
          </template>
        </td>
      </tr>
    </tbody>
  </table>

  <center>
    <button
      type="submit"
      class="align-items-center btn btn-primary btn-sm mt-4 mb-2 me-1"
      :disabled="paginationControls.prev_url === null"
      @click="prevPage"
    >Prev page</button>

    <button
      type="submit"
      class="align-items-center btn btn-primary btn-sm mt-4 mb-2 ms-1"
      :disabled="paginationControls.next_url === null"
      @click="nextPage"
    >Next Page (Show more)</button>
  </center>

</template>

<style scoped>

</style>