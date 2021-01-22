import React, { Component } from 'react';
import { BrowserRouter as Router, Route, NavLink, Redirect } from 'react-router-dom'
import authService from "../../services/auth.service"

const ProtectedRoute = ({component: Component, ...rest}) =>{
    return(
        <Route
            {...rest}
            render={props =>{
                
                if(authService.getCurrentUser()){
                    return <Component {...props}/>
                }
                else {
                    return <Redirect to = {
                        {
                            pathname: "/",
                            state: {
                                from: props.location
                            }
                        }

                    }/>
                }
            }}
        />
    );
};
export default ProtectedRoute;