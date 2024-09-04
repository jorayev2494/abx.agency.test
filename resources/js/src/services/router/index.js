import { createRouter, createWebHistory, RouterView } from "vue-router";
import routes from './routes.js'

const router = createRouter({
  history: createWebHistory('/'),
  linkActiveClass: 'active',
  routes: [
    {
      path: '/',
      component: RouterView,
      redirect: { name: 'user-index' },
      children: routes,
    },
  ],
});

router.beforeEach(function(to, from, next) {
  // Middleware
  if (to.meta.hasOwnProperty('middleware')) {
    const accessToken = localStorage.getItem('access_token');

    // For Guest
    if (to.meta.middleware.includes('guest')) {
      if (accessToken) {
        next({ name: 'user-index' });
      }
    }

    // For Authorization
    if (to.meta.middleware.includes('auth')) {
      if (accessToken) {
        next();
      } else {
        next({ name: 'user-index' });
      }
    }

    next();
  } else {
    // Non-protected route, allow access
    next();
  }
});

export default router;
