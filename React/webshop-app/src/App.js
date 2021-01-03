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
import Profile from "./Components/pages/Profile";
import ProtectedRoute from "./Components/auth/protected.route";

function App() {
  return (
    <>
      <Router>
        <Switch>
          <Route path="/" exact component={Home} />
          <Route path="/services" component={Services} />
          <Route path="/products" component={Products} />
          <Route path="/sign-up" component={Register} />
          <Route path="/login" component={Login} />
          <ProtectedRoute path="/profile" component={Profile} />
          <Route path="*" component={() => "404 NOT FOUND"} />
        </Switch>
      </Router>
    </>
  );
}

export default App;
