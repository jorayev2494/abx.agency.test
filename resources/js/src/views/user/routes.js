export default [
  {
    path: 'users',
    name: 'user-index',
    component: () => import('./pages/index/Index.vue'),
    meta: {
      middleware: [
        // 'auth',
      ],
    },
  },
  {
    path: 'users/show/:uuid',
    name: 'user-show',
    component: () => import('./pages/show/Index.vue'),
    meta: {
      middleware: [
        // 'auth',
      ],
    },
  },
  {
    path: 'users/edit/:uuid',
    name: 'user-edit',
    component: () => import('./pages/edit/Index.vue'),
    meta: {
      middleware: [
        'auth',
      ],
    },
  },
  {
    path: 'users/create',
    name: 'user-create',
    component: () => import('./pages/create/Index.vue'),
    meta: {
      middleware: [
        'auth',
      ],
    },
  },
]