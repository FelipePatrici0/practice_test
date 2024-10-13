<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Cadastro de Usuário</h1>
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label for="nomeUsuario" class="block mb-2 text-sm font-medium text-gray-700">Nome do Usuário</label>
          <input
            type="text"
            id="nomeUsuario"
            v-model="nomeUsuario"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
            placeholder="Digite o nome do usuário"
          />
        </div>
  
        <div>
          <label for="emailUsuario" class="block mb-2 text-sm font-medium text-gray-700">Email do Usuário</label>
          <input
            type="email"
            id="emailUsuario"
            v-model="emailUsuario"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
            placeholder="Digite o email do usuário"
          />
        </div>
  
        <div>
          <label for="senhaUsuario" class="block mb-2 text-sm font-medium text-gray-700">Senha</label>
          <input
            type="password"
            id="senhaUsuario"
            v-model="senhaUsuario"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
            placeholder="Digite a senha do usuário"
          />
        </div>
  
        <div class="flex justify-between">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Cadastrar
          </button>
          <router-link to="/home/usuarios/listagem" class="px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400">
            Ver Usuários Cadastrados
          </router-link>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import api from '@/axios';
  import Swal from 'sweetalert2';
  
  const nomeUsuario = ref('');
  const emailUsuario = ref('');
  const senhaUsuario = ref('');
  const router = useRouter();
  
  const handleSubmit = async () => {
    try {
      const postData = {
        name: nomeUsuario.value,
        email: emailUsuario.value,
        password: senhaUsuario.value,
      };
  
      const response = await api.post('user/register', postData);
  
      Swal.fire({
        icon: 'success',
        title: 'Usuário cadastrado com sucesso!',
        showConfirmButton: false,
        timer: 1500,
      });
  
      // Limpar os campos do formulário
      nomeUsuario.value = '';
      emailUsuario.value = '';
      senhaUsuario.value = '';
  
      // Redirecionar para a listagem de usuários
      setTimeout(() => {
        router.push('/home/usuario/listagem');
      }, 1600);
  
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Erro ao cadastrar usuário',
        text: error.response?.data?.message || 'Verifique os dados e tente novamente.',
      });
    }
  };
  </script>
  
  <style scoped>
  </style>
  