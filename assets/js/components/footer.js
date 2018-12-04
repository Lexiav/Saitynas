import React from 'react';
import * as ReactDOM from "react-dom";

require('../../css/components/footer.css');

function Header() {
    return (
        <div className="name">
            Footer
        </div>
    );
}
ReactDOM.render(<Header />, document.querySelector('#footer'));