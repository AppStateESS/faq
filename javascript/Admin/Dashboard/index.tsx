'use strict'
import React, {useState, useEffect} from 'react'
import {createRoot} from 'react-dom/client';
import axios from 'axios';

const Dashboard = () => {
  axios.post('./faq/Admin/Dashboard', {
    question: 'Fred?',
    answer: 'Flintstone'
  })
  .then(function (response) {
    console.log(response);
  })
  .catch(function (error) {
    console.log(error);
  });

  return (
      <h1>Hello!</h1>
    );
}

const App = () => {
  return(
    <div>
      <Dashboard />
    </div>
  );
};

const container = document.getElementById('Dashboard') as HTMLElement
const root = createRoot(container)
root.render(<App />)
