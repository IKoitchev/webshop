import React, { Component } from "react";

class Read extends Component {
  constructor(props) {
    super(props);
    this.state = {
      items: [],
      isLoaded: false,
    };
  }

  componentDidMount() {
    fetch("/webshop/products?name=amongus")
      .then((res) => res.json())
      .then((json) => {
        this.setState({
          isLoaded: true,
          items: json,
        });
        console.log(json + "asdasdasdasd");
      });
  }
  render() {
    var { isLoaded, items } = this.state;

    if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div className="App">
          <ul>
            {this.state.items.map((item) => (
              <li key={item.id}>{item.description}</li>
            ))}
            ;
          </ul>
        </div>
      );
    }
  }
}

export default Read;
