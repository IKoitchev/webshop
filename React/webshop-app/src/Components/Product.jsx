import React, { Component } from 'react'

class Product extends Component{
    
    componentDidMount() {
        console.log("this.state")
    }
    state = {
       id: this.props.product.id,
       name: this.props.product.name,
       description: this.props.product.description,
       info: this.props.product.info,
       price: this.props.product.price,
       url: this.props.product.url
            
    }
    render(){
        console.log("this.state")
        return(
            <ul>
                {console.log("this.state2")}
                <li>id: {this.state.id}</li>
                <li>name: {this.state.name}</li>
                <li>description: {this.state.description}</li>
                <li>genre: {this.state.info}</li>
                <li>price: {this.state.price}</li>
                <li><img src={"http://localhost:8080" + this.state.url}/></li>
            </ul> 

        );
    }

}

export default Product;