import React, { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import classNames from 'classnames';
import apiFetch from '@wordpress/api-fetch';
import {
  Button,
  Card,
  CardBody,
  CardHeader,
  Panel,
  Spinner,
} from '@wordpress/components';
import NotificationItem from '../components/NotificationItem';

function Notifications() {
  const [isLoading, setIsLoading] = useState(true);
  const [isSaving, setIsSaving] = useState(false);
  const [settings, setSettings] = useState({});

  useEffect(() => {
    setIsLoading(true);

    apiFetch({
      path: '/texty/v1/notifications?context=edit',
    }).then((resp) => {
      setSettings(resp);
      setIsLoading(false);
    });
  }, []);

  const setOption = (name, option, value) => {
    setSettings({
      ...settings,
      ['notifications']: {
        ...settings['notifications'],
        [name]: {
          ...settings['notifications'][name],
          [option]: value,
        },
      },
    });
  };

  if (isLoading) {
    return <Spinner />;
  }

  return (
    <div>
      <h1>{__('Notifications', 'texty')}</h1>
      <p>
        {__(
          'Enable or disable notification based on different events.',
          'texty'
        )}
      </p>

      <form>
        {Object.keys(settings.groups).map((group) => (
          <Card key={group}>
            <CardHeader>{settings.groups[group].title}</CardHeader>
            <CardBody className="has-panel">
              <Panel>
                {Object.keys(settings.notifications).map((notify) => {
                  const notification = settings.notifications[notify];

                  return (
                    group === notification.group && (
                      <NotificationItem
                        key={notify}
                        title={notification.title}
                        keyName={notification.id}
                        settings={notification}
                        setOption={setOption}
                      />
                    )
                  );
                })}
              </Panel>
            </CardBody>
          </Card>
        ))}

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

export default Notifications;
