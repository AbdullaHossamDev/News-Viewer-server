import Axios from "axios";
import router from "../../router/index";

import gql from 'graphql-tag';

import graphqlClient from '../../utils/graphql';

const state = { isLogged: false };

const getters = {};

const actions = {
  register({ commit }, userData) {
    graphqlClient.mutate({
      mutation: gql`
        mutation ( $name: String!, $email: String!, $birthDate: String!){
          register( name: $name, email: $email, birthDate: $birthDate){
            msg
            errors
            status
          }
        }
      `,
      variables: {name: userData.name, email: userData.email, birthDate: userData.birthDate}
    }).then(response => {
      console.log('register response: ', response)
      if(response.data.register.status == "200"){
        commit("showPopup", {
          msgType: "Success",
          msgText: "Please check your mail to sign in"
        });    
      }else{
        let errors = response.data.register.errors;
        if(errors.includes("The email has already been taken.")){
          commit("showPopup", {
            msgType: "Error",
            msgText: "This email has already been taken"
          });    
        }else{
          commit("showPopup", {
            msgType: "Error",
            msgText: "Please add valid data!"
          });
        }
      }
    }).catch(function(error){
      console.log('register error: ', error)
      if (error.message.startsWith("GraphQL error: Internal")) {
        commit("showPopup", {
            msgType: "Error",
            msgText: "Some error has happend, please try again later!"
        });
      }else{
        commit("showPopup", {
          msgType: "Error",
          msgText: "Please check your network 5"
      });
      }
    })
  },

  login({ commit }, userData) {
    graphqlClient.mutate({
      mutation: gql`
        mutation ( $email: String!, $password: String!){
          login( email: $email, password: $password){
            name
            token
            errors
            status
          }
        }
      `,
      variables: {email: userData.email, password: userData.password}
    }).then(response => {
      console.log('login response: ', response)
      if(response.data.login.status == "200"){
        commit("chngLoginState", true);
        commit("login", response.data.login);
        commit("showSnackBar", {
          text: "You are logged in successfully",
          timeout: 3000
        });
      }else{
        let status = response.data.login.status;
        if(status == "401"){
          commit("showPopup", {
            msgType: "Error",
            msgText: "Invalid Credentials"
          });
        }else{
          commit("showPopup", {
            msgType: "Error",
            msgText: "Please add valid data!"
          });    
        }
      }
    }).catch(function(error){
      console.log('login error: ', error)
      if (error.message.startsWith("GraphQL error: Internal")) {
        commit("showPopup", {
            msgType: "Error",
            msgText: "Some error has happend, please try again later!"
        });
      }else{
        commit("showPopup", {
          msgType: "Error",
          msgText: "Please check your network 5"
      });
      }
    })
  },

  logout({ commit }) {
    graphqlClient.mutate({
      mutation: gql`
      mutation {
          logout{
              msg
          }
      }
      `
    }).then(response => {
        console.log('logout response: ', response)
        localStorage.removeItem("token");
        localStorage.removeItem("name");
        commit("chngLoginState", false);
        commit("showSnackBar", {
          text: "You are logged out successfully",
          timeout: 3000
        });
        router.push("/");
    }).catch(function(error){
          if(error.message.startsWith("GraphQL error: Unauthenticated.")){
              commit("showPopup", {
                  msgType: "Error",
                  msgText: "You not allowed to do this"
              });
          }else{
              commit("showPopup", {
                  msgType: "Error",
                  msgText: "Please check your network 2"
              });
          }
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
