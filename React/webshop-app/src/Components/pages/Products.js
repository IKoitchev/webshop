import axios from "axios";
import { Component } from "react";
import { React } from "react";
import "../../App.css";
import Product from "../Product/Product";
import Navbar from "../Navbar";
import { Link, Redirect } from "react-router-dom";
import Axios from "axios";
class Products extends Component {
  state = {
    products: [],
    loading: true,
    disctinctGenres: [],
    filteredProducts: [],
  };

  async getFilteredProducts() {
    Axios.get(
      "http://localhost:8080/products/getByGenre?genre=" +
        document.getElementById("dropdown").value
    ).then((res) => this.setState({ products: res.data }));
  }
  handleFilterChange = () => {
    this.getFilteredProducts();
  };

  componentDidMount() {
    this.handleSearch();
  }
  getData(res) {
    if (this.state.disctinctGenres.length === 0) {
      // 1time
      var flags = [],
        output = [],
        l = res.length,
        i;
      for (i = 0; i < l; i++) {
        if (flags[res[i].genre]) continue;
        flags[res[i].genre] = true;
        output.push(res[i].genre);
      }
    } else {
      var output = this.state.disctinctGenres;
    }
    this.setState({ products: res, loading: false, disctinctGenres: output });
    console.log(res);
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
  handleAdd = () => {
    this.history.pushState(null, "/new-product");
  };
  render() {
    return (
      <>
        <Navbar />
        <h1 className="products">Products</h1>
        <div>
          <div className="input-elements">
            <input
              type="text"
              className="btn btn-dark"
              placeholder="Search.."
              id="searchbox"
            />
            &nbsp;&nbsp;
            <input
              type="button"
              value="search"
              onClick={this.handleSearch}
              className="btn btn-dark"
            />
            &nbsp;&nbsp;
            <Link to="/new-product" value="Add Product">
              <button className="btn btn-dark">Add product</button>
            </Link>
            &nbsp;&nbsp;
            {!this.state.disctinctGenres ? (
              <></>
            ) : (
              <select
                id="dropdown"
                className="btn btn-dark"
                onChange={this.handleFilterChange}
              >
                <option disabled selected>
                  Filter by genre..
                </option>
                {this.state.disctinctGenres.map((genre, i) => (
                  <option value={genre} key={i}>
                    {genre}
                  </option>
                ))}
              </select>
            )}
          </div>
          <div className="all-product-container">
            {this.state.loading ? (
              "Loading Page..."
            ) : (
              <div>
                {this.state.products.map((p, i) => {
                  return <Product product={p} key={i} />;
                })}
              </div>
            )}
          </div>
        </div>
      </>
    );
  }
}
export default Products;
