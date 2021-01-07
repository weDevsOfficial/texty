import React from 'react';
import { __, sprintf } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';

function Vonage({ settings, setOption }) {
  return (
    <div className="settings-vonage settings-row">
      <h3>{__('Vonage', 'texty')}</h3>

      <p>
        {
          <span
            className="help"
            dangerouslySetInnerHTML={{
              __html: sprintf(
                __(
                  'Send SMS with Vonage (formerly Nexmo). Follow <a href="%s" target="_blank">this link</a> to get the API Key and Secret from Vonage.',
                  'texty'
                ),
                'https://dashboard.nexmo.com/settings'
              ),
            }}
          ></span>
        }
      </p>

      <TextControl
        label={__('API Key', 'texty')}
        value={settings.key}
        onChange={(value) => setOption('vonage', 'key', value)}
        required
      />

      <TextControl
        label={__('API Secret', 'texty')}
        value={settings.secret}
        type="password"
        required
        onChange={(value) => setOption('vonage', 'secret', value)}
      />
    </div>
  );
}

export default Vonage;
