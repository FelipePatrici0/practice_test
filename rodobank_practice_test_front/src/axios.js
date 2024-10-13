import axios from 'axios';

// Criação da instância do Axios
const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/', // URL base da API
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Interceptar requisições para adicionar o token JWT no cabeçalho
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('authToken'); // Busca o token no localStorage
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`; // Adiciona o token no cabeçalho
  }
  return config;
});

export default api;
