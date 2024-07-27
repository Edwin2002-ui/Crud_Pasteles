<template>
  <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card text-center p-4">
      <img alt="Vue logo" src="../assets/logo.png" class="card-img-top">
      <div class="card-body">
        <HelloWorld msg="Bienvenido a Crud Pasteles"/>
        <router-link to="/pasteles/list">
          <button class="btn btn-primary mt-3">Ver Lista de Pasteles</button>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from '@/components/HelloWorld.vue'

export default {
  name: 'HomeView',
  components: {
    HelloWorld
  }
}
</script>

<style scoped>
.card {
  max-width: 350px;
}
</style>


