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
    },
    arrayPush(filterString, s) {
			if(filterString.length == 0){
				filterString.push('egy'+s);
				filterString.push('uae'+s);
			}else{
				if(filterString[0].length > 3){
					let filterStrLen = filterString.length;
					for (let i = 0; i < filterStrLen; i++) {
						if(filterString[i].includes("egy") ){
							filterString.push(`egy${s}`);
						}else{
							filterString.push(`uae${s}`);
						}
					}
				}else{
					for (let i = 0; i < filterString.length; i++) {
						if(filterString[i] == "egy" || filterString[i] == "uae" ){
							filterString[i] += s;
						}
					}
				}
			}
		}
  },
  computed: {
    ...mapState(["news"]),
    favNews() {
      let filterString = [];
		
			if (this.filterData.EG) {
				filterString.push("egy");
			}

			if (this.filterData.UAE) {
				filterString.push("uae");
			}

			if (this.filterData.Business) {
				this.arrayPush(filterString, "Business");
			}

			if (this.filterData.Sports) {
				this.arrayPush(filterString, "Sports");
			}
			return this.news.news.filter(n => {
				return filterString.length == 0 ? 1 : filterString.some(x => n.type.includes(x));
			});
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
