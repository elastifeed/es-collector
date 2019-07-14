import React from 'react';
import axios from 'axios';

import Request from './libs/Request';
import Routes from './libs/Routes';

// Components
import Login from './components/Login';
import Page from './components/Page';
import Feed from './components/Feed';
import Success from './components/Success';
import ApiCalls from "./libs/ApiCalls";

class App extends React.Component{
    constructor(props){
        super(props);

        // @todo retrieve the token from local storage and test, if it is still valid
        this.state = {
            loading: true,
            jwt: false,
            request: Request(Routes.target),
            success: false
        };
        this.loginUser = this.loginUser.bind(this);
        this.handleSuccess = this.handleSuccess.bind(this);
    }

    componentDidMount(){
        this.initializeComponent();
    }

    initializeComponent(){
        const token = localStorage.getItem('jwt');
        if (token === null || token === 'null') {
            this.setState({
                loading: false
            });
            return;
        }
        ApiCalls.profile(token)
            .then(res => {
                this.setState({
                    jwt: token,
                    loading: false
                });
            })
            .catch(e => {
                localStorage.setItem('jwt', null);
                this.setState({
                    loading: false
                });
            });
    }

    /**
     * Handles the push success
     */
    handleSuccess(){
        this.setState({success: true});
    }

    /**
     * Handles the Login callback passed to the login component
     * and updates the jwt token
     * @param token jwt auth token
     */
    loginUser(token){
        localStorage.setItem('jwt', token);
        this.setState({jwt: token});
        this.initializeComponent();
    }

    /**
     * Routes the application to the appropriate component
     */
    getEntryPoint(){

        if (this.state.loading) {
            return <div>Loading</div>;
        }

        if (!this.state.jwt) {
            return <Login callback={this.loginUser}/>;
        }

        if (this.state.success) {
            return <Success url={this.state.request.url}/>
        }

        const request = this.state.request;
        if (request.type === 'page') {
            return <Page data={request.data} url={request.url} token={this.state.jwt} success={this.handleSuccess}/>
        }
        return <Feed data={request.data} url={request.url} token={this.state.jwt} success={this.handleSuccess}/>
    }

    /**
     * Renders the main application component
     */
    render(){
        return (
            <div className="wrapper">
                <div className="wrapper__content">
                    {this.getEntryPoint()}
                </div>
            </div>
        );
    }
}

export default App;
