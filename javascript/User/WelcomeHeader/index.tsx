'use strict'
import React, {useState, useEffect} from 'react'
import {createRoot} from 'react-dom/client';
import axios from 'axios';

const WelcomeHeader = ({ props }) => {
  return (
    <div className="card">
                    <div className="card-header" id={"heading-" + props.id}>
                        <h2 className="mb-0">
                            <button className="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target={"#collapse-" + props.id} aria-expanded="false" aria-controls={"collapse-" + props.id}>
                                {props.question}
                            </button>
                        </h2>
                    </div>
                    
                    <div id={"collapse-" + props.id} className="collapse" aria-labelledby={"heading-" + props.id} data-toggle={"#collapse-" + props.id}>
                        <div className="card-body">
                            {props.answer}
                        </div>
                    </div>
                </div>
  );
}

const App = () => {
  return(
    <div>
        <WelcomeHeader props={{question: "What color is the sky?", answer: "Red", id: "0"}}/>
        <WelcomeHeader props={{question: "Who is the lead singer of Aerosmith?", answer:"Steven Tyler", id: "1"}}/>
        <div>
        </div>
    </div>
  );
};

axios.get('./faq/User/FAQTableController').then(res => { console.log(res.data) });

const container = document.getElementById('WelcomeHeader') as HTMLElement
const root = createRoot(container)
root.render(<App />)
