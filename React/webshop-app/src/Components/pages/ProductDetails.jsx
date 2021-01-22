import React, { Component } from 'react';
import "../Product/Product.css";
import Navbar from "../Navbar";
import AuthService from '../../services/auth.service';
import Axios from 'axios';
import { Redirect } from 'react-router-dom';

class ProductDetails extends Component {
    state = { 
        product: this.props.location.state,
        productIsOwned: false,
        redirect: false,
        isBeingEdited: false,
        reviewBeingAdded: false,
        reviews:[],
        reviewsLoaded: false

    }
    handleCancelReview = () =>{
        this.setState({reviewBeingAdded: false})
    }
    handleAddReview = () => {
        this.setState({reviewBeingAdded: true})
    }
    handleSubmitReview = () => {
        const username = AuthService.getCurrentUser().username;
        const text = document.getElementById("reviewBox").value;
        let review = {author:username, productId: this.state.product.id, text: text}

        Axios.put("http://localhost:8080/reviews/update", review)
            .then((res)=> console.log(res))
            .then(this.setState({reviewBeingAdded:false}))
            
    }
    async updateComponent (){
       await Axios.get("http://localhost:8080/reviews/get?productId=" + this.state.product.id)
            .then(res => {this.setState({reviews: res.data, reviewsLoaded: true})})
    }
    handleDelete = () => {
        Axios.delete("http://localhost:8080/products/delete?id=" + this.state.product.id)
            .then(() => this.setState({redirect:true}));
    }
    handlePurchase = () => {
        console.log("purchased");
        let review = {
            author: AuthService.getCurrentUser().username,
            productId: this.state.product.id
        }
        Axios.post("http://localhost:8080/reviews/buyProduct", review).then(this.setState({productIsOwned: true}));         
            
    };
    /*productOwned = () =>{
        (Axios.get("localhost:8080/reviews/owned?productId=" + this.state.product.id + "&authorName=" + AuthService.getCurrentUser().username)
        .then(res => {this.state.setState({productIsOwned: res})}))
    }*/
    componentDidMount(){
        
        Axios.get("http://localhost:8080/reviews/owned?productId=" + this.state.product.id + "&authorName=" + AuthService.getCurrentUser().username)
            .then(res => {this.setState({productIsOwned: res.data})});
        Axios.get("http://localhost:8080/reviews/get?productId=" + this.state.product.id)
            .then(res => {this.setState({reviews: res.data, reviewsLoaded: true})})
            //.then(console.log(this.state.reviews))
        //
        // this.productOwned();
    }
    handleUpdateDescription = () => {
        this.setState({isBeingEdited: true})
    }
    handleFinishEditing = () => {
        let prod = this.state.product;
        prod.description = document.getElementById("updateBox").value;

        Axios.put("http://localhost:8080/products/update", prod)
            .then(() => this.setState({isBeingEdited: false}))
    }
    handleCancel = () =>{
        this.setState({isBeingEdited: false, reviewBeingAdded: false})
    }
    render() { 
        return (  
            <>
            {this.state.redirect ? <Redirect to="/products"/> : <></>} 
            
            <Navbar/>
            <div className="product-details-container">
                <div className="image-container">
                    <img src={"http://localhost:8080" + this.state.product.url} alt="image loading..."/> <br/>
                    <label className="product-title-label">{this.state.product.name}</label>
                </div>
                
                <br/>
                <label className="label-title">About the game </label><br/>
                <label className="label-title2">Genre:&nbsp;</label>{this.state.product.genre}

                <div>{this.state.product.description}</div>
                <label className="label-title">Creator of the game:&nbsp;</label>
                
                {this.state.product.author}
                <br/>
                <label className="label-title">Price:&nbsp;</label>{this.state.product.price} €
                <br/>
                {AuthService.getCurrentUser() ? // user is logged
                    (AuthService.getCurrentUser().username === this.state.product.author ? // user is the author 
                        (this.state.isBeingEdited ? // edit mode
                            <>
                                <label>Write new description here</label><br/>
                                <textarea type="text" className="new-description" id="updateBox"/><br/>
                                <input type="button" value="Set new description" className="btn btn-dark" onClick={this.handleFinishEditing}/>
                                <input type="button" value="Cancel"  className="btn btn-dark" onClick={this.handleCancel}/>
                            </> 
                            :     
                            <>                                              
                                <input type="button" className="btn btn-dark" value="Delete" onClick={this.handleDelete}/> 
                                <input type="button" className="btn btn-dark" value="Update" onClick={this.handleUpdateDescription}/>  
                            </>
                            
                            
                        )
                        
                        :   // user is not the author
                            (!this.state.productIsOwned ? //user doesnt own that product
                                <>  
                                    <br/>
                                    <input type="button" className="btn btn-dark" value="Buy now" onClick={this.handlePurchase}/> <br/>
                                    {AuthService.getCurrentUser().roles[0] === "ROLE_ADMIN" ? 
                                        <>
                                            <label className="label-title">As an admin you can delete this product</label><br/>
                                            <input type="button" className="btn btn-dark" value="Delete" onClick={this.handleDelete}/>
                                        </>
                                     : 
                                     <>
                                     </>}
                                </>
                                :   // user owns that product
                               (!this.state.reviewBeingAdded ?
                                    <>
                                        <label type="text" className="product-owned-label">You already own that product</label><br/>
                                        <input type="button" className="btn btn-dark" value="Add a review" onClick={this.handleAddReview}/>
                                    </>
                                    :
                                    <>
                                        <label>Write new description here</label><br/>
                                        <textarea type="text" className="new-description" id="reviewBox"/><br/>
                                        <input type="button" value="Submit review" className="btn btn-dark" onClick={this.handleSubmitReview}/>
                                        <input type="button" value="Cancel" className="btn btn-dark" onClick={this.handleCancelReview}/>
                                    </>
                               )
                                
                            )
                        
                    ) : (
                        <p>You need to login to buy this product</p> // user is not logged in
                    )
                }<br></br>
                <label className="label-title">See what other users think about this product</label><br/>
            <div>
                {this.state.reviewsLoaded ?
                <>
                    {this.state.reviews.map((r, i) =>
                        <>
                            
                            <div className="review-field" key={i}>
                                <label className="label-title">{r.author}</label><br/>
                                {r.text}
                               
                            </div>
                            <br/>
                        </>
                    )}
                </>
                :
                <></>
                }
            </div>
            </div>
            
            </> 
        );
    }
}
 
export default ProductDetails;