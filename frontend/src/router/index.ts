import { createRouter, createWebHistory } from 'vue-router'
import ModuleView from '@/views/ModuleView.vue'

const routes = [
  {
    path: '/',
    name: 'Module',
    component: ModuleView
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router 