<template>
  <aside class="w-64 bg-gray-800 text-white h-screen">
    <!-- Logo da empresa -->
    <div class="flex items-center justify-center p-4 border-b border-gray-700">
      <img src="https://camo.githubusercontent.com/b7bd8ff68b132fa9c5417a3850f73f64c446181d70fab149cab7b06eb69dcd6e/68747470733a2f2f726f646f62616e6b2e636f6d2e62722f7468656d65732f726f646f62616e6b2f6173736574732f696d672f6c6f676f2e706e67" alt="Logo" class="mr-2" />
    </div>

    <!-- Menu principal -->
    <nav class="p-4">
      <ul>
        <!-- Transportadora -->
        <li class="mb-4">
          <div @click="toggleSection('transportadora')" class="flex justify-between items-center cursor-pointer p-2 hover:bg-gray-700 rounded">
            <span>Transportadora</span>
            <span>{{ activeSection === 'transportadora' ? '▲' : '▼' }}</span>
          </div>
          <ul v-if="activeSection === 'transportadora'" class="pl-4">
            <li class="mb-2">
              <router-link to="/home/transportadora/listagem" class="hover:bg-gray-700 p-2 rounded block">Listagem</router-link>
            </li>
            <li class="mb-2">
              <router-link to="/home/transportadora/motorista" class="hover:bg-gray-700 p-2 rounded block w-full text-left">
                Transportadora x Motorista
              </router-link>
            </li>
            <li class="mb-2">
              <button @click="openModalTransportadora" class="hover:bg-gray-700 p-2 rounded block w-full text-left">
                Motoristas por Transportadora
              </button>
            </li>
          </ul>
        </li>

        <!-- Motorista -->
        <li class="mb-4">
          <div @click="toggleSection('motorista')" class="flex justify-between items-center cursor-pointer p-2 hover:bg-gray-700 rounded">
            <span>Motorista</span>
            <span>{{ activeSection === 'motorista' ? '▲' : '▼' }}</span>
          </div>
          <ul v-if="activeSection === 'motorista'" class="pl-4">
            <li class="mb-2">
              <router-link to="/home/motorista/listagem" class="hover:bg-gray-700 p-2 rounded block">Listagem</router-link>
            </li>
            <li class="mb-2">
              <button @click="openModalMotorista" class="hover:bg-gray-700 p-2 rounded block w-full text-left">
                Caminhões por motorista
              </button>
            </li>
          </ul>
        </li>

        <!-- Modelo de Caminhões -->
        <li class="mb-4">
          <div @click="toggleSection('modeloCaminhoes')" class="flex justify-between items-center cursor-pointer p-2 hover:bg-gray-700 rounded">
            <span>Modelo de Caminhões</span>
            <span>{{ activeSection === 'modeloCaminhoes' ? '▲' : '▼' }}</span>
          </div>
          <ul v-if="activeSection === 'modeloCaminhoes'" class="pl-4">
            <li>
              <router-link to="/home/modelo-caminhao/listagem" class="hover:bg-gray-700 p-2 rounded block">Listagem</router-link>
            </li>
          </ul>
        </li>

        <!-- Caminhões -->
        <li class="mb-4">
          <div @click="toggleSection('caminhoes')" class="flex justify-between items-center cursor-pointer p-2 hover:bg-gray-700 rounded">
            <span>Caminhões</span>
            <span>{{ activeSection === 'caminhoes' ? '▲' : '▼' }}</span>
          </div>
          <ul v-if="activeSection === 'caminhoes'" class="pl-4">
            <li>
              <router-link to="/home/caminhao/listagem" class="hover:bg-gray-700 p-2 rounded block">Listagem</router-link>
            </li>
          </ul>
        </li>

        <!-- Usuários -->
        <li class="mb-4">
          <div @click="toggleSection('usuarios')" class="flex justify-between items-center cursor-pointer p-2 hover:bg-gray-700 rounded">
            <span>Usuários</span>
            <span>{{ activeSection === 'usuarios' ? '▲' : '▼' }}</span>
          </div>
          <ul v-if="activeSection === 'usuarios'" class="pl-4">
            <li>
              <router-link to="/home/usuario/listagem" class="hover:bg-gray-700 p-2 rounded block">Listagem</router-link>
            </li>
          </ul>
        </li>
      </ul>
    </nav>

    <!-- Modal para selecionar transportadora -->
    <div v-if="isModalOpenTransportadora" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-black">Selecione a Transportadora</h2>
        <div>
          <label for="transportadora" class="block mb-2 text-sm font-medium text-gray-700">Transportadora:</label>
          <select
            v-model="selectedCarrier"
            id="transportadora"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          >
            <option disabled value="">Selecione uma transportadora</option>
            <option v-for="carrier in carriers" :key="carrier.id_carrier_tbc" :value="carrier.id_carrier_tbc">
              {{ carrier.name_carrier_tbc }}
            </option>
          </select>
        </div>

        <div class="flex justify-end mt-4">
          <button @click="closeModalTransportadora" class="bg-gray-300 px-4 py-2 rounded mr-2">Cancelar</button>
          <button @click="goToListagemTransportadora" class="bg-blue-600 text-white px-4 py-2 rounded">Buscar</button>
        </div>
      </div>
    </div>

    <!-- Modal para selecionar motorista (Caminhões por motorista) -->
    <div v-if="isModalOpenMotorista" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-black">Selecione o Motorista</h2>
        <div>
          <label for="motorista" class="block mb-2 text-sm font-medium text-gray-700">Motorista:</label>
          <select
            v-model="selectedDriver"
            id="motorista"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          >
            <option disabled value="">Selecione um motorista</option>
            <option v-for="driver in drivers" :key="driver.id_driver_tbd" :value="driver.id_driver_tbd">
              {{ driver.name_driver_tbd }} - {{ driver.cpf_driver_tbd }}
            </option>
          </select>
        </div>

        <div class="flex justify-end mt-4">
          <button @click="closeModalMotorista" class="bg-gray-300 px-4 py-2 rounded mr-2">Cancelar</button>
          <button @click="goToListagemMotorista" class="bg-blue-600 text-white px-4 py-2 rounded">Buscar</button>
        </div>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '@/axios';

const activeSection = ref('');
const isModalOpenMotorista = ref(false);
const isModalOpenTransportadora = ref(false);
const drivers = ref([]);
const carriers = ref([]);
const selectedDriver = ref(null);
const selectedCarrier = ref(null);
const router = useRouter();

// Função para alternar entre abrir e fechar as seções
const toggleSection = (section) => {
  activeSection.value = activeSection.value === section ? '' : section;
};

// Funções para abrir/fechar modal de motoristas
const openModalMotorista = () => {
  isModalOpenMotorista.value = true;
};
const closeModalMotorista = () => {
  isModalOpenMotorista.value = false;
};
const goToListagemMotorista = () => {
  if (selectedDriver.value) {
    closeModalMotorista();
    router.push(`/home/motorista/caminhoes/${selectedDriver.value}`);
  }
};

// Funções para abrir/fechar modal de transportadora
const openModalTransportadora = () => {
  isModalOpenTransportadora.value = true;
};
const closeModalTransportadora = () => {
  isModalOpenTransportadora.value = false;
};
const goToListagemTransportadora = () => {
  if (selectedCarrier.value) {
    closeModalTransportadora();
    router.push(`/home/transportadora/motoristas/${selectedCarrier.value}`);
  }
};

// Buscar os motoristas e transportadoras para o select
onMounted(async () => {
  try {
    const responseDrivers = await api.get('driver');
    drivers.value = responseDrivers.data;
    const responseCarriers = await api.get('carrier');
    carriers.value = responseCarriers.data;
  } catch (error) {
    console.error('Erro ao buscar dados:', error);
  }
});
</script>

<style scoped>
/* Estilos personalizados da sidebar */
select {
  appearance: none;
  background-color: white;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 0.375rem;
  font-size: 1rem;
  color: #333;
}

select:focus {
  border-color: #3b82f6;
  outline: none;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}
</style>
