<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Cadastro de Caminhão</h1>
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label for="driver" class="block mb-2 text-sm font-medium text-gray-700">Motorista</label>
          <select
            v-model="selectedDriver"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          >
            <option disabled value="">Selecione um motorista</option>
            <option v-for="driver in drivers" :key="driver.id_" :value="driver.id">{{ driver.name }} - {{ driver.cpf }}</option>
          </select>
        </div>
        <div>
          <label for="modelTruck" class="block mb-2 text-sm font-medium text-gray-700">Modelo de Caminhão</label>
          <select
            v-model="selectedModelTruck"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          >
            <option disabled value="">Selecione um modelo de caminhão</option>
            <option v-for="model in models" :key="model.id" :value="model.id">{{ model.model }} - {{ model.color }}</option>
          </select>
        </div>
        <div>
          <label for="plateTruck" class="block mb-2 text-sm font-medium text-gray-700">Placa do Caminhão</label>
          <input
            type="text"
            id="plateTruck"
            v-model="plateTruck"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
            placeholder="Digite a placa do caminhão"
          />
        </div>
        <div class="flex justify-between">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Cadastrar
          </button>
          <router-link to="/home/caminhao/listagem" class="px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400">
            Ver Caminhões Cadastrados
          </router-link>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import api from '@/axios';
  import Swal from 'sweetalert2';
  
  const selectedDriver = ref(null);
  const selectedModelTruck = ref(null);
  const plateTruck = ref('');
  const drivers = ref([]);
  const models = ref([]);
  const router = useRouter();
  
  onMounted(async () => {
    [drivers.value, models.value] = await Promise.all([
      api.get('driver').then(response => response.data.map(driver => ({ id: driver.id_driver_tbd, name: driver.name_driver_tbd, cpf: driver.cpf_driver_tbd }))),
      api.get('model-truck').then(response => response.data.map(model => ({ id: model.id_model_truck_tmt, model: model.model_truck_tmt, color: model.color_truck_tmt })))
    ]);
  });

  const handleSubmit = async () => {
    try {
      await api.post('truck', {
        id_driver_tbt: selectedDriver.value,
        id_model_truck_tbt: selectedModelTruck.value,
        plate_truck_tbt: plateTruck.value,
      });
  
      Swal.fire({
        icon: 'success',
        title: 'Cadastro realizado com sucesso!',
        showConfirmButton: false,
        timer: 1500,
      });
  
      plateTruck.value = '';
      selectedDriver.value = null;
      selectedModelTruck.value = null;
  
      setTimeout(() => {
        router.push('/home/caminhao/listagem');
      }, 1600);
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Erro ao cadastrar caminhão',
        text: error.response?.data?.message || 'Verifique os dados e tente novamente.',
      });
    }
  };
  </script>
  
  <style scoped>
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

  option {
    background-color: white;
    color: #333;
  }

  input {
    padding: 0.5rem;
  }
  </style>
