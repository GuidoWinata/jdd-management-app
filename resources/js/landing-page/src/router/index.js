import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/refund-policy',
    name: 'RefundPolicy',
    component: () => import('../views/RefundPolicyPage.vue')
  },
  {
    path: '/faq',
    name: 'Faq',
    component: () => import('../views/FaqPage.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to) {
    if (to.hash) {
      return { el: to.hash, behavior: 'smooth' }
    }
    return { top: 0 }
  }
})

export default router