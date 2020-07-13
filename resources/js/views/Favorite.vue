<template>
  <div class="favorite">
    <div class="row">
      <div
        class="col-md-3 position-sticky ml-0 mr-0 position-relative"
        style=" top: 50px;right: 0;height: 683px;"
      >
        <welcome />
      </div>
      <div class="pt-5 pb-5 col-md-6">
        <newCard
          v-for="(newData, index) in favNews"
          :newData="newData"
          :newDataId="newData.id"
          :key="index"
          :index="index"
        />
        <div
          class="loading base_page_color col-md-6 ml-0 mr-0"
          v-if="news.favNews.length == 0"
        >
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div
        class="col-md-3 position-sticky base_page_color ml-0 mr-0 position-relative"
        style=" top: 50px;right: 0;height: 683px;"
      >
        <FilterNew @filterNew="filterNew" />
      </div>
    </div>
  </div>
</template>

<script>
import newCard from "../components/newCard";
import { mapActions, mapState } from "vuex";
import FilterNew from "../components/FilterNew";
import welcome from "../components/welcome";
import router from "../router";
export default {
  name: "favorite",
  data() {
    return {
      showedDataIndex: -1,
      filterData: {}
    };
  },
  components: { newCard, FilterNew, welcome },
  methods: {
    ...mapActions(["getMyFav", "popupDisplay"]),
    filterNew(filterData) {
      this.filterData = filterData;
    }
  },
  computed: {
    ...mapState(["news"]),
    favNews() {
      let filterString = [];
      if (this.filterData.EG) {
        if (
          (this.filterData.Business && this.filterData.Sports) ||
          (!this.filterData.Business && !this.filterData.Sports)
        ) {
          filterString.push("egyBusiness");
          filterString.push("egySports");
        } else if (this.filterData.Business) {
          filterString.push("egyBusiness");
        } else {
          filterString.push("egySports");
        }
      }

      if (this.filterData.UAE) {
        if (
          (this.filterData.Business && this.filterData.Sports) ||
          (!this.filterData.Business && !this.filterData.Sports)
        ) {
          filterString.push("uaeBusiness");
          filterString.push("uaeSports");
        } else if (this.filterData.Business) {
          filterString.push("uaeBusiness");
        } else {
          filterString.push("uaeSports");
        }
      }

      if (!this.filterData.EG && !this.filterData.UAE) {
        if (this.filterData.Business) {
          filterString.push("egyBusiness");
          filterString.push("uaeBusiness");
        }
        if (this.filterData.Sports) {
          filterString.push("egySports");
          filterString.push("uaeSports");
        }
      }

      if (filterString.length == 0) {
        filterString.push("egyBusiness");
        filterString.push("egySports");
        filterString.push("uaeBusiness");
        filterString.push("uaeSports");
      }

      return this.news.favNews.filter(n => filterString.includes(n.type));
    }
  },
  watch: {
    favNews: {
      immediate: true,
      handler() {
        setTimeout(() => {
          if (this.favNews.length == 0) {
            this.popupDisplay({
              showPopupMSG: true,
              msgType: "Warning",
              msgText:
                "Ooh you don't have any news in your favorite list, lets add more!"
            });
            router.push("/");
          }
        }, 3000);
      },
      deep: true
    }
  },
  mounted() {
    this.getMyFav();
  }
};
</script>

<style scoped>
.loading {
  position: absolute;
  margin: auto;
  top: 50%;
  left: 50%;
  right: 50%;
  bottom: 50%;
}
</style>
