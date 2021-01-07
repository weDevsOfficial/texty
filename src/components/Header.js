import React from 'react';
import { __ } from '@wordpress/i18n';

function Header() {
  return (
    <div className="textly-admin-header">
      {/* <div className="textly-admin-header__logo"></div> */}

      <div className="textly-admin-header__menu">
        {/* <a href="#/" className="header-link" title={__('Home', 'texty')}>
          <span className="dashicons dashicons-admin-home"></span>
          <span className="title">{__('Home', 'texty')}</span>
        </a> */}

        <a href="#/tools" className="header-link" title={__('Tools', 'texty')}>
          <span className="dashicons dashicons-admin-tools"></span>
          <span className="title">{__('Tools', 'texty')}</span>
        </a>

        <a
          href="#/settings"
          className="header-link"
          title={__('Settings', 'texty')}
        >
          <span className="dashicons dashicons-admin-settings"></span>
          <span className="title">{__('Settings', 'texty')}</span>
        </a>
      </div>
    </div>
  );
}

export default Header;
