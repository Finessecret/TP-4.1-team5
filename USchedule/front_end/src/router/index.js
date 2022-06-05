import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../components/HomeView.vue'
import LoginView from '../components/LoginView.vue'
import AboutView from '../components/AboutView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/about',
    name: 'about',
    component: AboutView
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
