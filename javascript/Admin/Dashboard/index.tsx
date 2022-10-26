'use strict'
import React, {useState, useEffect} from 'react'
import {createRoot} from 'react-dom/client';
import axios from 'axios';

const Dashboard = () => {
  return (
    <div>This is the dashboard</div>
  );
}

const App = () => {
  return(
    <Dashboard />
  );
};

const container = document.getElementById('Dashboard') as HTMLElement
const root = createRoot(container)
root.render(<App />)
