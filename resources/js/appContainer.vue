<template>
  <v-app class="base_page_color">
    <v-content class="mt-5 base_page_color">
      <Header />
      <div class=" mt-5">
        <popupMessage
          v-if="popupModel.showPopupMSG"
          :dialog="popupModel.showPopupMSG"
          :msgType="popupModel.msgType"
          :msgText="popupModel.msgText"
        />
        <snackBar
          v-if="snackBar.showSnackBar"
          :snackbar="snackBar.showSnackBar"
          :text="snackBar.text"
          :timeout="snackBar.timeout"
        />
        <router-view />
      </div>
    </v-content>
  </v-app>
</template>

<script>
import { mapActions, mapState } from "vuex";
import Header from "./components/Header";
import popupMessage from "./components/popupMessage";
import snackBar from "./components/snackBar";
export default {
  name: "App",
  data() {
    return {};
  },
  components: {
    Header,
    popupMessage,
    snackBar
  },
  computed: {
    ...mapState(["popupModel", "snackBar"])
  },
  methods: {
    ...mapActions(["popupDisplay", "checkToken"])
  },
  mounted() {
    this.checkToken();
  }
};
</script>

<style>
.v-dialog.v-dialog--active.v-dialog--persistent {
  overflow: unset;
}
.base_page_color {
  background-color: #e9ebee !important;
}
</style>
