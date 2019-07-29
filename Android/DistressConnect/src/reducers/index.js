import { combineReducers } from 'redux';
import DemoReducer from './DemoReducer';
import LoginReducer from './LoginReducer';
import TTFormReducer from './TTFormReducer';

export default combineReducers({
    //  coool: () =>[]
    auth: DemoReducer,
    formtt: TTFormReducer,
    login: LoginReducer

});