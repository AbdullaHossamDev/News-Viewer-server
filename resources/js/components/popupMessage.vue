<template>
  <v-row justify="center">
    <!-- <v-btn >ana button </v-btn> -->
    <v-dialog v-model="dialog" persistent max-width="290">
      <v-card>
        <v-card-title
          class="headline"
          :class="{
            'text-danger': msgType == 'Error',
            'text-success': msgType == 'Success',
            'text-warning': msgType == 'Warning'
          }"
          >{{ msgType }}</v-card-title
        >
        <v-card-text>{{ msgText }}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="darken-1"
            text
            @click="popupDisplay({ showPopupMSG: false })"
            >Ok</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import { mapActions } from "vuex";
export default {
  props: {
    dialog: { type: Boolean, required: true },
    msgType: { type: String, required: true },
    msgText: { type: String, required: true }
  },
  methods: {
    ...mapActions(["popupDisplay"])
  }
};
</script>
