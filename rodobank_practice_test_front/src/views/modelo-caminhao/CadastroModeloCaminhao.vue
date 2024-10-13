<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Cadastro de Modelo de Caminhão</h1>
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label for="modeloCaminhao" class="block mb-2 text-sm font-medium text-gray-700">Modelo do Caminhão</label>
          <input
            type="text"
            id="modeloCaminhao"
            v-model="modeloCaminhao"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
            placeholder="Digite o modelo do caminhão"
          />
        </div>
  
        <div>
          <label for="corCaminhao" class="block mb-2 text-sm font-medium text-gray-700">Cor do Caminhão</label>
          <input
            type="text"
            id="corCaminhao"
            v-model="corCaminhao"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
            placeholder="Digite a cor do caminhão"
          />
        </div>
  
        <div class="flex justify-between">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Cadastrar
            </button>
            <router-link to="/home/modelo-caminhao/listagem" class="px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400">
                Ver Modelos de Caminhão Cadastrados
            </router-link>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import api from '@/axios';
  import Swal from 'sweetalert2';
  
  const modeloCaminhao = ref('');
  const corCaminhao = ref('');
  
  const handleSubmit = async () => {
    try {
      const response = await api.post('model-truck', {
        model_truck_tmt: modeloCaminhao.value,
        color_truck_tmt: corCaminhao.value
      });
  
      Swal.fire({
        icon: 'success',
        title: 'Cadastro realizado com sucesso!',
        showConfirmButton: false,
        timer: 1500
      });
  
      modeloCaminhao.value = '';
      corCaminhao.value = '';
  
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Erro ao cadastrar modelo de caminhão',
        text: error.response?.data?.message || 'Verifique os dados e tente novamente.'
      });
    }
  };
  </script>
  
  <style scoped>
  </style>
  