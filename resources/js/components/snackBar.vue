<template>
  <div class="text-center">
    <!-- <v-btn >ana button </v-btn> -->
    <v-snackbar v-model="snackbar">
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="blue"
          text
          v-bind="attrs"
          @click="snackBarDisplay({ showSnackBar: false })"
        >
          Ok
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "snackBar",
  props: {
    snackbar: { type: Boolean, required: true },
    text: { type: String, required: true },
    timeout: { type: Number, required: false, default: 3000 }
  },
  methods: {
    ...mapActions(["snackBarDisplay"])
  },
  mounted() {
    setTimeout(() => {
      this.snackBarDisplay({ showSnackBar: false });
    }, this.timeout);
  }
};
</script>
