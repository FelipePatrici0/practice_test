<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Motoristas Associados à Transportadora</h1>
  
      <table id="driversTable" class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-center">Nome do Motorista</th>
            <th class="py-2 px-4 border-b text-center">CPF</th>
            <th class="py-2 px-4 border-b text-center">Data de Nascimento</th>
            <th class="py-2 px-4 border-b text-center">Email</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="driver in drivers" :key="driver.id_driver_tbd">
            <td class="py-2 px-4 border-b text-center">{{ driver.name_driver_tbd }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatCPF(driver.cpf_driver_tbd) }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDate(driver.birthdate_driver_tbd) }}</td>
            <td class="py-2 px-4 border-b text-center">{{ driver.email_driver_tbd }}</td>
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
  
  const drivers = ref([]);
  const route = useRoute();
  const router = useRouter();
  let dataTable = null;
  
  // Função para formatar CPF
  const formatCPF = (cpf) => {
    let value = String(cpf).replace(/\D/g, '');
    if (value.length > 11) value = value.slice(0, 11);
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    return value;
  };
  
  // Função para formatar datas
  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
  };
  
  // Função para buscar motoristas associados à transportadora
  const fetchDrivers = async (carrierId) => {
    try {
      const response = await api.get(`carrier-driver/driver-associated-carrier/${carrierId}`);
      drivers.value = response.data;
  
      if (dataTable) {
        dataTable.destroy();
      }
  
      setTimeout(() => {
        dataTable = $('#driversTable').DataTable({
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
          },
          destroy: true,
        });
      }, 100);
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Erro ao buscar motoristas',
        text: error.response?.data?.message || 'Erro ao acessar API',
      });
    }
  };
  
  // Observa a mudança no ID da transportadora e busca novamente
  watch(
    () => route.params.carrierId,
    (newCarrierId) => {
      if (newCarrierId) {
        fetchDrivers(newCarrierId);
      }
    }
  );
  
  // Faz a busca inicial
  onMounted(() => {
    const carrierId = route.params.carrierId;
    fetchDrivers(carrierId);
  });
  </script>
  
  <style scoped>
  #driversTable {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
    width: 100%;
  }
  
  #driversTable th {
    background-color: #f7f7f7;
    color: #333;
    padding: 12px 15px;
    white-space: nowrap;
  }
  
  #driversTable td {
    padding: 10px 15px;
    border-bottom: 1px solid #ccc;
    text-align: center;
  }
  </style>
  