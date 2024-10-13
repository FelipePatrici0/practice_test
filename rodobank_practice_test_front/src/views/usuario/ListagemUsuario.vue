<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Listagem de Usuários</h1>
      <router-link to="/home/usuario/cadastro" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
        + Cadastrar Novo Usuário
      </router-link>
  
      <table id="userTable" class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-center">Cód Usuário</th>
            <th class="py-2 px-4 border-b text-center">Nome</th>
            <th class="py-2 px-4 border-b text-center">Email</th>
            <th class="py-2 px-4 border-b text-center">Data de Criação</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td class="py-2 px-4 border-b text-center">{{ user.id }}</td>
            <td class="py-2 px-4 border-b text-center">{{ user.name }}</td>
            <td class="py-2 px-4 border-b text-center">{{ user.email }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDate(user.created_at) }}</td>

          </tr>
        </tbody>
      </table>
  
      <!-- Modal de Edição -->
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-2xl mb-4">Editar Usuário</h2>
          <form @submit.prevent="handleUpdate">
            <div class="mb-4">
              <label for="nomeUsuario" class="block mb-2">Nome do Usuário</label>
              <input type="text" v-model="editForm.nomeUsuario" class="w-full px-3 py-2 border rounded" required />
            </div>
            <div class="mb-4">
              <label for="emailUsuario" class="block mb-2">Email</label>
              <input type="email" v-model="editForm.emailUsuario" class="w-full px-3 py-2 border rounded" required />
            </div>
            <div class="flex justify-end space-x-4">
              <button type="button" @click="closeModal" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
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
  
  const users = ref([]);
  const isModalOpen = ref(false);
  const editForm = ref({
    id: null,
    nomeUsuario: '',
    emailUsuario: '',
  });
  
  let dataTable = null;
  
  // Função para formatar data
  const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');
    return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
  };
  
  // Função para buscar usuários
  const fetchUsers = async () => {
    try {
      const response = await api.get('user/list');
      users.value = response.data;
  
      if (dataTable) {
        dataTable.destroy();
      }
  
      setTimeout(() => {
        dataTable = $('#userTable').DataTable({
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
          },
        });
      }, 100);
    } catch (error) {
      console.error('Erro ao buscar usuários:', error);
    }
  };

  const openEditModal = (user) => {
    editForm.value.id = user.id;
    editForm.value.nomeUsuario = user.name;
    editForm.value.emailUsuario = user.email;
    isModalOpen.value = true;
  };

  const closeModal = () => {
    isModalOpen.value = false;
  };

  onMounted(fetchUsers);
  </script>
  
  <style scoped>
  #userTable {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
    width: 100%;
    overflow-x: auto;
  }
  
  #userTable th {
    background-color: #f7f7f7;
    color: #333;
    padding: 12px 15px;
    white-space: nowrap;
  }
  
  #userTable td {
    padding: 10px 15px;
    border-bottom: 1px solid #ccc;
    text-align: center;
    white-space: nowrap;
  }
  
  #userTable .text-blue-600, .text-red-600 {
    border: none;
    background: none;
    color: inherit;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }
  
  #userTable .text-blue-600:hover, .text-red-600:hover {
    background-color: #e2e2e2;
  }
  </style>
  