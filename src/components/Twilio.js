import React from 'react';
import { __, sprintf } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';

function Twilio({ settings, setOption }) {
  return (
    <div className="settings-twilio">
      <h3>{__('Twilio', 'texty')}</h3>

      <TextControl
        label={__('Account SID', 'texty')}
        value={settings.sid}
        onChange={(value) => setOption('twilio', 'sid', value)}
        required
        // help={
        //   <span
        //     dangerouslySetInnerHTML={{
        //       __html: sprintf(
        //         __(
        //           'Follow <a href="%s" target="_blank">this link</a> to get the Account SID from Twilio.',
        //           'texty'
        //         ),
        //         'https://www.twilio.com/console/project/settings'
        //       ),
        //     }}
        //   ></span>
        // }
      />

      <TextControl
        label={__('Auth Token', 'texty')}
        value={settings.token}
        required
        onChange={(value) => setOption('twilio', 'token', value)}
      />
    </div>
  );
}

export default Twilio;
