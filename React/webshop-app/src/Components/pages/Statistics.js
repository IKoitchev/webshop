import Axios from "axios";
import React from "react";
import "../../App.css";
import Navbar from "../Navbar";
import axios from "axios";

class Statistics extends React.Component {
  state = {
    stats: [],
  };
  componentDidMount() {
    Axios.get("http://localhost:8080/products/getStatistics").then((res) =>
      this.setState({ stats: { ...res.data } })
    );
  }
  render() {
    return (
      <>
        <Navbar />
        <h1>Statistics about our products</h1>

        <div className="statistic-card">
          <label className="label-title">Total number of products</label>
          <br />
          {this.state.stats.totalNumberOfProducts}
          <br />
          <label className="label-title">Average product cost (in euro)</label>
          <br />
          {this.state.stats.averageProductPrice}
          <br />
          <label className="label-title">Newest product</label>
          <br />
          {this.state.stats.newestProduct}
          {console.log(this.state.stats.newestProduct)}
          <br />
          <br />
        </div>
      </>
    );
  }
}

export default Statistics;
