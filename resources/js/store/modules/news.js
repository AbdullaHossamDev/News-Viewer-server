// import Axios from "axios";

import Axios from "axios";

const filter = function(newsData) {
    newsData = newsData.filter(nw => {
        return (
            nw.source.name &&
            nw.author &&
            nw.title &&
            nw.description &&
            nw.url &&
            nw.urlToImage &&
            nw.publishedAt
        );
    });
    newsData.sort((a, b) => {
        var dateA = new Date(a.publishedAt),
            dateB = new Date(b.publishedAt);
        return dateA > dateB ? -1 : dateA < dateB ? 1 : 0;
    });
    return newsData;
};

const state = {
    news: [],
    favNews: []
};

const getters = {};

const actions = {
    async getAllNews({ commit }) {
        Axios.get("/api/newsAPI")
            .then(response => commit("getAllNews", response.data))
            .catch(function(error) {
                if (error.response) {
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: error.response.data.msg
                    });
                } else {
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Please check your network 1"
                    });
                }
            });
    },

    getMyFav({ commit }) {
        Axios.get("/api/new/")
            .then(response => commit("getMyFav", response.data))
            .catch(function(error) {
                if (error.response) {
                    if (error.response.status == 401) {
                        commit("showPopup", {
                            msgType: "Error",
                            msgText: "You not allowed to get this page"
                        });
                    } else {
                        commit("showPopup", {
                            msgType: "Error",
                            msgText: "Internal Server Error"
                        });
                    }
                } else {
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Please check your network 2"
                    });
                }
            });
    },

    addToFav({ commit }, newData) {
        Axios.post("/api/new/", newData)
            .then(response => {
                commit("addToFav", { savedData: response.data, newData });
                commit("showSnackBar", {
                    text: "New is added successfully to your favorite list",
                    timeout: 3000
                });
            })
            .catch(function(error) {
                if (error.response) {
                    if (error.response.status == 401) {
                        commit("showPopup", {
                            msgType: "Error",
                            msgText: "You should sign in first!"
                        });
                    } else if (error.response.status == 400) {
                        commit("showPopup", {
                            msgType: "Error",
                            msgText: "This new can not be in your favorite list"
                        });
                    } else {
                        commit("showPopup", {
                            msgType: "Error",
                            msgText: "Some error has happend, please try again later!"
                        });
                    }
                } else {
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Please check your network 3"
                    });
                }
            });
    },

    deleteFromFav({ commit }, newData) {
        Axios.delete(`/api/new/${newData.id}`)
            .then(() => {
                commit("deleteFromFav", newData);
                commit("showSnackBar", {
                    text: "New is deleted successfully from your favorite list",
                    timeout: 3000
                });
            })
            .catch(function(error) {
                if (error.response) {
                    if (error.response.status == 401) {
                        commit("showPopup", {
                            msgType: "Error",
                            msgText: "You not allowed to get this page"
                        });
                    } else if (error.response.status == 400) {
                        commit("showPopup", {
                            msgType: "Error",
                            msgText:
                                "This new is not in your favorite list, You can't delete it"
                        });
                    } else {
                        commit("showPopup", {
                            msgType: "Error",
                            msgText:
                                "Some error has happend, please try again later!"
                        });
                    }
                } else {
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Please check your network 3"
                    });
                }
            });
    }
};

const mutations = {
    getAllNews: (state, allNews) => {
        allNews[0].map(n => (n.type = "egyBusiness"));
        allNews[1].map(n => (n.type = "egySports"));
        allNews[2].map(n => (n.type = "uaeBusiness"));
        allNews[3].map(n => (n.type = "uaeSports"));

        state.news = filter([
            ...allNews[0],
            ...allNews[1],
            ...allNews[2],
            ...allNews[3]
        ]);
    },

    getMyFav: async (state, favNews) => {
        favNews.map(fn => (fn.source = JSON.parse(fn.source)));
        state.favNews = filter(favNews);
    },

    addToFav: (state, { savedData, newData }) => {
        newData.id = savedData.id;

        state.news = [...state.news];
    },

    deleteFromFav: (state, newData) => {
        let ind = state.favNews.indexOf(newData);
        state.favNews.splice(ind, 1);
        delete newData.id;

        state.news = [...state.news];
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
