<template>
  <div class="container mt-4">
    <h1 class="mb-4">Agregar Pastel</h1>
    <form @submit.prevent="createPastel">
      <!-- Datos del pastel -->
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input
          type="text"
          v-model="pastel.Nombre"
          id="nombre"
          class="form-control"
          required
        />
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <input
          type="text"
          v-model="pastel.Descripcion"
          id="descripcion"
          class="form-control"
          required
        />
      </div>
      <div class="form-group">
        <label for="preparado_por">Preparado por:</label>
        <input
          type="text"
          v-model="pastel.Preparado_por"
          id="preparado_por"
          class="form-control"
          required
        />
      </div>
      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="fecha_creacion">Fecha de Creación:</label>
            <input
              type="date"
              v-model="pastel.Fecha_creacion"
              id="fecha_creacion"
              class="form-control"
              required
            />
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
            <input
              type="date"
              v-model="pastel.Fecha_Vencimiento"
              id="fecha_vencimiento"
              class="form-control"
              required
            />
          </div>
        </div>
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

      <button type="submit" class="btn btn-success">Agregar</button>
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
    createPastel() {
      console.log("Datos enviados:", this.pastel, this.selectedIngredientes); // Verificamos los datos antes de enviarlos

      axios
        .post(
          "http://localhost/crud_pasteles/backend/api/pastel/create.php",
          {
            ...this.pastel,
            ingredientes: this.selectedIngredientes, // Usar el nombre correcto del campo
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
        .catch((error) => {
          if (error.response) {
            console.error("Error Response Data:", error.response.data);
            console.error("Error Response Status:", error.response.status);
            console.error("Error Response Headers:", error.response.headers);
          } else if (error.request) {
            console.error("Error Request:", error.request);
          } else {
            console.error("Error Message:", error.message);
          }
        });
    },
  },
};
</script>
