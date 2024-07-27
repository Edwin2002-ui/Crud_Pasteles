<template>
  <nav class="navbar navbar-expand navbar-light bg-light">
      <div class="nav navbar-nav">
         <!-- <router-link to="/">Home</router-link> -->
    
        <router-link to="/pasteles/list" class="nav-link">Lista de Pasteles</router-link>
      
        <router-link to="/ingredientes/list"  class="nav-link">Lista de ingredientes </router-link>


        <router-link to="/about"  class="nav-link">About</router-link>

      </div>
  </nav>
  <br>
  <router-view/>


</template>


