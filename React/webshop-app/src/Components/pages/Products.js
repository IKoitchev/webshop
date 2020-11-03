import { render } from '@testing-library/react';
import React from 'react';
import '../../App.css';

import FetchAPI from '../FetchAPI';

export default function Products() {

  function handleSearch (searched) {
    
    render(
      <div>
        <FetchAPI name={searched}/>
        
      </div>
      
    );
  }
  return (
    <>
      <h1 className='products'>PRODUCTS</h1>

      <input type="text" className="search" placeholder="Search.." id="searchbox"/>
      <input type="button" value="search" onClick={() => handleSearch(document.getElementById("searchbox").value)}/>

     
      

      
    </>
      
  );
}
