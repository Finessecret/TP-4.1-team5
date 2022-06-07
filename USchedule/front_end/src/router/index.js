import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../components/HomeView.vue'
import LoginView from '../components/LoginView.vue'
import AboutView from '../components/AboutView.vue'
import ResetView from '../components/ResetView.vue'
import PersonalAccountView from '../components/PersonalAccountView.vue'
import ScheduleTableView from '../components/ScheduleTableView.vue'
import AdminUserView from '../components/AdminUserView.vue'

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
  {
    path: '/reset',
    name: 'reset',
    component: ResetView
  },
  {
    path: '/personal_account',
    name: 'personal_account',
    component: PersonalAccountView
  },
  {
    path: '/schedule_table',
    name: 'schedule_table',
    component: ScheduleTableView
  },
  {
    path: '/admin_user',
    name: 'admin_user',
    component: AdminUserView
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
