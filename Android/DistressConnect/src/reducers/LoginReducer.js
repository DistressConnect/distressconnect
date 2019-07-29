import {
  LOGIN_LOADING,
  SAVE_DATA,
  MESSAGE_CONTENT,
  MSG_LOADING,
  LAT_LNG
} from "../config/Config";

const INITIAL_STATE = {
  loginLoading: false,
  savedData: {},
  msgs: {},
  msgLoading: false,latlng:[]
};

export default (state = INITIAL_STATE, action) => {
  switch (action.type) {
    case LOGIN_LOADING:
      return { ...state, loginLoading: action.payload };
    case SAVE_DATA:
      return { ...state, savedData: action.payload };
    case MESSAGE_CONTENT:
      return { ...state, msgs: action.payload };
    case MSG_LOADING:
      return { ...state, msgLoading: action.payload };
    case LAT_LNG:
      return { ...state, latlng: action.payload };

    default:
      return state;
  }
};
