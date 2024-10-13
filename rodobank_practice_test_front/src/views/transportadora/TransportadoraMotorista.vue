<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Associar Transportadora x Motorista</h1>
      
      <!-- Formulário de associação -->
      <form @submit.prevent="submitData" class="space-y-4">
        
        <!-- Select Transportadora -->
        <div>
          <label for="transportadora" class="block mb-2 text-sm font-medium text-gray-700">Transportadora:</label>
          <select
            v-model="selectedCarrier"
            id="transportadora"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          >
            <option disabled value="">Selecione uma transportadora</option>
            <option v-for="carrier in carriers" :key="carrier.id_carrier_tbc" :value="carrier.id_carrier_tbc">
              {{ carrier.name_carrier_tbc }}
            </option>
          </select>
        </div>
  
        <!-- Select Motorista -->
        <div>
          <label for="motorista" class="block mb-2 text-sm font-medium text-gray-700">Motorista:</label>
          <select
            v-model="selectedDriver"
            id="motorista"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          >
            <option disabled value="">Selecione um motorista</option>
            <option v-for="driver in drivers" :key="driver.id_driver_tbd" :value="driver.id_driver_tbd">
              {{ driver.name_driver_tbd }} - {{ driver.cpf_driver_tbd }}
            </option>
          </select>
        </div>
  
        <!-- Botão de enviar -->
        <div class="flex justify-end mt-4">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Associar
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import api from '@/axios';
  import Swal from 'sweetalert2';
  
  const selectedCarrier = ref(null);
  const selectedDriver = ref(null);
  const carriers = ref([]);
  const drivers = ref([]);
  
  // Buscar transportadoras e motoristas ao carregar a página
  onMounted(async () => {
    try {
      const [carrierResponse, driverResponse] = await Promise.all([
        api.get('carrier'),
        api.get('driver')
      ]);
      carriers.value = carrierResponse.data;
      drivers.value = driverResponse.data;
    } catch (error) {
      console.error('Erro ao buscar dados:', error);
    }
  });
  
  // Enviar dados para a rota de associação
  const submitData = async () => {
    if (selectedCarrier.value && selectedDriver.value) {
      try {
        await api.post('/carrier-driver', {
          id_carrier_rcd: selectedCarrier.value,
          id_driver_rcd: selectedDriver.value
        });
  
        Swal.fire({
          icon: 'success',
          title: 'Associação realizada com sucesso!',
          showConfirmButton: false,
          timer: 1500
        });
  
        // Limpar os selects
        selectedCarrier.value = null;
        selectedDriver.value = null;
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Erro ao associar',
          text: error.response?.data?.message || 'Erro ao acessar API',
        });
      }
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Selecione ambos os campos',
      });
    }
  };
  </script>
  
  <style scoped>
  /* Estilos para os selects */
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
  