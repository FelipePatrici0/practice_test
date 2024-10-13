<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h2 class="mb-6 text-3xl font-bold text-center text-gray-800">Login</h2>
        <form @submit.prevent="handleSubmit">
          <div class="mb-4">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>
            <input
              type="email"
              id="email"
              v-model="email"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
              placeholder="seuemail@exemplo.com"
            />
          </div>
          <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Senha</label>
            <input
              type="password"
              id="password"
              v-model="password"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
              placeholder="Digite sua senha"
            />
          </div>
          <button
            type="submit"
            class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200 transition duration-200"
          >
            Entrar
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import api from '@/axios'; // Importa a instância Axios configurada
  import Swal from 'sweetalert2';
  import { useRouter } from 'vue-router';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async handleSubmit() {
        try {
          // Envia a requisição de login para a API usando a instância `api`
          const response = await api.post('user', {
            email: this.email,
            password: this.password,
          });
  
          // Supondo que a resposta contenha um token JWT
          const token = response.data.token;
  
          // Armazena o token no localStorage ou sessionStorage
          localStorage.setItem('authToken', token);
  
          // Alerta de sucesso usando SweetAlert2
          Swal.fire({
            icon: 'success',
            title: 'Login realizado com sucesso!',
            showConfirmButton: false,
            timer: 1500,
          });
  
          // Redireciona o usuário para a página principal após o login
          setTimeout(() => {
            this.$router.push('/home');
          }, 1600);
  
        } catch (error) {
          // Alerta de erro usando SweetAlert2
          Swal.fire({
            icon: 'error',
            title: 'Erro no login',
            text: 'Verifique suas credenciais e tente novamente.',
          });
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Seus estilos aqui */
  </style>
  