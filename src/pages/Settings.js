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
      path: '/texty/v1/settings?context=edit',
    }).then((resp) => {
      setSettings(resp);
      setIsLoading(false);
    });
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
        [name]: {
          ...settings[provider][name],
          ['value']: value,
        },
      },
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    let data = {
      gateway: settings.gateway,
    };

    Object.keys(settings.gateways).forEach((gateway) => {
      Object.keys(settings[gateway]).forEach((field) => {
        if (!data.hasOwnProperty(gateway)) {
          data[gateway] = {};
        }

        data[gateway][field] = settings[gateway][field]['value'];
      });
    });

    setIsSaving(true);

    apiFetch({
      path: '/texty/v1/settings',
      method: 'POST',
      data: data,
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

  const gateways = Object.keys(settings.gateways);

  return (
    <div className="textly-settings">
      <h1>{__('Settings', 'texty')}</h1>

      <form onSubmit={handleSubmit} className="textly-settings__form">
        <div className="texty-card">
          <div className="texty-card__header">{__('SMS Gateway', 'texty')}</div>
          <div className="texty-card__body">
            <fieldset disabled={isSaving}>
              <div className="settings-row">
                <div className="settings-row__label">
                  <label>{__('Gateways', 'texty')}</label>
                </div>
                <div className="settings-row__field">
                  <div className="settings-row__gateways">
                    {gateways.map((key) => {
                      const { name, logo } = settings.gateways[key];

                      return (
                        <div
                          className={classNames('gateway-card', {
                            active: key === settings.gateway,
                          })}
                          key={'gateway-' + key}
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

              {gateways.map((key) => {
                const { name, description } = settings.gateways[key];

                return (
                  settings.gateway === key && (
                    <div
                      className={'settings-row settings-' + key}
                      key={'settings-' + key}
                    >
                      <h3>{name}</h3>

                      <p>
                        {
                          <span
                            className="help"
                            dangerouslySetInnerHTML={{
                              __html: description,
                            }}
                          ></span>
                        }
                      </p>

                      {Object.keys(settings[key]).map((item) => {
                        const { name, type, value, help } = settings[key][item];

                        return (
                          <TextControl
                            key={'field' + item}
                            label={name}
                            value={value}
                            type={type}
                            help={help}
                            onChange={(value) =>
                              setCredential(key, item, value)
                            }
                          />
                        );
                      })}
                    </div>
                  )
                );
              })}

              {/* {settings.gateway === 'twilio' && (
                <Twilio settings={settings.twilio} setOption={setCredential} />
              )}

              {settings.gateway === 'vonage' && (
                <Vonage settings={settings.vonage} setOption={setCredential} />
              )} */}
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
