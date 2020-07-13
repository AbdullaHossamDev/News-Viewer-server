<template>
  <v-row justify="center">
    <!-- <v-btn >ana button </v-btn> -->
    <v-dialog v-model="dialog" persistent max-width="500">
      <v-card>
        <div class="xClass" @click="$emit('disableLogin')">
          <i class="fas fa-times"></i>
        </div>

        <div>
          <div class="login-wrap">
            <div class="login-html">
              <input
                id="tab-1"
                type="radio"
                name="tab"
                class="sign-in"
                checked
              />
              <label for="tab-1" class="tab">Sign In</label>
              <input id="tab-2" type="radio" name="tab" class="sign-up" />
              <label for="tab-2" class="tab">Sign Up</label>
              <div class="login-form">
                <form @submit.prevent="loginData">
                  <div class="sign-in-htm">
                    <div class="group">
                      <label for="pass" class="label">Email Address</label>
                      <input
                        type="text"
                        class="input"
                        name="email"
                        email
                        required
                        v-model="loginEmail"
                      />
                    </div>
                    <div class="group">
                      <label for="pass" class="label">Password</label>
                      <input
                        type="password"
                        class="input"
                        name="password"
                        data-type="password"
                        required
                        v-model="loginPassword"
                      />
                    </div>
                    <div class="group">
                      <input
                        type="submit"
                        class="button btn"
                        value="Sign In"
                        :disabled="loginBtnDisable"
                      />
                    </div>
                    <div class="hr"></div>
                  </div>
                </form>
                <form @submit.prevent="registerData">
                  <div class="sign-up-htm">
                    <div class="group">
                      <label for="user" class="label">Username</label>
                      <input
                        type="text"
                        class="input"
                        name="userName"
                        required
                        v-model="registerName"
                      />
                    </div>
                    <div class="group">
                      <label for="pass" class="label">Email Address</label>
                      <input
                        type="text"
                        class="input"
                        name="email"
                        email
                        required
                        v-model="registerEmail"
                      />
                    </div>
                    <div class="group">
                      <b-input-group class="mb-3">
                        <label class="label">Birth date</label>
                        <input
                          type="text"
                          class="input birthDateInput"
                          name="birthDate"
                          placeholder="Selected date"
                          :value="registerBirthDate"
                          disabled
                        />
                        <b-input-group-append>
                          <b-form-datepicker
                            v-model="registerBirthDate"
                            button-only
                            right
                            locale="en-US"
                            aria-controls="example-input"
                          ></b-form-datepicker>
                        </b-input-group-append>
                      </b-input-group>
                    </div>
                    <div class="group">
                      <input
                        type="submit"
                        class="button btn"
                        value="Sign Up"
                        :disabled="regBtnDisable"
                      />
                    </div>
                    <div class="hr"></div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "Auth",
  props: {
    dialog: { type: Boolean, required: true }
  },
  data() {
    return {
      loginEmail: "",
      loginPassword: "",
      registerEmail: "",
      registerName: "",
      registerBirthDate: ""
    };
  },
  methods: {
    ...mapActions(["register", "login"]),
    loginData() {
      let userData = {
        email: this.loginEmail,
        password: this.loginPassword
      };
      this.login(userData);
    },
    registerData() {
      let userData = {
        email: this.registerEmail,
        name: this.registerName,
        birthDate: new Date(this.registerBirthDate)
      };
      this.register(userData);
    },
    validEmail: function(email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }
  },
  computed: {
    regBtnDisable() {
      let email = this.registerEmail;
      let name = this.registerName;

      const searchRegExp = / /g;
      const replaceWith = "";

      name = name.replace(searchRegExp, replaceWith);
      email = email.replace(searchRegExp, replaceWith);
      return !name || !this.registerBirthDate || !this.validEmail(email);
    },
    loginBtnDisable() {
      return !this.validEmail(this.loginEmail) || !this.loginPassword;
    }
  },
  watch: {
    dialog: {
      immediate: true,
      handler(newVal) {
        if (!newVal) {
          this.loginEmail = "";
          this.loginPassword = "";
          this.registerEmail = "";
          this.registerName = "";
          this.registerBirthDate = "";
        }
      }
    }
  }
};
</script>

<style scoped>
.xClass {
  position: relative;
  cursor: pointer;
}
i.fas.fa-times {
  font-size: 30px;
  position: absolute !important;
  z-index: 10;
  color: #eee;
  right: 3%;
  top: 10px;
}
body {
  margin: 0;
  color: #6a6f8c;
  background: #c8c8c8;
  font: 600 16px/18px "Open Sans", sans-serif;
}
*,
:after,
:before {
  box-sizing: border-box;
}
.clearfix:after,
.clearfix:before {
  content: "";
  display: table;
}
.clearfix:after {
  clear: both;
  display: block;
}
a {
  color: inherit;
  text-decoration: none;
}

.login-wrap {
  width: 100%;
  margin: auto;
  max-width: 525px;
  min-height: 670px;
  position: relative;
  background: url(https://raw.githubusercontent.com/khadkamhn/day-01-login-form/master/img/bg.jpg)
    no-repeat center;
  box-shadow: 0 12px 15px 0 rgba(0, 0, 0, 0.24),
    0 17px 50px 0 rgba(0, 0, 0, 0.19);
}
.login-html {
  width: 100%;
  height: 100%;
  position: absolute;
  padding: 90px 70px 50px 70px;
  background: rgba(40, 57, 101, 0.9);
}
.login-html .sign-in-htm,
.login-html .sign-up-htm {
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  position: absolute;
  transform: rotateY(180deg);
  backface-visibility: hidden;
  transition: all 0.4s linear;
}
.login-html .sign-in,
.login-html .sign-up,
.login-form .group .check {
  display: none;
}
.login-html .tab,
.login-form .group .label,
.login-form .group .button {
  text-transform: uppercase;
}
.login-html .tab {
  font-size: 22px;
  margin-right: 15px;
  padding-bottom: 5px;
  margin: 0 15px 10px 0;
  display: inline-block;
  border-bottom: 2px solid transparent;
  color: #6c757d;
}
.login-html .sign-in:checked + .tab,
.login-html .sign-up:checked + .tab {
  color: #fff;
  border-color: #1161ee;
}
.login-form {
  min-height: 345px;
  position: relative;
  perspective: 1000px;
  transform-style: preserve-3d;
}
.login-form .group {
  margin-bottom: 15px;
}
.login-form .group .label,
.login-form .group .input,
.login-form .group .button {
  width: 100%;
  color: #fff;
  display: block;
}
.login-form .group .input,
.login-form .group .button {
  border: none;
  padding: 15px 20px;
  border-radius: 25px;
  background: rgba(255, 255, 255, 0.1);
}
.login-form .group input[data-type="password"] {
  text-security: circle;
  -webkit-text-security: circle;
}
.login-form .group .label {
  color: #aaa;
  font-size: 12px;
}
.login-form .group .button {
  background: #1161ee;
}
.login-form .group label .icon {
  width: 15px;
  height: 15px;
  border-radius: 2px;
  position: relative;
  display: inline-block;
  background: rgba(255, 255, 255, 0.1);
}
.login-form .group label .icon:before,
.login-form .group label .icon:after {
  content: "";
  width: 10px;
  height: 2px;
  background: #fff;
  position: absolute;
  transition: all 0.2s ease-in-out 0s;
}
.login-form .group label .icon:before {
  left: 3px;
  width: 5px;
  bottom: 6px;
  transform: scale(0) rotate(0);
}
.login-form .group label .icon:after {
  top: 6px;
  right: 0;
  transform: scale(0) rotate(0);
}
.login-form .group .check:checked + label {
  color: #fff;
}
.login-form .group .check:checked + label .icon {
  background: #1161ee;
}
.login-form .group .check:checked + label .icon:before {
  transform: scale(1) rotate(45deg);
}
.login-form .group .check:checked + label .icon:after {
  transform: scale(1) rotate(-45deg);
}
.login-html
  .sign-in:checked
  + .tab
  + .sign-up
  + .tab
  + .login-form
  .sign-in-htm {
  transform: rotate(0);
}
.login-html .sign-up:checked + .tab + .login-form .sign-up-htm {
  transform: rotate(0);
}

.hr {
  height: 2px;
  margin: 60px 0 50px 0;
  background: rgba(255, 255, 255, 0.2);
}
.foot-lnk {
  text-align: center;
}

.suggestion {
  display: none;
  text-align: center;
}

.birthDateInput {
  width: 84% !important;
}
</style>
