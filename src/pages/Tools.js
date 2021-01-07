import React, { useState } from 'react';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import {
  Button,
  TextControl,
  Card,
  CardBody,
  CardHeader,
} from '@wordpress/components';
import { toast } from 'react-toastify';
import Status from '../components/Status';

function Tools() {
  const [isSending, setIsSending] = useState(false);
  const [phoneNumber, setPhoneNumber] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();

    setIsSending(true);

    apiFetch({
      path: '/texty/v1/tools/test',
      method: 'POST',
      data: {
        to: phoneNumber,
      },
    })
      .then((resp) => {
        setIsSending(false);

        if (resp.success) {
          toast.success(__('Message has been sent.', 'texty'));
        } else {
          toast.error(
            __('Error, message could not be sent.', 'texty') +
              ' ' +
              resp.message
          );
        }
      })
      .catch((err) => {
        setIsSending(false);
        console.log(err);
        // toast.error(err.message);
      });
  };

  return (
    <div className="textly-tools">
      <h1>{__('Tools', 'texty')}</h1>

      <Status />

      <Card className="mt-4">
        <CardHeader>{__('Test Message', 'texty')}</CardHeader>
        <CardBody>
          <form onSubmit={handleSubmit} className="textly-settings__form">
            <fieldset disabled={isSending}>
              <TextControl
                label={__('Test Number', 'texty')}
                type="tel"
                value={phoneNumber}
                onChange={(value) => setPhoneNumber(value)}
                help={__(
                  'Enter a phone number to test the SMS sending.',
                  'texty'
                )}
                required
              />
            </fieldset>

            <Button type="submit" isPrimary={true} isBusy={isSending}>
              {isSending ? __('Sending...', 'texty') : __('Send Test', 'texty')}
            </Button>
          </form>
        </CardBody>
      </Card>
    </div>
  );
}

export default Tools;
