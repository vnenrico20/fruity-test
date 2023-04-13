import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  routes: [
    {
      path: '/favourite',
      name: 'favourite',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../components/FruitList.vue')
    }
  ]
})

export default router
