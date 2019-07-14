import React from 'react';


function Iframe(props){
    if (!props.url) {
        return null;
    }
    return (
        <iframe className="page-preview" src={props.url} frameBorder="0"/>
    );
}

export default Iframe;