<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h1 class="mb-4">Agregar Nuevo Ingrediente</h1>
      </div>
      <div class="card-body">
        <form @submit.prevent="createIngrediente">
          <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input
              type="text"
              id="nombre"
              v-model="ingrediente.Nombre"
              class="form-control"
              placeholder="Ingrese el nombre del ingrediente"
              required
            />
          </div>
          <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input
              type="text"
              id="descripcion"
              v-model="ingrediente.Descripcion"
              class="form-control"
              placeholder="Ingrese la descripción"
              required
            />
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label for="fecha_ingreso">Fecha de Ingreso:</label>
              <input
                type="date"
                id="fecha_ingreso"
                v-model="ingrediente.Fecha_ingreso"
                class="form-control"
                required
              />
            </div>
            <div class="col-md-6 form-group">
              <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
              <input
                type="date"
                id="fecha_vencimiento"
                v-model="ingrediente.Fecha_Vencimiento"
                class="form-control"
                required
              />
            </div>
          </div>
          <button type="submit" class="btn btn-success">Agregar</button>
          <router-link to="/pasteles/list">
            <button class="btn btn-primary ms-3">Regresar</button>
          </router-link>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      ingrediente: {
        Nombre: "",
        Descripcion: "",
        Fecha_ingreso: "",
        Fecha_Vencimiento: "",
      },
    };
  },
  methods: {
    createIngrediente() {
      console.log("Datos enviados:", this.ingrediente);
      axios
        .post(
          "http://localhost/Crud_pasteles/backend/api/ingrediente/create.php",
          this.ingrediente,
          {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
        .then(() => {
          this.$router.push("/ingredientes/list");
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
