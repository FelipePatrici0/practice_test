<template>
    <div class="flex h-screen">
      <!-- Sidebar -->
      <Sidebar />
  
      <!-- Conteúdo principal -->
      <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <Navbar />
  
        <!-- Conteúdo dinâmico -->
        <div class="flex-1 p-4">
          <router-view />
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import Sidebar from '@/components/Sidebar.vue';
  import Navbar from '@/components/Navbar.vue';
  </script>
  
  <style scoped>
  /* Estilos adicionais, se necessário */
  </style>
  