<template>
  <div class="container">
    <div class="card">
      <div class="d-flex">
        <router-link to="/ingrediente/create">
          <button class="btn btn-success btn-lg">Agregar Nuevo Ingrediente</button>
        </router-link>
      </div><br>
      <div class="card-header">
        <h1 class="my-4">Lista de Ingredientes</h1>
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Fecha de ingreso</th>
              <th>Fecha de vencimiento</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="ingrediente in ingredientes" :key="ingrediente.ID_ingrediente">
              <td>{{ ingrediente.ID_ingrediente }}</td>
              <td>{{ ingrediente.Nombre }}</td>
              <td>{{ ingrediente.Descripcion }}</td>
              <td>{{ ingrediente.Fecha_ingreso }}</td>
              <td>{{ ingrediente.Fecha_Vencimiento }}</td>
              <td class="d-flex">
                <router-link :to="{ name: 'ingrediente-edit', params: { id: ingrediente.ID_ingrediente } }" class="btn btn-outline-warning ml-2">Editar</router-link>
                <button @click="deleteIngrediente(ingrediente.ID_ingrediente)" class="btn btn-danger ml-2">Eliminar</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';


export default {
  data() {
    return {
      ingredientes: [],
    };
  },
  created() {
    this.fetchIngredientes();
  },
  methods: {
    fetchIngredientes() {
      axios
        .get('http://localhost/Crud_pasteles/backend/api/ingrediente/read.php')
        .then(response => {
          this.ingredientes = response.data.records;
        })
        .catch(error => {
          console.error('Error fetching ingredientes:', error);
        });
    },
    deleteIngrediente(id) {
      console.log(id);
      axios
        .post('http://localhost/crud_pasteles/backend/api/ingrediente/delete.php', {
          ID_ingrediente: id,
        })
        .then(() => {
          this.fetchIngredientes();
        })
        .catch(error => {
          console.error('Error deleting ingrediente:', error);
        });
    },
  },
};
</script>
