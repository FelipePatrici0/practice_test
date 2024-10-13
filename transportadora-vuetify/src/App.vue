<template>
  <v-app>
    <v-navigation-drawer v-model="drawer" app>
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
          :prepend-icon="item.icon"
          :title="item.title"
          :value="item.title"
        ></v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Transportadora INC</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script setup>
import { ref } from "vue";

const drawer = ref(true);
const items = [
  { title: "Transportadora", icon: "mdi-truck", to: "/transportadora" },
  { title: "Motorista", icon: "mdi-account-tie", to: "/motorista" },
  { title: "Modelo", icon: "mdi-car", to: "/modelo" },
  { title: "Caminhao", icon: "mdi-truck-cargo-container", to: "/caminhao" },
];
</script>
