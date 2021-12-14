import React from "react";
import axios from "axios";

const API_URL = "http://localhost:8080/api/auth/";

class AuthService {
  login(username, password) {
    return axios
      .post(API_URL + "signin", {
        username,
        password,
      })
      .then((response) => {
        if (response.data.accessToken) {
          localStorage.setItem("user", JSON.stringify(response.data));
        }
        console.log(this.getCurrentUser());
        return response.data;
      });
  }

  logout() {
    localStorage.removeItem("user");
    console.log("logout");
  }

  register(username, email, password) {
    console.log("signup");
    return axios.post(API_URL + "signup", {
      username,
      email,
      password,
    });
  }

  getCurrentUser() {
    return JSON.parse(localStorage.getItem("user"));
  }
}

let a = new AuthService();
export default a;
