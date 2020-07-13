<template>
  <b-navbar class="fixed-top w-100" toggleable="lg" type="dark" variant="dark">
    <b-navbar-brand to="/">Yodawy</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item to="/">Home</b-nav-item>
        <b-nav-item to="/favorites" v-if="user.isLogged">Favorites</b-nav-item>
      </b-navbar-nav>
      <Auth
        :dialog="showLogin && !user.isLogged"
        @disableLogin="disableLogin"
      />
      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-item v-if="!user.isLogged" @click="showLogin = true"
          >Login</b-nav-item
        >
        <b-nav-item v-if="user.isLogged" @click="logout">Logout</b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
import Auth from "./Auth";
import { mapState, mapActions } from "vuex";
export default {
  name: "Header",
  data() {
    return {
      showLogin: false
    };
  },
  components: {
    Auth
  },
  computed: {
    ...mapState(["user"]),
    logged() {
      return this.user.isLogged;
    }
  },
  methods: {
    ...mapActions(["logout"]),
    disableLogin() {
      this.showLogin = false;
    }
  },
  watch: {
    logged: {
      immediate: true,
      handler(newVal) {
        this.showLogin = !newVal ? false : this.showLogin;
      }
    }
  }
};
</script>

<style scoped></style>
