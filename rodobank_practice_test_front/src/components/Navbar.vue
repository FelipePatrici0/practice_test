<template>
  <nav class="bg-gray-800 text-white h-[5.2rem] flex items-center justify-between px-4">
    <!-- Ícone de logout à direita -->
    <div class="ml-auto">
      <button
        @click="handleLogout"
        class="flex items-center space-x-2 hover:text-gray-400"
      >
        <span>Logout</span>
        <i class="fas fa-sign-out-alt"></i>
      </button>
    </div>
  </nav>
</template>

<script setup>
import api from '@/axios';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';

const router = useRouter();

  const handleLogout = async () => {
    try {
        const response = await api.post('user/logout');

        console.log(response.data.message);

        Swal.fire({
          icon: 'success',
          title: 'Logout realizado com sucesso!',
          text: 'Você será redirecionado para a tela de login.',
          timer: 2000,
          showConfirmButton: false
        }).then(() => {
          localStorage.removeItem('authToken');
          router.push('/');
        });
      } catch (error) {
        console.error('Erro ao fazer logout:', error);
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: 'Ocorreu um erro ao tentar realizar o logout.',
        });
      }
  };

</script>

<style scoped>
button {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.2rem;
}
</style>
