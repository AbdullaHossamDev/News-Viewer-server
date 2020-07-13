<template>
	<div class="home">
		<div class="row">
			<div
				class="col-md-3 position-sticky ml-0 mr-0 position-relative"
				style=" top: 50px;right: 0;height: 683px;"
			>
				<welcome />
			</div>
			<div class="pt-5 pb-5 col-md-6">
				<div v-for="(newData, index) in allNews" :key="index">
					<newCard
						:newData="newData"
						:newDataId="newData.id"
						:index="index"
						:arrayName="'news'"
						v-if="index < showedDataIndex"
					/>
				</div>
				<div class="w-50 m-auto">
					<button
						@click="increaseShowedNews"
						class="btn btn-block btn-outline-secondary mb-1"
						v-if="showedDataIndex <= allNews.length"
					>Seemore</button>
				</div>
				<div class="loading base_page_color col-md-6 ml-0 mr-0" v-if="news.news.length == 0">
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
import { mapState, mapActions } from "vuex";
import newCard from "../components/newCard";
import FilterNew from "../components/FilterNew";
import welcome from "../components/welcome";
export default {
	name: "Home",
	data() {
		return {
			showedDataIndex: 10,
			filterData: {}
		};
	},
	components: { newCard, FilterNew, welcome },
	methods: {
		...mapActions(["getAllNews"]),
		filterNew(filterData) {
			this.filterData = filterData;
		},
		increaseShowedNews() {
			this.showedDataIndex += 10;
		}
	},
	computed: {
		...mapState(["news"]),
		allNews() {
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

			return this.news.news.filter(n => filterString.includes(n.type));
		}
	},
	mounted() {
		this.getAllNews();
	},
	watch: {
		// "news.news": {
		//   immediate: true,
		//   handler(newVal) {
		//     console.log("news.news: gdeeeda hna", newVal);
		//   },
		//   deep: true
		// }
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
