'use strict'
import React, {useState, useEffect} from 'react'
import {createRoot} from 'react-dom/client';
import axios from 'axios';

const WelcomeHeader = ({ props }) => {
  if (props.length > 0) {
    console.log(props);
    return (
      props.map((data, index) => {
        return (
          <div className="card">
            <div className="card-header" id={"heading-" + index}>
              <h2 className="mb-0">
                  <button className="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target={"#collapse-" + index} aria-expanded="false" aria-controls={"collapse-" + index}>
                      {data.question}
                  </button>
              </h2>
            </div>
          
            <div id={"collapse-" + index} className="collapse" aria-labelledby={"heading-" + index} data-toggle={"#collapse-" + index}>
              <div className="card-body">
                {data.answer}
              </div>
            </div>
          </div>
        )
      })
    );
  } else {
    return (<div>Still loading FAQ, please wait...</div>)
  }
}


const App = () => {
  const [jsonData, getJsonData] = useState('');

  const url = './faq/User/FAQTableController?json=true';

  useEffect(() => {
    getData();
  }, []);

  const getData = () => {
    axios.get(`${url}`).then(res => { 
      getJsonData(res.data);
    });
  }
  
  return(
    <div>
      <WelcomeHeader props={jsonData}/>
    </div>
  );
};

const container = document.getElementById('WelcomeHeader') as HTMLElement
const root = createRoot(container)
root.render(<App />)
