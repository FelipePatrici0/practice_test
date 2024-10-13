<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Listagem de Motoristas</h1>
      <router-link to="/home/motorista/cadastro" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
        + Cadastrar Novo Item
      </router-link>
  
      <table id="driverTable" class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-center">Cód Motorista</th>
            <th class="py-2 px-4 border-b text-center">Nome do Motorista</th>
            <th class="py-2 px-4 border-b text-center">CPF</th>
            <th class="py-2 px-4 border-b text-center">Data de Nascimento</th>
            <th class="py-2 px-4 border-b text-center">Email</th>
            <th class="py-2 px-4 border-b text-center">Data de Cadastro</th>
            <th class="py-2 px-4 border-b text-center">Data de Edição</th>
            <th class="py-2 px-4 border-b text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="driver in drivers" :key="driver.id_driver_tbd">
            <td class="py-2 px-4 border-b text-center">{{ driver.id_driver_tbd }}</td>
            <td class="py-2 px-4 border-b text-center">{{ driver.name_driver_tbd }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatCPF(driver.cpf_driver_tbd) }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDate(driver.birthdate_driver_tbd) }}</td>
            <td class="py-2 px-4 border-b text-center">{{ driver.email_driver_tbd }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDateTable(driver.created_at) }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDateTable(driver.updated_at) }}</td>
            <td class="py-2 px-4 border-b text-center flex justify-center space-x-2 items-center">
                <button @click="openEditModal(driver)" class="text-blue-600 hover:text-blue-800">
                    📝
                </button>
                <button @click="deleteDriver(driver)" class="text-red-600 hover:text-red-800" title="Deletar Motorista">
                    ❌
                </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Modal de Edição -->
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-2xl mb-4">Editar Motorista</h2>
          <form @submit.prevent="handleUpdate">
            <div class="mb-4">
              <label for="nomeMotorista" class="block mb-2">Nome do Motorista</label>
              <input type="text" v-model="editForm.nomeMotorista" class="w-full px-3 py-2 border rounded" required />
            </div>
            <div class="mb-4">
              <label for="cpfMotorista" class="block mb-2">CPF</label>
              <input
                type="text"
                v-model="editForm.cpfMotorista"
                @input="formatCPFModal"
                class="w-full px-3 py-2 border rounded"
                required
              />
            </div>
            <div class="mb-4">
              <label for="dataNascimento" class="block mb-2">Data de Nascimento</label>
              <input 
                type="date" 
                v-model="editForm.dataNascimento" 
                class="w-full px-3 py-2 border rounded" 
                required 
              />
            </div>
            <div class="mb-4">
              <label for="emailMotorista" class="block mb-2">Email</label>
              <input 
                type="email" 
                v-model="editForm.emailMotorista" 
                class="w-full px-3 py-2 border rounded" 
                required 
              />
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

  const drivers = ref([]);
  const isModalOpen = ref(false);
  const editForm = ref({
    id: null,
    nomeMotorista: '',
    cpfMotorista: '',
    dataNascimento: '',
    emailMotorista: '',
  });
  
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

  const formatCPFModal = (event) => {
    let value = event.target.value.replace(/\D/g, '');
    if (value.length > 11) value = value.slice(0, 11);
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    editForm.value.cpfMotorista = value; 
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

  const formatDateTable = (dateString) => {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');
    return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
  };
  
  // Função que busca a lista de motoristas
  const fetchDrivers = async () => {
    try {
      const response = await api.get('driver');
      drivers.value = response.data;
  
      // Verifica se o DataTables já foi inicializado, caso positivo, destrói-o antes de inicializar novamente
      if (dataTable) {
        dataTable.destroy();
      }
  
      setTimeout(() => {
        dataTable = $('#driverTable').DataTable({
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
          },
        });
      }, 100);
    } catch (error) {
      console.error('Erro ao buscar motoristas:', error);
    }
  };

  // Abrir o modal de edição
  const openEditModal = (driver) => {
    editForm.value.id = driver.id_driver_tbd;
    editForm.value.nomeMotorista = driver.name_driver_tbd;
    editForm.value.cpfMotorista = driver.cpf_driver_tbd;
    editForm.value.dataNascimento = driver.birthdate_driver_tbd;
    editForm.value.emailMotorista = driver.email_driver_tbd;
    isModalOpen.value = true;
  };
  
  // Fechar o modal
  const closeModal = () => {
    isModalOpen.value = false;
  };
  
  // Função de atualização para enviar os dados atualizados para a API
    const handleUpdate = async () => {
        try {
            const updateData = {
            name_driver_tbd: editForm.value.nomeMotorista,
            cpf_driver_tbd: editForm.value.cpfMotorista.replace(/\D/g, ''),
            birthdate_driver_tbd: editForm.value.dataNascimento,
            };

            // Inclui o email somente se não estiver vazio
            if (editForm.value.emailMotorista.trim() !== '') {
            updateData.email_driver_tbd = editForm.value.emailMotorista;
            }

            await api.put(`driver/${editForm.value.id}`, updateData);

            Swal.fire({
            icon: 'success',
            title: 'Motorista atualizado com sucesso!',
            showConfirmButton: false,
            timer: 2000,
            });

            closeModal();
            fetchDrivers(); // Atualiza a listagem de motoristas
        } catch (error) {
            Swal.fire({
            icon: 'error',
            title: 'Erro ao atualizar motorista',
            text: error.response?.data?.message || 'Verifique os dados e tente novamente.',
            });
        }
    };
  
  // Função para deletar motorista
  const deleteDriver = async (driver) => {
    const result = await Swal.fire({
      title: 'Deseja realmente deletar o motorista?',
      text: 'Esta ação não pode ser desfeita!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, deletar!',
      cancelButtonText: 'Cancelar',
    });
  
    if (result.isConfirmed) {
      try {
        await api.delete(`driver/${driver.id_driver_tbd}`);
        Swal.fire({
          icon: 'success',
          title: 'Motorista deletado com sucesso!',
          timer: 2000,
          showConfirmButton: false,
        });
        fetchDrivers(); // Atualiza a listagem de motoristas
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Erro ao deletar motorista',
          text: 'Ocorreu um erro ao tentar deletar o motorista.',
        });
      }
    }
  };
  
  onMounted(fetchDrivers);
  </script>
  
  <style scoped>
#driverTable {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fonte mais moderna */
    color: #333; /* Cor do texto mais escura para melhor leitura */
    width: 100%; /* Ajusta a largura da tabela para ocupar todo o espaço disponível */
    overflow-x: auto; /* Adiciona rolagem horizontal se necessário */
  }

  /* Cabeçalhos da tabela */
  #driverTable th {
    background-color: #f7f7f7; /* Cor de fundo cinza claro */
    color: #333; /* Texto cinza escuro para contraste */
    padding: 12px 15px; /* Aumenta o espaçamento interno */
    white-space: nowrap; /* Evita que o texto quebre em múltiplas linhas */
  }

  /* Células da tabela */
  #driverTable td {
    padding: 10px 15px; /* Aumenta o espaçamento interno */
    border-bottom: 1px solid #ccc; /* Bordas inferiores sutis */
    text-align: center; /* Alinhamento central para todas as células */
    white-space: nowrap; /* Evita que o texto quebre em múltiplas linhas */
  }

  /* Botões dentro da tabela */
  #driverTable .text-blue-600, .text-red-600 {
    border: none;
    background: none;
    color: inherit; /* Mantém a cor padrão do texto para melhor integração */
    padding: 5px 10px;
    border-radius: 5px; /* Bordas arredondadas para os botões */
    cursor: pointer; /* Cursor de ponteiro para indicar interatividade */
  }

  #driverTable .text-blue-600:hover, .text-red-600:hover {
    background-color: #e2e2e2; /* Mudança de cor ao passar o mouse para um cinza muito leve */
  }  </style>
  