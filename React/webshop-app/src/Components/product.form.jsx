import React, { Component } from 'react';
import Navbar from './Navbar';
import '../App.css';
import axios from 'axios';
import AuthService from '../services/auth.service';

class ProductForm extends Component {
    state = { 
        added: false,
        productNameError:"",
        descriptionError:"",
        genreError:"",
        priceError:"",
        pictureError:"",
        picture: null,
        product: "" 

    }
    handleFileSelected = event => {
        this.setState({
            picture: event.target.files[0]
        });
    }
    validateProduct = () => {
        let productNameError = "";
        let descriptionError = "";
        let genreError = "";
        let priceError = "";
        let emptyError = "this field is required";
        let pictureError = "";
        const regex = /^\d+(\.\d{1,2})?$/;

        
        if(!document.getElementById("product-name").value){
            productNameError = emptyError;  
        }
        if(!document.getElementById("description").value){
            descriptionError = emptyError;
        }
        if(!document.getElementById("genre").value){
            genreError = emptyError;
        }
        if(!document.getElementById("price").value){
            priceError = emptyError; 
        } else if (!document.getElementById("price").value.match(regex)){
            priceError = "invalid number"
        }
        if(!this.state.picture){
            pictureError = "picture upload is required";
        }
        if(productNameError || descriptionError || genreError || priceError || pictureError)
        {
            this.setState({
                productNameError: productNameError,
                descriptionError: descriptionError,
                genreError: genreError,
                priceError: priceError,
                pictureError: pictureError
            })
            return false;
        }
        return true;
        
    }
    handlePublish = event => {
        event.preventDefault();
        const isValid = this.validateProduct();

        if(isValid) {
           // console.log(this.state);

            let product = {
                name: document.getElementById("product-name").value,
                description: document.getElementById("description").value,
                genre: document.getElementById("genre").value,
                price: document.getElementById("price").value,
                author: AuthService.getCurrentUser().usesrname,
                url: "/images/" + this.state.picture.name
            };
            const fd = new FormData();
            fd.append('file', this.state.picture, this.state.picture.name);
            axios.post("http://localhost:8080/images/upload", fd).then(res => console.log(res));
            axios.post('http://localhost:8080/products/post', product).then(res => {console.log(res)});
            this.setState({
                productNameError: "",
                descriptionError: "",
                genreError: "",
                priceError: "",
                pictureError: ""
            })

        }
    }
    render() { 
        return (  
            this.state.added ? <div>Product added!</div> : 
                <>
                    <Navbar/>
                    
                    <div className="product-form-container">
                        <label className="product-form-title">Product details</label><br/>
                        <label>product name:</label><br/>
                        <input type="text" id="product-name" /><br/>
                        <div className="error-message" >{this.state.productNameError}</div>

                        <label>description:</label><br/>
                        <input type="text" id="description"/><br/>
                        <div className="error-message">{this.state.descriptionError}</div>

                        <label>genre:</label><br/>
                        <input type="text" id="genre"/><br/>
                        <div className="error-message">{this.state.genreError}</div>

                        <label>price:</label><br/>
                        <input type="text" id="price"/><br/>
                        <div className="error-message">{this.state.priceError}</div>

                        <label>picture:</label><br/>
                        <input type="file" accept="image/*" id="picture" onChange={this.handleFileSelected}/><br/>
                        <div className="error-message">{this.state.pictureError}</div>

                        <input type="button" value="Publish product" onClick={this.handlePublish}/>
                    </div>
                </>
            
        );
    }
}
 
export default ProductForm;