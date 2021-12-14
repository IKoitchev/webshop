import React, { Component } from 'react';

class FetchAPI extends Component {
    prod = [{name: "fffff", id:"" }];

    state = { 
        loading: false,
        products: [],
        timestamp: 0
    }
    async componentDidUpdate(){
        alert(this.props.name);
        let url = "/products/all";

        if(this.props.name){
            url = "/products/get?name=" + this.props.name;
            
        }

        const response = await fetch(url);
        this.prod = await response.json();
        //this.setState({products: data, loading: false, timestamp: this.props.timestamp});
        console.log(this.state);

        this.render();
    }
    async componentDidMount(){
       /* alert("mounted");
        let url = "/products/all";

        if(this.props.name){
            url = "/products/get?name=" + this.props.name;
            
        }

        const response = await fetch(url);
        const data = await response.json();
        this.setState({products: data, loading: false, timestamp: this.props.timestamp});
        console.log(this.state);*/
       
        
    }

    render() { 
        
        return (
            
        <div>
            {this.state.loading ?
                <div>loading product info...</div> :
            
                <div>
                    <br/>
                    {this.prod[0].name
                        
                    }
                    
                    
                </div>}
        </div>
        );
        
    }
}
 
export default FetchAPI;