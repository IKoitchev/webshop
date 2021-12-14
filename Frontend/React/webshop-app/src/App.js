import React, { useState, useEffect } from "react";
import "./App.css";
import Navbar from "./Components/Navbar";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";

import "./App.css";
import "bootstrap/dist/css/bootstrap.css";
import Home from "./Components/pages/Home.js";
import Products from "./Components/pages/Products";
import Register from "./Components/auth/register.component";
import Login from "./Components/auth/login.component";
import Profile from "./Components/pages/Profile";
import ProtectedRoute from "./Components/auth/protected.route";
import ProductForm from "./Components/product.form";
import Statistics from "./Components/pages/Statistics";
import ProductDetails from "./Components/pages/ProductDetails";

function App() {
  return (
    <>
      <Router>
        <Switch>
          <Route path="/" exact component={Home} />
          <Route path="/statistics" component={Statistics} />
          <Route path="/products" component={Products} />
          <Route path="/sign-up" component={Register} />
          <Route path="/login" component={Login} />
          <ProtectedRoute path="/profile" component={Profile} />
          <ProtectedRoute path="/new-product" component={ProductForm} />
          <Route
            path="/details"
            render={(props) => <ProductDetails {...props} />}
          />
          {/* <ProtectedRoute path="/details" component={ProductDetails} /> */}
          <Route path="*" component={() => "404 NOT FOUND"} />
        </Switch>
      </Router>
    </>
  );
}

export default App;
