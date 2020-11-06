import React, { Component } from 'react';

class FetchAPI extends Component {

    state = { 
        loading: true,
        product: null,
    }
    
    async componentDidMount(){
        const url = "/products/get?name=" + this.props.name;
        const response = await fetch(url);
        console.log(response);
        const data = await response.json();
        //console.log(data)
        this.setState({product: data, loading: false});
        console.log(data);
        
    }

    render() { 
        return (
        <div>
            {this.state.loading ?
                <div>loading product info...</div> :
            
                <div>
                    <br/>
                    {this.state.product.id}.&nbsp;
                    {this.state.product.name}: <br/>
                    Genre: {this.state.product.description}<br/>
                    Price: {this.state.product.price}<br/>
                    
                </div>}
        </div>
        );
    }
}
 
export default FetchAPI;