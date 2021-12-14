import React, { Component } from 'react'
import './Product.css';

import Axios from 'axios';
import {Link, Redirect }from "react-router-dom";

class Product extends Component{
    
    state = { 
        id: this.props.product.id,
        name: this.props.product.name,
        description: this.props.product.description,
        genre: this.props.product.genre,
        price: this.props.product.price,
        url: this.props.product.url,
        author: this.props.product.author
    }
    
    
    render(){
        
        return(
            this.state.id ?  
            <div className="product-container">

                <img src={"http://localhost:8080" + this.props.product.url}/>
                Name: {this.props.product.name}<br/>
                Genre: {this.props.product.genre}<br/>
                Price: {this.props.product.price} €<br/> 
                

                <Link to={{
                    pathname: "/details",
                    state:{... this.props.product}
                }}>
                    <button className="btn btn-dark">Product details</button>
                </Link>
                
            </div>
            :
            <div className='error-container'>Product not found</div>

        );
    }

}

export default Product;