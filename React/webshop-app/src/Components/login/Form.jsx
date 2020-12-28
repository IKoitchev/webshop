import React, { useState } from 'react';
import './Form.css';
import FormLogin from './FormLogin';
import FormSignup from './FormSignup';
import FormSuccess from './FormSuccess';

const Form = (props) => {
  const [isSubmitted, setIsSubmitted] = useState(false);
  
  console.log(props);
  function submitForm() {
    setIsSubmitted(true);

  }

  return (
    <>
      <div className='form-container'>
        <span className='close-btn'>×</span>
        <div className='form-content-left'>
          <img className='form-img' src='./images/login/img-2.svg' alt='pic' />
        </div>
        {!isSubmitted ? (
          (props.location.pathname.includes("/login") ? (<FormLogin submitForm={submitForm} method="login" />) : <FormSignup submitForm={submitForm} method="signup"/> )  
        ) : (
          <FormSuccess  />
        )}
      </div>
    </>
  );
};

export default Form;