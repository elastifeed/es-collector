import React from 'react';


function Image(props){
    if (!props.url) {
        return null;
    }
    return (
        <picture className="page-preview">
            <img src={props.url} alt="screenshot of the captured page"/>
        </picture>
    );
}

export default Image;