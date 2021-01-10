/**
 * External dependencies
 */
import React, { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import { Button, Spinner, TextControl } from '@wordpress/components';
import classNames from 'classnames';
import { toast } from 'react-toastify';

/**
 * Internal dependencies
 */
import ActiveIcon from '../components/ActiveIcon';
import Twilio from '../components/Twilio';
import Vonage from '../components/Vonage';

function Settings() {
  const [isLoading, setIsLoading] = useState(true);
  const [isSaving, setIsSaving] = useState(false);
  const [settings, setSettings] = useState({
    gateway: 'twilio',
    from: '',
    twilio: {
      sid: '',
      token: '',
    },
    vonage: {
      key: '',
      secret: '',
    },
  });

  useEffect(() => {
    setIsLoading(true);

    apiFetch({
      path: '/texty/v1/settings',
    }).then((resp) => {
      setSettings(resp);
      setIsLoading(false);
    });
    return () => {};
  }, []);

  const setOption = (option, value) => {
    setSettings({
      ...settings,
      [option]: value,
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

    apiFetch({
      path: '/texty/v1/settings',
      method: 'POST',
      data: settings,
    })
      .then((resp) => {
        setIsSaving(false);

        toast.success(__('Changes have been saved', 'texty'));
      })
      .catch((err) => {
        setIsSaving(false);
        console.log(err);
        toast.error(err.message);
      });
  };

  if (isLoading) {
    return <Spinner />;
  }

  return (
    <div className="textly-settings">
      <h1>{__('Settings', 'texty')}</h1>

      <form onSubmit={handleSubmit} className="textly-settings__form">
        <div className="texty-card">
          <div className="texty-card__body">
            <fieldset disabled={isSaving}>
              <div className="settings-row">
                <TextControl
                  label={__('From Number', 'texty')}
                  value={settings.from}
                  type="tel"
                  onChange={(value) => setOption('from', value)}
                  help={__(
                    'The phone number all messages will go from. Make sure your gateway accepts the format.',
                    'texty'
                  )}
                  required
                />
              </div>

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
                          onClick={() => setOption('gateway', key)}
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

              {settings.gateway === 'vonage' && (
                <Vonage settings={settings.vonage} setOption={setCredential} />
              )}
            </fieldset>
          </div>
        </div>

        <div className="submit-area">
          <Button
            type="submit"
            isPrimary={true}
            isBusy={isSaving}
            className="large"
          >
            {isSaving ? __('Saving...', 'texty') : __('Save Changes', 'texty')}
          </Button>
        </div>
      </form>
    </div>
  );
}

export default Settings;
