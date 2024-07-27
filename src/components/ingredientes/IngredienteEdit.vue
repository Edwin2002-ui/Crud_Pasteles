<template>
<div class="container">
  <form @submit.prevent="updateIngrediente">
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
    <button type="submit" class="btn btn-success">Actualizar</button>
    <router-link to="/pasteles/list">
      <button class="btn btn-primary ms-3">Regresar</button>
    </router-link>
  </form>
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

  created() {
    this.fetchIngrediente();
  },

  methods: {
    fetchIngrediente() {
      const id = this.$route.params.id;
      axios
        .get(
          `http://localhost/crud_pasteles/backend/api/ingrediente/show.php?id=${id}`
        )
        .then((response) => {
          this.ingrediente = response.data;
        })
        .catch((error) => {
          console.error("Error fetching ingrediente:", error);
        });
    },

    updateIngrediente() {
      axios
        .post(`http://localhost/crud_pasteles/backend/api/ingrediente/update.php`,
         this.ingrediente
         )
        .then(() => {
          this.$router.push("/ingredientes/list");
        })
        .catch((error) => {
          console.error("Error updating ingrediente:", error);
        });
    },
  },
};
</script>
