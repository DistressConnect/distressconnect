import {AsyncStorage,Alert} from 'react-native';
import {Actions} from 'react-native-router-flux';
export async function setLoginSession (sessionData) {

    await AsyncStorage.setItem('userData',
        JSON.stringify(sessionData));
    debugger;
}
export async function getLoginSessionData() {
    let stringifydata = await AsyncStorage.getItem('userData');
    let data = await JSON.parse(stringifydata) || [];
    debugger;
    return data;
}
export async function clearLoginSession() {
    await AsyncStorage.removeItem('userData');
    debugger;
}
export function  clearAllSavedData() {
    Alert.alert(
        "",
        "Are you sure you want to logout ?",
        [
            {text: 'Cancel', onPress: () =>  console.log("cancel"),style: 'cancel'},
            {text: 'Yes', onPress: () => backToDashboard()},
        ],
        { cancelable: true }
    )
}
/*function backToDashboard() {
    AsyncStorage.removeItem('userData');
    Actions.Dashboard();
}*/
export async function clearSavedDataByKey(Key) {
    await AsyncStorage.removeItem(Key);
    debugger;
}
export async function saveData(Key,saveItem) {
    await AsyncStorage.setItem(Key,
        JSON.stringify(saveItem));
    debugger;
}
export async function getSavedData(Key) {
    debugger;
    let stringifydata = await AsyncStorage.getItem(Key);
    debugger;
    let data = await JSON.parse(stringifydata) || [];
    debugger;
    return data;
}