import Axios from "axios";
import router from "../../router/index";

const state = { isLogged: false };

const getters = {};

const actions = {
  register({ commit }, userData) {
    Axios.post("/api/user/register", userData)
      .then(() => {
        commit("showPopup", {
          msgType: "Success",
          msgText: "Please check your mail to sign in"
        });
      })
      .catch(function(error) {
        if (error.response) {
          if (error.response.status == 409) {
            commit("showPopup", {
              msgType: "Error",
              msgText: "This email has already been taken"
            });
          } else if (error.response.status == 500) {
            commit("showPopup", {
              msgType: "Error",
              msgText: "Opps!, Internal server error, please try again later"
            });
          } else {
            // error.response.status == 400
            commit("showPopup", {
              msgType: "Error",
              msgText: "Please add valid data!"
            });
          }
        } else {
          commit("showPopup", {
            msgType: "Error",
            msgText: "Please check your network 4"
          });
        }
      });
  },

  login({ commit }, userData) {
    Axios.post("/api/user/login", userData)
      .then(response => {
        commit("chngLoginState", true);
        commit("login", response.data);
        commit("showSnackBar", {
          text: "You are logged in successfully",
          timeout: 3000
        });
      })
      .catch(function(error) {
        if (error.response) {
          if (error.response.status == 401 || error.response.status == 500) {
            commit("showPopup", {
              msgType: "Error",
              msgText: "Invalid Credentials "
            });
          } else {
            // error.response.status == 400
            commit("showPopup", {
              msgType: "Error",
              msgText: "Please fill all the requirments!"
            });
          }
        } else {
          commit("showPopup", {
            msgType: "Error",
            msgText: "Please check your network 5"
          });
        }
      });
  },

  logout({ commit }) {
    Axios.post("/api/user/logout")
      .then(() => {
        localStorage.removeItem("token");
        localStorage.removeItem("name");
        commit("chngLoginState", false);
        commit("showSnackBar", {
          text: "You are logged out successfully",
          timeout: 3000
        });
        router.push("/");
      })
      .catch(() => {
        commit("showPopup", {
          msgType: "Error",
          msgText: "Please check your network 6"
        });
      });
  },

  checkToken({ commit }) {
    let isLogged = localStorage.getItem("token") ? true : false;
    commit("chngLoginState", isLogged);
  }
};

const mutations = {
  login: (state, userData) => {
    localStorage.setItem("token", userData.token);
    localStorage.setItem("name", userData.name);
  },
  chngLoginState: (state, isLogged) => {
    state.isLogged = isLogged;
  },
  showPopup(state, { msgType, msgText }) {
    this.state.popupModel.showPopupMSG = true;
    this.state.popupModel.msgType = msgType;
    this.state.popupModel.msgText = msgText;
  },
  showSnackBar(state, { text, timeout }) {
    this.state.snackBar.showSnackBar = true;
    this.state.snackBar.text = text;
    this.state.snackBar.timeout = timeout;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
