'use strict'
import React, {useState, useEffect} from 'react'
import {createRoot} from 'react-dom/client';
import axios from 'axios';

const headers = {'X-Requested-With': 'XMLHttpRequest'}

const Dashboard = () => {
  let question : string = 'What is 2 + 2?';
  let answer : string = '4';

  axios.post('./faq/Admin/Dashboard', {
    question,
    answer
  },
  {headers})
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
