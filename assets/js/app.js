// assets/js/app.js
// ...
import React, {Component} from 'react';
export default class App extends Component {
    componentDidMount() {
        console.log('I was triggered during componentDidMount');
    }

    render() {
        console.log('I was triggered during render');
        return (
            <div> I am the App component </div>
        )
    }
}
// var $ = require('jquery');

require('../css/app.css');

// ... the rest of your JavaScript...