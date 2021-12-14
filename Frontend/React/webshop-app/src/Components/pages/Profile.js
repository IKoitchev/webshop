import React, { Component } from "react";
import AuthService from "../../services/auth.service";
import Navbar from "../Navbar";
import "../../App.css";
import Axios from "axios";
import Product from "../Product/Product";
export default class Profile extends Component {
  constructor(props) {
    super(props);

    this.state = {
      userReady: false,
      currentUser: null,
      ownedProducts: [],
    };
  }
  getData = (...res) => {
    this.setState({
      userReady: true,
      currentUser: AuthService.getCurrentUser(),
      ownedProducts: res,
    });
    //console.log(this.state);
  };
  async getOwnedProducts() {
    await Axios.get(
      "http://localhost:8080/products/ownedBy?name=" +
        AuthService.getCurrentUser().username
    ).then((res) => this.getData(...res.data));
  }
  componentDidMount() {
    if (AuthService.getCurrentUser()) {
      this.getOwnedProducts();
    }
  }

  render() {
    return (
      <>
        <Navbar />
        <div className="container">
          {this.state.userReady ? (
            <div>
              <header className="jumbotron">
                <h3>
                  <strong>Logged in as: &nbsp;</strong>
                  {this.state.currentUser.username}
                  {AuthService.getCurrentUser().roles[0] === "ROLE_ADMIN" ? (
                    <>
                      <label className="label-title">&nbsp;- Admin</label>
                    </>
                  ) : (
                    <></>
                  )}
                </h3>
                <p>
                  <strong>Email:</strong> {this.state.currentUser.email}
                </p>
              </header>
              <div className="purchases-container">
                <label className="purchases-label">Your purchases: </label>
                <br />
                {AuthService.getCurrentUser() ? (
                  this.state.ownedProducts.map((p, i) => {
                    return <Product product={p} key={i} />;
                  })
                ) : (
                  <>Loading...</>
                )}
              </div>
            </div>
          ) : null}
        </div>
      </>
    );
  }
}
