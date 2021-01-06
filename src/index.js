import React from 'react';
import ReactDOM from 'react-dom';
import menuFix from './utils/admin-menu-fix';

import App from './App';
import './style.scss';

var mountNode = document.getElementById('textly-app');
ReactDOM.render(<App />, mountNode);

menuFix('texty');
