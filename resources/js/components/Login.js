import React, {Fragment} from 'react';
;
import ApiCalls from "../libs/ApiCalls";

/**
 * Login form
 */
class Login extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            callback: props.callback,
            email: '',
            password: '',
            errors: false
        };
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    /**
     * Update the local form state
     * @param field field to update
     * @param e event triggered on the change
     */
    handleChange(field, e){
        this.setState({
            [field]: e.target.value
        });
    }

    /**
     * Handles the form submit button
     */
    handleSubmit(){
        ApiCalls.login(this.state.email, this.state.password)
            .then(res => {
                this.state.callback(res.data.token);
            }).catch((e) => {
                this.setState({
                    'errors': e.response.data.messages
                });
            });
    }

    /**
     * Renders the login error-message if there is one
     */
    renderErrors(){
        const errors = this.state.errors;
        if (errors) {
            return (
                <div className={"login-form__errors"}>
                    {errors}
                </div>
            );
        }
    }

    /**
     * Renders the component
     */
    render(){
        return (
            <Fragment>
                <div className="login-form">
                    {this.renderErrors()}
                    <div className="field">
                        <label htmlFor="email">E-Mail</label>
                        <input type="email" id="email" onChange={(e) => this.handleChange('email', e)}/>
                    </div>
                    <div className="field">
                        <label htmlFor="password">E-Mail</label>
                        <input type="password" id="password" onChange={(e) => this.handleChange('password', e)}/>
                    </div>
                    <button className="button prim" onClick={this.handleSubmit}>Jetzt einloggen</button>
                </div>
            </Fragment>
        );
    }
}

export default Login;