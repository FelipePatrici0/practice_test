import { createRouter, createWebHistory } from 'vue-router';
import LoginView from '@/views/LoginView.vue';
import HomeView from '@/views/HomeView.vue';
import CadastroTransportadora from '@/views/transportadora/CadastroTransportadora.vue';
import CadastroMotorista from '@/views/motorista/CadastroMotorista.vue';
import CadastroModeloCaminhao from '@/views/modelo-caminhao/CadastroModeloCaminhao.vue';
import CadastroCaminhao from '@/views/caminhao/CadastroCaminhao.vue';
import ListagemTransportadora from '@/views/transportadora/ListagemTransportadora.vue';
import ListagemMotorista from '@/views/motorista/ListagemMotorista.vue';
import ListagemModeloCaminhao from '@/views/modelo-caminhao/ListagemModeloCaminhao.vue';
import ListagemCaminhao from '@/views/caminhao/ListagemCaminhao.vue';
import ListagemCaminhoesPorMotorista from '@/views/motorista/ListagemCaminhoesPorMotorista.vue';
import TransportadoraMotorista from '@/views/transportadora/TransportadoraMotorista.vue';
import MotoristasPorTransportadora from '@/views/transportadora/MotoristasPorTransportadora.vue';

const routes = [
  {
    path: '/',
    name: 'login',
    component: LoginView,
  },
  {
    path: '/home',
    component: () => import('@/layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        name: 'home',
        component: HomeView,
        meta: { requiresAuth: true },
      },
      {
        path: 'transportadora/cadastro',
        name: 'CadastroTransportadora',
        component: CadastroTransportadora,
        meta: { requiresAuth: true },
      },
      {
        path: 'transportadora/listagem',
        name: 'ListagemTransportadora',
        component: ListagemTransportadora,
        meta: { requiresAuth: true },
      },
      {
        path: 'transportadora/motorista',
        name: 'TransportadoraMotorista',
        component: TransportadoraMotorista,
        meta: { requiresAuth: true },
      },
      {
        path: 'transportadora/motoristas/:carrierId',
        name: 'MotoristasPorTransportadora',
        component: MotoristasPorTransportadora,
        meta: { requiresAuth: true },
      },
      {
        path: 'motorista/cadastro',
        name: 'CadastroMotorista',
        component: CadastroMotorista,
        meta: { requiresAuth: true },
      },
      {
        path: 'motorista/listagem',
        name: 'ListagemMotorista',
        component: ListagemMotorista,
        meta: { requiresAuth: true },
      },
      {
        path: 'modelo-caminhao/cadastro',
        name: 'CadastroModeloCaminhao',
        component: CadastroModeloCaminhao,
        meta: { requiresAuth: true },
      },
      {
        path: 'modelo-caminhao/listagem',
        name: 'ListagemModeloCaminhao',
        component: ListagemModeloCaminhao,
        meta: { requiresAuth: true },
      },
      {
        path: 'caminhao/cadastro',
        name: 'CadastroCaminhao',
        component: CadastroCaminhao,
        meta: { requiresAuth: true },
      },
      {
        path: 'caminhao/listagem',
        name: 'ListagemCaminhao',
        component: ListagemCaminhao,
        meta: { requiresAuth: true },
      },
      {
        path: 'motorista/caminhoes/:driverId',
        name: 'ListagemCaminhoesPorMotorista',
        component: ListagemCaminhoesPorMotorista,
        meta: { requiresAuth: true },
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('authToken');

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      next({ name: 'login' });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
