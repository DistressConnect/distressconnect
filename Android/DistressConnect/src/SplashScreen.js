/**
 * Distress Connect Site Template
 * @version v1.0.0
 * @link
 * Copyright (c) 2019  Distress Connect
 * @Author Team Distress Connect
 * IBM : CALL FOR CODE 2019 Global Challange
 */

import React, { Component } from "react";

import { View, Image, Alert, ImageBackground } from "react-native";

import { Actions } from "react-native-router-flux";

import { getSavedData } from "./business/common/AsyncStorage/AsyncStorageDB";
import { USER_SEARCH } from "./config/Config";
import { getLocalDatas } from "./actions/LoginActions";
import {connect} from 'react-redux';

//

let data = [];

class SplashScreen extends React.PureComponent {
  constructor() {
    super();
  }
//   async componentWillMount() {
//     data = await getSavedData(USER_SEARCH);
//     debugger
//   }
  

  async componentDidMount() {
    //let data = this.props.getLocalDatas(USER_SEARCH);
    let data = await getSavedData(USER_SEARCH);

    debugger;
    setTimeout( function() {
      debugger;
      if (data.hasOwnProperty('status')) {
        Actions.TrainingTrackingForm();
      } else {
        Actions.LoginComponent();
      }
    }, 500);
  }

  render() {
    debugger;

    return (
      <ImageBackground
        resizeMode="stretch"
        source={require("./imgs/bgimage.png")}
        style={{ flex: 1, alignItems: "center", justifyContent: "center" }}
      />
    );
  }
}
const mapStateToProps = ({ login }) => {
    // email:auth.state.email;
    const { savedData } = login;
    return { savedData };
  };
  export default connect(
    mapStateToProps,
    { getLocalDatas }
  )(SplashScreen);