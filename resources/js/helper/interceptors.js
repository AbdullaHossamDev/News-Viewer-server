import Axios from "axios";

export default function setup() {
  Axios.interceptors.request.use(
    function(config) {

      const token = localStorage.getItem("token");
      if (token) {
        config.headers.Authorization = `Bearer ${token}`;
      }
      return config;
    },
    function(err) {

      return Promise.reject(err);
    }
  );
}
