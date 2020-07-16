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
		allNews() {
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
	mounted() {
		this.getAllNews();
	},
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
