'use strict'
import React, {useState, useEffect} from 'react'
import {createRoot} from 'react-dom/client';

const WelcomeHeader = () => {
  return (
    <div>
      <h1>The module is loaded and working through React!</h1>
    </div>
  )
}

const container = document.getElementById('WelcomeHeader') as HTMLElement
const root = createRoot(container)
root.render(<WelcomeHeader />)
