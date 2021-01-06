/**
 * External dependencies
 */
import React, { useState } from 'react';
import { __ } from '@wordpress/i18n';
import classNames from 'classnames';
import { Button, TextControl } from '@wordpress/components';
import { toast } from 'react-toastify';

/**
 * Internal dependencies
 */
import ActiveIcon from '../components/ActiveIcon';
import Twilio from '../components/Twilio';

function Settings() {
  const [isSaving, setIsSaving] = useState(false);
  const [settings, setSettings] = useState({
    gateway: 'twilio',
    twilio: {
      sid: '',
      token: '',
    },
  });

  const setGateway = (gateway) => {
    setSettings({
      ...settings,
      ['gateway']: gateway,
    });
  };

  const setCredential = (provider, name, value) => {
    setSettings({
      ...settings,
      [provider]: {
        ...settings[provider],
        [name]: value,
      },
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    setIsSaving(true);

    setTimeout(() => {
      setIsSaving(false);
      toast.success(__('Changes have been saved', 'texty'));
    }, 2000);
  };

  return (
    <div className="textly-settings">
      <h1>{__('Settings', 'texty')}</h1>

      <form onSubmit={handleSubmit}>
        <fieldset disabled={isSaving}>
          <div className="settings-row">
            <div className="settings-row__label">
              <label>{__('Gateways', 'texty')}</label>
            </div>
            <div className="settings-row__field">
              <div className="settings-row__gateways">
                {Object.keys(texty.gateways).map((key) => {
                  const { name, logo } = texty.gateways[key];

                  return (
                    <div
                      className={classNames('gateway-card', {
                        active: key === settings.gateway,
                      })}
                      key={key}
                      onClick={() => setGateway(key)}
                    >
                      <ActiveIcon />
                      <div className="gateway-card__logo">
                        <img src={logo} alt={name} />
                      </div>

                      <div className="gateway-card__heading">{name}</div>
                    </div>
                  );
                })}
              </div>
            </div>
          </div>

          {settings.gateway === 'twilio' && (
            <Twilio settings={settings.twilio} setOption={setCredential} />
          )}

          <div className="submit-area">
            <Button type="submit" isPrimary={true} isBusy={isSaving}>
              {isSaving
                ? __('Saving...', 'texty')
                : __('Save Changes', 'texty')}
            </Button>
          </div>
        </fieldset>
      </form>
    </div>
  );
}

export default Settings;
