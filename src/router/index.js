import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import PastelList from '../components/PastelList.vue'
import PastelEdit from '../components/PastelEdit.vue'
import PastelCreate from '../components/PastelCreate.vue'
import PastelShow from '../components/PastelShow.vue'
import IngredientesList from '../components/ingredientes/IngredientesList.vue'
import IngredienteCreate from '../components/ingredientes/IngredienteCreate.vue'
import IngredienteEdit from '../components/ingredientes/IngredienteEdit.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/pasteles/list',
    name: 'pastel-list',
    component: PastelList
  },
  {
    path: '/pastel/show/:id',
    name: 'pastel-show',
    component: PastelShow
  },
  {
    path: '/pastel/edit/:id',
    name: 'pastel-edit',
    component: PastelEdit
  },
  {
    path: '/pastel/create',
    name: 'pastel-create',
    component: PastelCreate
  },

  {
    path: '/ingredientes/list',
    name: 'ingredientes-list',
    component: IngredientesList
  },
  {
    path: '/ingrediente/edit/:id',
    name: 'ingrediente-edit',
    component: IngredienteEdit
  },
  {
    path: '/ingrediente/create',
    name: 'ingrediente-create',
    component: IngredienteCreate
  },

  
  {
    path: '/about',
    name: 'about',
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
