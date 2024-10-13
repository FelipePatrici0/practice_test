<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Listagem de Transportadoras</h1>
      <router-link to="/home/transportadora/cadastro" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
        + Cadastrar Novo Item
      </router-link>
  
      <table id="transportadoraTable" class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-center">Cód Transportadora</th>
            <th class="py-2 px-4 border-b text-center">Nome da Transportadora</th>
            <th class="py-2 px-4 border-b text-center">CNPJ</th>
            <th class="py-2 px-4 border-b text-center">Data de Cadastro</th>
            <th class="py-2 px-4 border-b text-center">Data de Edição</th>
            <th class="py-2 px-4 border-b text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="carrier in carriers" :key="carrier.id_carrier_tbc">
            <td class="py-2 px-4 border-b text-center">{{ carrier.id_carrier_tbc }}</td>
            <td class="py-2 px-4 border-b text-center">{{ carrier.name_carrier_tbc }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatTableCNPJ(carrier.cnpj_carrier_tbc) }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDate(carrier.created_at) }}</td>
            <td class="py-2 px-4 border-b text-center">{{ formatDate(carrier.updated_at) }}</td>
            <td class="py-2 px-4 border-b text-center flex justify-center space-x-2 items-center"> <!-- Adicionada a classe items-center -->
                <button @click="openEditModal(carrier)" class="text-blue-600 hover:text-blue-800">
                    📝
                </button>
                <!-- Bolinha de status -->
                <button
                    :class="carrier.is_active_tbc ? 'bg-green-500' : 'bg-red-500'"
                    class="w-4 h-4 rounded-full"
                    @click="toggleCarrierStatus(carrier)"
                    :title="carrier.is_active_tbc ? 'Inativar' : 'Ativar'"
                ></button>
                <!-- Botão de deletar -->
                <button
                    @click="deleteCarrier(carrier)"
                    class="text-red-600 hover:text-red-800"
                    title="Deletar Transportadora"
                >
                    ❌
                </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Modal de Edição -->
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-2xl mb-4">Editar Transportadora</h2>
          <form @submit.prevent="handleUpdate">
            <div class="mb-4">
              <label for="nomeEmpresa" class="block mb-2">Nome da Empresa</label>
              <input type="text" v-model="editForm.nomeEmpresa" class="w-full px-3 py-2 border rounded" required />
            </div>
            <div class="mb-4">
              <label for="cnpjEmpresa" class="block mb-2">CNPJ</label>
              <input 
                type="text" 
                v-model="editForm.cnpjEmpresa" 
                @input="formatCNPJ"
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
  import Swal from 'sweetalert2'; // Importa o SweetAlert2
  
  const carriers = ref([]);
  const isModalOpen = ref(false);
  const editForm = ref({
    id: null,
    nomeEmpresa: '',
    cnpjEmpresa: '',
  });
  const originalValues = ref({
    nomeEmpresa: '',
    cnpjEmpresa: '',
  });
  
  let dataTable = null;
  
  // Função que busca a lista de transportadoras
  const fetchCarriers = async () => {
    try {
      const response = await api.get('carrier');
      carriers.value = response.data;
  
      // Verifica se o DataTables já foi inicializado, caso positivo, destrói-o antes de inicializar novamente
      if (dataTable) {
        dataTable.destroy();
      }
  
      setTimeout(() => {
        dataTable = $('#transportadoraTable').DataTable({
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json',
          },
        });
      }, 100);
    } catch (error) {
      console.error('Erro ao buscar transportadoras:', error);
    }
  };
  
  // Função para formatar as datas
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
  
  // Função para formatar o CNPJ
  const formatCNPJ = (event) => {
    let value = event.target.value.replace(/\D/g, '');
    if (value.length > 14) value = value.slice(0, 14);
    value = value.replace(/^(\d{2})(\d)/, '$1.$2');
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
    value = value.replace(/(\d{4})(\d)/, '$1-$2');
    editForm.value.cnpjEmpresa = value; // Atualiza o valor formatado no campo
  };
  
  const formatTableCNPJ = (cnpj) => {
    let value = cnpj.replace(/\D/g, '');
    if (value.length > 14) value = value.slice(0, 14);
    value = value.replace(/^(\d{2})(\d)/, '$1.$2');
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
    value = value.replace(/(\d{4})(\d)/, '$1-$2');
    return value;
  };
  
  // Abrir o modal de edição
  const openEditModal = (carrier) => {
    editForm.value.id = carrier.id_carrier_tbc;
    editForm.value.nomeEmpresa = carrier.name_carrier_tbc;
    editForm.value.cnpjEmpresa = carrier.cnpj_carrier_tbc;
    originalValues.value.nomeEmpresa = carrier.name_carrier_tbc;
    originalValues.value.cnpjEmpresa = carrier.cnpj_carrier_tbc;
    isModalOpen.value = true;
  };
  
  // Fechar o modal
  const closeModal = () => {
    isModalOpen.value = false;
  };
  
  // Função de ativar ou inativar transportadora
  const toggleCarrierStatus = async (carrier) => {
    const action = carrier.is_active_tbc ? 'inativar' : 'ativar';
    const route = carrier.is_active_tbc ? `carrier/deactivate/${carrier.id_carrier_tbc}` : `carrier/activate/${carrier.id_carrier_tbc}`;
  
    const result = await Swal.fire({
      title: `Deseja realmente ${action} a transportadora?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim',
      cancelButtonText: 'Cancelar',
    });
  
    if (result.isConfirmed) {
      try {
        // Faz a requisição PATCH para ativar ou inativar
        await api.patch(route);
        Swal.fire({
          icon: 'success',
          title: `Transportadora ${action} com sucesso!`,
          timer: 2000,
          showConfirmButton: false,
        });
        fetchCarriers(); // Atualiza a listagem de transportadoras
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Erro!',
          text: `Ocorreu um erro ao tentar ${action} a transportadora.`,
        });
      }
    }
  };
  
  // Função para deletar transportadora
  const deleteCarrier = async (carrier) => {
    const result = await Swal.fire({
      title: 'Deseja realmente deletar a transportadora?',
      text: 'Esta ação não pode ser desfeita!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, deletar!',
      cancelButtonText: 'Cancelar',
    });
  
    if (result.isConfirmed) {
      try {
        await api.delete(`driver/${carrier.id_carrier_tbc}`); // Requisição para deletar a transportadora
        Swal.fire({
          icon: 'success',
          title: 'Deletada!',
          text: 'A transportadora foi deletada com sucesso.',
          timer: 2000,
          showConfirmButton: false,
        });
        fetchCarriers(); // Atualiza a listagem de transportadoras
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Erro!',
          text: 'Ocorreu um erro ao tentar deletar a transportadora.',
        });
      }
    }
  };
  
  onMounted(fetchCarriers);
  </script>
  
  <style scoped>
    /* Estilos gerais para a tabela */
    #transportadoraTable {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fonte mais moderna */
    color: #333; /* Cor do texto mais escura para melhor leitura */
    }

    /* Cabeçalhos da tabela */
    #transportadoraTable th {
    background-color: #f7f7f7; /* Cor de fundo cinza claro */
    color: #333; /* Texto cinza escuro para contraste */
    padding: 10px 15px; /* Espaçamento interno maior */
    border-bottom: 2px solid #e0e0e0; /* Linha de separação mais definida */
    }

    /* Células da tabela */
    #transportadoraTable td {
    padding: 8px 10px; /* Espaçamento interno */
    border-bottom: 1px solid #ccc; /* Bordas inferiores sutis */
    text-align: center; /* Alinhamento central para todas as células */
    }

    /* Botões dentro da tabela */
    #transportadoraTable .text-blue-600 {
    border: none;
    color: white;
    padding: 5px 10px;
    border-radius: 5px; /* Bordas arredondadas para os botões */
    cursor: pointer; /* Cursor de ponteiro para indicar interatividade */
    }

    #transportadoraTable .text-blue-600:hover {
    background-color: #0056b3; /* Mudança de cor ao passar o mouse */
    }

    /* Botões de ação */
    #transportadoraTable .text-red-600, .text-green-500 {
    padding: 3px 6px;
    border-radius: 50%; /* Botões redondos para ações de status */
    color: white;
    font-size: 12px; /* Tamanho de fonte menor para os ícones dentro dos botões */
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    }

</style>
  