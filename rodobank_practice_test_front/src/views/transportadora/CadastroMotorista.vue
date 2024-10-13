<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Cadastro de Motorista</h1>
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <!-- Campo Nome do Motorista -->
        <div>
          <label for="nomeMotorista" class="block mb-2 text-sm font-medium text-gray-700">Nome do Motorista</label>
          <input
            type="text"
            id="nomeMotorista"
            v-model="nomeMotorista"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
            placeholder="Digite o nome do motorista"
          />
        </div>
  
        <!-- Campo CPF do Motorista -->
        <div>
          <label for="cpfMotorista" class="block mb-2 text-sm font-medium text-gray-700">CPF do Motorista</label>
          <input
            type="text"
            id="cpfMotorista"
            v-model="cpfMotorista"
            @input="formatCPF"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
            placeholder="Digite o CPF do motorista"
          />
        </div>
  
        <!-- Campo Data de Nascimento -->
        <div>
          <label for="dataNascimento" class="block mb-2 text-sm font-medium text-gray-700">Data de Nascimento</label>
          <input
            type="date"
            id="dataNascimento"
            v-model="dataNascimento"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          />
        </div>
  
        <!-- Campo Email do Motorista -->
        <div>
          <label for="emailMotorista" class="block mb-2 text-sm font-medium text-gray-700">Email do Motorista</label>
          <input
            type="email"
            id="emailMotorista"
            v-model="emailMotorista"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
            placeholder="Digite o email do motorista"
          />
        </div>
  
        <!-- Botões -->
        <div class="flex justify-between">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Cadastrar
          </button>
          <router-link to="/home/motorista/listagem" class="px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400">
            Ver Motoristas Cadastrados
          </router-link>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router'; // Importa o router para fazer o redirecionamento
  import api from '@/axios';
  import Swal from 'sweetalert2';
  
  const nomeMotorista = ref('');
  const cpfMotorista = ref('');
  const dataNascimento = ref('');
  const emailMotorista = ref('');
  const router = useRouter(); // Configura o router
  
  const formatCPF = (event) => {
    let value = event.target.value.replace(/\D/g, '');
    if (value.length > 11) value = value.slice(0, 11);
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    cpfMotorista.value = value;
  };
  
  const handleSubmit = async () => {
    try {
        const postData = {
        name_driver_tbd: nomeMotorista.value,
        cpf_driver_tbd: cpfMotorista.value.replace(/\D/g, ''),
        birthdate_driver_tbd: dataNascimento.value,
        };

        // Adiciona o email somente se não estiver vazio
        if (emailMotorista.value) {
        postData.email_driver_tbd = emailMotorista.value;
        }

        const response = await api.post('driver', postData);

        Swal.fire({
        icon: 'success',
        title: 'Cadastro realizado com sucesso!',
        showConfirmButton: false,
        timer: 1500,
        });

        // Limpa os campos após o cadastro
        nomeMotorista.value = '';
        cpfMotorista.value = '';
        dataNascimento.value = '';
        emailMotorista.value = '';

        // Redireciona para a tela de listagem de motoristas
        setTimeout(() => {
        router.push('/home/motorista/listagem');
        }, 1600);

    } catch (error) {
        Swal.fire({
        icon: 'error',
        title: 'Erro ao cadastrar motorista',
        text: error.response?.data?.message || 'Verifique os dados e tente novamente.',
        });
    }
    };


  </script>
  
  <style scoped>
  /* Estilos adicionais, se necessário */
  </style>
  