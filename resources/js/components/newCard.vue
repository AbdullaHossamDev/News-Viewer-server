<template>
  <div>
    <div class="container w-100 pl-5 pr-5">
      <div class="mb-3">
        <div class="card mb-3 w-100 m-auto">
          <img :src="newData.urlToImage" class="card-img-top w-100 m-auto" />
          <div class="card-body position-relative">
            <div class="text-center drop">
              <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    v-bind="attrs"
                    v-on="on"
                    class="btn dropdown-toggle dropdown-toggle-split"
                  ></v-btn>
                </template>
                <v-list>
                  <v-list-item @click="viewAllNew = true">
                    <v-list-item-title>View</v-list-item-title>
                  </v-list-item>
                  <v-list-item v-if="!newDataId" @click="addNewToFav()">
                    <v-list-item-title>Add to favorites</v-list-item-title>
                  </v-list-item>
                  <v-list-item
                    class="danger"
                    v-if="newDataId"
                    @click="deleteNewFromFav()"
                  >
                    <v-list-item-title>Delete from favorites</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
              <span
                class="fa fa-star starPosition"
                v-if="!newDataId"
                @click="addNewToFav()"
              ></span>
              <span
                class="fa fa-star starPosition checked"
                v-if="newDataId"
                @click="deleteNewFromFav()"
              ></span>
            </div>
            <h4 class="text-right card-title mb-4">
              <a :href="sourceUrl" target="_blank">{{ newData.source.name }}</a>
            </h4>
            <h5 class="card-subtitle mb-2 text-muted text-right">
              {{ newData.author }}
            </h5>
            <h5 class="card-text text-right" dir="rtl">{{ newData.title }}</h5>
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
        <ViewNew
          v-if="viewAllNew"
          :dialog="viewAllNew"
          :newData="newData"
          @disableViewCard="disableViewCard"
        />
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import { mapActions } from "vuex";

import ViewNew from "./ViewNew";
export default {
  name: "newCard",
  components: { ViewNew },
  props: {
    newData: {
      type: Object,
      required: true
    },
    newDataId: { type: Number },
    index: {
      type: Number,
      required: true
    },
    arrayName: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      viewAllNew: false
    };
  },
  computed: {
    sourceUrl() {
      return `http://www.${this.newData.source.name}`;
    },
    puplishedAt() {
      return moment(this.newData.publishedAt).format("llll");
    }
    // id() {
    //   return this.newData["id"];
    // }
  },
  methods: {
    ...mapActions(["addToFav", "deleteFromFav"]),
    addNewToFav() {
      this.addToFav(this.newData);
    },
    deleteNewFromFav() {
      this.deleteFromFav(this.newData);
    },
    disableViewCard() {
      this.viewAllNew = false;
    }
  },
  watch: {
    // id: {
    //   immediate: true,
    //   handler(newVal) {
    //     console.log("d5l fel id watch", newVal);
    //   }
    // },
    // newDataId: {
    //   immediate: true,
    //   handler(newVal) {
    //     console.log("d5l fel newDataId watch", newVal);
    //   }
    // }
  }
};
</script>

<style scoped>
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
