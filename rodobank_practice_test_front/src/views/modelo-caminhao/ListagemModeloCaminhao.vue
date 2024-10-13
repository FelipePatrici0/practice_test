<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Listagem de Modelos de Caminhões</h1>
      <router-link to="/home/modelo-caminhao/cadastro" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
        + Cadastrar Novo Modelo
      </router-link>
  
      <table id="modelTruckTable" class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-center">Cód Caminhão</th>
            <th class="py-2 px-4 border-b text-center">Modelo do Caminhão</th>
            <th class="py-2 px-4 border-b text-center">Cor</th>
            <th class="py-2 px-4 border-b text-center">Data de Cadastro</th>
            <th class="py-2 px-4 border-b text-center">Data de Atualização</th>
            <th class="py-2 px-4 border-b text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="model in models" :key="model.id_model_truck_tmt">
            <td class="py-2 px-4 border-b text-center">{{ model.id_model_truck_tmt }}</td>
            <td class="py-2 px-4 border-b text-center">{{ model.model_truck_tmt }}</td>
            <td class="py-2 px-4 border-b text-center">{{ model.color_truck_tmt }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDateTable(model.created_at) }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDateTable(model.updated_at) }}</td>
            <td class="py-2 px-4 border-b text-center flex justify-center space-x-2 items-center">
              <button @click="openEditModal(model)" class="text-blue-600 hover:text-blue-800">
                📝
              </button>
              <button @click="deleteModel(model.id_model_truck_tmt)" class="text-red-600 hover:text-red-800" title="Deletar Modelo">
                ❌
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Modal de Edição -->
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-2xl mb-4">Editar Modelo de Caminhão</h2>
          <form @submit.prevent="handleUpdate">
            <div class="mb-4">
              <label for="modelo" class="block mb-2">Modelo do Caminhão</label>
              <input type="text" v-model="editForm.modelo" class="w-full px-3 py-2 border rounded" required />
            </div>
            <div class="mb-4">
              <label for="cor" class="block mb-2">Cor</label>
              <input type="text" v-model="editForm.cor" class="w-full px-3 py-2 border rounded" required />
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

  const models = ref([]);
  const isModalOpen = ref(false);
  const editForm = ref({
    id: null,
    modelo: '',
    cor: ''
  });

  const fetchModels = async () => {
    try {
      const response = await api.get('model-truck');
      models.value = response.data;
      // Initialize or reinitialize DataTable
      $(document).ready(function () {
        $('#modelTruckTable').DataTable({
          destroy: true, // Destroy the previous instance of DataTable
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
          }
        });
      });
    } catch (error) {
      console.error('Erro ao buscar modelos de caminhões:', error);
    }
  };

  const openEditModal = (model) => {
  isModalOpen.value = true;
  editForm.value.id = model.id_model_truck_tmt;
  editForm.value.modelo = model.model_truck_tmt;
  editForm.value.cor = model.color_truck_tmt;
};

    const handleUpdate = async () => {
        try {
            await api.put(`model-truck/${editForm.value.id}`, {
            model_truck_tmt: editForm.value.modelo,
            color_truck_tmt: editForm.value.cor,
            });

            Swal.fire({
            icon: 'success',
            title: 'Modelo atualizado com sucesso!',
            showConfirmButton: false,
            timer: 2000,
            });

            closeModal();
            fetchModels(); // Refresh the list after update
        } catch (error) {
            Swal.fire({
            icon: 'error',
            title: 'Erro ao atualizar modelo',
            text: error.response?.data?.message || 'Verifique os dados e tente novamente.',
            });
        }
    };


  const deleteModel = async (id) => {
    const result = await Swal.fire({
      title: 'Deseja realmente deletar este modelo de caminhão?',
      text: 'Esta ação não pode ser desfeita!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, deletar!',
      cancelButtonText: 'Cancelar',
    });

    if (result.isConfirmed) {
      try {
        await api.delete(`model-truck/${id}`);
        Swal.fire({
          icon: 'success',
          title: 'Modelo deletado com sucesso!',
          timer: 2000,
          showConfirmButton: false,
        });
        fetchModels(); // Refresh the list after deletion
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Erro ao deletar modelo',
          text: 'Ocorreu um erro ao tentar deletar o modelo.',
        });
      }
    }
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

  const closeModal = () => {
    isModalOpen.value = false;
  };

  onMounted(fetchModels);
  </script>

<style scoped>
    #modelTruckTable {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fonte mais moderna */
    color: #333; /* Cor do texto mais escura para melhor leitura */
    width: 100%; /* Ajusta a largura da tabela para ocupar todo o espaço disponível */
    overflow-x: auto; /* Adiciona rolagem horizontal se necessário */
    }

    /* Cabeçalhos da tabela */
    #modelTruckTable th {
    background-color: #f7f7f7; /* Cor de fundo cinza claro */
    color: #333; /* Texto cinza escuro para contraste */
    padding: 12px 15px; /* Aumenta o espaçamento interno */
    white-space: nowrap; /* Evita que o texto quebre em múltiplas linhas */
    border-bottom: 2px solid #e0e0e0; /* Linha de separação mais definida */
    }

    /* Células da tabela */
    #modelTruckTable td {
    padding: 10px 15px; /* Aumenta o espaçamento interno */
    border-bottom: 1px solid #ccc; /* Bordas inferiores sutis */
    text-align: center; /* Alinhamento central para todas as células */
    white-space: nowrap; /* Evita que o texto quebre em múltiplas linhas */
    }

    /* Botões dentro da tabela */
    #modelTruckTable .text-blue-600, .text-red-600 {
    border: none;
    background: none;
    color: inherit; /* Mantém a cor padrão do texto para melhor integração */
    padding: 5px 10px;
    border-radius: 5px; /* Bordas arredondadas para os botões */
    cursor: pointer; /* Cursor de ponteiro para indicar interatividade */
    }

    #modelTruckTable .text-blue-600:hover, .text-red-600:hover {
    background-color: #e2e2e2; /* Mudança de cor ao passar o mouse para um cinza muito leve */
    }
</style>

