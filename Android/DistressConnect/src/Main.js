import React, {Component} from 'react';
import ReduxThunk from 'redux-thunk';
import {Provider} from 'react-redux';
import {createStore, applyMiddleware} from 'redux';
import reducers from './reducers';

import Router from './Router';

class Main extends Component {

    render() {
        const store = createStore(reducers, {}, applyMiddleware(ReduxThunk));
        return (
            <Provider store={store}>
                <Router/>
                {/*<View>
                    <Header headerText="Login"/>
                    <LoginPage />
                </View>*/}
            </Provider>
        );
    }
}

export default Main;