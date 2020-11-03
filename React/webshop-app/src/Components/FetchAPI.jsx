import React, { Component } from 'react';

class FetchAPI extends Component {

    state = { 
        loading: true,
        product: null,
    }
    
    async componentDidMount(){
        const url = "/products?name=" + this.props.name;
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
                <div>loading...</div> :
                <div>
                    {
                    
                    this.state.product.map((product, index) =>{
                        return <h2>{product.name, product.id}</h2>
                    })}
                </div>}
        </div>
        );
    }
}
 
export default FetchAPI;