import React from 'react';
import * as ReactDOM from "react-dom";

require('../../css/components/header.css');


function Header() {
    return (
      <div className="name">
          Header
      </div>
    );
}

ReactDOM.render(<Header />, document.querySelector('#header'));