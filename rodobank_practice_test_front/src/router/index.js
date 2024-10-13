import { createRouter, createWebHistory } from 'vue-router';
import LoginView from '@/views/LoginView.vue';
import HomeView from '@/views/HomeView.vue';
import CadastroTransportadora from '@/views/transportadora/CadastroTransportadora.vue';
import CadastroMotorista from '@/views/transportadora/CadastroMotorista.vue';
import ListagemTransportadora from '@/views/transportadora/ListagemTransportadora.vue'; // Importa a nova view de listagem
import ListagemMotorista from '@/views/transportadora/ListagemMotorista.vue'; // Importa a nova view de listagem

const routes = [
  {
    path: '/',
    name: 'login',
    component: LoginView,
  },
  {
    path: '/home',
    component: () => import('@/layouts/MainLayout.vue'), // Layout com Sidebar e Navbar
    children: [
      {
        path: '',
        name: 'home',
        component: HomeView,
      },
      {
        path: 'transportadora/cadastro',
        name: 'CadastroTransportadora',
        component: CadastroTransportadora,
      },
      {
        path: 'transportadora/listagem',
        name: 'ListagemTransportadora',
        component: ListagemTransportadora, // Rota para a listagem
      },
      {
        path: 'motorista/cadastro',
        name: 'CadastroMotorista',
        component: CadastroMotorista,
      },
      {
        path: 'motorista/listagem',
        name: 'ListagemMotorista',
        component: ListagemMotorista, // Rota para a listagem
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
