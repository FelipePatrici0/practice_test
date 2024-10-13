<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Cadastro de Transportadora</h1>
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <!-- Campo Nome da Empresa -->
      <div>
        <label for="nomeEmpresa" class="block mb-2 text-sm font-medium text-gray-700">Nome da Empresa</label>
        <input
          type="text"
          id="nomeEmpresa"
          v-model="nomeEmpresa"
          required
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          placeholder="Digite o nome da empresa"
        />
      </div>

      <!-- Campo CNPJ da Empresa -->
      <div>
        <label for="cnpjEmpresa" class="block mb-2 text-sm font-medium text-gray-700">CNPJ da Empresa</label>
        <input
          type="text"
          id="cnpjEmpresa"
          v-model="cnpjEmpresa"
          @input="formatCNPJ"
          required
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200"
          placeholder="Digite o CNPJ da empresa"
        />
      </div>

      <!-- Botão de enviar -->
      <div class="flex justify-between">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
          Cadastrar
        </button>
        <router-link to="/home/transportadora/listagem" class="px-4 py-2 bg-gray-300 text-black rounded-md hover:bg-gray-400">
          Ver Transportadoras Cadastradas
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

const nomeEmpresa = ref('');
const cnpjEmpresa = ref('');
const router = useRouter(); // Configura o router

const formatCNPJ = (event) => {
  let value = event.target.value.replace(/\D/g, '');
  if (value.length > 14) value = value.slice(0, 14);
  value = value.replace(/^(\d{2})(\d)/, '$1.$2');
  value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
  value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
  value = value.replace(/(\d{4})(\d)/, '$1-$2');
  cnpjEmpresa.value = value;
};

const handleSubmit = async () => {
  try {
    const response = await api.post('carrier', {
      name_carrier_tbc: nomeEmpresa.value,
      cnpj_carrier_tbc: cnpjEmpresa.value.replace(/\D/g, ''),
    });

    Swal.fire({
      icon: 'success',
      title: 'Cadastro realizado com sucesso!',
      showConfirmButton: false,
      timer: 1500,
    });

    nomeEmpresa.value = '';
    cnpjEmpresa.value = '';

    // Redireciona para a tela de listagem de transportadoras
    setTimeout(() => {
      router.push('/home/transportadora/listagem');
    }, 1600);

  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Erro ao cadastrar transportadora',
      text: error.response?.data?.message || 'Verifique os dados e tente novamente.',
    });
  }
};
</script>

<style scoped>
/* Estilos adicionais, se necessário */
</style>
