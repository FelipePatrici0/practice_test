<template>
  <aside class="w-64 bg-gray-800 text-white h-screen">
    <!-- Logo da empresa -->
    <div class="flex items-center justify-center p-4 border-b border-gray-700">
      <img src="https://via.placeholder.com/40" alt="Logo" class="mr-2" />
      <span class="text-2xl font-bold">Minha Empresa</span>
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
              <router-link to="/home/transportadora/cadastro" class="hover:bg-gray-700 p-2 rounded block">Cadastro</router-link>
            </li>
            <li>
              <router-link to="/home/transportadora/listagem" class="hover:bg-gray-700 p-2 rounded block">Listagem</router-link>
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
              <router-link to="/home/motorista/cadastro" class="hover:bg-gray-700 p-2 rounded block">Cadastro</router-link>
            </li>
            <li>
              <router-link to="/home/motorista/listagem" class="hover:bg-gray-700 p-2 rounded block">Listagem</router-link>
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
            <li class="mb-2">
              <router-link to="/home/modelo-caminhao/cadastro" class="hover:bg-gray-700 p-2 rounded block">Cadastro</router-link>
            </li>
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
            <li class="mb-2">
              <router-link to="/caminhoes/cadastro" class="hover:bg-gray-700 p-2 rounded block">Cadastro</router-link>
            </li>
            <li>
              <router-link to="/caminhoes/listagem" class="hover:bg-gray-700 p-2 rounded block">Listagem</router-link>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
import { ref } from 'vue';

// Variável para controlar a seção ativa (aberta)
const activeSection = ref('');

// Função para alternar entre abrir e fechar as seções
const toggleSection = (section) => {
  activeSection.value = activeSection.value === section ? '' : section;
};
</script>

<style scoped>
/* Estilos personalizados da sidebar */
</style>
