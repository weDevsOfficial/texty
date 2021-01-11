import 'react-hot-loader/patch';
import React from 'react';
import ReactDOM from 'react-dom';
import menuFix from './utils/admin-menu-fix';

import App from './App';

import 'react-toastify/dist/ReactToastify.css';
import 'react-phone-input-2/lib/style.css';
import './style.scss';

var mountNode = document.getElementById('texty-app');
ReactDOM.render(<App />, mountNode);

menuFix('texty');
