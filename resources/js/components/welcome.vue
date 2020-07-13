<template>
  <div class="card leftDiv bg-light">
    <div class="card-body">
      <h2 class="text-success"><small>Hello </small>{{ name }}</h2>
      <p class="card-text">Welcome to our website.</p>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: "welcome",
  computed: {
    ...mapState(["user"]),
    logged() {
      return this.user.isLogged;
    },
    name() {
      if (this.logged) {
        return localStorage.getItem("name");
      }
      return "";
    }
  }
};
</script>
<style scoped>
.leftDiv {
  position: absolute;
  top: 10%;
  right: 10%;
  width: 67%;
  height: 200px;
}
</style>
