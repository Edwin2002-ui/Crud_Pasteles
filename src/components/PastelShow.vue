<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Detalles del Pastel</h3>
          </div>
          <div class="card-body">
            <p><strong>Nombre:</strong> {{ pastel.Nombre }}</p>
            <p><strong>Descripción:</strong> {{ pastel.Descripcion }}</p>
            <p><strong>Preparado por:</strong> {{ pastel.Preparado_por }}</p>
            <p><strong>Fecha de Creación:</strong> {{ pastel.Fecha_creacion }}</p>
            <p><strong>Fecha de Vencimiento:</strong> {{ pastel.Fecha_Vencimiento }}</p>
            <div v-if="ingredientes.length">
              <h5>Ingredientes:</h5>
              <ul>
                <li v-for="ingrediente in ingredientes" :key="ingrediente.ID_ingrediente">
                  {{ ingrediente.Nombre }}
                </li>
              </ul>
            </div>
            <router-link to="/pasteles/list">
              <button class="btn btn-primary ms-3" type="button">Regresar</button>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      pastel: {},
      ingredientes: []
    };
  },
  created() {
    this.fetchPastel();
    this.fetchIngredientes();
  },
  methods: {
    fetchPastel() {
      const id = this.$route.params.id;
      axios
        .get(`http://localhost/crud_pasteles/backend/api/pastel/show.php?id=${id}`)
        .then(response => {
          this.pastel = response.data;
        })
        .catch(error => {
          console.error("Error fetching pastel:", error);
        });
    },
    fetchIngredientes() {
      const id = this.$route.params.id;
      axios
        .get(`http://localhost/crud_pasteles/backend/api/pastel/read_ingredientes.php?id=${id}`)
        .then(response => {
          this.ingredientes = response.data.records;
        })
        .catch(error => {
          console.error("Error fetching ingredientes:", error);
        });
    }
  }
};
</script>
