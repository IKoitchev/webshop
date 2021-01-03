import axios from "axios";
import { Component } from "react";
import { React } from "react";
import "../../App.css";
import Product from "../Product";
import Navbar from "../Navbar";
class Products extends Component {
  state = {
    products: [],
    loading: true,
  };
  componentDidMount() {
    this.handleSearch();
  }
  getData(res) {
    this.setState({ products: res, loading: false });
  }
  async getAllProducts() {
    await axios
      .get("http://localhost:8080/products/all")
      .then((resp) => this.getData(resp.data));
  }

  async getProduct(value) {
    await axios
      .get("http://localhost:8080/products/get?name=" + value)
      .then((resp) => this.getData([resp.data]));
  }
  handleSearch = () => {
    this.setState({ products: [], loading: true });
    const searchedName = document.getElementById("searchbox").value;
    if (!searchedName) {
      this.getAllProducts();
    } else {
      const newProducts = [];
      newProducts.push(this.getProduct(searchedName));
      this.setState({ products: newProducts });
      console.log(newProducts);
    }
  };
  render() {
    return (
      <>
        <Navbar />
        <div>
          <h1 className="products">PRODUCTS</h1>

          <input
            type="text"
            className="search"
            placeholder="Search.."
            id="searchbox"
          />
          <input type="button" value="search" onClick={this.handleSearch} />
          <br />
          {this.state.loading ? (
            "Loading Page..."
          ) : (
            <ul>
              {this.state.products.map((p, i) => {
                console.log(this.state.products);
                return (
                  <li key={i}>
                    <Product product={p} />
                  </li>
                );
              })}
            </ul>
          )}
        </div>
      </>
    );
  }
}
export default Products;
