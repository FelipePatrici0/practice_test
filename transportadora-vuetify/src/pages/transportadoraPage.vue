<template>
  <v-container class="fill-height">
    <v-responsive class="align-center height mx-auto">
      <v-data-table :items="items"></v-data-table>
    </v-responsive>
  </v-container>
</template>

<script setup>
import { onMounted, ref } from "vue";
import api from "@/services/api";

const items = ref([]);
const loading = ref(false);
const error = ref(null);

const fetchData = async () => {
  loading.value = true;
  error.value = null;
  try {
    const response = await api.get("motoristas");
    console.log(response);
    items.value = response.data; // Limiting to 10 items for this example
  } catch (err) {
    console.error("Error fetching data:", err);
    error.value = "An error occurred while fetching data. Please try again.";
  } finally {
    loading.value = false;
  }
};

onMounted(fetchData);
</script>
