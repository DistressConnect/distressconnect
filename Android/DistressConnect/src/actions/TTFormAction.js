import {
  HOUSE_HOLD,
  INTENET,
  FORM_DATA,
  SET_HOUSE,
  FORM_LOADING,
  SAVE_FORM,
  USER_SEARCH
} from "../config/Config";
import { searchHouseInArray, mapDataToArray } from "../business/TTFormBusiness";
import { Alert } from "react-native";
import ApiAccess from "../apiAccess/ApiAccess";
import {
  saveData,
  getSavedData
} from "../business/common/AsyncStorage/AsyncStorageDB";
import { _ } from "lodash";
import dataJson from "../config/loginDara.json";
import { Actions } from "react-native-router-flux";
export const housldSearch = (text, arr) => {
  return async dispatch => {
    try {
      let data = searchHouseInArray(text, arr);
      debugger;
      dispatch({
        type: HOUSE_HOLD,
        payload: data
      });
    } catch (e) {}
  };
};
export const getSearchData = () => {
  return async dispatch => {
    try {
      dispatch({
        type: FORM_DATA,
        payload: []
      });
      //       debugger;
      //       await saveData(USER_SEARCH,dataJson)
      //       debugger;
      //       let savedData = await getSavedData(USER_SEARCH);//
      debugger;
      let data = await mapDataToArray();
      debugger;
      dispatch({
        type: FORM_DATA,
        payload: data
      });
    } catch (e) {}
  };
};
export const onSaveData = (forSaveData, isConnection) => {
  debugger;
  return async dispatch => {
    try {
      dispatch({
        type: FORM_LOADING,
        payload: true
      });
      debugger;
      if (!isConnection) {
        let savedData = await getSavedData(SAVE_FORM);
        debugger;
        if (!_.find(savedData, { training_id_no: forSaveData.training_id_no }))
         {
          savedData.push(forSaveData);
          await saveData(SAVE_FORM, savedData);
          Alert.alert("", "Record saved in offline storage! ");
        } else {
          Alert.alert("", "This record already exist in offline storage! ");
        }
      } else {
        // params.append("logged_from", forSaveData.logged_from);
        debugger;
        let params = [forSaveData];
        debugger;
        let resp = await ApiAccess.postSubmitForm("post", params);
      }
      debugger;
      dispatch({
        type: FORM_LOADING,
        payload: false
      });
    } catch (e) {
      debugger;
      dispatch({
        type: FORM_LOADING,
        payload: false
      });
      Alert.alert("", "Form data successfully saved.");
    }
  };
};

export const connectionCheck = isConnected => {
  return async dispatch => {
    try {
      //alert(isConnected)
      dispatch({
        type: INTENET,
        payload: isConnected
      });
    } catch (e) {}
  };
};
export const setHouseholdField = item => {
  return async dispatch => {
    try {
      //alert(isConnected)
      dispatch({
        type: SET_HOUSE,
        payload: item
      });
    } catch (e) {}
  };
};

export const saveOflineDataToServer = (forSaveData, is_connection) => {
  debugger;
  return async dispatch => {
    try {
      debugger;
      if (is_connection) {
        dispatch({
          type: FORM_LOADING,
          payload: true
        });      
        debugger;

        let resp = await ApiAccess.postSubmitForm("post", forSaveData);
      } else {
        debugger;

        Alert.alert(
          "Device is Offline ",
          "Please check the internet connections and try again."
        );
      }
    } catch (e) {
      debugger;

      await saveData(SAVE_FORM, []);
      dispatch({
        type: FORM_LOADING,
        payload: false
      });
      Alert.alert(
        "",
        "Form saved successfully.",
        [
          { text: "Ok", onPress: () => Actions.refresh({ key: Math.random() }) }
        ],
        { cancelable: false }
      );
    }
  };
};
