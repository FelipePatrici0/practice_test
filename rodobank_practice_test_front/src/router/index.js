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
        path: '/home/transportadora/motorista',
        name: 'TransportadoraMotorista',
        component: TransportadoraMotorista
      },
      {
        path: '/home/transportadora/motoristas/:carrierId',
        name: 'MotoristasPorTransportadora',
        component: MotoristasPorTransportadora,
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
      {
        path: 'modelo-caminhao/cadastro',
        name: 'CadastroModeloCaminhao',
        component: CadastroModeloCaminhao,
      },
      {
        path: 'modelo-caminhao/listagem',
        name: 'ListagemModeloCaminhao',
        component: ListagemModeloCaminhao, // Rota para a listagem
      },
      {
        path: 'caminhao/cadastro',
        name: 'CadastroCaminhao',
        component: CadastroCaminhao,
      },
      {
        path: 'caminhao/listagem',
        name: 'ListagemCaminhao',
        component: ListagemCaminhao,
      },
      {
        path: '/home/motorista/caminhoes/:driverId',
        name: 'ListagemCaminhoesPorMotorista',
        component: ListagemCaminhoesPorMotorista,
      }
      
    ],
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
