import React, {Fragment} from 'react';
import ApiCalls from "../libs/ApiCalls";


/**
 * Feed-Store-UI for the ES client-pusher
 */
class Feed extends React.Component{

    constructor(props){
        super(props);
        this.state = {
            url: props.url,
            data: props.data,
            posts: [],
            error: false,
            token: props.token,
            success: props.success
        };

        this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount(){
        this.state.data.then(data => {
            this.setState({
                posts: data.posts,
                error: data.error
            })
        });
    }

    renderFeed(){
        return this.state.posts.map((post, i) => {
            const title = post.title;
            let description = post.description;
            if (description.length > 100) {
                description = description.substr(0, 100) + '...';
            }
            return (
                <div className="feed__item" key={i}>
                    <h2 className="h6">{title}</h2>
                    <p>{description}</p>
                </div>
            );
        });
    }

    handleSubmit(){
        ApiCalls.pushFeed(this.state.token, this.state.url)
            .then(res => {
                this.state.success(this.state.url)
            })
            .catch(console.log);
    }

    /**
     * Renders the Component
     */
    render(){
        return (
            <Fragment>
                <div className="flex align-center">
                    <div className="flex__item / small-6 large-3">
                        <h1 className="h2">
                            RSS-Feed speichern </h1>
                        <p>
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. </p>
                        <button className="button prim" onClick={this.handleSubmit}>Feed jetzt abonnieren!</button>
                    </div>
                    <div className="flex__item / small-6 large-3">
                        <div className="feed">
                            <div className="feed__content">
                                {this.renderFeed()}
                            </div>
                            {/*<button className="button small">mehr Artikel zeigen</button>*/}
                        </div>
                    </div>
                </div>
            </Fragment>
        );
    }
}

export default Feed;