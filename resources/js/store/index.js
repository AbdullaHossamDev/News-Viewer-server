import Vue from "vue";
import Vuex from "vuex";
import user from "./modules/user";
import news from "./modules/news";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    popupModel: {
      showPopupMSG: false,
      msgType: "",
      msgText: ""
    },
    snackBar: {
      showSnackBar: false,
      text: "",
      timeout: 0
    }
  },
  actions: {
    popupDisplay({ commit }, popupData) {
      commit("chngPopupDis", popupData);
    },
    snackBarDisplay({ commit }, snackData) {
      commit("snackBarDis", snackData);
    }
  },
  mutations: {
    chngPopupDis: (state, popupData) => {
      state.popupModel.showPopupMSG = popupData.showPopupMSG;
      state.popupModel.msgText = popupData.showPopupMSG
        ? popupData.msgText
        : "";
      state.popupModel.msgType = popupData.showPopupMSG
        ? popupData.msgType
        : "";
    },
    snackBarDis: state => {
      state.snackBar.showSnackBar = false;
      state.snackBar.text = "";
      state.snackBar.timeout = 0;
    }
  },
  modules: { user, news }
});
