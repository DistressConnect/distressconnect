import {
    EMAIL_CHANGE, FETCHING_DATA, GETTING_JSON_RESPONSE, GETTING_MONITORED_STOP_VISIT_RESPONSE, ORIGIN_REF,
    PASSWORD_CHANGE
} from "../config/Config";

const INITIAL_STATE = {loading: false,email: 'fo1@forants.com', password: 'tarina@1a', resp: {},monitordData:[],originList:[]};

export default (state = INITIAL_STATE, action) => {

    switch (action.type) {

        case EMAIL_CHANGE:
            return {...state, email: action.payload};

        case PASSWORD_CHANGE:
            return {...state, password: action.payload};

        case GETTING_JSON_RESPONSE:
            return {...state, resp: action.payload};
        case  GETTING_MONITORED_STOP_VISIT_RESPONSE:
            return {...state, monitordData: action.payload, loading: false};
        case FETCHING_DATA:
            return {...state, loading:true };
        case ORIGIN_REF:
            return {...state, originList: action.payload, loading: false}

        default:
            return state;
    }
}