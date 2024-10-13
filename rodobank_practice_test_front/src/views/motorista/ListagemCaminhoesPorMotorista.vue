<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Caminhões do Motorista</h1>

      <table id="trucksTable" class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-center">Cód Caminhão</th>
            <th class="py-2 px-4 border-b text-center">Modelo</th>
            <th class="py-2 px-4 border-b text-center">Cor</th>
            <th class="py-2 px-4 border-b text-center">Placa</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="truck in trucks" :key="truck.id_truck_tbt">
            <td class="py-2 px-4 border-b text-center">{{ truck.id_truck_tbt }}</td>
            <td class="py-2 px-4 border-b text-center">{{ truck.model_truck_tmt }}</td>
            <td class="py-2 px-4 border-b text-center">{{ truck.color_truck_tmt }}</td>
            <td class="py-2 px-4 border-b text-center">{{ truck.plate_truck_tbt }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script setup>
  import { ref, watch, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import api from '@/axios';
  import Swal from 'sweetalert2';
  
  const trucks = ref([]);
  const route = useRoute();
  const router = useRouter();
  let dataTable = null;
  
  const fetchTrucks = async (driverId) => {
    try {
      const response = await api.get(`truck/list-trucks-by-driver/${driverId}`);
      trucks.value = response.data;

      if (dataTable) {
        dataTable.destroy();
      }

      setTimeout(() => {
        dataTable = $('#trucksTable').DataTable({
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
          },
          destroy: true,
        });
      }, 100);
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Erro ao buscar caminhões',
        text: error.response?.data?.message || 'Erro ao acessar API',
      });
    }
  };

  watch(
    () => route.params.driverId,
    (newDriverId) => {
      if (newDriverId) {
        fetchTrucks(newDriverId);
      }
    }
  );

  onMounted(() => {
    const driverId = route.params.driverId;
    fetchTrucks(driverId);
  });
  </script>

  <style scoped>
  #trucksTable {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
    width: 100%;
  }

  #trucksTable th {
    background-color: #f7f7f7;
    color: #333;
    padding: 12px 15px;
    white-space: nowrap;
  }

  #trucksTable td {
    padding: 10px 15px;
    border-bottom: 1px solid #ccc;
    text-align: center;
  }
  </style>
