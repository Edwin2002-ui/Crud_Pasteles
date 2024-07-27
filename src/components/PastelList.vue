<template>
  <div class="container">
    <div class="card">
      <div class="d-flex">
        <router-link to="/pastel/create">
          <button class="btn btn-success btn-lg">Agregar Nuevo Pastel</button>
        </router-link>
      </div>
      <br>
      <div class="card-header">
        <h1 class="my-4">Lista de Pasteles</h1>
      </div>

      <div class="card-body">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Preparado por</th>
              <th>Fecha de Creación</th>
              <th>Fecha de Vencimiento</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="pastel in pasteles" :key="pastel.ID_pastel">
              
              <td>{{ pastel.ID_pastel }}</td>
              
              <router-link :to="{ name: 'pastel-show', params: { id: pastel.ID_pastel } }">
              <td>{{ pastel.Nombre }}</td>
              </router-link>
              <td>{{ pastel.Descripcion }}</td>
              <td>{{ pastel.Preparado_por }}</td>
              <td>{{ pastel.Fecha_creacion }}</td>
              <td>{{ pastel.Fecha_Vencimiento }}</td>
              <td class="d-flex">
                <!-- <button type="button" class="btn btn-outline-warning btn-sm ml-2">Editar</button>  -->
                <router-link :to="{ name: 'pastel-edit', params: { id: pastel.ID_pastel } }" class="btn btn-outline-warning ml-2">Editar</router-link>
                <button
                  @click="deletePastel(pastel.ID_pastel)"
                  class="btn btn-danger ml-2"
                >
                  Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      pasteles: [],
    };
  },
  created() {
    this.fetchPasteles();
  },
  methods: {
    fetchPasteles() {
      axios
        .get("http://localhost/crud_pasteles/backend/api/pastel/read.php")
        .then((response) => {
          this.pasteles = response.data.records;
        })
        .catch((error) => {
          console.error("Error fetching pasteles:", error);
        });
    },
    deletePastel(id) {
      axios
        .post("http://localhost/crud_pasteles/backend/api/pastel/delete.php", {
          ID_pastel: id,
        })
        .then(() => {
  
          this.fetchPasteles();
        })
        .catch((error) => {
          console.error("Error deleting pastel:", error);
        });
    },
  },
};
</script>


