// import Axios from "axios";

import Axios from "axios";
import gql from 'graphql-tag';

import graphqlClient from '../../utils/graphql';

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
        graphqlClient.query({
            query: gql`
              query {
                newsAPI{
                    source{id name}
                    author
                    title
                    description
                    url
                    urlToImage
                    publishedAt
                  }
              }
            `,
          }).then(response => {
              console.log('getAllNews response: ', response.data.newsAPI)
              commit("getAllNews", response.data.newsAPI)
          }).catch(function(error){
              console.log('errrrrrr',error.message)
            commit("showPopup", {
                msgType: "Error",
                msgText: "Please check your network 1"
            });
          })
    },

    getMyFav({ commit }) {
        graphqlClient.mutate({
            mutation: gql`
            mutation {
                getFav{
                    id
                    userId
                    source
                    author
                    type
                    title
                    description
                    url
                    urlToImage
                    publishedAt
                    errors
                }
            }
            `
          }).then(response => {
              console.log('getMyFav response: ', response)
              commit("getMyFav", response.data.getFav)
          }).catch(function(error){
                console.log('getMyFav error : ',error)
                if (error.message.startsWith("GraphQL Error: Database")) {
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Internal server error, please try again"
                    });
                }else if(error.message.startsWith("GraphQL error: Unauthenticated.")){
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "You not allowed to get this page"
                    });
                }else{
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Please check your network 2"
                    });
                }
            });
    },

    addToFav({ commit }, newData) {
        console.log('newData: ',newData)
        graphqlClient.mutate({
            mutation: gql`
            mutation ($sourceName: String, $sourceId: String, $author: String!,$type: String!,$title: String!,$description: String!,$url: String!,$urlToImage: String!,$publishedAt: String! ) { 
                saveFav(
                    input:{
                        source: {
                            id: $sourceId
                            name: $sourceName
                        }
                        author: $author
                       type: $type
                       title: $title
                       description: $description
                       url: $url
                       urlToImage: $urlToImage
                       publishedAt: $publishedAt
                    }
              ){
                id
                userId
                source
                author
                type
                title
                description
                url
                urlToImage
                publishedAt
                errors
            }
              
            }
            `,

        
        variables: { sourceName: newData.source.name, sourceId: newData.source.id, author: newData.author, type: newData.type, title: newData.title, description: newData.description, url: newData.url, urlToImage: newData.urlToImage, publishedAt: newData.publishedAt}
        
          }).then(response => {
                console.log('addToFav response: ', response)
                commit("addToFav", { savedData: response.data.saveFav, newData });
                commit("showSnackBar", {
                    text: "New is added successfully to your favorite list",
                    timeout: 3000
                });
          }).catch(function(error){
                console.log('addToFav error : ',error)
                if (error.message.startsWith("GraphQL Error: Database")) {
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Some error has happend, please try again later!"
                    });
                }else if(error.message.startsWith("GraphQL error: Unauthenticated.")){
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "You should sign in first!"
                    });
                }else{
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Please check your network 3"
                    });
                }
            });
    },

    deleteFromFav({ commit }, newData) {
        graphqlClient.mutate({
            mutation: gql`
            mutation ($id: ID! ) { 
                deleteFav(id: $id){
                id
                userId
                source
                author
                type
                title
                description
                url
                urlToImage
                publishedAt
                errors
            }
              
            }
            `,

        
        variables: { id: newData.id}
        
          }).then(response => {
                console.log('deleteFromFav response: ', response.data.deleteFav)
                commit("deleteFromFav", newData);
                commit("showSnackBar", {
                    text: "New is deleted successfully from your favorite list",
                    timeout: 3000
                });
          }).catch(function(error){
                console.log('addToFav error : ',error)
                if (error.message.startsWith("GraphQL Error: Database")) {
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Some error has happend, please try again later!"
                    });
                }else if(error.message.startsWith("GraphQL error: Unauthenticated.")){
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "This new is not in your favorite list, You can't delete it"
                    });
                }else{
                    commit("showPopup", {
                        msgType: "Error",
                        msgText: "Please check your network 4"
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
