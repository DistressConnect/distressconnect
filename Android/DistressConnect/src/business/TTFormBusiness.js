import dataJson from "../config/loginDara.json";
import { getSavedData } from "./common/AsyncStorage/AsyncStorageDB.js";
import { USER_SEARCH } from "../config/Config.js";
//const data = require('../config/loginData.json');
export async function mapDataToArray() {
  let newList = [];
  debugger
  let savedData = await getSavedData(USER_SEARCH);
  debugger
  let data = savedData.hasOwnProperty("status") ? savedData : dataJson;
  debugger;
  for (var j = 0; j < data.data.length; j++) {
    let dataObj = {
      id: "1",
      nameserch:data.data[j].hh_id +
        "/" +
        data.data[j].name +
        "/" +
        data.data[j].spouse_name +
        "/" +
        data.data[j].village_name +
        "/" +
        data.data[j].gp_name +
        "/" +
        data.data[j].block_name +
        "/" +
        data.data[j].district_name,
      suffix: "",
      hh_id: "204010107155",
      fk_district_id: "1",
      fk_block_id: "1",
      fk_gp_id: "1",
      fk_village_id: "1",
      name: "Lipi Pradhan",
      spouse_name: "Gopala Pradhan",
      caste: "2",
      status: "1",
      fk_shg_id: "9101",
      created_by: "1",
      created_on: "1558618525",
      updated_by: "1",
      updated_on: "1558618525",
      shg_id: null,
      shg_name: null,
      village_name: "Bakikamba",
      gp_name: "Gressingia",
      block_name: "Gudayagiri",
      district_name: "Kandhamal"
    };
    newList.push(dataObj);
  }
  debugger;
  return newList;
}
export function searchHouseInArray(text, arr) {
  // debugger;
  let newList = [];
  // for (var j=0; j<data.data.length; j++) {
  //     debugger
  //     if (data.data[j].match(str)) {
  //         newList.push(data.data[j])
  //         return newList;
  //     }
  // }
  let list = arr.filter(item => {
    // debugger;
    if (text !== "") {
      if (item.nameserch.toLowerCase().indexOf(text.toLowerCase()) > -1) {
        newList.push(item);
      }
    } else {
      newList = arr;
    }
  });
  debugger;
  return newList;
}
