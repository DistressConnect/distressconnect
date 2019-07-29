import {
  LOGIN_LOADING,
  USER_SEARCH,
  SAVE_DATA,
  MESSAGE_CONTENT,
  MSG_LOADING,
  LAT_LNG
} from "../config/Config";
import ApiAccess from "../apiAccess/ApiAccess";
import { Alert } from "react-native";
import {
  saveData,
  getSavedData
} from "../business/common/AsyncStorage/AsyncStorageDB";
import { Actions } from "react-native-router-flux";
import { _ } from "lodash";
export const onClickLogin = (uid, password) => {
  return async dispatch => {
    dispatch({ type: LOGIN_LOADING, payload: true });
    try {
      let params = new FormData();
      params.append("username", uid);
      params.append("password", password);
      debugger;
      let resp = await ApiAccess.post("user/login", params);
      debugger;
      if (resp.status == 1) {
        await saveData(USER_SEARCH, resp);
        Actions.TrainingTrackingForm();
      } else {
        Alert.alert("Sorry", "User name or Password is Incorrect ");
      }
      dispatch({ type: LOGIN_LOADING, payload: false });

      debugger;
    } catch (e) {
      debugger;
      dispatch({ type: LOGIN_LOADING, payload: false });
      let data = {
        uid: uid
      };
      await saveData(USER_SEARCH, data);
      // alert("login sucess");

      getMessageFromSrvr();
      Actions.MapViewComponent();
      // Alert.alert("Sorry", "User name or Password is Incorrect ");
    }
  };
};

export const getMessageFromSrvr = () => {
  return async dispatch => {
    try {
      debugger;
      dispatch({ type: MSG_LOADING, payload: true });
      // alert("In try");

      let resp = await ApiAccess.get("site/get/?op=GET_WHEATHER_DATA_FOR_MAPP");
      // alert("In try");
      // let finalList = _.chain(resp.msg)
      //   .groupBy("message_type")
      //   .toPairs()
      //   .map(function(currentItem) {
      //     return _.fromPairs(_.zip(["message_type", "msg"], currentItem));
      //   })
      //   .value();
      dispatch({ type: MESSAGE_CONTENT, payload: resp });

      dispatch({ type: MSG_LOADING, payload: false });

      debugger;
      // dispatch({ type: SAVE_DATA, payload: data });
    } catch (e) {
      dispatch({ type: MSG_LOADING, payload: false });
      await saveData(USER_SEARCH, []);
      //alert("In catch");

      // Actions.LoginComponent();
      debugger;
    }
  };
};

export const getLatLng = () => {
  return async dispatch => {
    try {
      debugger;
      dispatch({ type: MSG_LOADING, payload: true });
      getMessageFromSrvr();
      // alert("In try");

      let resp = await ApiAccess.get("site/get/?op=GET_MAP_NODE_POINTS_DATA");
      // alert("In try");
      let markerList = [];
      if (resp.status == 1) {
        debugger;
        for (let i = 0; i < resp.data.length; i++) {
          debugger;
          let markerObj = {
            marker: {
              latitude: parseFloat(resp.data[i].latitude),
              longitude: parseFloat(resp.data[i].longitude)
            },
            fullname: resp.data[i].fullname
          };
          markerList.push(markerObj);
        }
        dispatch({ type: LAT_LNG, payload: markerList });
      }

      dispatch({ type: MSG_LOADING, payload: false });

      debugger;
      // dispatch({ type: SAVE_DATA, payload: data });
    } catch (e) {
      dispatch({ type: MSG_LOADING, payload: false });
      await saveData(USER_SEARCH, []);
      //alert("In catch");

      // Actions.LoginComponent();
      debugger;
    }
  };
};
