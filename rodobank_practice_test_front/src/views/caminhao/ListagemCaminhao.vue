<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Listagem de Caminhões</h1>
      <router-link to="/home/caminhao/cadastro" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
        + Cadastrar Novo Caminhão
      </router-link>
  
      <table id="truckTable" class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-center">Cód Caminhão</th>
            <th class="py-2 px-4 border-b text-center">Motorista</th>
            <th class="py-2 px-4 border-b text-center">Modelo do Caminhão</th>
            <th class="py-2 px-4 border-b text-center">Placa</th>
            <th class="py-2 px-4 border-b text-center">Data de Cadastro</th>
            <th class="py-2 px-4 border-b text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="truck in trucks" :key="truck.id_truck_tbt">
            <td class="py-2 px-4 border-b text-center">{{ truck.id_truck_tbt }}</td>
            <td class="py-2 px-4 border-b text-center">{{ truck.name_driver_tbd }}</td>
            <td class="py-2 px-4 border-b text-center">{{ truck.model_truck_tmt }} - {{ truck.color_truck_tmt }}</td>
            <td class="py-2 px-4 border-b text-center">{{ truck.plate_truck_tbt }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDate(truck.created_at) }}</td>
            <td class="py-2 px-4 border-b text-center flex justify-center space-x-2 items-center">
              <button @click="openEditModal(truck)" class="text-blue-600 hover:text-blue-800">
                📝
              </button>
              <button @click="deleteTruck(truck.id_truck_tbt)" class="text-red-600 hover:text-red-800" title="Deletar Caminhão">
                ❌
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-2xl mb-4">Editar Caminhão</h2>
          <form @submit.prevent="handleUpdate">
            <div class="mb-4">
              <label for="driver" class="block mb-2 text-sm font-medium text-gray-700">Motorista</label>
              <select
                v-model="selectedDriver"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
              >
                <option disabled value="">Selecione um motorista</option>
                <option v-for="driver in drivers" :key="driver.id" :value="driver.id">{{ driver.name }} - {{ driver.cpf }}</option>
              </select>
            </div>
  
            <div class="mb-4">
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
  
            <div class="mb-4">
              <label for="plateTruck" class="block mb-2 text-sm font-medium text-gray-700">Placa do Caminhão</label>
              <input
                type="text"
                id="plateTruck"
                v-model="plateTruck"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
                placeholder="Digite a placa do caminhão (se deseja alterar)"
              />
            </div>
  
            <div class="flex justify-end space-x-4">
              <button type="button" @click="closeModal" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Salvar Alterações</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import api from '@/axios';
  import Swal from 'sweetalert2';
  
  const trucks = ref([]);
  const drivers = ref([]);
  const models = ref([]);
  const selectedDriver = ref(null);
  const selectedModelTruck = ref(null);
  const plateTruck = ref('');
  const isModalOpen = ref(false);
  const truckId = ref(null);
  const originalPlate = ref(null);
  
  let dataTable = null;
  
  const fetchTrucks = async () => {
    const response = await api.get('truck/data-truck-drivers');
    trucks.value = response.data;
  
    if (dataTable) {
      dataTable.destroy();
    }
  
    setTimeout(() => {
      dataTable = $('#truckTable').DataTable({
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
        },
      });
    }, 100);
  };
  
  const openEditModal = async (truck) => {
    isModalOpen.value = true;
    truckId.value = truck.id_truck_tbt;
    selectedDriver.value = truck.id_driver_tbt;
    selectedModelTruck.value = truck.id_model_truck_tbt;
    plateTruck.value = truck.plate_truck_tbt;
    originalPlate.value = truck.plate_truck_tbt;
  
    [drivers.value, models.value] = await Promise.all([
      api.get('driver').then(response => response.data.map(driver => ({ id: driver.id_driver_tbd, name: driver.name_driver_tbd, cpf: driver.cpf_driver_tbd }))),
      api.get('model-truck').then(response => response.data.map(model => ({ id: model.id_model_truck_tmt, model: model.model_truck_tmt, color: model.color_truck_tmt }))),
    ]);
  };
  
  const closeModal = () => {
    isModalOpen.value = false;
  };
  
  const handleUpdate = async () => {
    try {
      const updateData = {};

      if (selectedDriver.value !== null) {
        updateData.id_driver_tbt = selectedDriver.value;
      }
      if (selectedModelTruck.value !== null) {
        updateData.id_model_truck_tbt = selectedModelTruck.value;
      }
      if (plateTruck.value.trim() !== '' && plateTruck.value !== originalPlate.value) {
        updateData.plate_truck_tbt = plateTruck.value;
      }
  
      if (Object.keys(updateData).length > 0) {
        await api.put(`truck/${truckId.value}`, updateData);
  
        Swal.fire({
          icon: 'success',
          title: 'Caminhão atualizado com sucesso!',
          showConfirmButton: false,
          timer: 1500,
        });
      } else {
        Swal.fire({
          icon: 'info',
          title: 'Nenhuma alteração feita!',
          showConfirmButton: false,
          timer: 1500,
        });
      }
  
      closeModal();
      fetchTrucks();
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Erro ao atualizar caminhão',
        text: error.response?.data?.message || 'Verifique os dados e tente novamente.',
      });
    }
  };

  const deleteTruck = async (id) => {
    const result = await Swal.fire({
      title: 'Deseja realmente deletar este caminhão?',
      text: 'Esta ação não pode ser desfeita!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, deletar!',
      cancelButtonText: 'Cancelar',
    });
  
    if (result.isConfirmed) {
      try {
        await api.delete(`truck/${id}`);
        Swal.fire({
          icon: 'success',
          title: 'Caminhão deletado com sucesso!',
          timer: 2000,
          showConfirmButton: false,
        });
        fetchTrucks();
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Erro ao deletar caminhão',
          text: 'Ocorreu um erro ao tentar deletar o caminhão.',
        });
      }
    }
  };
  
  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    return `${day}/${month}/${year} ${hours}:${minutes}`;
  };
  
  onMounted(fetchTrucks);
  </script>
  
  <style scoped>
  #truckTable {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
    width: 100%;
  }
  
  #truckTable th {
    background-color: #f7f7f7;
    color: #333;
    padding: 12px 15px;
    white-space: nowrap;
  }
  
  #truckTable td {
    padding: 10px 15px;
    border-bottom: 1px solid #ccc;
    text-align: center;
  }
  
  button.text-blue-600:hover {
    background-color: #e2e2e2;
  }
  </style>
  