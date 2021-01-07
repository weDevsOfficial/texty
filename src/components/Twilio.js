import React from 'react';
import { __, sprintf } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';

function Twilio({ settings, setOption }) {
  return (
    <div className="settings-twilio settings-row">
      <h3>{__('Twilio', 'texty')}</h3>

      <p>
        {
          <span
            className="help"
            dangerouslySetInnerHTML={{
              __html: sprintf(
                __(
                  'Send SMS with Twilio. Follow <a href="%s" target="_blank">this link</a> to get the Account SID and Token from Twilio.',
                  'texty'
                ),
                'https://www.twilio.com/console/project/settings'
              ),
            }}
          ></span>
        }
      </p>

      <TextControl
        label={__('Account SID', 'texty')}
        value={settings.sid}
        onChange={(value) => setOption('twilio', 'sid', value)}
        required
      />

      <TextControl
        label={__('Auth Token', 'texty')}
        value={settings.token}
        type="password"
        required
        onChange={(value) => setOption('twilio', 'token', value)}
      />
    </div>
  );
}

export default Twilio;
