<template>
  <v-row justify="center">
    <!-- <v-btn >ana button </v-btn> -->
    <v-dialog v-model="dialog" persistent max-width="500">
      <v-card>
        <div class="xClass" @click="$emit('disableViewCard')">
          <i class="fas fa-times"></i>
        </div>
        <div class="w-100">
          <div class="mb-3">
            <div class="card mb-3 w-100 m-auto">
              <img
                :src="newData.urlToImage"
                class="card-img-top w-100 m-auto"
              />
              <div class="card-body position-relative">
                <h4 class="text-right card-title mb-4">
                  <a :href="sourceUrl" target="_blank">{{
                    newData.source.name
                  }}</a>
                </h4>
                <h5 class="card-subtitle mb-2 text-muted text-right">
                  {{ newData.author }}
                </h5>
                <h5 class="card-text text-right" dir="rtl">
                  {{ newData.title }}
                </h5>
                <h6 class="card-text text-right text-muted" dir="rtl">
                  {{ newData.description }}
                </h6>

                <h6 class="card-text mb-0">
                  <small class="text-muted">
                    <div>
                      Published Date:
                      {{ puplishedAt }}
                    </div>
                  </small>
                </h6>
                <h5 class="card-text">
                  <small class="text-muted">
                    <div>
                      New link:
                      <a :href="newData.url" target="_blank">Link</a>
                    </div>
                  </small>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import moment from "moment";

export default {
  name: "ViewNew",
  props: {
    newData: {
      type: Object,
      required: true
    },
    dialog: { type: Boolean, required: true }
  },
  computed: {
    sourceUrl() {
      return `http://www.${this.newData.source.name}`;
    },
    puplishedAt() {
      return moment(this.newData.publishedAt).format("llll");
    }
  }
};
</script>

<style scoped>
.xClass {
  position: relative;
  cursor: pointer;
}
i.fas.fa-times {
  font-size: 30px;
  position: absolute !important;
  z-index: 10;
  color: #eee;
  right: 3%;
  top: 10px;
}
.checked {
  color: orange;
}
.drop {
  position: absolute;
  top: 8%;
  left: 2%;
}

button.btn.dropdown-toggle.dropdown-toggle-split.v-btn.v-btn--contained.theme--light.v-size--default {
  max-width: 3px !important;
  border: 0 !important;
  box-shadow: none;
  background: white;
}

.v-btn:not(.v-btn--round).v-size--default {
  /* height: 36px; */
  /* min-width: 64px; */
  padding: 0 16px;
  margin: 0 10px 0 0;
}

.v-btn:hover {
  cursor: pointer;
  border: 0 !important;
  box-shadow: none;
  background: white;
}

.v-list-item:hover {
  cursor: pointer;
  background-color: #eee;
}

.danger {
  background-color: lightcoral;
}

span {
  cursor: pointer;
}
</style>
