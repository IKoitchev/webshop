import React, { useState, useEffect } from "react";
import "./App.css";
import Navbar from "./Components/Navbar";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";

import "./App.css";
import "bootstrap/dist/css/bootstrap.css";
import Home from "./Components/pages/Home.js";
import Services from "./Components/pages/Services";
import Products from "./Components/pages/Products";
import Register from "./Components/auth/register.component";
import Login from "./Components/auth/login.component";
import Profile from "./Components/auth/profile.component";

function App() {
  return (
    <>
      <Router>
        <Navbar />
        <Switch>
          <Route path="/" exact component={Home} />
          <Route path="/services" component={Services} />
          <Route path="/products" component={Products} />
          <Route path="/sign-up" component={Register} />
          <Route path="/login" component={Login} />
          <Route path="/profile" component={Profile} />
        </Switch>
      </Router>
    </>
  );
}

export default App;
