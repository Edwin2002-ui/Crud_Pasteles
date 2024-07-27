<template>
  <div class="container">
    <h1 class="my-4">Editar Pastel</h1>
    <form @submit.prevent="updatePastel">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input
          type="text"
          class="form-control"
          id="nombre"
          v-model="pastel.Nombre"
          required
        />
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <input
          type="text"
          class="form-control"
          id="descripcion"
          v-model="pastel.Descripcion"
          required
        />
      </div>
      <div class="form-group">
        <label for="preparado_por">Preparado por</label>
        <input
          type="text"
          class="form-control"
          id="preparado_por"
          v-model="pastel.Preparado_por"
          required
        />
      </div>
      <div class="form-group">
        <label for="fecha_creacion">Fecha de Creación</label>
        <input
          type="date"
          class="form-control"
          id="fecha_creacion"
          v-model="pastel.Fecha_creacion"
          required
        />
      </div>
      <div class="form-group">
        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
        <input
          type="date"
          class="form-control"
          id="fecha_vencimiento"
          v-model="pastel.Fecha_Vencimiento"
          required
        />
      </div>

      <!-- Ingredientes -->
      <div class="form-group">
        <label for="ingredientes">Ingredientes:</label>
        <select multiple v-model="selectedIngredientes" class="form-control">
          <option v-for="ingrediente in ingredientes" :key="ingrediente.ID_ingrediente" :value="ingrediente.ID_ingrediente">
            {{ ingrediente.Nombre }}
          </option>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Actualizar</button>
      <router-link to="/pasteles/list">
        <button class="btn btn-primary ms-3" type="button">Regresar</button>
      </router-link>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      pastel: {
        ID_pastel: "",
        Nombre: "",
        Descripcion: "",
        Preparado_por: "",
        Fecha_creacion: "",
        Fecha_Vencimiento: "",
      },
      ingredientes: [],
      selectedIngredientes: [], // Lista de ingredientes seleccionados
    };
  },
  created() {
    this.fetchIngredientes();
    this.fetchPastel();
  },
  methods: {
    fetchIngredientes() {
      axios
        .get("http://localhost/crud_pasteles/backend/api/ingrediente/read.php")
        .then(response => {
          this.ingredientes = response.data.records;
        })
        .catch(error => {
          console.error("Hubo un error al obtener los ingredientes:", error);
        });
    },
    fetchPastel() {
      const id = this.$route.params.id;
      axios
        .get(`http://localhost/crud_pasteles/backend/api/pastel/show.php?id=${id}`)
        .then(response => {
          this.pastel = response.data;
          this.fetchSelectedIngredientes(); // Obtener ingredientes seleccionados para el pastel
        })
        .catch(error => {
          console.error("Error fetching pastel:", error);
        });
    },
    fetchSelectedIngredientes() {
      const id = this.$route.params.id;
      axios
        .get(`http://localhost/crud_pasteles/backend/api/pastel/read_ingredientes.php?id=${id}`)
        .then(response => {
          this.selectedIngredientes = response.data.records.map(item => item.ID_ingrediente);
        })
        .catch(error => {
          console.error("Error fetching selected ingredientes:", error);
        });
    },
    updatePastel() {
      axios
        .post(
          "http://localhost/crud_pasteles/backend/api/pastel/update.php",
          {
            ...this.pastel,
            ingredientes: this.selectedIngredientes, // Enviar ingredientes seleccionados
          },
          {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
        .then(() => {
          this.$router.push("/pasteles/list");
        })
        .catch(error => {
          console.error("Error updating pastel:", error);
        });
    },
  },
};
</script>
