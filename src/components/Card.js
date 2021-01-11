import React from 'react';

function Card({ heading, children }) {
  return (
    <div className="texty-card">
      {heading && <div className="texty-card__header">{heading}</div>}

      <div className="texty-card__body">{children}</div>
    </div>
  );
}

export default Card;
